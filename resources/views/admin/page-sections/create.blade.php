@extends('admin.layouts.app')

@section('title', 'Create Page Section')

@section('content')
    <div>
        <p class="text-xs font-black uppercase tracking-[0.2em] text-brand-primary">
            {{ $page->title }}
        </p>

        <h1 class="mt-3 text-3xl font-black text-slate-900 dark:text-white sm:text-4xl">
            Create Page Section
        </h1>

        <form
            method="POST"
            action="{{ route(
                'admin.pages.sections.store',
                $page
            ) }}"
            enctype="multipart/form-data"
            class="mt-8"
        >
            @csrf

            @include('admin.page-sections._form')
        </form>
    </div>
@endsection
