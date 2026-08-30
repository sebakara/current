@extends('admin.layouts.app')

@section('title', $contactMessage->subject)

@section('content')
    @php
        $message = $contactMessage;

        $phoneDigits = preg_replace('/\D+/', '', $message->phone ?? '');

        $whatsAppText = rawurlencode(
            'Hello ' . $message->name
            . ', thank you for contacting VTLABS regarding: '
            . $message->subject
        );
    @endphp

    <div class="space-y-8">
        <div class="flex flex-col justify-between gap-5 lg:flex-row lg:items-end">
            <div>
                <p class="text-xs font-black uppercase tracking-[0.2em] text-brand-primary">
                    Contact Message
                </p>

                <h1 class="mt-3 text-3xl font-black text-slate-900 dark:text-white sm:text-4xl">
                    {{ $message->subject }}
                </h1>

                <p class="mt-3 text-sm text-slate-600 dark:text-slate-500">
                    Received {{ $message->created_at->format('d M Y, H:i') }}
                </p>
            </div>

            <div class="flex flex-wrap gap-3">
                <a
                    href="{{ route('admin.contact-messages.index') }}"
                    class="rounded-2xl border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-white/[0.04] px-6 py-3.5 text-sm font-black text-slate-700 dark:text-slate-300"
                >
                    Back to Messages
                </a>

                @if ($message->email)
                    <a
                        href="mailto:{{ $message->email }}?subject={{ rawurlencode('Re: ' . $message->subject) }}"
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

        <div class="grid gap-7 xl:grid-cols-[1fr_390px]">
            <div class="space-y-7">
                <section class="rounded-[2rem] border border-slate-200 dark:border-white/10 bg-white dark:bg-slate-900/70 p-7">
                    <p class="text-xs font-black uppercase tracking-wider text-brand-primary">
                        Sender Information
                    </p>

                    <dl class="mt-6 grid gap-6 sm:grid-cols-2">
                        @foreach ([
                            'Name' => $message->name,
                            'Company' => $message->company,
                            'Email' => $message->email,
                            'Phone' => $message->phone,
                            'Department' => $message->department,
                            'IP address' => $message->ip_address,
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
                        Message
                    </p>

                    <p class="mt-5 whitespace-pre-line text-sm leading-8 text-slate-700 dark:text-slate-300">
                        {{ $message->message }}
                    </p>
                </section>
            </div>

            <aside>
                <form
                    method="POST"
                    action="{{ route(
                        'admin.contact-messages.update',
                        $message
                    ) }}"
                    class="rounded-[2rem] border border-slate-200 dark:border-white/10 bg-white dark:bg-slate-900/80 p-7"
                >
                    @csrf
                    @method('PUT')

                    <p class="text-xs font-black uppercase tracking-wider text-brand-primary">
                        Message Management
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
                                'read' => 'Read',
                                'in-progress' => 'In progress',
                                'replied' => 'Replied',
                                'closed' => 'Closed',
                                'spam' => 'Spam',
                            ] as $value => $label)
                                <option
                                    value="{{ $value }}"
                                    @selected(
                                        old('status', $message->status)
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
                            Department
                        </span>

                        <input
                            type="text"
                            name="department"
                            value="{{ old(
                                'department',
                                $message->department
                            ) }}"
                            maxlength="100"
                            placeholder="Sales, Support, Academy..."
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
                                            $message->assigned_to
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
                            placeholder="Internal follow-up notes..."
                            class="w-full rounded-2xl border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-slate-950 px-4 py-3.5 text-slate-900 dark:text-white"
                        >{{ old(
                            'internal_notes',
                            $message->internal_notes
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
                            $message->admin_notes
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
