@extends('admin.layouts.app')

@section('title', 'Projects')

@section('content')
    <div class="space-y-8">
        <div class="flex flex-col justify-between gap-5 sm:flex-row sm:items-end">
            <div>
                <p class="text-xs font-black uppercase tracking-[0.2em] text-brand-primary">
                    Portfolio Management
                </p>

                <h1 class="mt-3 text-3xl font-black text-slate-900 dark:text-white sm:text-4xl">
                    Projects
                </h1>

                <p class="mt-3 text-sm leading-7 text-slate-600 dark:text-slate-500">
                    Manage project case studies, images, technologies, and publishing.
                </p>
            </div>

            <a
                href="{{ route('admin.projects.create') }}"
                class="inline-flex items-center justify-center rounded-2xl bg-gradient-to-r from-brand-primary to-brand-secondary px-6 py-3.5 text-sm font-black text-white"
            >
                + New Project
            </a>
        </div>

        @if (session('success'))
            <div class="rounded-2xl border border-emerald-400/20 bg-emerald-400/10 px-5 py-4 text-sm font-semibold text-emerald-700 dark:text-emerald-300">
                {{ session('success') }}
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
                placeholder="Search title, client, or location..."
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
                    'all' => 'All projects',
                    'published' => 'Published',
                    'draft' => 'Draft',
                    'featured' => 'Featured',
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
                href="{{ route('admin.projects.index') }}"
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
                                Project
                            </th>

                            <th class="px-6 py-4 text-left text-xs font-black uppercase tracking-wider text-slate-600 dark:text-slate-500">
                                Category
                            </th>

                            <th class="px-6 py-4 text-left text-xs font-black uppercase tracking-wider text-slate-600 dark:text-slate-500">
                                Client
                            </th>

                            <th class="px-6 py-4 text-left text-xs font-black uppercase tracking-wider text-slate-600 dark:text-slate-500">
                                Completion
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
                        @forelse ($projects as $project)
                            <tr class="transition hover:bg-slate-100 dark:hover:bg-white/[0.02]">
                                <td class="px-6 py-5">
                                    <div class="flex items-center gap-4">
                                        <div class="flex h-14 w-14 shrink-0 items-center justify-center overflow-hidden rounded-2xl border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-slate-950">
                                            @if (
                                                $project->featured_image
                                                && Storage::disk('public')->exists($project->featured_image)
                                            )
                                                <img
                                                    src="{{ Storage::url($project->featured_image) }}"
                                                    alt="{{ $project->title }}"
                                                    class="h-full w-full object-cover"
                                                >
                                            @else
                                                <span class="text-sm font-black text-brand-primary dark:text-brand-primary-light">
                                                    {{ strtoupper(substr($project->title, 0, 2)) }}
                                                </span>
                                            @endif
                                        </div>

                                        <div class="min-w-0">
                                            <p class="max-w-sm truncate font-black text-slate-900 dark:text-white">
                                                {{ $project->title }}
                                            </p>

                                            <p class="mt-1 text-xs text-slate-600 dark:text-slate-600">
                                                {{ $project->location ?: $project->slug }}
                                            </p>
                                        </div>
                                    </div>
                                </td>

                                <td class="px-6 py-5 text-sm text-slate-600 dark:text-slate-400">
                                    {{ $project->category?->name ?: 'Uncategorised' }}
                                </td>

                                <td class="px-6 py-5 text-sm text-slate-600 dark:text-slate-400">
                                    {{ $project->client_name ?: 'Not specified' }}
                                </td>

                                <td class="px-6 py-5 text-sm text-slate-600 dark:text-slate-500">
                                    {{ $project->completed_at
                                        ? $project->completed_at->format('M Y')
                                        : 'Ongoing / unspecified' }}
                                </td>

                                <td class="px-6 py-5">
                                    <div class="flex flex-wrap gap-2">
                                        <span class="rounded-full px-3 py-1.5 text-xs font-black
                                            {{ $project->is_published
                                                ? 'bg-emerald-400/10 text-emerald-700 dark:text-emerald-300'
                                                : 'bg-slate-100 dark:bg-slate-400/10 text-slate-600 dark:text-slate-400'
                                            }}"
                                        >
                                            {{ $project->is_published
                                                ? 'Published'
                                                : 'Draft' }}
                                        </span>

                                        @if ($project->is_featured)
                                            <span class="rounded-full bg-brand-primary/10 px-3 py-1.5 text-xs font-black text-brand-primary dark:text-brand-primary-light">
                                                Featured
                                            </span>
                                        @endif
                                    </div>
                                </td>

                                <td class="px-6 py-5">
                                    <div class="flex justify-end gap-2">
                                        @if ($project->is_published)
                                            <a
                                                href="{{ route('projects.show', $project) }}"
                                                target="_blank"
                                                class="rounded-xl border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-white/[0.03] px-3 py-2 text-xs font-black text-slate-700 dark:text-slate-300"
                                            >
                                                View
                                            </a>
                                        @endif

                                        <a
                                            href="{{ route('admin.projects.edit', $project) }}"
                                            class="rounded-xl border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-white/[0.04] px-3 py-2 text-xs font-black text-slate-900 dark:text-white"
                                        >
                                            Edit
                                        </a>

                                        <form
                                            method="POST"
                                            action="{{ route('admin.projects.destroy', $project) }}"
                                            onsubmit="return confirm('Delete this project?')"
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
                                        No projects found
                                    </p>

                                    <p class="mt-2 text-sm text-slate-600 dark:text-slate-600">
                                        Create the first project or adjust the filters.
                                    </p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{ $projects->links() }}
    </div>
@endsection
