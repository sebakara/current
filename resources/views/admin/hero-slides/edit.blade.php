@extends('admin.layouts.app')

@section('title', 'Edit Hero Slide')

@section('content')
    <div>
        <p class="text-xs font-black uppercase tracking-[0.2em] text-brand-primary">
            Homepage Content
        </p>

        <h1 class="mt-3 text-3xl font-black text-slate-900 dark:text-white sm:text-4xl">
            Edit Hero Slide
        </h1>

        <form
            method="POST"
            action="{{ route(
                'admin.hero-slides.update',
                $heroSlide
            ) }}"
            enctype="multipart/form-data"
            class="mt-8"
        >
            @csrf
            @method('PUT')

            @include('admin.hero-slides._form')
        </form>
    </div>
@endsection
