@extends('admin.layouts.app')

@section('title', 'Create Social Link')

@section('content')
    <h1 class="text-4xl font-black text-slate-900 dark:text-white">
        Create Social Link
    </h1>

    <form
        method="POST"
        action="{{ route('admin.social-links.store') }}"
        class="mt-8"
    >
        @csrf

        @include('admin.social-links._form')
    </form>
@endsection
