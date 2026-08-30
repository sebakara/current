@extends('admin.layouts.app')

@section('title', 'Create Hero Slide')

@section('content')
    <div>
        <p class="text-xs font-black uppercase tracking-[0.2em] text-brand-primary">
            Homepage Content
        </p>

        <h1 class="mt-3 text-3xl font-black text-slate-900 dark:text-white sm:text-4xl">
            Create Hero Slide
        </h1>

        <form
            method="POST"
            action="{{ route('admin.hero-slides.store') }}"
            enctype="multipart/form-data"
            class="mt-8"
        >
            @csrf

            @include('admin.hero-slides._form')
        </form>
    </div>
@endsection
