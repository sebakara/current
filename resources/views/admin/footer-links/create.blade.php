@extends('admin.layouts.app')

@section('title', 'Create Footer Link')

@section('content')
    <p class="text-xs font-black uppercase tracking-[0.2em] text-brand-primary">
        {{ $footerSection->title }}
    </p>

    <h1 class="mt-3 text-4xl font-black text-slate-900 dark:text-white">
        Create Footer Link
    </h1>

    <form
        method="POST"
        action="{{ route(
            'admin.footer-sections.links.store',
            $footerSection
        ) }}"
        class="mt-8"
    >
        @csrf

        @include('admin.footer-links._form')
    </form>
@endsection
