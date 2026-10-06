@extends('admin.layouts.app')

@section('title', 'Edit Footer Section')

@section('content')
    <h1 class="text-4xl font-black text-slate-900 dark:text-white">
        Edit {{ $footerSection->title }}
    </h1>

    <form
        method="POST"
        action="{{ route(
            'admin.footer-sections.update',
            $footerSection
        ) }}"
        class="mt-8"
    >
        @csrf
        @method('PUT')

        @include('admin.footer-sections._form')
    </form>
@endsection
