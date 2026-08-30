<x-guest-layout>
    @section('title', 'Administrator Login')

    <div class="rounded-[2rem] border border-slate-200 bg-white p-6 shadow-2xl shadow-slate-900/10 backdrop-blur-2xl dark:border-white/10 dark:bg-slate-900/75 dark:shadow-black/30 sm:p-8">
        <div>
            <span class="inline-flex items-center gap-2 rounded-full border border-brand-primary/20 bg-brand-primary/10 px-3 py-1.5 text-[10px] font-bold uppercase tracking-[0.18em] text-brand-primary-dark dark:text-brand-primary-light">
                <span class="h-1.5 w-1.5 rounded-full bg-brand-primary"></span>
                Authorized access only
            </span>

            <h1 class="mt-5 text-3xl font-black tracking-tight text-slate-900 dark:text-white">
                Welcome back
            </h1>

            <p class="mt-2 text-sm leading-6 text-slate-600 dark:text-slate-400">
                Sign in to manage the VTLABS website and digital operations.
            </p>
        </div>

        <x-auth-session-status
            class="mt-6 rounded-xl border border-emerald-500/30 bg-emerald-50 px-4 py-3 text-sm text-emerald-700 dark:border-emerald-500/20 dark:bg-emerald-500/10 dark:text-emerald-300"
            :status="session('status')"
        />

        <form method="POST" action="{{ route('login') }}" class="mt-8">
            @csrf

            {{-- Email --}}
            <div>
                <label
                    for="email"
                    class="mb-2 block text-sm font-bold text-slate-700 dark:text-slate-300"
                >
                    Email address
                </label>

                <div class="group relative">
                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400 transition group-focus-within:text-brand-primary dark:text-slate-500">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="1.8"
                                d="M4 6h16v12H4V6Zm0 1 8 6 8-6"
                            />
                        </svg>
                    </div>

                    <input
                        id="email"
                        name="email"
                        type="email"
                        value="{{ old('email') }}"
                        required
                        autofocus
                        autocomplete="username"
                        placeholder="admin@vtlabs.com"
                        class="w-full rounded-2xl border border-slate-300 bg-white py-4 pl-12 pr-4 text-sm text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-brand-primary/40 focus:bg-brand-primary/[0.04] focus:ring-4 focus:ring-brand-primary/10 dark:border-white/10 dark:bg-white/[0.04] dark:text-white dark:placeholder:text-slate-600"
                    >
                </div>

                <x-input-error
                    :messages="$errors->get('email')"
                    class="mt-2 text-sm text-red-600 dark:text-red-400"
                />
            </div>

            {{-- Password --}}
            <div class="mt-5" x-data="{ showPassword: false }">
                <label
                    for="password"
                    class="mb-2 block text-sm font-bold text-slate-700 dark:text-slate-300"
                >
                    Password
                </label>

                <div class="group relative">
                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400 transition group-focus-within:text-brand-primary dark:text-slate-500">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="1.8"
                                d="M7 10V8a5 5 0 0 1 10 0v2M5 10h14v11H5V10Z"
                            />
                        </svg>
                    </div>

                    <input
                        id="password"
                        name="password"
                        :type="showPassword ? 'text' : 'password'"
                        required
                        autocomplete="current-password"
                        placeholder="Enter your password"
                        class="w-full rounded-2xl border border-slate-300 bg-white py-4 pl-12 pr-12 text-sm text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-brand-primary/40 focus:bg-brand-primary/[0.04] focus:ring-4 focus:ring-brand-primary/10 dark:border-white/10 dark:bg-white/[0.04] dark:text-white dark:placeholder:text-slate-600"
                    >

                    <button
                        type="button"
                        class="absolute inset-y-0 right-0 flex items-center pr-4 text-slate-400 transition hover:text-brand-primary dark:text-slate-500"
                        @click="showPassword = !showPassword"
                    >
                        <svg
                            x-show="!showPassword"
                            class="h-5 w-5"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="1.8"
                                d="M2 12s3.5-6 10-6 10 6 10 6-3.5 6-10 6S2 12 2 12Zm10 3a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z"
                            />
                        </svg>

                        <svg
                            x-cloak
                            x-show="showPassword"
                            class="h-5 w-5"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="1.8"
                                d="m3 3 18 18M10.6 10.7a2 2 0 0 0 2.7 2.7M9.9 4.2A10.8 10.8 0 0 1 12 4c6.5 0 10 8 10 8a15 15 0 0 1-3 4.2M6.6 6.6C3.6 8.6 2 12 2 12s3.5 8 10 8a10 10 0 0 0 4.1-.9"
                            />
                        </svg>
                    </button>
                </div>

                <x-input-error
                    :messages="$errors->get('password')"
                    class="mt-2 text-sm text-red-600 dark:text-red-400"
                />
            </div>

            <div class="mt-5 flex items-center justify-between gap-4">
                <label class="flex cursor-pointer items-center gap-3">
                    <input
                        id="remember_me"
                        name="remember"
                        type="checkbox"
                        class="h-4 w-4 rounded border-slate-300 bg-white text-brand-primary focus:ring-brand-primary/30 dark:border-white/20 dark:bg-white/5"
                    >

                    <span class="text-sm text-slate-600 dark:text-slate-400">
                        Keep me signed in
                    </span>
                </label>

                @if (Route::has('password.request'))
                    <a
                        href="{{ route('password.request') }}"
                        class="text-sm font-bold text-brand-primary transition hover:text-brand-primary-light"
                    >
                        Forgot password?
                    </a>
                @endif
            </div>

            <button
                type="submit"
                class="group mt-7 flex w-full items-center justify-center gap-3 rounded-2xl bg-gradient-to-r from-brand-primary to-brand-secondary px-5 py-4 text-sm font-black uppercase tracking-[0.12em] text-white shadow-xl shadow-brand-primary-dark/20 transition duration-300 hover:-translate-y-0.5 hover:shadow-brand-primary-dark/30 focus:outline-none focus:ring-4 focus:ring-brand-primary/20"
            >
                Access dashboard

                <svg
                    class="h-4 w-4 transition group-hover:translate-x-1"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="m9 18 6-6-6-6"
                    />
                </svg>
            </button>
        </form>

        <div class="mt-7 border-t border-slate-200 pt-5 dark:border-white/10">
            <div class="flex items-center justify-between gap-4 text-xs text-slate-500 dark:text-slate-600">
                <span>Protected administration portal</span>

                <a
                    href="{{ url('/') }}"
                    class="font-semibold text-slate-600 transition hover:text-brand-primary dark:text-slate-500"
                >
                    Return to website
                </a>
            </div>
        </div>
    </div>

    <p class="mt-6 text-center text-xs leading-5 text-slate-500 dark:text-slate-600 lg:hidden">
        © {{ now()->year }} VTLABS. Secure administration platform.
    </p>
</x-guest-layout>
