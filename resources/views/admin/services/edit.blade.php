@extends('admin.layouts.app')

@section('title', 'Edit Service')
@section('page-heading', 'Edit Service')

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
            Edit {{ $service->title }}
        </h2>

        <p class="mt-2 text-sm text-slate-600 dark:text-slate-500">
            Update the service content, media, SEO, and publication status.
        </p>
    </div>

    <form
        method="POST"
        action="{{ route('admin.services.update', $service) }}"
        enctype="multipart/form-data"
    >
        @csrf
        @method('PUT')

        @include('admin.services._form')
    </form>
@endsection
