<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\QuotationRequest;
use App\Models\Service;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class QuotationRequestController extends Controller
{
    private const STATUSES = [
        'new',
        'reviewing',
        'quoted',
        'approved',
        'in-progress',
        'completed',
        'declined',
        'cancelled',
    ];

    public function index(Request $request): View
    {
        $search = trim((string) $request->query('search'));
        $status = (string) $request->query('status', 'all');
        $requestType = trim(
            (string) $request->query('request_type')
        );

        $quotations = QuotationRequest::query()
            ->with([
                'service',
                'product',
                'assignee',
            ])
            ->when($search !== '', function (Builder $query) use ($search) {
                $query->where(function (Builder $innerQuery) use ($search) {
                    $innerQuery
                        ->where(
                            'reference_number',
                            'like',
                            "%{$search}%"
                        )
                        ->orWhere('name', 'like', "%{$search}%")
                        ->orWhere('company', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                        ->orWhere('phone', 'like', "%{$search}%")
                        ->orWhere(
                            'project_title',
                            'like',
                            "%{$search}%"
                        )
                        ->orWhere(
                            'project_description',
                            'like',
                            "%{$search}%"
                        );
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
                $requestType !== '',
                fn (Builder $query) => $query->where(
                    'request_type',
                    $requestType
                )
            )
            ->latest('created_at')
            ->paginate(25)
            ->withQueryString();

        $counts = [
            'all' => QuotationRequest::query()->count(),
            'new' => QuotationRequest::query()
                ->where('status', 'new')
                ->count(),
            'reviewing' => QuotationRequest::query()
                ->where('status', 'reviewing')
                ->count(),
            'quoted' => QuotationRequest::query()
                ->where('status', 'quoted')
                ->count(),
            'approved' => QuotationRequest::query()
                ->where('status', 'approved')
                ->count(),
        ];

        $requestTypes = QuotationRequest::query()
            ->whereNotNull('request_type')
            ->where('request_type', '!=', '')
            ->distinct()
            ->orderBy('request_type')
            ->pluck('request_type');

        return view(
            'admin.quotation-requests.index',
            compact(
                'quotations',
                'counts',
                'requestTypes',
                'search',
                'status',
                'requestType'
            )
        );
    }

    public function show(
        QuotationRequest $quotationRequest
    ): View {
        $quotationRequest->load([
            'service',
            'product',
            'assignee',
        ]);

        $users = User::query()
            ->orderBy('name')
            ->get(['id', 'name', 'email']);

        $services = Service::query()
            ->orderBy('title')
            ->get(['id', 'title']);

        $products = Product::query()
            ->orderBy('name')
            ->get(['id', 'name', 'sku']);

        return view(
            'admin.quotation-requests.show',
            compact(
                'quotationRequest',
                'users',
                'services',
                'products'
            )
        );
    }

    public function update(
        Request $request,
        QuotationRequest $quotationRequest
    ): RedirectResponse {
        $validated = $request->validate([
            'status' => [
                'required',
                Rule::in(self::STATUSES),
            ],
            'request_type' => [
                'nullable',
                'string',
                'max:100',
            ],
            'service_id' => [
                'nullable',
                'integer',
                Rule::exists('services', 'id'),
            ],
            'product_id' => [
                'nullable',
                'integer',
                Rule::exists('products', 'id'),
            ],
            'estimated_budget' => [
                'nullable',
                'numeric',
                'min:0',
                'max:999999999999',
            ],
            'currency' => [
                'nullable',
                'string',
                'max:10',
            ],
            'required_by' => [
                'nullable',
                'date',
            ],
            'assigned_to' => [
                'nullable',
                'integer',
                Rule::exists('users', 'id'),
            ],
            'internal_notes' => [
                'nullable',
                'string',
                'max:10000',
            ],
            'admin_notes' => [
                'nullable',
                'string',
                'max:10000',
            ],
        ]);

        if (! empty($validated['currency'])) {
            $validated['currency'] = strtoupper(
                trim($validated['currency'])
            );
        }

        $quotationRequest->update($validated);

        return redirect()
            ->route(
                'admin.quotation-requests.show',
                $quotationRequest
            )
            ->with(
                'success',
                'Quotation request updated successfully.'
            );
    }

    public function destroy(
        QuotationRequest $quotationRequest
    ): RedirectResponse {
        if (
            $quotationRequest->attachment
            && Storage::disk('public')->exists(
                $quotationRequest->attachment
            )
        ) {
            Storage::disk('public')->delete(
                $quotationRequest->attachment
            );
        }

        $quotationRequest->delete();

        return redirect()
            ->route('admin.quotation-requests.index')
            ->with(
                'success',
                'Quotation request deleted successfully.'
            );
    }
}
