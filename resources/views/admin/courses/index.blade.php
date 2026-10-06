@extends('admin.layouts.app')

@section('title', 'Courses')

@section('content')
    <div class="space-y-8">
        <div class="flex flex-col justify-between gap-5 sm:flex-row sm:items-end">
            <div>
                <p class="text-xs font-black uppercase tracking-[0.2em] text-brand-primary">
                    Academy Management
                </p>

                <h1 class="mt-3 text-3xl font-black text-slate-900 dark:text-white sm:text-4xl">
                    Courses
                </h1>

                <p class="mt-3 text-sm leading-7 text-slate-600 dark:text-slate-500">
                    Manage Academy courses, schedules, fees, capacity, and applications.
                </p>
            </div>

            <a
                href="{{ route('admin.courses.create') }}"
                class="inline-flex items-center justify-center rounded-2xl bg-gradient-to-r from-brand-primary to-brand-secondary px-6 py-3.5 text-sm font-black text-white"
            >
                + New Course
            </a>
        </div>

        @if (session('success'))
            <div class="rounded-2xl border border-emerald-400/20 bg-emerald-400/10 px-5 py-4 text-sm font-semibold text-emerald-700 dark:text-emerald-300">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="rounded-2xl border border-red-400/20 bg-red-400/10 px-5 py-4 text-sm font-semibold text-red-700 dark:text-red-300">
                {{ session('error') }}
            </div>
        @endif

        <form
            method="GET"
            class="grid gap-3 rounded-2xl border border-slate-200 dark:border-white/10 bg-white dark:bg-slate-900/70 p-4 md:grid-cols-[1fr_230px_180px_auto_auto]"
        >
            <input
                type="search"
                name="search"
                value="{{ $search }}"
                placeholder="Search course name, code, or description..."
                class="rounded-xl border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-slate-950 px-4 py-3 text-slate-900 dark:text-white"
            >

            <select
                name="category"
                class="rounded-xl border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-slate-950 px-4 py-3 text-slate-900 dark:text-white"
            >
                <option value="">All categories</option>

                @foreach ($categories as $category)
                    <option
                        value="{{ $category->id }}"
                        @selected($categoryId === $category->id)
                    >
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>

            <select
                name="status"
                class="rounded-xl border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-slate-950 px-4 py-3 text-slate-900 dark:text-white"
            >
                @foreach ([
                    'all' => 'All courses',
                    'published' => 'Published',
                    'draft' => 'Draft',
                    'featured' => 'Featured',
                    'open' => 'Applications open',
                    'closed' => 'Applications closed',
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
                href="{{ route('admin.courses.index') }}"
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
                                Course
                            </th>

                            <th class="px-6 py-4 text-left text-xs font-black uppercase tracking-wider text-slate-600 dark:text-slate-500">
                                Category
                            </th>

                            <th class="px-6 py-4 text-left text-xs font-black uppercase tracking-wider text-slate-600 dark:text-slate-500">
                                Fee
                            </th>

                            <th class="px-6 py-4 text-left text-xs font-black uppercase tracking-wider text-slate-600 dark:text-slate-500">
                                Applications
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
                        @forelse ($courses as $course)
                            <tr class="transition hover:bg-slate-100 dark:hover:bg-white/[0.02]">
                                <td class="px-6 py-5">
                                    <div class="flex items-center gap-4">
                                        <div class="flex h-14 w-14 shrink-0 items-center justify-center overflow-hidden rounded-2xl border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-slate-950">
                                            @if (
                                                $course->featured_image
                                                && Storage::disk('public')->exists($course->featured_image)
                                            )
                                                <img
                                                    src="{{ Storage::url($course->featured_image) }}"
                                                    alt="{{ $course->title }}"
                                                    class="h-full w-full object-cover"
                                                >
                                            @else
                                                <span class="text-sm font-black text-brand-primary dark:text-brand-primary-light">
                                                    {{ strtoupper(substr($course->title, 0, 2)) }}
                                                </span>
                                            @endif
                                        </div>

                                        <div class="min-w-0">
                                            <p class="max-w-sm truncate font-black text-slate-900 dark:text-white">
                                                {{ $course->title }}
                                            </p>

                                            <p class="mt-1 text-xs text-slate-600 dark:text-slate-600">
                                                {{ $course->code ?: $course->slug }}
                                            </p>
                                        </div>
                                    </div>
                                </td>

                                <td class="px-6 py-5 text-sm text-slate-600 dark:text-slate-400">
                                    {{ $course->category?->name ?: 'Uncategorised' }}
                                </td>

                                <td class="px-6 py-5">
                                    @if ($course->fee !== null)
                                        <p class="font-black text-slate-900 dark:text-white">
                                            {{ $course->currency }}
                                            {{ number_format((float) $course->fee, 2) }}
                                        </p>
                                    @else
                                        <span class="text-sm font-black text-brand-primary dark:text-brand-primary-light">
                                            On request
                                        </span>
                                    @endif
                                </td>

                                <td class="px-6 py-5">
                                    <p class="font-black text-slate-900 dark:text-white">
                                        {{ number_format($course->applications_count) }}
                                    </p>

                                    @if ($course->available_places !== null)
                                        <p class="mt-1 text-xs text-slate-600 dark:text-slate-600">
                                            {{ $course->available_places }} places left
                                        </p>
                                    @endif
                                </td>

                                <td class="px-6 py-5">
                                    <div class="flex flex-wrap gap-2">
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

                                        <span class="rounded-full px-3 py-1.5 text-xs font-black
                                            {{ $course->applicationsAreOpen()
                                                ? 'bg-brand-primary/10 text-brand-primary dark:text-brand-primary-light'
                                                : 'bg-amber-400/10 text-amber-700 dark:text-amber-300'
                                            }}"
                                        >
                                            {{ $course->applicationsAreOpen()
                                                ? 'Applications open'
                                                : 'Applications closed' }}
                                        </span>

                                        @if ($course->is_featured)
                                            <span class="rounded-full bg-brand-secondary-light/10 px-3 py-1.5 text-xs font-black text-brand-secondary dark:text-brand-secondary-light">
                                                Featured
                                            </span>
                                        @endif
                                    </div>
                                </td>

                                <td class="px-6 py-5">
                                    <div class="flex justify-end gap-2">
                                        @if ($course->is_published)
                                            <a
                                                href="{{ route(
                                                    'academy.courses.show',
                                                    $course
                                                ) }}"
                                                target="_blank"
                                                class="rounded-xl border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-white/[0.03] px-3 py-2 text-xs font-black text-slate-700 dark:text-slate-300"
                                            >
                                                View
                                            </a>
                                        @endif

                                        <a
                                            href="{{ route(
                                                'admin.courses.edit',
                                                $course
                                            ) }}"
                                            class="rounded-xl border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-white/[0.04] px-3 py-2 text-xs font-black text-slate-900 dark:text-white"
                                        >
                                            Edit
                                        </a>

                                        <form
                                            method="POST"
                                            action="{{ route(
                                                'admin.courses.destroy',
                                                $course
                                            ) }}"
                                            onsubmit="return confirm('Delete this course?')"
                                        >
                                            @csrf
                                            @method('DELETE')

                                            <button
                                                type="submit"
                                                class="rounded-xl border border-red-400/15 bg-red-400/[0.06] px-3 py-2 text-xs font-black text-red-700 dark:text-red-300"
                                            >
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td
                                    colspan="6"
                                    class="px-6 py-16 text-center"
                                >
                                    <p class="text-lg font-black text-slate-900 dark:text-white">
                                        No courses found
                                    </p>

                                    <p class="mt-2 text-sm text-slate-600 dark:text-slate-600">
                                        Create the first Academy course or adjust the filters.
                                    </p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{ $courses->links() }}
    </div>
@endsection
