@extends('admin.layouts.app')

@section(
    'title',
    'Application ' . $trainingApplication->application_number
)

@section('content')
    @php
        $application = $trainingApplication;
    @endphp

    <div class="space-y-8">
        <div class="flex flex-col justify-between gap-5 lg:flex-row lg:items-end">
            <div>
                <p class="text-xs font-black uppercase tracking-[0.2em] text-brand-primary">
                    Training Application
                </p>

                <h1 class="mt-3 text-3xl font-black text-slate-900 dark:text-white sm:text-4xl">
                    {{ $application->full_name }}
                </h1>

                <p class="mt-3 text-sm text-slate-600 dark:text-slate-500">
                    {{ $application->application_number }}
                </p>
            </div>

            <div class="flex flex-wrap gap-3">
                <a
                    href="{{ route('admin.training-applications.index') }}"
                    class="rounded-2xl border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-white/[0.04] px-6 py-3.5 text-sm font-black text-slate-700 dark:text-slate-300"
                >
                    Back to Applications
                </a>

                @if ($application->course)
                    <a
                        href="{{ route(
                            'admin.courses.show',
                            $application->course
                        ) }}"
                        class="rounded-2xl bg-brand-primary px-6 py-3.5 text-sm font-black text-slate-950"
                    >
                        View Course
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

        <div class="grid gap-7 xl:grid-cols-[1fr_380px]">
            <div class="space-y-7">
                <section class="rounded-[2rem] border border-slate-200 dark:border-white/10 bg-white dark:bg-slate-900/70 p-7">
                    <p class="text-xs font-black uppercase tracking-wider text-brand-primary">
                        Applicant Information
                    </p>

                    <dl class="mt-6 grid gap-6 sm:grid-cols-2">
                        @foreach ([
                            'Full name' => $application->full_name,
                            'Email' => $application->email,
                            'Phone' => $application->phone,
                            'Gender' => $application->gender
                                ? str($application->gender)
                                    ->replace('-', ' ')
                                    ->title()
                                : null,
                            'Date of birth' => $application->date_of_birth
                                ? $application->date_of_birth->format(
                                    'd M Y'
                                )
                                : null,
                            'Nationality' => $application->nationality,
                            'Education level' =>
                                $application->education_level,
                            'Current occupation' =>
                                $application->current_occupation,
                            'Preferred schedule' =>
                                $application->preferred_schedule,
                            'Address' => $application->address,
                        ] as $label => $value)
                            <div>
                                <dt class="text-xs font-black uppercase tracking-wider text-slate-600 dark:text-slate-600">
                                    {{ $label }}
                                </dt>

                                <dd class="mt-2 whitespace-pre-line text-sm font-semibold leading-7 text-slate-700 dark:text-slate-300">
                                    {{ $value ?: 'Not provided' }}
                                </dd>
                            </div>
                        @endforeach
                    </dl>
                </section>

                <section class="rounded-[2rem] border border-slate-200 dark:border-white/10 bg-white dark:bg-slate-900/70 p-7">
                    <p class="text-xs font-black uppercase tracking-wider text-brand-primary">
                        Motivation
                    </p>

                    <p class="mt-5 whitespace-pre-line text-sm leading-8 text-slate-600 dark:text-slate-400">
                        {{ $application->motivation }}
                    </p>
                </section>

                <section class="rounded-[2rem] border border-slate-200 dark:border-white/10 bg-white dark:bg-slate-900/70 p-7">
                    <p class="text-xs font-black uppercase tracking-wider text-brand-primary">
                        Previous Experience
                    </p>

                    <p class="mt-5 whitespace-pre-line text-sm leading-8 text-slate-600 dark:text-slate-400">
                        {{ $application->experience
                            ?: 'No previous experience was provided.' }}
                    </p>
                </section>

                @if ($application->document)
                    <section class="rounded-[2rem] border border-slate-200 dark:border-white/10 bg-white dark:bg-slate-900/70 p-7">
                        <p class="text-xs font-black uppercase tracking-wider text-brand-primary">
                            Supporting Document
                        </p>

                        @if (
                            Storage::disk('public')->exists(
                                $application->document
                            )
                        )
                            <a
                                href="{{ Storage::url(
                                    $application->document
                                ) }}"
                                target="_blank"
                                rel="noopener noreferrer"
                                class="mt-5 inline-flex rounded-2xl border border-brand-primary/20 bg-brand-primary/[0.08] px-5 py-3 text-sm font-black text-brand-primary dark:text-brand-primary-light"
                            >
                                Open Supporting Document
                            </a>
                        @else
                            <p class="mt-5 text-sm text-amber-700 dark:text-amber-300">
                                The document record exists, but the file is missing.
                            </p>
                        @endif
                    </section>
                @endif
            </div>

            <aside class="space-y-7">
                <section class="rounded-[2rem] border border-slate-200 dark:border-white/10 bg-white dark:bg-slate-900/80 p-7">
                    <p class="text-xs font-black uppercase tracking-wider text-brand-primary">
                        Application Summary
                    </p>

                    <dl class="mt-6 space-y-5">
                        <div>
                            <dt class="text-xs font-black uppercase tracking-wider text-slate-600 dark:text-slate-600">
                                Course
                            </dt>

                            <dd class="mt-2 text-sm font-black leading-7 text-slate-900 dark:text-white">
                                {{ $application->course?->title
                                    ?: 'Course unavailable' }}
                            </dd>
                        </div>

                        <div>
                            <dt class="text-xs font-black uppercase tracking-wider text-slate-600 dark:text-slate-600">
                                Submitted
                            </dt>

                            <dd class="mt-2 text-sm font-black text-slate-900 dark:text-white">
                                {{ $application->created_at->format(
                                    'd M Y, H:i'
                                ) }}
                            </dd>
                        </div>

                        <div>
                            <dt class="text-xs font-black uppercase tracking-wider text-slate-600 dark:text-slate-600">
                                Last reviewed
                            </dt>

                            <dd class="mt-2 text-sm font-black leading-7 text-slate-900 dark:text-white">
                                @if ($application->reviewed_at)
                                    {{ $application->reviewed_at->format(
                                        'd M Y, H:i'
                                    ) }}

                                    @if ($application->reviewer)
                                        <span class="block text-xs font-normal text-slate-600 dark:text-slate-500">
                                            by {{ $application->reviewer->name }}
                                        </span>
                                    @endif
                                @else
                                    Not reviewed
                                @endif
                            </dd>
                        </div>
                    </dl>
                </section>

                <form
                    method="POST"
                    action="{{ route(
                        'admin.training-applications.update',
                        $application
                    ) }}"
                    class="rounded-[2rem] border border-slate-200 dark:border-white/10 bg-white dark:bg-slate-900/80 p-7"
                >
                    @csrf
                    @method('PUT')

                    <p class="text-xs font-black uppercase tracking-wider text-brand-primary">
                        Review Decision
                    </p>

                    <label class="mt-6 block">
                        <span class="mb-2 block text-sm font-black text-slate-700 dark:text-slate-300">
                            Application status
                        </span>

                        <select
                            name="status"
                            required
                            class="w-full rounded-2xl border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-slate-950 px-4 py-3.5 text-slate-900 dark:text-white"
                        >
                            @foreach ([
                                'pending' => 'Pending',
                                'under-review' => 'Under review',
                                'accepted' => 'Accepted',
                                'rejected' => 'Rejected',
                                'waitlisted' => 'Waitlisted',
                                'cancelled' => 'Cancelled',
                            ] as $value => $label)
                                <option
                                    value="{{ $value }}"
                                    @selected(
                                        old(
                                            'status',
                                            $application->status
                                        ) === $value
                                    )
                                >
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                    </label>

                    <label class="mt-5 block">
                        <span class="mb-2 block text-sm font-black text-slate-700 dark:text-slate-300">
                            Internal notes
                        </span>

                        <textarea
                            name="admin_notes"
                            rows="10"
                            maxlength="10000"
                            placeholder="Add review notes, interview details, or follow-up instructions..."
                            class="w-full rounded-2xl border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-slate-950 px-4 py-3.5 text-slate-900 dark:text-white"
                        >{{ old(
                            'admin_notes',
                            $application->admin_notes
                        ) }}</textarea>

                        <span class="mt-2 block text-xs text-slate-600 dark:text-slate-600">
                            These notes are visible only to administrators.
                        </span>
                    </label>

                    <button
                        type="submit"
                        class="mt-7 w-full rounded-2xl bg-gradient-to-r from-brand-primary to-brand-secondary px-6 py-4 text-sm font-black text-white"
                    >
                        Save Review
                    </button>
                </form>
            </aside>
        </div>
    </div>
@endsection
