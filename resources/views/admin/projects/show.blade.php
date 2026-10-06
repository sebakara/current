@extends('admin.layouts.app')

@section('title', $project->title)

@section('content')
    <div class="space-y-8">
        <div class="flex flex-col justify-between gap-5 sm:flex-row sm:items-end">
            <div>
                <p class="text-xs font-black uppercase tracking-[0.2em] text-brand-primary">
                    Project Details
                </p>

                <h1 class="mt-3 text-4xl font-black text-slate-900 dark:text-white">
                    {{ $project->title }}
                </h1>

                <p class="mt-3 text-sm text-slate-600 dark:text-slate-500">
                    {{ $project->client_name ?: 'No client specified' }}
                </p>
            </div>

            <div class="flex flex-wrap gap-3">
                @if ($project->is_published)
                    <a
                        href="{{ route('projects.show', $project) }}"
                        target="_blank"
                        class="rounded-2xl border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-white/[0.04] px-6 py-3.5 text-sm font-black text-slate-900 dark:text-white"
                    >
                        View Public Page
                    </a>
                @endif

                <a
                    href="{{ route('admin.projects.edit', $project) }}"
                    class="rounded-2xl bg-brand-primary px-6 py-3.5 text-sm font-black text-slate-950"
                >
                    Edit Project
                </a>
            </div>
        </div>

        <div class="grid gap-7 lg:grid-cols-[1fr_350px]">
            <div class="space-y-7">
                @if (
                    $project->featured_image
                    && Storage::disk('public')->exists($project->featured_image)
                )
                    <img
                        src="{{ Storage::url($project->featured_image) }}"
                        alt="{{ $project->title }}"
                        class="h-[440px] w-full rounded-[2rem] border border-slate-200 dark:border-white/10 object-cover"
                    >
                @endif

                @foreach ([
                    'Description' => $project->description,
                    'Challenge' => $project->challenge,
                    'Solution' => $project->solution,
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

                @if (collect($project->gallery ?? [])->isNotEmpty())
                    <section class="rounded-[2rem] border border-slate-200 dark:border-white/10 bg-white dark:bg-slate-900/70 p-7">
                        <p class="text-xs font-black uppercase tracking-wider text-brand-primary">
                            Gallery
                        </p>

                        <div class="mt-6 grid gap-4 sm:grid-cols-2">
                            @foreach ($project->gallery as $image)
                                @if (
                                    $image
                                    && Storage::disk('public')->exists($image)
                                )
                                    <img
                                        src="{{ Storage::url($image) }}"
                                        alt="{{ $project->title }}"
                                        class="h-64 w-full rounded-2xl object-cover"
                                    >
                                @endif
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
                                {{ $project->category?->name }}
                            </dd>
                        </div>

                        <div class="flex justify-between gap-4">
                            <dt class="text-sm text-slate-600 dark:text-slate-500">Client</dt>
                            <dd class="text-right font-black text-slate-900 dark:text-white">
                                {{ $project->client_name ?: 'Not specified' }}
                            </dd>
                        </div>

                        <div class="flex justify-between gap-4">
                            <dt class="text-sm text-slate-600 dark:text-slate-500">Location</dt>
                            <dd class="text-right font-black text-slate-900 dark:text-white">
                                {{ $project->location ?: 'Not specified' }}
                            </dd>
                        </div>

                        <div class="flex justify-between gap-4">
                            <dt class="text-sm text-slate-600 dark:text-slate-500">
                                Completed
                            </dt>

                            <dd class="text-right font-black text-slate-900 dark:text-white">
                                {{ $project->completed_at
                                    ? $project->completed_at->format('d M Y')
                                    : 'Unspecified' }}
                            </dd>
                        </div>

                        <div class="flex justify-between gap-4">
                            <dt class="text-sm text-slate-600 dark:text-slate-500">
                                Published
                            </dt>

                            <dd class="font-black text-slate-900 dark:text-white">
                                {{ $project->is_published ? 'Yes' : 'No' }}
                            </dd>
                        </div>

                        <div class="flex justify-between gap-4">
                            <dt class="text-sm text-slate-600 dark:text-slate-500">
                                Views
                            </dt>

                            <dd class="font-black text-slate-900 dark:text-white">
                                {{ number_format($project->views) }}
                            </dd>
                        </div>
                    </dl>
                </section>

                @if (collect($project->technologies ?? [])->isNotEmpty())
                    <section class="rounded-[2rem] border border-slate-200 dark:border-white/10 bg-white dark:bg-slate-900/80 p-7">
                        <p class="text-xs font-black uppercase tracking-wider text-brand-primary">
                            Technologies
                        </p>

                        <div class="mt-5 flex flex-wrap gap-2">
                            @foreach ($project->technologies as $technology)
                                <span class="rounded-full border border-brand-primary/15 bg-brand-primary/[0.07] px-3 py-2 text-xs font-black text-brand-primary dark:text-brand-primary-light">
                                    {{ $technology }}
                                </span>
                            @endforeach
                        </div>
                    </section>
                @endif

                @if ($project->video_url)
                    <a
                        href="{{ $project->video_url }}"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="flex w-full items-center justify-center rounded-2xl border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-white/[0.04] px-6 py-4 text-sm font-black text-slate-900 dark:text-white"
                    >
                        Open Project Video
                    </a>
                @endif
            </aside>
        </div>
    </div>
@endsection
