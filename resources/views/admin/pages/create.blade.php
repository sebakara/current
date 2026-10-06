@extends('admin.layouts.app')

@section('title', 'Create Page')

@section('content')
    <div>
        <p class="text-xs font-black uppercase tracking-[0.2em] text-brand-primary">
            Website Content
        </p>

        <h1 class="mt-3 text-3xl font-black text-slate-900 dark:text-white sm:text-4xl">
            Create Page
        </h1>

        <form
            method="POST"
            action="{{ route('admin.pages.store') }}"
            enctype="multipart/form-data"
            class="mt-8"
        >
            @csrf

            @include('admin.pages._form')
        </form>
    </div>
@endsection
