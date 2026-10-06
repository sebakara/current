@extends('admin.layouts.app')

@section('title', $quotationRequest->reference_number)

@section('content')
    @php
        $quotation = $quotationRequest;

        $phoneDigits = preg_replace(
            '/\D+/',
            '',
            $quotation->phone ?? ''
        );

        $replySubject = rawurlencode(
            'Quotation Request ' . $quotation->reference_number
        );

        $whatsAppText = rawurlencode(
            'Hello ' . $quotation->name
            . ', thank you for your quotation request '
            . $quotation->reference_number
            . '. Our VTLABS team is reviewing it.'
        );
    @endphp

    <div class="space-y-8">
        <div class="flex flex-col justify-between gap-5 lg:flex-row lg:items-end">
            <div>
                <p class="text-xs font-black uppercase tracking-[0.2em] text-brand-primary">
                    Quotation Request
                </p>

                <h1 class="mt-3 text-3xl font-black text-slate-900 dark:text-white sm:text-4xl">
                    {{ $quotation->reference_number }}
                </h1>

                <p class="mt-3 text-sm text-slate-600 dark:text-slate-500">
                    Submitted {{ $quotation->created_at->format('d M Y, H:i') }}
                </p>
            </div>

            <div class="flex flex-wrap gap-3">
                <a
                    href="{{ route('admin.quotation-requests.index') }}"
                    class="rounded-2xl border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-white/[0.04] px-6 py-3.5 text-sm font-black text-slate-700 dark:text-slate-300"
                >
                    Back to Requests
                </a>

                @if ($quotation->email)
                    <a
                        href="mailto:{{ $quotation->email }}?subject={{ $replySubject }}"
                        class="rounded-2xl border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-white/[0.04] px-6 py-3.5 text-sm font-black text-slate-900 dark:text-white"
                    >
                        Reply by Email
                    </a>
                @endif

                @if ($phoneDigits)
                    <a
                        href="https://wa.me/{{ $phoneDigits }}?text={{ $whatsAppText }}"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="rounded-2xl bg-emerald-400 px-6 py-3.5 text-sm font-black text-slate-950"
                    >
                        Reply on WhatsApp
                    </a>
                @endif
            </div>
        </div>

        @if (session('success'))
            <div class="rounded-2xl border border-emerald-400/20 bg-emerald-400/10 px-5 py-4 text-sm font-semibold text-emerald-700 dark:text-emerald-300">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="rounded-2xl border border-red-400/20 bg-red-400/10 px-5 py-4">
                <ul class="list-inside list-disc space-y-1 text-sm text-red-700 dark:text-red-200">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="grid gap-7 xl:grid-cols-[1fr_400px]">
            <div class="space-y-7">
                <section class="rounded-[2rem] border border-slate-200 dark:border-white/10 bg-white dark:bg-slate-900/70 p-7">
                    <p class="text-xs font-black uppercase tracking-wider text-brand-primary">
                        Client Information
                    </p>

                    <dl class="mt-6 grid gap-6 sm:grid-cols-2">
                        @foreach ([
                            'Name' => $quotation->name,
                            'Company' => $quotation->company,
                            'Email' => $quotation->email,
                            'Phone' => $quotation->phone,
                            'Location' => $quotation->location,
                            'Preferred contact' => $quotation->preferred_contact_method
                                ? str($quotation->preferred_contact_method)->title()
                                : null,
                        ] as $label => $value)
                            <div>
                                <dt class="text-xs font-black uppercase tracking-wider text-slate-600 dark:text-slate-600">
                                    {{ $label }}
                                </dt>

                                <dd class="mt-2 text-sm font-semibold leading-7 text-slate-700 dark:text-slate-300">
                                    {{ $value ?: 'Not provided' }}
                                </dd>
                            </div>
                        @endforeach
                    </dl>
                </section>

                <section class="rounded-[2rem] border border-slate-200 dark:border-white/10 bg-white dark:bg-slate-900/70 p-7">
                    <p class="text-xs font-black uppercase tracking-wider text-brand-primary">
                        Project Requirement
                    </p>

                    <h2 class="mt-5 text-2xl font-black text-slate-900 dark:text-white">
                        {{ $quotation->project_title
                            ?: $quotation->service_type
                            ?: 'General request' }}
                    </h2>

                    <p class="mt-5 whitespace-pre-line text-sm leading-8 text-slate-700 dark:text-slate-300">
                        {{ $quotation->project_description }}
                    </p>
                </section>

                <section class="rounded-[2rem] border border-slate-200 dark:border-white/10 bg-white dark:bg-slate-900/70 p-7">
                    <p class="text-xs font-black uppercase tracking-wider text-brand-primary">
                        Commercial Details
                    </p>

                    <dl class="mt-6 grid gap-6 sm:grid-cols-2">
                        <div>
                            <dt class="text-xs font-black uppercase tracking-wider text-slate-600 dark:text-slate-600">
                                Budget
                            </dt>

                            <dd class="mt-2 text-sm font-black text-slate-900 dark:text-white">
                                @if ($quotation->estimated_budget !== null)
                                    {{ $quotation->currency ?: 'RWF' }}
                                    {{ number_format(
                                        (float) $quotation->estimated_budget,
                                        2
                                    ) }}
                                @else
                                    {{ $quotation->budget ?: 'Not provided' }}
                                @endif
                            </dd>
                        </div>

                        <div>
                            <dt class="text-xs font-black uppercase tracking-wider text-slate-600 dark:text-slate-600">
                                Timeline
                            </dt>

                            <dd class="mt-2 text-sm font-black text-slate-900 dark:text-white">
                                {{ $quotation->timeline ?: 'Not provided' }}
                            </dd>
                        </div>

                        <div>
                            <dt class="text-xs font-black uppercase tracking-wider text-slate-600 dark:text-slate-600">
                                Required by
                            </dt>

                            <dd class="mt-2 text-sm font-black text-slate-900 dark:text-white">
                                {{ $quotation->required_by
                                    ? $quotation->required_by->format('d M Y')
                                    : 'Not provided' }}
                            </dd>
                        </div>

                        <div>
                            <dt class="text-xs font-black uppercase tracking-wider text-slate-600 dark:text-slate-600">
                                Request type
                            </dt>

                            <dd class="mt-2 text-sm font-black text-slate-900 dark:text-white">
                                {{ $quotation->request_type
                                    ? str($quotation->request_type)
                                        ->replace('-', ' ')
                                        ->title()
                                    : 'Not specified' }}
                            </dd>
                        </div>
                    </dl>
                </section>

                @if ($quotation->attachment)
                    <section class="rounded-[2rem] border border-slate-200 dark:border-white/10 bg-white dark:bg-slate-900/70 p-7">
                        <p class="text-xs font-black uppercase tracking-wider text-brand-primary">
                            Attachment
                        </p>

                        @if (
                            Storage::disk('public')->exists(
                                $quotation->attachment
                            )
                        )
                            <a
                                href="{{ Storage::url(
                                    $quotation->attachment
                                ) }}"
                                target="_blank"
                                rel="noopener noreferrer"
                                class="mt-5 inline-flex rounded-2xl border border-brand-primary/20 bg-brand-primary/[0.08] px-5 py-3 text-sm font-black text-brand-primary dark:text-brand-primary-light"
                            >
                                Open Attachment
                            </a>
                        @else
                            <p class="mt-5 text-sm text-amber-700 dark:text-amber-300">
                                The attachment record exists, but the file is missing.
                            </p>
                        @endif
                    </section>
                @endif
            </div>

            <aside>
                <form
                    method="POST"
                    action="{{ route(
                        'admin.quotation-requests.update',
                        $quotation
                    ) }}"
                    class="rounded-[2rem] border border-slate-200 dark:border-white/10 bg-white dark:bg-slate-900/80 p-7"
                >
                    @csrf
                    @method('PUT')

                    <p class="text-xs font-black uppercase tracking-wider text-brand-primary">
                        Request Management
                    </p>

                    <label class="mt-6 block">
                        <span class="mb-2 block text-sm font-black text-slate-700 dark:text-slate-300">
                            Status
                        </span>

                        <select
                            name="status"
                            required
                            class="w-full rounded-2xl border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-slate-950 px-4 py-3.5 text-slate-900 dark:text-white"
                        >
                            @foreach ([
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
                                    @selected(
                                        old('status', $quotation->status)
                                        === $value
                                    )
                                >
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                    </label>

                    <label class="mt-5 block">
                        <span class="mb-2 block text-sm font-black text-slate-700 dark:text-slate-300">
                            Request type
                        </span>

                        <input
                            type="text"
                            name="request_type"
                            value="{{ old(
                                'request_type',
                                $quotation->request_type
                            ) }}"
                            maxlength="100"
                            placeholder="service, product, manufacturing..."
                            class="w-full rounded-2xl border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-slate-950 px-4 py-3.5 text-slate-900 dark:text-white"
                        >
                    </label>

                    <label class="mt-5 block">
                        <span class="mb-2 block text-sm font-black text-slate-700 dark:text-slate-300">
                            Linked service
                        </span>

                        <select
                            name="service_id"
                            class="w-full rounded-2xl border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-slate-950 px-4 py-3.5 text-slate-900 dark:text-white"
                        >
                            <option value="">No linked service</option>

                            @foreach ($services as $service)
                                <option
                                    value="{{ $service->id }}"
                                    @selected(
                                        old(
                                            'service_id',
                                            $quotation->service_id
                                        ) == $service->id
                                    )
                                >
                                    {{ $service->title }}
                                </option>
                            @endforeach
                        </select>
                    </label>

                    <label class="mt-5 block">
                        <span class="mb-2 block text-sm font-black text-slate-700 dark:text-slate-300">
                            Linked product
                        </span>

                        <select
                            name="product_id"
                            class="w-full rounded-2xl border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-slate-950 px-4 py-3.5 text-slate-900 dark:text-white"
                        >
                            <option value="">No linked product</option>

                            @foreach ($products as $product)
                                <option
                                    value="{{ $product->id }}"
                                    @selected(
                                        old(
                                            'product_id',
                                            $quotation->product_id
                                        ) == $product->id
                                    )
                                >
                                    {{ $product->sku
                                        ? $product->sku . ' — ' . $product->name
                                        : $product->name }}
                                </option>
                            @endforeach
                        </select>
                    </label>

                    <div class="mt-5 grid gap-4 sm:grid-cols-2">
                        <label>
                            <span class="mb-2 block text-sm font-black text-slate-700 dark:text-slate-300">
                                Estimated budget
                            </span>

                            <input
                                type="number"
                                name="estimated_budget"
                                value="{{ old(
                                    'estimated_budget',
                                    $quotation->estimated_budget
                                ) }}"
                                min="0"
                                step="0.01"
                                class="w-full rounded-2xl border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-slate-950 px-4 py-3.5 text-slate-900 dark:text-white"
                            >
                        </label>

                        <label>
                            <span class="mb-2 block text-sm font-black text-slate-700 dark:text-slate-300">
                                Currency
                            </span>

                            <select
                                name="currency"
                                class="w-full rounded-2xl border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-slate-950 px-4 py-3.5 text-slate-900 dark:text-white"
                            >
                                @foreach (['RWF', 'USD', 'EUR', 'GBP'] as $currency)
                                    <option
                                        value="{{ $currency }}"
                                        @selected(
                                            old(
                                                'currency',
                                                $quotation->currency ?: 'RWF'
                                            ) === $currency
                                        )
                                    >
                                        {{ $currency }}
                                    </option>
                                @endforeach
                            </select>
                        </label>
                    </div>

                    <label class="mt-5 block">
                        <span class="mb-2 block text-sm font-black text-slate-700 dark:text-slate-300">
                            Required by
                        </span>

                        <input
                            type="date"
                            name="required_by"
                            value="{{ old(
                                'required_by',
                                $quotation->required_by
                                    ? $quotation->required_by->format('Y-m-d')
                                    : ''
                            ) }}"
                            class="w-full rounded-2xl border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-slate-950 px-4 py-3.5 text-slate-900 dark:text-white"
                        >
                    </label>

                    <label class="mt-5 block">
                        <span class="mb-2 block text-sm font-black text-slate-700 dark:text-slate-300">
                            Assigned to
                        </span>

                        <select
                            name="assigned_to"
                            class="w-full rounded-2xl border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-slate-950 px-4 py-3.5 text-slate-900 dark:text-white"
                        >
                            <option value="">Unassigned</option>

                            @foreach ($users as $user)
                                <option
                                    value="{{ $user->id }}"
                                    @selected(
                                        old(
                                            'assigned_to',
                                            $quotation->assigned_to
                                        ) == $user->id
                                    )
                                >
                                    {{ $user->name }}
                                </option>
                            @endforeach
                        </select>
                    </label>

                    <label class="mt-5 block">
                        <span class="mb-2 block text-sm font-black text-slate-700 dark:text-slate-300">
                            Internal notes
                        </span>

                        <textarea
                            name="internal_notes"
                            rows="7"
                            maxlength="10000"
                            placeholder="Internal review and follow-up notes..."
                            class="w-full rounded-2xl border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-slate-950 px-4 py-3.5 text-slate-900 dark:text-white"
                        >{{ old(
                            'internal_notes',
                            $quotation->internal_notes
                        ) }}</textarea>
                    </label>

                    <label class="mt-5 block">
                        <span class="mb-2 block text-sm font-black text-slate-700 dark:text-slate-300">
                            Additional admin notes
                        </span>

                        <textarea
                            name="admin_notes"
                            rows="5"
                            maxlength="10000"
                            class="w-full rounded-2xl border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-slate-950 px-4 py-3.5 text-slate-900 dark:text-white"
                        >{{ old(
                            'admin_notes',
                            $quotation->admin_notes
                        ) }}</textarea>
                    </label>

                    <button
                        type="submit"
                        class="mt-7 w-full rounded-2xl bg-gradient-to-r from-brand-primary to-brand-secondary px-6 py-4 text-sm font-black text-white"
                    >
                        Save Changes
                    </button>
                </form>
            </aside>
        </div>
    </div>
@endsection
