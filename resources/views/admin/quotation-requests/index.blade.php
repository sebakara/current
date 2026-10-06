@extends('admin.layouts.app')

@section('title', 'Quotation Requests')

@section('content')
    <div class="space-y-8">
        <div>
            <p class="text-xs font-black uppercase tracking-[0.2em] text-brand-primary">
                Sales Enquiries
            </p>

            <h1 class="mt-3 text-3xl font-black text-slate-900 dark:text-white sm:text-4xl">
                Quotation Requests
            </h1>

            <p class="mt-3 text-sm leading-7 text-slate-600 dark:text-slate-500">
                Review client requirements, assign requests, and track quotation progress.
            </p>
        </div>

        @if (session('success'))
            <div class="rounded-2xl border border-emerald-400/20 bg-emerald-400/10 px-5 py-4 text-sm font-semibold text-emerald-700 dark:text-emerald-300">
                {{ session('success') }}
            </div>
        @endif

        <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-5">
            @foreach ([
                'all' => ['All Requests', $counts['all']],
                'new' => ['New', $counts['new']],
                'reviewing' => ['Reviewing', $counts['reviewing']],
                'quoted' => ['Quoted', $counts['quoted']],
                'approved' => ['Approved', $counts['approved']],
            ] as $key => [$label, $count])
                <a
                    href="{{ route(
                        'admin.quotation-requests.index',
                        array_filter([
                            'status' => $key,
                            'search' => $search ?: null,
                            'request_type' => $requestType ?: null,
                        ])
                    ) }}"
                    class="rounded-[1.5rem] border p-5 transition
                        {{ $status === $key
                            ? 'border-brand-primary/30 bg-brand-primary/[0.08]'
                            : 'border-slate-200 dark:border-white/10 bg-white dark:bg-slate-900/70 hover:bg-slate-100 dark:hover:bg-white/[0.03]'
                        }}"
                >
                    <p class="text-xs font-black uppercase tracking-wider text-slate-600 dark:text-slate-500">
                        {{ $label }}
                    </p>

                    <p class="mt-3 text-3xl font-black text-slate-900 dark:text-white">
                        {{ number_format($count) }}
                    </p>
                </a>
            @endforeach
        </div>

        <form
            method="GET"
            class="grid gap-3 rounded-2xl border border-slate-200 dark:border-white/10 bg-white dark:bg-slate-900/70 p-4 lg:grid-cols-[1fr_220px_190px_auto_auto]"
        >
            <input
                type="search"
                name="search"
                value="{{ $search }}"
                placeholder="Search reference, client, company, or project..."
                class="rounded-xl border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-slate-950 px-4 py-3 text-slate-900 dark:text-white"
            >

            <select
                name="request_type"
                class="rounded-xl border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-slate-950 px-4 py-3 text-slate-900 dark:text-white"
            >
                <option value="">All request types</option>

                @foreach ($requestTypes as $type)
                    <option
                        value="{{ $type }}"
                        @selected($requestType === $type)
                    >
                        {{ str($type)->replace('-', ' ')->title() }}
                    </option>
                @endforeach
            </select>

            <select
                name="status"
                class="rounded-xl border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-slate-950 px-4 py-3 text-slate-900 dark:text-white"
            >
                @foreach ([
                    'all' => 'All statuses',
                    'new' => 'New',
                    'reviewing' => 'Reviewing',
                    'quoted' => 'Quoted',
                    'approved' => 'Approved',
                    'in-progress' => 'In progress',
                    'completed' => 'Completed',
                    'declined' => 'Declined',
                    'cancelled' => 'Cancelled',
                ] as $value => $label)
                    <option
                        value="{{ $value }}"
                        @selected($status === $value)
                    >
                        {{ $label }}
                    </option>
                @endforeach
            </select>

            <button
                type="submit"
                class="rounded-xl bg-slate-50 dark:bg-white/[0.07] px-5 py-3 text-sm font-black text-slate-900 dark:text-white"
            >
                Filter
            </button>

            <a
                href="{{ route('admin.quotation-requests.index') }}"
                class="rounded-xl border border-slate-200 dark:border-white/10 px-5 py-3 text-center text-sm font-black text-slate-600 dark:text-slate-400"
            >
                Reset
            </a>
        </form>

        <div class="overflow-hidden rounded-[2rem] border border-slate-200 dark:border-white/10 bg-white dark:bg-slate-900/70">
            <div class="overflow-x-auto">
                <table class="min-w-full">
                    <thead class="border-b border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-white/[0.025]">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-black uppercase tracking-wider text-slate-600 dark:text-slate-500">
                                Client
                            </th>

                            <th class="px-6 py-4 text-left text-xs font-black uppercase tracking-wider text-slate-600 dark:text-slate-500">
                                Request
                            </th>

                            <th class="px-6 py-4 text-left text-xs font-black uppercase tracking-wider text-slate-600 dark:text-slate-500">
                                Budget
                            </th>

                            <th class="px-6 py-4 text-left text-xs font-black uppercase tracking-wider text-slate-600 dark:text-slate-500">
                                Submitted
                            </th>

                            <th class="px-6 py-4 text-left text-xs font-black uppercase tracking-wider text-slate-600 dark:text-slate-500">
                                Status
                            </th>

                            <th class="px-6 py-4 text-right text-xs font-black uppercase tracking-wider text-slate-600 dark:text-slate-500">
                                Actions
                            </th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-slate-200 dark:divide-white/[0.07]">
                        @forelse ($quotations as $quotation)
                            @php
                                $statusClasses = match ($quotation->status) {
                                    'new' => 'bg-brand-primary/10 text-brand-primary dark:text-brand-primary-light',
                                    'reviewing' => 'bg-brand-secondary-light/10 text-brand-secondary dark:text-brand-secondary-light',
                                    'quoted' => 'bg-amber-400/10 text-amber-700 dark:text-amber-300',
                                    'approved' => 'bg-emerald-400/10 text-emerald-700 dark:text-emerald-300',
                                    'in-progress' => 'bg-purple-400/10 text-purple-700 dark:text-purple-300',
                                    'completed' => 'bg-green-400/10 text-green-700 dark:text-green-300',
                                    'declined' => 'bg-red-400/10 text-red-700 dark:text-red-300',
                                    default => 'bg-slate-100 dark:bg-slate-400/10 text-slate-600 dark:text-slate-400',
                                };
                            @endphp

                            <tr class="transition hover:bg-slate-100 dark:hover:bg-white/[0.02]">
                                <td class="px-6 py-5">
                                    <p class="font-black text-slate-900 dark:text-white">
                                        {{ $quotation->name }}
                                    </p>

                                    <p class="mt-1 text-xs text-slate-600 dark:text-slate-500">
                                        {{ $quotation->company ?: $quotation->phone }}
                                    </p>

                                    <p class="mt-1 text-xs text-slate-600 dark:text-slate-600">
                                        {{ $quotation->reference_number }}
                                    </p>
                                </td>

                                <td class="px-6 py-5">
                                    <p class="max-w-sm font-black text-slate-700 dark:text-slate-300">
                                        {{ $quotation->project_title
                                            ?: $quotation->service_type
                                            ?: 'General quotation request' }}
                                    </p>

                                    <p class="mt-2 max-w-sm line-clamp-2 text-xs leading-6 text-slate-600 dark:text-slate-600">
                                        {{ $quotation->project_description }}
                                    </p>
                                </td>

                                <td class="px-6 py-5">
                                    @if ($quotation->estimated_budget !== null)
                                        <p class="font-black text-slate-900 dark:text-white">
                                            {{ $quotation->currency ?: 'RWF' }}
                                            {{ number_format(
                                                (float) $quotation->estimated_budget,
                                                2
                                            ) }}
                                        </p>
                                    @elseif ($quotation->budget)
                                        <p class="text-sm font-black text-slate-900 dark:text-white">
                                            {{ $quotation->budget }}
                                        </p>
                                    @else
                                        <span class="text-sm text-slate-600 dark:text-slate-600">
                                            Not specified
                                        </span>
                                    @endif
                                </td>

                                <td class="px-6 py-5 text-sm text-slate-600 dark:text-slate-500">
                                    {{ $quotation->created_at->format('d M Y') }}

                                    <p class="mt-1 text-xs text-slate-600 dark:text-slate-600">
                                        {{ $quotation->created_at->format('H:i') }}
                                    </p>
                                </td>

                                <td class="px-6 py-5">
                                    <span class="rounded-full px-3 py-1.5 text-xs font-black {{ $statusClasses }}">
                                        {{ str($quotation->status)
                                            ->replace('-', ' ')
                                            ->title() }}
                                    </span>

                                    @if ($quotation->assignee)
                                        <p class="mt-2 text-xs text-slate-600 dark:text-slate-600">
                                            {{ $quotation->assignee->name }}
                                        </p>
                                    @endif
                                </td>

                                <td class="px-6 py-5">
                                    <div class="flex justify-end gap-2">
                                        <a
                                            href="{{ route(
                                                'admin.quotation-requests.show',
                                                $quotation
                                            ) }}"
                                            class="rounded-xl border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-white/[0.04] px-4 py-2 text-xs font-black text-slate-900 dark:text-white"
                                        >
                                            Open
                                        </a>

                                        <form
                                            method="POST"
                                            action="{{ route(
                                                'admin.quotation-requests.destroy',
                                                $quotation
                                            ) }}"
                                            onsubmit="return confirm('Delete this quotation request permanently?')"
                                        >
                                            @csrf
                                            @method('DELETE')

                                            <button
                                                type="submit"
                                                class="rounded-xl border border-red-400/15 bg-red-400/[0.06] px-4 py-2 text-xs font-black text-red-700 dark:text-red-300"
                                            >
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-16 text-center">
                                    <p class="text-lg font-black text-slate-900 dark:text-white">
                                        No quotation requests found
                                    </p>

                                    <p class="mt-2 text-sm text-slate-600 dark:text-slate-600">
                                        Website quotation submissions will appear here.
                                    </p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{ $quotations->links() }}
    </div>
@endsection
