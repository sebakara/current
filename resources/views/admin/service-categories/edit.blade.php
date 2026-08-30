@extends('admin.layouts.app')

@section('title', 'Edit Service Category')
@section('page-heading', 'Edit Service Category')

@section('content')
    <div class="mb-6">
        <a
            href="{{ route('admin.service-categories.index') }}"
            class="inline-flex items-center gap-2 text-sm font-bold text-slate-600 dark:text-slate-500 transition hover:text-brand-primary"
        >
            <span>←</span>
            Back to service categories
        </a>

        <h2 class="mt-4 text-2xl font-black text-slate-900 dark:text-white">
            Edit {{ $serviceCategory->name }}
        </h2>

        <p class="mt-2 text-sm text-slate-600 dark:text-slate-500">
            Update the category information and publishing status.
        </p>
    </div>

    <form
        method="POST"
        action="{{ route(
            'admin.service-categories.update',
            $serviceCategory
        ) }}"
        enctype="multipart/form-data"
    >
        @csrf
        @method('PUT')

        @include('admin.service-categories._form')
    </form>
@endsection
