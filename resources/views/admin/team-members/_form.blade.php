@php
    $editing = isset($teamMember);
@endphp

@if ($errors->any())
    <div class="mb-7 rounded-2xl border border-red-400/20 bg-red-400/10 px-5 py-4">
        <p class="font-black text-red-700 dark:text-red-300">
            Please correct the following errors:
        </p>

        <ul class="mt-3 list-inside list-disc space-y-1 text-sm text-red-700 dark:text-red-200">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="grid gap-8 xl:grid-cols-[1fr_370px]">
    <div class="space-y-7">
        <section class="rounded-[2rem] border border-slate-200 dark:border-white/10 bg-white dark:bg-slate-900/70 p-7">
            <p class="text-xs font-black uppercase tracking-[0.18em] text-brand-primary">
                Team Member Information
            </p>

            <div class="mt-6 grid gap-6 sm:grid-cols-2">
                <label class="sm:col-span-2">
                    <span class="mb-2 block text-sm font-black text-slate-700 dark:text-slate-300">
                        Full name *
                    </span>

                    <input
                        type="text"
                        name="name"
                        value="{{ old(
                            'name',
                            $teamMember->name ?? ''
                        ) }}"
                        required
                        maxlength="150"
                        class="w-full rounded-2xl border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-slate-950 px-4 py-3.5 text-slate-900 dark:text-white"
                    >
                </label>

                <label>
                    <span class="mb-2 block text-sm font-black text-slate-700 dark:text-slate-300">
                        Role *
                    </span>

                    <input
                        type="text"
                        name="role"
                        value="{{ old(
                            'role',
                            $teamMember->role ?? ''
                        ) }}"
                        required
                        maxlength="150"
                        placeholder="Managing Director"
                        class="w-full rounded-2xl border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-slate-950 px-4 py-3.5 text-slate-900 dark:text-white"
                    >
                </label>

                <label>
                    <span class="mb-2 block text-sm font-black text-slate-700 dark:text-slate-300">
                        Department
                    </span>

                    <input
                        type="text"
                        name="department"
                        value="{{ old(
                            'department',
                            $teamMember->department ?? ''
                        ) }}"
                        maxlength="150"
                        placeholder="Management, Engineering, Academy..."
                        class="w-full rounded-2xl border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-slate-950 px-4 py-3.5 text-slate-900 dark:text-white"
                    >
                </label>

                <label class="sm:col-span-2">
                    <span class="mb-2 block text-sm font-black text-slate-700 dark:text-slate-300">
                        Biography
                    </span>

                    <textarea
                        name="bio"
                        rows="10"
                        maxlength="10000"
                        class="w-full rounded-2xl border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-slate-950 px-4 py-3.5 text-slate-900 dark:text-white"
                    >{{ old(
                        'bio',
                        $teamMember->bio ?? ''
                    ) }}</textarea>
                </label>
            </div>
        </section>

        <section class="rounded-[2rem] border border-slate-200 dark:border-white/10 bg-white dark:bg-slate-900/70 p-7">
            <p class="text-xs font-black uppercase tracking-[0.18em] text-brand-primary">
                Contact Information
            </p>

            <div class="mt-6 grid gap-6 sm:grid-cols-2">
                <label>
                    <span class="mb-2 block text-sm font-black text-slate-700 dark:text-slate-300">
                        Email
                    </span>

                    <input
                        type="email"
                        name="email"
                        value="{{ old(
                            'email',
                            $teamMember->email ?? ''
                        ) }}"
                        maxlength="150"
                        class="w-full rounded-2xl border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-slate-950 px-4 py-3.5 text-slate-900 dark:text-white"
                    >
                </label>

                <label>
                    <span class="mb-2 block text-sm font-black text-slate-700 dark:text-slate-300">
                        Phone
                    </span>

                    <input
                        type="text"
                        name="phone"
                        value="{{ old(
                            'phone',
                            $teamMember->phone ?? ''
                        ) }}"
                        maxlength="50"
                        class="w-full rounded-2xl border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-slate-950 px-4 py-3.5 text-slate-900 dark:text-white"
                    >
                </label>

                <label>
                    <span class="mb-2 block text-sm font-black text-slate-700 dark:text-slate-300">
                        LinkedIn URL
                    </span>

                    <input
                        type="url"
                        name="linkedin_url"
                        value="{{ old(
                            'linkedin_url',
                            $teamMember->linkedin_url ?? ''
                        ) }}"
                        maxlength="500"
                        placeholder="https://linkedin.com/in/..."
                        class="w-full rounded-2xl border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-slate-950 px-4 py-3.5 text-slate-900 dark:text-white"
                    >
                </label>

                <label>
                    <span class="mb-2 block text-sm font-black text-slate-700 dark:text-slate-300">
                        X / Twitter URL
                    </span>

                    <input
                        type="url"
                        name="twitter_url"
                        value="{{ old(
                            'twitter_url',
                            $teamMember->twitter_url ?? ''
                        ) }}"
                        maxlength="500"
                        placeholder="https://x.com/..."
                        class="w-full rounded-2xl border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-slate-950 px-4 py-3.5 text-slate-900 dark:text-white"
                    >
                </label>
            </div>
        </section>

        <section class="rounded-[2rem] border border-slate-200 dark:border-white/10 bg-white dark:bg-slate-900/70 p-7">
            <p class="text-xs font-black uppercase tracking-[0.18em] text-brand-primary">
                Profile Photo
            </p>

            @if (
                $editing
                && $teamMember->photo
                && Storage::disk('public')->exists(
                    $teamMember->photo
                )
            )
                <img
                    src="{{ Storage::url($teamMember->photo) }}"
                    alt="{{ $teamMember->name }}"
                    class="mt-6 h-72 w-72 rounded-[2rem] border border-slate-200 dark:border-white/10 object-cover"
                >

                <label class="mt-4 flex items-center gap-3">
                    <input
                        type="checkbox"
                        name="remove_photo"
                        value="1"
                        class="rounded border-slate-300 dark:border-white/20 bg-slate-50 dark:bg-slate-950 text-red-400"
                    >

                    <span class="text-sm font-bold text-red-700 dark:text-red-300">
                        Remove current photo
                    </span>
                </label>
            @endif

            <label class="mt-6 block">
                <span class="mb-2 block text-sm font-black text-slate-700 dark:text-slate-300">
                    {{ $editing
                        ? 'Replace profile photo'
                        : 'Upload profile photo' }}
                </span>

                <input
                    type="file"
                    name="photo"
                    accept=".jpg,.jpeg,.png,.webp"
                    class="block w-full rounded-2xl border border-dashed border-slate-200 dark:border-white/15 bg-slate-50 dark:bg-slate-950 px-4 py-4 text-sm text-slate-600 dark:text-slate-400"
                >

                <span class="mt-2 block text-xs text-slate-600 dark:text-slate-600">
                    Recommended: square portrait, at least 800 × 800 pixels.
                </span>
            </label>
        </section>
    </div>

    <aside>
        <section class="rounded-[2rem] border border-slate-200 dark:border-white/10 bg-white dark:bg-slate-900/80 p-7">
            <p class="text-xs font-black uppercase tracking-[0.18em] text-brand-primary">
                Display Settings
            </p>

            <label class="mt-6 flex items-start justify-between gap-4 rounded-2xl border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-slate-950 p-4">
                <span>
                    <span class="block text-sm font-black text-slate-900 dark:text-white">
                        Active
                    </span>

                    <span class="mt-1 block text-xs leading-5 text-slate-600 dark:text-slate-600">
                        Display this team member on the public website.
                    </span>
                </span>

                <input
                    type="checkbox"
                    name="is_active"
                    value="1"
                    @checked(old(
                        'is_active',
                        $teamMember->is_active ?? true
                    ))
                    class="mt-1 rounded border-slate-300 dark:border-white/20 bg-slate-50 dark:bg-slate-950 text-brand-primary"
                >
            </label>

            <label class="mt-5 block">
                <span class="mb-2 block text-sm font-black text-slate-700 dark:text-slate-300">
                    Sort order
                </span>

                <input
                    type="number"
                    name="sort_order"
                    value="{{ old(
                        'sort_order',
                        $teamMember->sort_order ?? 0
                    ) }}"
                    min="0"
                    class="w-full rounded-2xl border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-slate-950 px-4 py-3.5 text-slate-900 dark:text-white"
                >
            </label>

            <button
                type="submit"
                class="mt-7 w-full rounded-2xl bg-gradient-to-r from-brand-primary to-brand-secondary px-6 py-4 text-sm font-black text-white"
            >
                {{ $editing
                    ? 'Update Team Member'
                    : 'Create Team Member' }}
            </button>

            <a
                href="{{ route('admin.team-members.index') }}"
                class="mt-3 flex w-full items-center justify-center rounded-2xl border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-white/[0.03] px-6 py-4 text-sm font-black text-slate-600 dark:text-slate-400"
            >
                Cancel
            </a>
        </section>
    </aside>
</div>
