@extends('admin.layouts.app')

@section('title', 'Edit Course')

@section('content')
    <div>
        <p class="text-xs font-black uppercase tracking-[0.2em] text-brand-primary">
            Academy Management
        </p>

        <h1 class="mt-3 text-3xl font-black text-slate-900 dark:text-white sm:text-4xl">
            Edit {{ $course->title }}
        </h1>

        <form
            method="POST"
            action="{{ route('admin.courses.update', $course) }}"
            enctype="multipart/form-data"
            class="mt-8"
        >
            @csrf
            @method('PUT')

            @include('admin.courses._form')
        </form>
    </div>
@endsection
