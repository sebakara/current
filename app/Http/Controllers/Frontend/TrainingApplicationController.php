<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\TrainingApplication;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class TrainingApplicationController extends Controller
{
    public function create(Course $course): View
    {
        abort_unless($course->is_published, 404);

        abort_unless(
            $course->applicationsAreOpen(),
            403,
            'Applications for this course are currently closed.'
        );

        return view(
            'frontend.pages.academy.apply',
            compact('course')
        );
    }

    public function store(
        Request $request,
        Course $course
    ): RedirectResponse {
        abort_unless($course->is_published, 404);

        abort_unless(
            $course->applicationsAreOpen(),
            403,
            'Applications for this course are currently closed.'
        );

        $validated = $request->validate([
            'full_name' => [
                'required',
                'string',
                'max:150',
            ],
            'email' => [
                'nullable',
                'email',
                'max:150',
            ],
            'phone' => [
                'required',
                'string',
                'max:40',
            ],
            'gender' => [
                'nullable',
                'in:male,female,other,prefer-not-to-say',
            ],
            'date_of_birth' => [
                'nullable',
                'date',
                'before:today',
            ],
            'nationality' => [
                'nullable',
                'string',
                'max:100',
            ],
            'education_level' => [
                'nullable',
                'string',
                'max:150',
            ],
            'current_occupation' => [
                'nullable',
                'string',
                'max:150',
            ],
            'address' => [
                'nullable',
                'string',
                'max:1000',
            ],
            'motivation' => [
                'required',
                'string',
                'max:3000',
            ],
            'experience' => [
                'nullable',
                'string',
                'max:3000',
            ],
            'preferred_schedule' => [
                'nullable',
                'string',
                'max:150',
            ],
            'document' => [
                'nullable',
                'file',
                'mimes:pdf,doc,docx,jpg,jpeg,png',
                'max:10240',
            ],
        ]);

        if ($request->hasFile('document')) {
            $validated['document'] = $request
                ->file('document')
                ->store(
                    'training-applications/documents',
                    'public'
                );
        }

        $application = TrainingApplication::create([
            ...$validated,
            'course_id' => $course->id,
            'application_number' =>
                $this->generateApplicationNumber(),
            'status' => 'pending',
        ]);

        return redirect()
            ->route(
                'academy.application.success',
                $application
            );
    }

    public function success(
        TrainingApplication $application
    ): View {
        $application->load('course');

        return view(
            'frontend.pages.academy.success',
            compact('application')
        );
    }

    private function generateApplicationNumber(): string
    {
        do {
            $number = 'VTA-'
                . now()->format('Ymd')
                . '-'
                . Str::upper(Str::random(6));
        } while (
            TrainingApplication::query()
                ->where('application_number', $number)
                ->exists()
        );

        return $number;
    }
}
