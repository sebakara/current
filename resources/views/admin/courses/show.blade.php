@extends('admin.layouts.app')

@section('title', $course->title)

@section('content')
    <div class="space-y-8">
        <div class="flex flex-col justify-between gap-5 sm:flex-row sm:items-end">
            <div>
                <p class="text-xs font-black uppercase tracking-[0.2em] text-brand-primary">
                    Course Details
                </p>

                <h1 class="mt-3 text-4xl font-black text-slate-900 dark:text-white">
                    {{ $course->title }}
                </h1>

                <p class="mt-3 text-sm text-slate-600 dark:text-slate-500">
                    {{ $course->code ?: $course->slug }}
                </p>
            </div>

            <div class="flex flex-wrap gap-3">
                @if ($course->is_published)
                    <a
                        href="{{ route('academy.courses.show', $course) }}"
                        target="_blank"
                        class="rounded-2xl border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-white/[0.04] px-6 py-3.5 text-sm font-black text-slate-900 dark:text-white"
                    >
                        View Public Page
                    </a>
                @endif

                <a
                    href="{{ route('admin.courses.edit', $course) }}"
                    class="rounded-2xl bg-brand-primary px-6 py-3.5 text-sm font-black text-slate-950"
                >
                    Edit Course
                </a>
            </div>
        </div>

        <div class="grid gap-7 lg:grid-cols-[1fr_350px]">
            <div class="space-y-7">
                @if (
                    $course->featured_image
                    && Storage::disk('public')->exists($course->featured_image)
                )
                    <img
                        src="{{ Storage::url($course->featured_image) }}"
                        alt="{{ $course->title }}"
                        class="h-[440px] w-full rounded-[2rem] border border-slate-200 dark:border-white/10 object-cover"
                    >
                @endif

                @foreach ([
                    'Overview' => $course->overview,
                    'Description' => $course->description,
                    'Requirements' => $course->requirements,
                    'Learning Outcomes' => $course->learning_outcomes,
                    'Additional Outcomes' => $course->outcomes,
                ] as $title => $content)
                    @if ($content)
                        <section class="rounded-[2rem] border border-slate-200 dark:border-white/10 bg-white dark:bg-slate-900/70 p-7">
                            <p class="text-xs font-black uppercase tracking-wider text-brand-primary">
                                {{ $title }}
                            </p>

                            <p class="mt-5 whitespace-pre-line text-sm leading-8 text-slate-600 dark:text-slate-400">
                                {{ $content }}
                            </p>
                        </section>
                    @endif
                @endforeach

                @if (collect($course->modules ?? [])->isNotEmpty())
                    <section class="rounded-[2rem] border border-slate-200 dark:border-white/10 bg-white dark:bg-slate-900/70 p-7">
                        <p class="text-xs font-black uppercase tracking-wider text-brand-primary">
                            Modules
                        </p>

                        <div class="mt-6 space-y-3">
                            @foreach ($course->modules as $index => $module)
                                <div class="flex gap-4 rounded-2xl border border-slate-200 dark:border-white/[0.07] bg-slate-50 dark:bg-slate-950 p-4">
                                    <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-xl bg-brand-primary/10 text-xs font-black text-brand-primary dark:text-brand-primary-light">
                                        {{ $index + 1 }}
                                    </span>

                                    <p class="text-sm font-bold leading-7 text-slate-700 dark:text-slate-300">
                                        {{ $module }}
                                    </p>
                                </div>
                            @endforeach
                        </div>
                    </section>
                @endif
            </div>

            <aside class="space-y-7">
                <section class="rounded-[2rem] border border-slate-200 dark:border-white/10 bg-white dark:bg-slate-900/80 p-7">
                    <p class="text-xs font-black uppercase tracking-wider text-brand-primary">
                        Summary
                    </p>

                    <dl class="mt-6 space-y-5">
                        <div class="flex justify-between gap-4">
                            <dt class="text-sm text-slate-600 dark:text-slate-500">Category</dt>
                            <dd class="text-right font-black text-slate-900 dark:text-white">
                                {{ $course->category?->name }}
                            </dd>
                        </div>

                        <div class="flex justify-between gap-4">
                            <dt class="text-sm text-slate-600 dark:text-slate-500">Fee</dt>
                            <dd class="text-right font-black text-slate-900 dark:text-white">
                                @if ($course->fee !== null)
                                    {{ $course->currency }}
                                    {{ number_format((float) $course->fee, 2) }}
                                @else
                                    On request
                                @endif
                            </dd>
                        </div>

                        <div class="flex justify-between gap-4">
                            <dt class="text-sm text-slate-600 dark:text-slate-500">Duration</dt>
                            <dd class="text-right font-black text-slate-900 dark:text-white">
                                {{ $course->duration ?: 'Not specified' }}
                            </dd>
                        </div>

                        <div class="flex justify-between gap-4">
                            <dt class="text-sm text-slate-600 dark:text-slate-500">Mode</dt>
                            <dd class="text-right font-black text-slate-900 dark:text-white">
                                {{ $course->delivery_mode ?: 'Not specified' }}
                            </dd>
                        </div>

                        <div class="flex justify-between gap-4">
                            <dt class="text-sm text-slate-600 dark:text-slate-500">Applications</dt>
                            <dd class="font-black text-slate-900 dark:text-white">
                                {{ number_format($course->applications_count) }}
                            </dd>
                        </div>

                        <div class="flex justify-between gap-4">
                            <dt class="text-sm text-slate-600 dark:text-slate-500">Applications open</dt>
                            <dd class="font-black text-slate-900 dark:text-white">
                                {{ $course->applicationsAreOpen()
                                    ? 'Yes'
                                    : 'No' }}
                            </dd>
                        </div>

                        <div class="flex justify-between gap-4">
                            <dt class="text-sm text-slate-600 dark:text-slate-500">Views</dt>
                            <dd class="font-black text-slate-900 dark:text-white">
                                {{ number_format($course->views) }}
                            </dd>
                        </div>
                    </dl>
                </section>

                @if (collect($course->curriculum ?? [])->isNotEmpty())
                    <section class="rounded-[2rem] border border-slate-200 dark:border-white/10 bg-white dark:bg-slate-900/80 p-7">
                        <p class="text-xs font-black uppercase tracking-wider text-brand-primary">
                            Curriculum
                        </p>

                        <ul class="mt-5 space-y-3">
                            @foreach ($course->curriculum as $item)
                                <li class="flex gap-3 text-sm leading-7 text-slate-600 dark:text-slate-400">
                                    <span class="text-brand-primary dark:text-brand-primary-light">✓</span>
                                    <span>{{ $item }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </section>
                @endif
            </aside>
        </div>
    </div>
@endsection
