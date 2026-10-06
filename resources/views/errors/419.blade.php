@extends('frontend.layouts.app')

@section('title', 'Session Expired')
@section('robots', 'noindex, nofollow')

@section('content')
    <section class="flex min-h-[720px] items-center bg-white dark:bg-slate-950 py-24">
        <div class="mx-auto w-full max-w-4xl px-4 text-center sm:px-6">
            <div class="rounded-[2.5rem] border border-amber-400/20 bg-gradient-to-br from-amber-400/10 via-slate-100 dark:via-slate-900 to-orange-500/[0.06] p-8 sm:p-14">
                <div class="mx-auto flex h-20 w-20 items-center justify-center rounded-[1.7rem] bg-amber-400/10 text-2xl font-black text-amber-700 dark:text-amber-300">
                    419
                </div>

                <p class="mt-8 text-xs font-black uppercase tracking-[0.22em] text-amber-400">
                    Session Expired
                </p>

                <h1 class="mt-5 text-4xl font-black text-slate-900 dark:text-white sm:text-5xl">
                    The form session has expired.
                </h1>

                <p class="mx-auto mt-5 max-w-2xl text-base leading-8 text-slate-600 dark:text-slate-400">
                    This normally happens when a form remains open for too long. Refresh the page and submit it again.
                </p>

                <div class="mt-9 flex flex-col justify-center gap-3 sm:flex-row">
                    <button
                        type="button"
                        onclick="window.location.reload()"
                        class="rounded-2xl bg-amber-400 px-7 py-4 text-sm font-black text-slate-950"
                    >
                        Refresh Page
                    </button>

                    <a
                        href="{{ route('home') }}"
                        class="rounded-2xl border border-slate-200 dark:border-white/10 bg-white dark:bg-white/[0.04] px-7 py-4 text-sm font-black text-slate-900 dark:text-white"
                    >
                        Return Home
                    </a>
                </div>
            </div>
        </div>
    </section>
@endsection
