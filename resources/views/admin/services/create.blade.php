@extends('admin.layouts.app')

@section('title', 'Create Service')
@section('page-heading', 'Create Service')

@section('content')
    <div class="mb-6">
        <a
            href="{{ route('admin.services.index') }}"
            class="inline-flex items-center gap-2 text-sm font-bold text-slate-600 dark:text-slate-500 transition hover:text-brand-primary"
        >
            <span>←</span>
            Back to services
        </a>

        <h2 class="mt-4 text-2xl font-black text-slate-900 dark:text-white">
            Create service
        </h2>

        <p class="mt-2 text-sm text-slate-600 dark:text-slate-500">
            Add a new VTLABS service to the website.
        </p>
    </div>

    <form
        method="POST"
        action="{{ route('admin.services.store') }}"
        enctype="multipart/form-data"
    >
        @csrf

        @include('admin.services._form')
    </form>
@endsection
