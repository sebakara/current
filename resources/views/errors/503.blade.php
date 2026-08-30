@extends('frontend.layouts.app')

@section('title', 'Website Maintenance')
@section('robots', 'noindex, nofollow')

@section('content')
    <section class="relative flex min-h-[720px] items-center overflow-hidden bg-white dark:bg-slate-950 py-24">
        <div class="pointer-events-none absolute inset-0">
            <div class="absolute left-1/4 top-0 h-96 w-96 rounded-full bg-brand-primary-dark/10 blur-[140px]"></div>
            <div class="absolute bottom-0 right-1/4 h-96 w-96 rounded-full bg-brand-secondary/10 blur-[140px]"></div>
        </div>

        <div class="relative mx-auto w-full max-w-4xl px-4 text-center sm:px-6">
            <div class="rounded-[2.5rem] border border-brand-primary/20 bg-gradient-to-br from-brand-primary/10 via-slate-100 dark:via-slate-900 to-brand-secondary/[0.07] p-8 sm:p-14">
                <div class="mx-auto flex h-20 w-20 items-center justify-center rounded-[1.7rem] bg-brand-primary/10 text-2xl font-black text-brand-primary-dark dark:text-brand-primary-light">
                    503
                </div>

                <p class="mt-8 text-xs font-black uppercase tracking-[0.22em] text-brand-primary">
                    Scheduled Maintenance
                </p>

                <h1 class="mt-5 text-4xl font-black text-slate-900 dark:text-white sm:text-5xl">
                    We are improving the website.
                </h1>

                <p class="mx-auto mt-5 max-w-2xl text-base leading-8 text-slate-600 dark:text-slate-400">
                    VTLABS is temporarily unavailable while updates are being completed. Please check again shortly.
                </p>
