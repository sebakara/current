@extends('admin.layouts.app')

@section('title', 'Edit Page')

@section('content')
    <div>
        <p class="text-xs font-black uppercase tracking-[0.2em] text-brand-primary">
            Website Content
        </p>

        <h1 class="mt-3 text-3xl font-black text-slate-900 dark:text-white sm:text-4xl">
            Edit {{ $page->title }}
        </h1>

        <form
            method="POST"
            action="{{ route('admin.pages.update', $page) }}"
            enctype="multipart/form-data"
            class="mt-8"
        >
            @csrf
            @method('PUT')

            @include('admin.pages._form')
        </form>
    </div>
@endsection
