@extends('frontend.layouts.app')

@section('title', 'Apply for ' . $course->title)

@section('content')
    <section class="border-b border-slate-200 dark:border-white/10 bg-white dark:bg-slate-950 py-20">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <a
                href="{{ route(
                    'academy.courses.show',
                    $course
                ) }}"
                class="text-sm font-bold text-slate-600 dark:text-slate-500 hover:text-brand-primary-dark dark:hover:text-brand-primary-light"
            >
                ← Back to Course
            </a>

            <p class="mt-10 text-xs font-black uppercase tracking-[0.22em] text-brand-primary">
                Training Application
            </p>

            <h1 class="mt-5 text-5xl font-black text-slate-900 dark:text-white sm:text-6xl">
                Apply for {{ $course->title }}
            </h1>

            <p class="mt-5 max-w-2xl text-base leading-8 text-slate-600 dark:text-slate-400">
                Complete the form below. Our Academy team will review your
                application and contact you.
            </p>
        </div>
    </section>

    <section class="bg-slate-50/90 dark:bg-slate-900/30 py-20">
        <div class="mx-auto grid max-w-7xl gap-8 px-4 sm:px-6 lg:grid-cols-[1fr_360px] lg:px-8">
            <form
                action="{{ route(
                    'academy.courses.apply.store',
                    $course
                ) }}"
                method="POST"
                enctype="multipart/form-data"
                class="rounded-[2rem] border border-slate-200 dark:border-white/10 bg-slate-50/90 dark:bg-slate-900/70 p-7 sm:p-9"
            >
                @csrf

                @if ($errors->any())
                    <div class="mb-7 rounded-2xl border border-red-400/20 bg-red-400/10 px-5 py-4">
                        <p class="font-black text-red-700 dark:text-red-300">
                            Please correct the following:
                        </p>

                        <ul class="mt-3 list-inside list-disc space-y-1 text-sm text-red-200">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="grid gap-6 sm:grid-cols-2">
                    <label>
                        <span class="mb-2 block text-sm font-black text-slate-700 dark:text-slate-300">
                            Full name *
                        </span>

                        <input
                            type="text"
                            name="full_name"
                            value="{{ old('full_name') }}"
                            required
                            maxlength="150"
                            class="w-full rounded-2xl border border-slate-200 dark:border-white/10 bg-white dark:bg-slate-950 px-4 py-3.5 text-slate-900 dark:text-white"
                        >
                    </label>

                    <label>
                        <span class="mb-2 block text-sm font-black text-slate-700 dark:text-slate-300">
                            Phone number *
                        </span>

                        <input
                            type="text"
                            name="phone"
                            value="{{ old('phone') }}"
                            required
                            maxlength="40"
                            placeholder="+250..."
                            class="w-full rounded-2xl border border-slate-200 dark:border-white/10 bg-white dark:bg-slate-950 px-4 py-3.5 text-slate-900 dark:text-white"
                        >
                    </label>

                    <label>
                        <span class="mb-2 block text-sm font-black text-slate-700 dark:text-slate-300">
                            Email
                        </span>

                        <input
                            type="email"
                            name="email"
                            value="{{ old('email') }}"
                            maxlength="150"
                            class="w-full rounded-2xl border border-slate-200 dark:border-white/10 bg-white dark:bg-slate-950 px-4 py-3.5 text-slate-900 dark:text-white"
                        >
                    </label>

                    <label>
                        <span class="mb-2 block text-sm font-black text-slate-700 dark:text-slate-300">
                            Nationality
                        </span>

                        <input
                            type="text"
                            name="nationality"
                            value="{{ old('nationality') }}"
                            maxlength="100"
                            placeholder="Example: Rwandan"
                            class="w-full rounded-2xl border border-slate-200 dark:border-white/10 bg-white dark:bg-slate-950 px-4 py-3.5 text-slate-900 dark:text-white"
                        >
                    </label>

                    <label>
                        <span class="mb-2 block text-sm font-black text-slate-700 dark:text-slate-300">
                            Gender
                        </span>

                        <select
                            name="gender"
                            class="w-full rounded-2xl border border-slate-200 dark:border-white/10 bg-white dark:bg-slate-950 px-4 py-3.5 text-slate-900 dark:text-white"
                        >
                            <option value="">Select</option>

                            <option
                                value="male"
                                @selected(old('gender') === 'male')
                            >
                                Male
                            </option>

                            <option
                                value="female"
                                @selected(old('gender') === 'female')
                            >
                                Female
                            </option>

                            <option
                                value="other"
                                @selected(old('gender') === 'other')
                            >
                                Other
                            </option>

                            <option
                                value="prefer-not-to-say"
                                @selected(
                                    old('gender') === 'prefer-not-to-say'
                                )
                            >
                                Prefer not to say
                            </option>
                        </select>
                    </label>

                    <label>
                        <span class="mb-2 block text-sm font-black text-slate-700 dark:text-slate-300">
                            Date of birth
                        </span>

                        <input
                            type="date"
                            name="date_of_birth"
                            value="{{ old('date_of_birth') }}"
                            max="{{ now()->subDay()->format('Y-m-d') }}"
                            class="w-full rounded-2xl border border-slate-200 dark:border-white/10 bg-white dark:bg-slate-950 px-4 py-3.5 text-slate-900 dark:text-white"
                        >
                    </label>

                    <label>
                        <span class="mb-2 block text-sm font-black text-slate-700 dark:text-slate-300">
                            Education level
                        </span>

                        <input
                            type="text"
                            name="education_level"
                            value="{{ old('education_level') }}"
                            maxlength="150"
                            placeholder="Example: Secondary school, Diploma, Degree"
                            class="w-full rounded-2xl border border-slate-200 dark:border-white/10 bg-white dark:bg-slate-950 px-4 py-3.5 text-slate-900 dark:text-white"
                        >
                    </label>

                    <label>
                        <span class="mb-2 block text-sm font-black text-slate-700 dark:text-slate-300">
                            Current occupation
                        </span>

                        <input
                            type="text"
                            name="current_occupation"
                            value="{{ old('current_occupation') }}"
                            maxlength="150"
                            placeholder="Student, employed, self-employed..."
                            class="w-full rounded-2xl border border-slate-200 dark:border-white/10 bg-white dark:bg-slate-950 px-4 py-3.5 text-slate-900 dark:text-white"
                        >
                    </label>

                    <label>
                        <span class="mb-2 block text-sm font-black text-slate-700 dark:text-slate-300">
                            Preferred schedule
                        </span>

                        <select
                            name="preferred_schedule"
                            class="w-full rounded-2xl border border-slate-200 dark:border-white/10 bg-white dark:bg-slate-950 px-4 py-3.5 text-slate-900 dark:text-white"
                        >
                            <option value="">Select a schedule</option>

                            @foreach ([
                                'Morning',
                                'Afternoon',
                                'Evening',
                                'Weekend',
                                'Flexible',
                            ] as $schedule)
                                <option
                                    value="{{ $schedule }}"
                                    @selected(
                                        old('preferred_schedule') === $schedule
                                    )
                                >
                                    {{ $schedule }}
                                </option>
                            @endforeach
                        </select>
                    </label>

                    <label class="sm:col-span-2">
                        <span class="mb-2 block text-sm font-black text-slate-700 dark:text-slate-300">
                            Address
                        </span>

                        <textarea
                            name="address"
                            rows="3"
                            maxlength="1000"
                            placeholder="District, sector, city, or full address"
                            class="w-full rounded-2xl border border-slate-200 dark:border-white/10 bg-white dark:bg-slate-950 px-4 py-3.5 text-slate-900 dark:text-white"
                        >{{ old('address') }}</textarea>
                    </label>

                    <label class="sm:col-span-2">
                        <span class="mb-2 block text-sm font-black text-slate-700 dark:text-slate-300">
                            Why do you want to join this course? *
                        </span>

                        <textarea
                            name="motivation"
                            rows="6"
                            required
                            maxlength="3000"
                            placeholder="Explain your goals and why this course is important to you."
                            class="w-full rounded-2xl border border-slate-200 dark:border-white/10 bg-white dark:bg-slate-950 px-4 py-3.5 text-slate-900 dark:text-white"
                        >{{ old('motivation') }}</textarea>
                    </label>

                    <label class="sm:col-span-2">
                        <span class="mb-2 block text-sm font-black text-slate-700 dark:text-slate-300">
                            Relevant experience
                        </span>

                        <textarea
                            name="experience"
                            rows="5"
                            maxlength="3000"
                            placeholder="Mention any previous training, projects, work experience, or related skills."
                            class="w-full rounded-2xl border border-slate-200 dark:border-white/10 bg-white dark:bg-slate-950 px-4 py-3.5 text-slate-900 dark:text-white"
                        >{{ old('experience') }}</textarea>
                    </label>

                    <label class="sm:col-span-2">
                        <span class="mb-2 block text-sm font-black text-slate-700 dark:text-slate-300">
                            Supporting document
                        </span>

                        <input
                            type="file"
                            name="document"
                            accept=".pdf,.doc,.docx,.jpg,.jpeg,.png"
                            class="block w-full rounded-2xl border border-dashed border-slate-200 dark:border-white/15 bg-white dark:bg-slate-950 px-4 py-4 text-sm text-slate-600 dark:text-slate-400"
                        >

                        <span class="mt-2 block text-xs leading-6 text-slate-500 dark:text-slate-600">
                            Optional. Upload a CV, certificate, identification,
                            portfolio, or other supporting document. Accepted:
                            PDF, Word, JPG, and PNG. Maximum size: 10 MB.
                        </span>
                    </label>
                </div>

                <button
                    type="submit"
                    class="mt-8 w-full rounded-2xl bg-gradient-to-r from-brand-primary to-brand-secondary px-7 py-4 text-sm font-black text-white"
                >
                    Submit Application
                </button>

                <p class="mt-4 text-center text-xs leading-6 text-slate-500 dark:text-slate-600">
                    By submitting this form, you confirm that the information
                    provided is accurate.
                </p>
            </form>

            <aside class="h-fit rounded-[2rem] border border-slate-200 dark:border-white/10 bg-slate-50/90 dark:bg-slate-900/80 p-7 lg:sticky lg:top-28">
                <p class="text-xs font-black uppercase tracking-[0.18em] text-brand-primary">
                    Course
                </p>

                <h2 class="mt-4 text-2xl font-black text-slate-900 dark:text-white">
                    {{ $course->title }}
                </h2>

                @if ($course->short_description)
                    <p class="mt-3 text-sm leading-7 text-slate-600 dark:text-slate-500">
                        {{ $course->short_description }}
                    </p>
                @endif

                <div class="mt-6 space-y-4 border-t border-slate-200 dark:border-white/10 pt-6 text-sm">
                    <div class="flex justify-between gap-4">
                        <span class="text-slate-600 dark:text-slate-500">Duration</span>

                        <span class="text-right font-black text-slate-900 dark:text-white">
                            {{ $course->duration ?: 'Flexible' }}
                        </span>
                    </div>

                    <div class="flex justify-between gap-4">
                        <span class="text-slate-600 dark:text-slate-500">Mode</span>

                        <span class="text-right font-black text-slate-900 dark:text-white">
                            {{ $course->delivery_mode ?: 'Practical' }}
                        </span>
                    </div>

                    <div class="flex justify-between gap-4">
                        <span class="text-slate-600 dark:text-slate-500">Location</span>

                        <span class="text-right font-black text-slate-900 dark:text-white">
                            {{ $course->location ?: 'VTLABS' }}
                        </span>
                    </div>

                    <div class="flex justify-between gap-4">
                        <span class="text-slate-600 dark:text-slate-500">Fee</span>

                        <span class="text-right font-black text-slate-900 dark:text-white">
                            @if ($course->fee !== null)
                                {{ $course->currency }}
                                {{ number_format((float) $course->fee, 2) }}
                            @else
                                Contact Academy
                            @endif
                        </span>
                    </div>

                    @if ($course->application_deadline)
                        <div class="flex justify-between gap-4">
                            <span class="text-slate-600 dark:text-slate-500">
                                Application deadline
                            </span>

                            <span class="text-right font-black text-slate-900 dark:text-white">
                                {{ $course->application_deadline->format(
                                    'd M Y'
                                ) }}
                            </span>
                        </div>
                    @endif

                    @if ($course->available_places !== null)
                        <div class="flex justify-between gap-4">
                            <span class="text-slate-600 dark:text-slate-500">
                                Available places
                            </span>

                            <span class="text-right font-black text-slate-900 dark:text-white">
                                {{ number_format(
                                    $course->available_places
                                ) }}
                            </span>
                        </div>
                    @endif
                </div>

                <div class="mt-7 rounded-2xl border border-brand-primary/15 bg-brand-primary/[0.06] p-4">
                    <p class="text-sm font-black text-brand-primary-dark dark:text-brand-primary-light">
                        Applications are open
                    </p>

                    <p class="mt-2 text-xs leading-6 text-slate-600 dark:text-slate-500">
                        Submit complete and accurate information. The Academy
                        team will contact you after reviewing your application.
                    </p>
                </div>
            </aside>
        </div>
    </section>
@endsection
