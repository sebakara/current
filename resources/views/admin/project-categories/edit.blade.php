@extends('admin.layouts.app')

@section('title', 'Edit Project Category')

@section('content')
    <div>
        <p class="text-xs font-black uppercase tracking-[0.2em] text-brand-primary">
            Portfolio Management
        </p>

        <h1 class="mt-3 text-3xl font-black text-slate-900 dark:text-white sm:text-4xl">
            Edit {{ $projectCategory->name }}
        </h1>

        <form
            method="POST"
            action="{{ route(
                'admin.project-categories.update',
                $projectCategory
            ) }}"
            class="mt-8"
        >
            @csrf
            @method('PUT')

            @include('admin.project-categories._form')
        </form>
    </div>
@endsection
