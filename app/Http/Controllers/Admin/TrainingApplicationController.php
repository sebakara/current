<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\TrainingApplication;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class TrainingApplicationController extends Controller
{
    private const STATUSES = [
        'pending',
        'under-review',
        'accepted',
        'rejected',
        'waitlisted',
        'cancelled',
    ];

    public function index(Request $request): View
    {
        $search = trim((string) $request->query('search'));
        $status = (string) $request->query('status', 'all');
        $courseId = $request->integer('course');

        $applications = TrainingApplication::query()
            ->with(['course.category', 'reviewer'])
            ->when($search !== '', function (Builder $query) use ($search) {
                $query->where(function (Builder $innerQuery) use ($search) {
                    $innerQuery
                        ->where(
                            'application_number',
                            'like',
                            "%{$search}%"
                        )
                        ->orWhere('full_name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                        ->orWhere('phone', 'like', "%{$search}%")
                        ->orWhere('nationality', 'like', "%{$search}%");
                });
            })
            ->when(
                $status !== 'all'
                && in_array($status, self::STATUSES, true),
                fn (Builder $query) => $query->where(
                    'status',
                    $status
                )
            )
            ->when(
                $courseId > 0,
                fn (Builder $query) => $query->where(
                    'course_id',
                    $courseId
                )
            )
            ->latest('created_at')
            ->paginate(25)
            ->withQueryString();

        $courses = Course::query()
            ->orderBy('title')
            ->get(['id', 'title', 'code']);

        $counts = [
            'all' => TrainingApplication::query()->count(),
            'pending' => TrainingApplication::query()
                ->where('status', 'pending')
                ->count(),
            'under-review' => TrainingApplication::query()
                ->where('status', 'under-review')
                ->count(),
            'accepted' => TrainingApplication::query()
                ->where('status', 'accepted')
                ->count(),
            'rejected' => TrainingApplication::query()
                ->where('status', 'rejected')
                ->count(),
        ];

        return view('admin.training-applications.index', compact(
            'applications',
            'courses',
            'counts',
            'search',
            'status',
            'courseId'
        ));
    }

    public function show(
        TrainingApplication $trainingApplication
    ): View {
        $trainingApplication->load([
            'course.category',
            'reviewer',
        ]);

        return view(
            'admin.training-applications.show',
            compact('trainingApplication')
        );
    }

    public function update(
        Request $request,
        TrainingApplication $trainingApplication
    ): RedirectResponse {
        $validated = $request->validate([
            'status' => [
                'required',
                Rule::in(self::STATUSES),
            ],
            'admin_notes' => [
                'nullable',
                'string',
                'max:10000',
            ],
        ]);

        $oldStatus = $trainingApplication->status;
        $newStatus = $validated['status'];

        $validated['reviewed_by'] = auth()->id();
        $validated['reviewed_at'] = now();

        $trainingApplication->update($validated);

        if (
            $oldStatus !== 'accepted'
            && $newStatus === 'accepted'
            && $trainingApplication->course
            && $trainingApplication->course->available_places !== null
            && $trainingApplication->course->available_places > 0
        ) {
            $trainingApplication->course()->decrement(
                'available_places'
            );
        }

        if (
            $oldStatus === 'accepted'
            && $newStatus !== 'accepted'
            && $trainingApplication->course
            && $trainingApplication->course->available_places !== null
        ) {
            $trainingApplication->course()->increment(
                'available_places'
            );
        }

        return redirect()
            ->route(
                'admin.training-applications.show',
                $trainingApplication
            )
            ->with(
                'success',
                'Application review saved successfully.'
            );
    }

    public function destroy(
        TrainingApplication $trainingApplication
    ): RedirectResponse {
        if (
            $trainingApplication->status === 'accepted'
            && $trainingApplication->course
            && $trainingApplication->course->available_places !== null
        ) {
            $trainingApplication->course()->increment(
                'available_places'
            );
        }

        if ($trainingApplication->document) {
            $this->deleteDocument(
                $trainingApplication->document
            );
        }

        $trainingApplication->delete();

        return redirect()
            ->route('admin.training-applications.index')
            ->with(
                'success',
                'Training application deleted successfully.'
            );
    }

    private function deleteDocument(?string $path): void
    {
        if (
            $path
            && Storage::disk('public')->exists($path)
        ) {
            Storage::disk('public')->delete($path);
        }
    }
}
