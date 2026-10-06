@extends('admin.layouts.app')

@section('title', $courseCategory->name)

@section('content')
    <div class="space-y-8">
        <div class="flex flex-col justify-between gap-5 sm:flex-row sm:items-end">
            <div>
                <p class="text-xs font-black uppercase tracking-[0.2em] text-brand-primary">
                    Course Category
                </p>

                <h1 class="mt-3 text-4xl font-black text-slate-900 dark:text-white">
                    {{ $courseCategory->name }}
                </h1>

                <p class="mt-3 text-sm text-slate-600 dark:text-slate-500">
                    {{ $courseCategory->slug }}
                </p>
            </div>

            <a
                href="{{ route(
                    'admin.course-categories.edit',
                    $courseCategory
                ) }}"
                class="rounded-2xl bg-brand-primary px-6 py-3.5 text-sm font-black text-slate-950"
            >
                Edit Category
            </a>
        </div>

        <div class="grid gap-7 lg:grid-cols-[1fr_330px]">
            <section class="rounded-[2rem] border border-slate-200 dark:border-white/10 bg-white dark:bg-slate-900/70 p-7">
                <p class="text-xs font-black uppercase tracking-wider text-brand-primary">
                    Description
                </p>

                <p class="mt-5 whitespace-pre-line text-sm leading-8 text-slate-600 dark:text-slate-400">
                    {{ $courseCategory->description
                        ?: 'No description provided.' }}
                </p>
            </section>

            <aside class="rounded-[2rem] border border-slate-200 dark:border-white/10 bg-white dark:bg-slate-900/80 p-7">
                <p class="text-xs font-black uppercase tracking-wider text-brand-primary">
                    Summary
                </p>

                <dl class="mt-6 space-y-5">
                    <div class="flex justify-between gap-4">
                        <dt class="text-sm text-slate-600 dark:text-slate-500">
                            Courses
                        </dt>

                        <dd class="font-black text-slate-900 dark:text-white">
                            {{ $courseCategory->courses_count }}
                        </dd>
                    </div>

                    <div class="flex justify-between gap-4">
                        <dt class="text-sm text-slate-600 dark:text-slate-500">
                            Icon
                        </dt>

                        <dd class="font-black text-slate-900 dark:text-white">
                            {{ $courseCategory->icon ?: 'Not set' }}
                        </dd>
                    </div>

                    <div class="flex justify-between gap-4">
                        <dt class="text-sm text-slate-600 dark:text-slate-500">
                            Status
                        </dt>

                        <dd class="font-black text-slate-900 dark:text-white">
                            {{ $courseCategory->is_active
                                ? 'Active'
                                : 'Inactive' }}
                        </dd>
                    </div>

                    <div class="flex justify-between gap-4">
                        <dt class="text-sm text-slate-600 dark:text-slate-500">
                            Sort order
                        </dt>

                        <dd class="font-black text-slate-900 dark:text-white">
                            {{ $courseCategory->sort_order }}
                        </dd>
                    </div>
                </dl>
            </aside>
        </div>

        @if ($courses->isNotEmpty())
            <section class="rounded-[2rem] border border-slate-200 dark:border-white/10 bg-white dark:bg-slate-900/70 p-7">
                <p class="text-xs font-black uppercase tracking-wider text-brand-primary">
                    Recent Courses
                </p>

                <div class="mt-6 divide-y divide-slate-200 dark:divide-white/[0.07]">
                    @foreach ($courses as $course)
                        <div class="flex items-center justify-between gap-5 py-4 first:pt-0 last:pb-0">
                            <div>
                                <p class="font-black text-slate-900 dark:text-white">
                                    {{ $course->title }}
                                </p>

                                <p class="mt-1 text-xs text-slate-600 dark:text-slate-600">
                                    {{ $course->code ?: $course->slug }}
                                </p>
                            </div>

                            <span class="rounded-full px-3 py-1.5 text-xs font-black
                                {{ $course->is_published
                                    ? 'bg-emerald-400/10 text-emerald-700 dark:text-emerald-300'
                                    : 'bg-slate-100 dark:bg-slate-400/10 text-slate-600 dark:text-slate-400'
                                }}"
                            >
                                {{ $course->is_published
                                    ? 'Published'
                                    : 'Draft' }}
                            </span>
                        </div>
                    @endforeach
                </div>
            </section>
        @endif
    </div>
@endsection
