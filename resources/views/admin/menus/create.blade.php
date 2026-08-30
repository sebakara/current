@extends('admin.layouts.app')

@section('title', 'Create Menu')

@section('content')
    <h1 class="text-4xl font-black text-slate-900 dark:text-white">
        Create Menu
    </h1>

    <form
        method="POST"
        action="{{ route('admin.menus.store') }}"
        class="mt-8"
    >
        @csrf

        @include('admin.menus._form')
    </form>
@endsection
