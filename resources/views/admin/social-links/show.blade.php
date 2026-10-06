@extends('admin.layouts.app')

@section('title', $socialLink->platform)

@section('content')
    <div class="space-y-8">
        <div class="flex flex-col justify-between gap-5 sm:flex-row sm:items-end">
            <div>
                <p class="text-xs font-black uppercase tracking-[0.2em] text-brand-primary">
                    Social Profile
                </p>

                <h1 class="mt-3 text-4xl font-black text-slate-900 dark:text-white">
                    {{ $socialLink->platform }}
                </h1>
            </div>

            <div class="flex gap-3">
                <a
                    href="{{ route('admin.social-links.index') }}"
                    class="rounded-2xl border border-slate-200 dark:border-white/10 px-6 py-3.5 text-sm font-black text-slate-700 dark:text-slate-300"
                >
                    Back
                </a>

                <a
                    href="{{ route(
                        'admin.social-links.edit',
                        $socialLink
                    ) }}"
                    class="rounded-2xl bg-brand-primary px-6 py-3.5 text-sm font-black text-slate-950"
                >
                    Edit
                </a>
            </div>
        </div>

        <section class="rounded-[2rem] border border-slate-200 dark:border-white/10 bg-white dark:bg-slate-900/70 p-7">
            <dl class="grid gap-6 sm:grid-cols-2">
                <div>
                    <dt class="text-xs font-black uppercase tracking-wider text-slate-600 dark:text-slate-600">
                        Platform
                    </dt>

                    <dd class="mt-2 font-black text-slate-900 dark:text-white">
                        {{ $socialLink->platform }}
                    </dd>
                </div>

                <div>
                    <dt class="text-xs font-black uppercase tracking-wider text-slate-600 dark:text-slate-600">
                        Status
                    </dt>

                    <dd class="mt-2 font-black text-slate-900 dark:text-white">
                        {{ $socialLink->is_active
                            ? 'Active'
                            : 'Inactive' }}
                    </dd>
                </div>

                <div>
                    <dt class="text-xs font-black uppercase tracking-wider text-slate-600 dark:text-slate-600">
                        Icon
                    </dt>

                    <dd class="mt-2 font-black text-slate-900 dark:text-white">
                        {{ $socialLink->icon ?: 'Not specified' }}
                    </dd>
                </div>

                <div>
                    <dt class="text-xs font-black uppercase tracking-wider text-slate-600 dark:text-slate-600">
                        Sort order
                    </dt>

                    <dd class="mt-2 font-black text-slate-900 dark:text-white">
                        {{ $socialLink->sort_order }}
                    </dd>
                </div>

                <div class="sm:col-span-2">
                    <dt class="text-xs font-black uppercase tracking-wider text-slate-600 dark:text-slate-600">
                        Profile URL
                    </dt>

                    <dd class="mt-2 break-all text-sm font-semibold text-brand-primary dark:text-brand-primary-light">
                        <a
                            href="{{ $socialLink->url }}"
                            target="_blank"
                            rel="noopener noreferrer"
                        >
                            {{ $socialLink->url }}
                        </a>
                    </dd>
                </div>
            </dl>
        </section>
    </div>
@endsection
