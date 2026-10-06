@extends('frontend.layouts.app')

@section('title', 'Application Submitted')

@section('content')
    <section class="flex min-h-[700px] items-center bg-white dark:bg-slate-950 py-24">
        <div class="mx-auto w-full max-w-4xl px-4 sm:px-6">
            <div class="rounded-[2.5rem] border border-emerald-400/20 bg-gradient-to-br from-emerald-400/10 via-slate-100 dark:via-slate-900 to-brand-primary/10 p-8 text-center sm:p-14">
                <div class="mx-auto flex h-20 w-20 items-center justify-center rounded-[1.7rem] bg-emerald-400/10 text-3xl text-emerald-700 dark:text-emerald-300">
                    ✓
                </div>

                <p class="mt-8 text-xs font-black uppercase tracking-[0.22em] text-emerald-400">
                    Application Received
                </p>

                <h1 class="mt-5 text-4xl font-black text-slate-900 dark:text-white sm:text-5xl">
                    Thank you, {{ $application->full_name }}.
                </h1>

                <p class="mx-auto mt-5 max-w-2xl text-base leading-8 text-slate-600 dark:text-slate-400">
                    Your application for
                    <strong class="text-slate-900 dark:text-white">
                        {{ $application->course?->title
                            ?: 'the selected course' }}
                    </strong>
                    has been submitted successfully.
                </p>

                <div class="mx-auto mt-8 max-w-md rounded-2xl border border-slate-200 dark:border-white/10 bg-white/50 dark:bg-slate-950/50 p-6">
                    <p class="text-xs font-black uppercase tracking-wider text-slate-600 dark:text-slate-500">
                        Application Number
                    </p>

                    <p class="mt-3 text-2xl font-black text-brand-primary-dark dark:text-brand-primary-light">
                        {{ $application->application_number }}
                    </p>
                </div>

                <p class="mt-7 text-sm leading-7 text-slate-600 dark:text-slate-500">
                    Keep this number for reference. The Academy team will contact you using the phone number or email you provided.
                </p>

                <div class="mt-9 flex flex-col justify-center gap-3 sm:flex-row">
                    <a
                        href="{{ route('academy') }}"
                        class="rounded-2xl bg-brand-primary px-6 py-4 text-sm font-black text-slate-950"
                    >
                        Explore More Courses
                    </a>

                    <a
                        href="{{ route('home') }}"
                        class="rounded-2xl border border-slate-200 dark:border-white/10 bg-white dark:bg-white/[0.04] px-6 py-4 text-sm font-black text-slate-900 dark:text-white"
                    >
                        Return Home
                    </a>
                </div>
            </div>
        </div>
    </section>
@endsection
