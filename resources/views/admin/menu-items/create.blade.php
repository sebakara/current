@extends('admin.layouts.app')

@section('title', 'Create Menu Item')

@section('content')
    <p class="text-xs font-black uppercase tracking-[0.2em] text-brand-primary">
        {{ $menu->name }}
    </p>

    <h1 class="mt-3 text-4xl font-black text-slate-900 dark:text-white">
        Create Menu Item
    </h1>

    <form
        method="POST"
        action="{{ route(
            'admin.menus.items.store',
            $menu
        ) }}"
        class="mt-8"
    >
        @csrf

        @include('admin.menu-items._form')
    </form>
@endsection
