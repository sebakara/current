@extends('admin.layouts.app')

@section('title', 'Edit Page Section')

@section('content')
    <div>
        <p class="text-xs font-black uppercase tracking-[0.2em] text-brand-primary">
            {{ $page->title }}
        </p>

        <h1 class="mt-3 text-3xl font-black text-slate-900 dark:text-white sm:text-4xl">
            Edit
            {{ $section->title
                ?: str($section->section_key)
                    ->replace('_', ' ')
                    ->title() }}
        </h1>

        <form
            method="POST"
            action="{{ route(
                'admin.pages.sections.update',
                [$page, $section]
            ) }}"
            enctype="multipart/form-data"
            class="mt-8"
        >
            @csrf
            @method('PUT')

            @include('admin.page-sections._form')
        </form>
    </div>
@endsection
