@extends('admin.layouts.app')

@section('title', 'Edit Menu')

@section('content')
    <h1 class="text-4xl font-black text-slate-900 dark:text-white">
        Edit {{ $menu->name }}
    </h1>

    <form
        method="POST"
        action="{{ route('admin.menus.update', $menu) }}"
        class="mt-8"
    >
        @csrf
        @method('PUT')

        @include('admin.menus._form')
    </form>
@endsection
