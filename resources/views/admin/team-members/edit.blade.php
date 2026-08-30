@extends('admin.layouts.app')

@section('title', 'Edit Team Member')

@section('content')
    <div>
        <p class="text-xs font-black uppercase tracking-[0.2em] text-brand-primary">
            Company Profile
        </p>

        <h1 class="mt-3 text-3xl font-black text-slate-900 dark:text-white sm:text-4xl">
            Edit {{ $teamMember->name }}
        </h1>

        <form
            method="POST"
            action="{{ route(
                'admin.team-members.update',
                $teamMember
            ) }}"
            enctype="multipart/form-data"
            class="mt-8"
        >
            @csrf
            @method('PUT')

            @include('admin.team-members._form')
        </form>
    </div>
@endsection
