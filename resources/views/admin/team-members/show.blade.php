@extends('admin.layouts.app')

@section('title', $teamMember->name)

@section('content')
    <div class="space-y-8">
        <div class="flex flex-col justify-between gap-5 sm:flex-row sm:items-end">
            <div>
                <p class="text-xs font-black uppercase tracking-[0.2em] text-brand-primary">
                    Team Member
                </p>

                <h1 class="mt-3 text-4xl font-black text-slate-900 dark:text-white">
                    {{ $teamMember->name }}
                </h1>

                <p class="mt-3 text-lg font-black text-brand-primary dark:text-brand-primary-light">
                    {{ $teamMember->role }}
                </p>
            </div>

            <div class="flex gap-3">
                <a
                    href="{{ route('admin.team-members.index') }}"
                    class="rounded-2xl border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-white/[0.04] px-6 py-3.5 text-sm font-black text-slate-700 dark:text-slate-300"
                >
                    Back
                </a>

                <a
                    href="{{ route(
                        'admin.team-members.edit',
                        $teamMember
                    ) }}"
                    class="rounded-2xl bg-brand-primary px-6 py-3.5 text-sm font-black text-slate-950"
                >
                    Edit
                </a>
            </div>
        </div>

        <div class="grid gap-7 lg:grid-cols-[360px_1fr]">
            <aside class="rounded-[2rem] border border-slate-200 dark:border-white/10 bg-white dark:bg-slate-900/70 p-6">
                @if (
                    $teamMember->photo
                    && Storage::disk('public')->exists(
                        $teamMember->photo
                    )
                )
                    <img
                        src="{{ Storage::url($teamMember->photo) }}"
                        alt="{{ $teamMember->name }}"
                        class="aspect-square w-full rounded-[1.5rem] object-cover"
                    >
                @else
                    <div class="flex aspect-square w-full items-center justify-center rounded-[1.5rem] bg-slate-50 dark:bg-slate-950">
                        <span class="text-6xl font-black text-brand-primary dark:text-brand-primary-light">
                            {{ strtoupper(
                                substr($teamMember->name, 0, 2)
                            ) }}
                        </span>
                    </div>
                @endif

                <dl class="mt-6 space-y-5">
                    <div>
                        <dt class="text-xs font-black uppercase tracking-wider text-slate-600 dark:text-slate-600">
                            Department
                        </dt>

                        <dd class="mt-2 font-black text-slate-900 dark:text-white">
                            {{ $teamMember->department ?: 'Not specified' }}
                        </dd>
                    </div>

                    <div>
                        <dt class="text-xs font-black uppercase tracking-wider text-slate-600 dark:text-slate-600">
                            Status
                        </dt>

                        <dd class="mt-2 font-black text-slate-900 dark:text-white">
                            {{ $teamMember->is_active
                                ? 'Active'
                                : 'Inactive' }}
                        </dd>
                    </div>

                    <div>
                        <dt class="text-xs font-black uppercase tracking-wider text-slate-600 dark:text-slate-600">
                            Display order
                        </dt>

                        <dd class="mt-2 font-black text-slate-900 dark:text-white">
                            {{ $teamMember->sort_order }}
                        </dd>
                    </div>
                </dl>
            </aside>

            <div class="space-y-7">
                @if ($teamMember->bio)
                    <section class="rounded-[2rem] border border-slate-200 dark:border-white/10 bg-white dark:bg-slate-900/70 p-7">
                        <p class="text-xs font-black uppercase tracking-wider text-brand-primary">
                            Biography
                        </p>

                        <p class="mt-5 whitespace-pre-line text-sm leading-8 text-slate-700 dark:text-slate-300">
                            {{ $teamMember->bio }}
                        </p>
                    </section>
                @endif

                <section class="rounded-[2rem] border border-slate-200 dark:border-white/10 bg-white dark:bg-slate-900/70 p-7">
                    <p class="text-xs font-black uppercase tracking-wider text-brand-primary">
                        Contact & Social Profiles
                    </p>

                    <dl class="mt-6 grid gap-6 sm:grid-cols-2">
                        @foreach ([
                            'Email' => $teamMember->email,
                            'Phone' => $teamMember->phone,
                            'LinkedIn' => $teamMember->linkedin_url,
                            'X / Twitter' => $teamMember->twitter_url,
                        ] as $label => $value)
                            <div>
                                <dt class="text-xs font-black uppercase tracking-wider text-slate-600 dark:text-slate-600">
                                    {{ $label }}
                                </dt>

                                <dd class="mt-2 break-all text-sm font-semibold leading-7 text-slate-700 dark:text-slate-300">
                                    {{ $value ?: 'Not provided' }}
                                </dd>
                            </div>
                        @endforeach
                    </dl>
                </section>
            </div>
        </div>
    </div>
@endsection
