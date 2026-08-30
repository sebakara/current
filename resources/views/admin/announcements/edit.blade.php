@extends('admin.layouts.app')

@section('title', 'Edit Announcement')

@section('content')
    <div>
        <p class="text-xs font-black uppercase tracking-[0.2em] text-brand-primary">
            Website Notices
        </p>

        <h1 class="mt-3 text-3xl font-black text-slate-900 dark:text-white sm:text-4xl">
            Edit Announcement
        </h1>

        <form
            method="POST"
            action="{{ route(
                'admin.announcements.update',
                $announcement
            ) }}"
            class="mt-8"
        >
            @csrf
            @method('PUT')

            @include('admin.announcements._form')
        </form>
    </div>
@endsection
