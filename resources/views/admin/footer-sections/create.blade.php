@extends('admin.layouts.app')

@section('title', 'Create Footer Section')

@section('content')
    <h1 class="text-4xl font-black text-slate-900 dark:text-white">
        Create Footer Section
    </h1>

    <form
        method="POST"
        action="{{ route(
            'admin.footer-sections.store'
        ) }}"
        class="mt-8"
    >
        @csrf

        @include('admin.footer-sections._form')
    </form>
@endsection
