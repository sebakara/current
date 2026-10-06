@extends('admin.layouts.app')

@section('title', 'Create Product Category')

@section('content')
    <div>
        <p class="text-xs font-black uppercase tracking-[0.2em] text-brand-primary">
            Product Catalogue
        </p>

        <h1 class="mt-3 text-3xl font-black text-slate-900 dark:text-white sm:text-4xl">
            Create Product Category
        </h1>

        <form
            method="POST"
            action="{{ route('admin.product-categories.store') }}"
            enctype="multipart/form-data"
            class="mt-8"
        >
            @csrf

            @include('admin.product-categories._form')
        </form>
    </div>
@endsection
