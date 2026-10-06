@extends('admin.layouts.app')

@section('title', 'Edit Footer Link')

@section('content')
    <p class="text-xs font-black uppercase tracking-[0.2em] text-brand-primary">
        {{ $footerSection->title }}
    </p>

    <h1 class="mt-3 text-4xl font-black text-slate-900 dark:text-white">
        Edit {{ $footerLink->label }}
    </h1>

    <form
        method="POST"
        action="{{ route(
            'admin.footer-sections.links.update',
            [$footerSection, $footerLink]
        ) }}"
        class="mt-8"
    >
        @csrf
        @method('PUT')

        @include('admin.footer-links._form')
    </form>
@endsection
