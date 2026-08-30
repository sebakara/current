@extends('admin.layouts.app')

@section('title', 'Edit Social Link')

@section('content')
    <h1 class="text-4xl font-black text-slate-900 dark:text-white">
        Edit {{ $socialLink->platform }}
    </h1>

    <form
        method="POST"
        action="{{ route(
            'admin.social-links.update',
            $socialLink
        ) }}"
        class="mt-8"
    >
        @csrf
        @method('PUT')

        @include('admin.social-links._form')
    </form>
@endsection
