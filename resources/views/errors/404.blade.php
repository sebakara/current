@extends('frontend.layouts.app')

@section('title', 'Page Not Found')
@section('robots', 'noindex, nofollow')

@section('content')
    <section class="relative flex min-h-[760px] items-center overflow-hidden bg-white dark:bg-slate-950 py-24">
        <div class="pointer-events-none absolute inset-0">
            <div class="absolute -left-40 top-0 h-[34rem] w-[34rem] rounded-full bg-brand-primary-dark/10 blur-[150px]"></div>
            <div class="absolute -right-40 bottom-0 h-[34rem] w-[34rem] rounded-full bg-brand-secondary/10 blur-[150px]"></div>

            <div
                class="absolute inset-0 opacity-[0.035] text-slate-900 dark:text-white"
                style="
                    background-image:
                    linear-gradient(currentColor 1px, transparent 1px),
                    linear-gradient(90deg, currentColor 1px, transparent 1px);
                    background-size: 54px 54px;
                "
            ></div>
        </div>

        <div class="relative mx-auto w-full max-w-5xl px-4 text-center sm:px-6 lg:px-8">
            <div class="mx-auto flex h-20 w-20 items-center justify-center rounded-[1.7rem] border border-brand-primary/20 bg-brand-primary/10 text-2xl font-black text-brand-primary-dark dark:text-brand-primary-light">
                404
            </div>

            <p class="mt-8 text-xs font-black uppercase tracking-[0.22em] text-brand-primary">
                Page Not Found
            </p>

            <h1 class="mt-5 text-5xl font-black leading-tight tracking-[-0.045em] text-slate-900 dark:text-white sm:text-6xl lg:text-7xl">
                This page does not exist.
            </h1>

            <p class="mx-auto mt-6 max-w-2xl text-base leading-8 text-slate-600 dark:text-slate-400">
                The address may be incorrect, the page may have moved, or the content may no longer be available.
            </p>

            <div class="mt-10 flex flex-col justify-center gap-3 sm:flex-row">
                <a
                    href="{{ route('home') }}"
                    class="inline-flex items-center justify-center rounded-2xl bg-gradient-to-r from-brand-primary to-brand-secondary px-7 py-4 text-sm font-black text-white"
                >
                    Return Home
                </a>

                <a
                    href="{{ route('contact') }}"
                    class="inline-flex items-center justify-center rounded-2xl border border-slate-200 dark:border-white/10 bg-white dark:bg-white/[0.04] px-7 py-4 text-sm font-black text-slate-900 dark:text-white"
                >
                    Contact VTLABS
                </a>
            </div>

            <div class="mx-auto mt-12 grid max-w-3xl gap-4 sm:grid-cols-3">
                <a
                    href="{{ route('services.index') }}"
                    class="rounded-2xl border border-slate-200 dark:border-white/10 bg-white dark:bg-white/[0.03] p-5 text-left transition hover:border-brand-primary/20"
                >
                    <p class="font-black text-slate-900 dark:text-white">Services</p>
                    <p class="mt-2 text-xs leading-6 text-slate-600 dark:text-slate-500">
                        Engineering and technical solutions.
                    </p>
                </a>

                <a
                    href="{{ route('products') }}"
                    class="rounded-2xl border border-slate-200 dark:border-white/10 bg-white dark:bg-white/[0.03] p-5 text-left transition hover:border-brand-primary/20"
                >
                    <p class="font-black text-slate-900 dark:text-white">Products</p>
                    <p class="mt-2 text-xs leading-6 text-slate-600 dark:text-slate-500">
                        Explore available products.
                    </p>
                </a>

                <a
                    href="{{ route('academy') }}"
                    class="rounded-2xl border border-slate-200 dark:border-white/10 bg-white dark:bg-white/[0.03] p-5 text-left transition hover:border-brand-primary/20"
                >
                    <p class="font-black text-slate-900 dark:text-white">Academy</p>
                    <p class="mt-2 text-xs leading-6 text-slate-600 dark:text-slate-500">
                        Practical technical training.
                    </p>
                </a>
            </div>
        </div>
    </section>
@endsection
