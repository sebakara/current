@extends('admin.layouts.app')

@section('title', 'Edit Product Category')

@section('content')
    <div>
        <p class="text-xs font-black uppercase tracking-[0.2em] text-brand-primary">
            Product Catalogue
        </p>

        <h1 class="mt-3 text-3xl font-black text-slate-900 dark:text-white sm:text-4xl">
            Edit {{ $productCategory->name }}
        </h1>

        <form
            method="POST"
            action="{{ route(
                'admin.product-categories.update',
                $productCategory
            ) }}"
            enctype="multipart/form-data"
            class="mt-8"
        >
            @csrf
            @method('PUT')

            @include('admin.product-categories._form')
        </form>
    </div>
@endsection
