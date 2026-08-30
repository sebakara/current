@extends('admin.layouts.app')

@section('title', 'Create Project')

@section('content')
    <div>
        <p class="text-xs font-black uppercase tracking-[0.2em] text-brand-primary">
            Portfolio Management
        </p>

        <h1 class="mt-3 text-3xl font-black text-slate-900 dark:text-white sm:text-4xl">
            Create Project
        </h1>

        <form
            method="POST"
            action="{{ route('admin.projects.store') }}"
            enctype="multipart/form-data"
            class="mt-8"
        >
            @csrf

            @include('admin.projects._form')
        </form>
    </div>
@endsection
