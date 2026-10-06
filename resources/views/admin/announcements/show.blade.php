@extends('admin.layouts.app')

@section('title', $announcement->title)

@section('content')
    @php
        $typeClasses = match ($announcement->type) {
            'success' =>
                'border-emerald-400/20 bg-emerald-400/10 text-emerald-700 dark:text-emerald-200',
            'warning' =>
                'border-amber-400/20 bg-amber-400/10 text-amber-700 dark:text-amber-200',
            'danger' =>
                'border-red-400/20 bg-red-400/10 text-red-700 dark:text-red-200',
            'promotion' =>
                'border-purple-400/20 bg-purple-400/10 text-purple-700 dark:text-purple-200',
            default =>
                'border-brand-primary/20 bg-brand-primary/10 text-cyan-700 dark:text-cyan-200',
        };
    @endphp

    <div class="space-y-8">
        <div class="flex flex-col justify-between gap-5 sm:flex-row sm:items-end">
            <div>
                <p class="text-xs font-black uppercase tracking-[0.2em] text-brand-primary">
                    Announcement Preview
                </p>

                <h1 class="mt-3 text-3xl font-black text-slate-900 dark:text-white sm:text-4xl">
                    {{ $announcement->title }}
                </h1>
            </div>

            <div class="flex gap-3">
                <a
                    href="{{ route('admin.announcements.index') }}"
                    class="rounded-2xl border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-white/[0.04] px-6 py-3.5 text-sm font-black text-slate-700 dark:text-slate-300"
                >
                    Back
                </a>

                <a
                    href="{{ route(
                        'admin.announcements.edit',
                        $announcement
                    ) }}"
                    class="rounded-2xl bg-brand-primary px-6 py-3.5 text-sm font-black text-slate-950"
                >
                    Edit
                </a>
            </div>
        </div>

        <section class="rounded-[2rem] border p-8 {{ $typeClasses }}">
            <div class="flex flex-col justify-between gap-6 lg:flex-row lg:items-center">
                <div>
                    <p class="text-xs font-black uppercase tracking-[0.2em] opacity-70">
                        {{ str($announcement->type)->title() }}
                    </p>

                    <h2 class="mt-3 text-2xl font-black">
                        {{ $announcement->title }}
                    </h2>

                    <p class="mt-4 max-w-3xl whitespace-pre-line text-sm leading-8 opacity-80">
                        {{ $announcement->message }}
                    </p>
                </div>

                @if (
                    $announcement->button_text
                    && $announcement->button_url
                )
                    <span class="shrink-0 rounded-2xl border border-current px-6 py-3.5 text-sm font-black">
                        {{ $announcement->button_text }}
                    </span>
                @endif
            </div>
        </section>

        <section class="rounded-[2rem] border border-slate-200 dark:border-white/10 bg-white dark:bg-slate-900/70 p-7">
            <dl class="grid gap-6 sm:grid-cols-2">
                <div>
                    <dt class="text-xs font-black uppercase tracking-wider text-slate-600 dark:text-slate-600">
                        Active
                    </dt>

                    <dd class="mt-2 font-black text-slate-900 dark:text-white">
                        {{ $announcement->is_active ? 'Yes' : 'No' }}
                    </dd>
                </div>

                <div>
                    <dt class="text-xs font-black uppercase tracking-wider text-slate-600 dark:text-slate-600">
                        Type
                    </dt>

                    <dd class="mt-2 font-black text-slate-900 dark:text-white">
                        {{ str($announcement->type)->title() }}
                    </dd>
                </div>

                <div>
                    <dt class="text-xs font-black uppercase tracking-wider text-slate-600 dark:text-slate-600">
                        Starts
                    </dt>

                    <dd class="mt-2 font-black text-slate-900 dark:text-white">
                        {{ $announcement->starts_at
                            ? $announcement->starts_at
                                ->format('d M Y, H:i')
                            : 'Immediately' }}
                    </dd>
                </div>

                <div>
                    <dt class="text-xs font-black uppercase tracking-wider text-slate-600 dark:text-slate-600">
                        Ends
                    </dt>

                    <dd class="mt-2 font-black text-slate-900 dark:text-white">
                        {{ $announcement->ends_at
                            ? $announcement->ends_at
                                ->format('d M Y, H:i')
                            : 'No expiry' }}
                    </dd>
                </div>
            </dl>
        </section>
    </div>
@endsection
