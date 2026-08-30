<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class OrderController extends Controller
{
    private const STATUSES = [
        'pending',
        'confirmed',
        'processing',
        'ready',
        'completed',
        'cancelled',
    ];

    public function index(Request $request): View
    {
        $search = trim(
            $request->string('search')->toString()
        );

        $status = $request->string('status')->toString();

        $method = $request->string('method')->toString();

        $orders = Order::query()
            ->withCount('items')
            ->when($search, function ($query) use ($search) {
                $query->where(function ($builder) use ($search) {
                    $builder
                        ->where('order_number', 'like', "%{$search}%")
                        ->orWhere('customer_name', 'like', "%{$search}%")
                        ->orWhere('customer_phone', 'like', "%{$search}%")
                        ->orWhere('customer_email', 'like', "%{$search}%");
                });
            })
            ->when(
                in_array($status, self::STATUSES, true),
                fn ($query) => $query->where('status', $status)
            )
            ->when(
                in_array($method, ['whatsapp', 'website'], true),
                fn ($query) => $query->where(
                    'order_method',
                    $method
                )
            )
            ->latest()
            ->paginate(20)
            ->withQueryString();

        $statusCounts = Order::query()
            ->selectRaw('status, COUNT(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status');

        $summary = [
            'total_orders' => Order::query()->count(),

            'pending_orders' => Order::query()
                ->where('status', 'pending')
                ->count(),

            'processing_orders' => Order::query()
                ->whereIn('status', [
                    'confirmed',
                    'processing',
                    'ready',
                ])
                ->count(),

            'completed_orders' => Order::query()
                ->where('status', 'completed')
                ->count(),

            'total_sales' => Order::query()
                ->where('status', 'completed')
                ->sum('total'),
        ];

        return view('admin.orders.index', compact(
            'orders',
            'search',
            'status',
            'method',
            'statusCounts',
            'summary'
        ));
    }

    public function show(Order $order): View
    {
        $order->load([
            'items.product',
        ]);

        return view('admin.orders.show', [
            'order' => $order,
            'statuses' => self::STATUSES,
        ]);
    }

    public function updateStatus(
        Request $request,
        Order $order
    ): RedirectResponse {
        $validated = $request->validate([
            'status' => [
                'required',
                Rule::in(self::STATUSES),
            ],
        ]);

        $status = $validated['status'];

        $updates = [
            'status' => $status,
        ];

        if (
            $status === 'confirmed'
            && ! $order->confirmed_at
        ) {
            $updates['confirmed_at'] = now();
        }

        if (
            $status === 'completed'
            && ! $order->completed_at
        ) {
            $updates['completed_at'] = now();
        }

        if ($status !== 'completed') {
            $updates['completed_at'] = null;
        }

        $order->update($updates);

        return back()->with(
            'success',
            'Order status updated successfully.'
        );
    }
}
