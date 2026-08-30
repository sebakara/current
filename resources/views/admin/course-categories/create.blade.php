@extends('admin.layouts.app')

@section('title', 'Create Course Category')

@section('content')
    <div>
        <p class="text-xs font-black uppercase tracking-[0.2em] text-brand-primary">
            Academy Management
        </p>

        <h1 class="mt-3 text-3xl font-black text-slate-900 dark:text-white sm:text-4xl">
            Create Course Category
        </h1>

        <form
            method="POST"
            action="{{ route('admin.course-categories.store') }}"
            class="mt-8"
        >
            @csrf

            @include('admin.course-categories._form')
        </form>
    </div>
@endsection
