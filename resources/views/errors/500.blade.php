@extends('frontend.layouts.app')

@section('title', 'Server Error')
@section('robots', 'noindex, nofollow')

@section('content')
    <section class="flex min-h-[720px] items-center bg-white dark:bg-slate-950 py-24">
        <div class="mx-auto w-full max-w-4xl px-4 text-center sm:px-6">
            <div class="rounded-[2.5rem] border border-red-400/20 bg-gradient-to-br from-red-400/10 via-slate-100 dark:via-slate-900 to-orange-500/[0.05] p-8 sm:p-14">
                <div class="mx-auto flex h-20 w-20 items-center justify-center rounded-[1.7rem] bg-red-400/10 text-2xl font-black text-red-700 dark:text-red-300">
                    500
                </div>

                <p class="mt-8 text-xs font-black uppercase tracking-[0.22em] text-red-400">
                    Server Error
                </p>

                <h1 class="mt-5 text-4xl font-black text-slate-900 dark:text-white sm:text-5xl">
                    Something went wrong.
                </h1>

                <p class="mx-auto mt-5 max-w-2xl text-base leading-8 text-slate-600 dark:text-slate-400">
                    The request could not be completed. Please try again shortly or contact the VTLABS team if the problem continues.
                </p>

                <div class="mt-9 flex flex-col justify-center gap-3 sm:flex-row">
                    <button
                        type="button"
                        onclick="window.location.reload()"
                        class="rounded-2xl bg-red-400 px-7 py-4 text-sm font-black text-slate-950"
                    >
                        Try Again
                    </button>

                    <a
                        href="{{ route('contact') }}"
                        class="rounded-2xl border border-slate-200 dark:border-white/10 bg-white dark:bg-white/[0.04] px-7 py-4 text-sm font-black text-slate-900 dark:text-white"
                    >
                        Contact Support
                    </a>
                </div>
            </div>
        </div>
    </section>
@endsection
