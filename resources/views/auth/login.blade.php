<x-guest-layout>
    {{-- @var \Illuminate\Support\MessageBag $errors --}}
    <div
        class="h-screen bg-gradient-to-br from-indigo-50 via-purple-50 to-pink-50 flex flex-col items-center justify-center relative overflow-hidden">
        <!-- Background decoration -->
        <div
            class="absolute top-0 right-0 w-[600px] h-[600px] bg-purple-300 rounded-full mix-blend-multiply filter blur-3xl opacity-10">
        </div>
        <div
            class="absolute bottom-0 left-0 w-[600px] h-[600px] bg-indigo-300 rounded-full mix-blend-multiply filter blur-3xl opacity-10">
        </div>

        <!-- Main Container -->
        <div class="relative z-10 w-full flex flex-col items-center justify-center flex-1">
            <div class="w-full max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
                <!-- Branding -->
                <div class="text-center mb-6">
                    <!-- Logo -->
                    <div class="mb-3 flex justify-center">
                        <div class="bg-gradient-to-br from-indigo-600 to-purple-600 rounded-full p-2 shadow-lg">
                            <svg class="w-12 h-12" viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <!-- Outer circle background -->
                                <circle cx="50" cy="50" r="48" fill="white" opacity="0.15" stroke="white"
                                    stroke-width="2" />

                                <!-- Main shape - stylized book/growth -->
                                <g transform="translate(50, 50)">
                                    <!-- Left curve -->
                                    <path d="M -15 -10 Q -20 0 -15 10 L 0 15 L 0 -15 Z" fill="white" opacity="0.95" />
                                    <!-- Right curve -->
                                    <path d="M 15 -10 Q 20 0 15 10 L 0 15 L 0 -15 Z" fill="white" opacity="0.75" />
                                    <!-- Center arrow up -->
                                    <path d="M 0 -8 L -4 4 L -1 4 L -1 8 L 1 8 L 1 4 L 4 4 Z" fill="white" />
                                </g>
                            </svg>
                        </div>
                    </div>
                    <h1 class="text-3xl font-bold text-gray-900 mb-1">Sistem BK</h1>
                    <p class="text-sm text-gray-600">Platform Bimbingan Karir Digital</p>
                </div>

                <!-- Login Card -->
                <div class="bg-white rounded-2xl shadow-2xl p-12 border border-gray-100">
                    <!-- Form Header -->
                    <div class="mb-6">
                        <h2 class="text-2xl font-bold text-gray-900 mb-2">Selamat Datang 👋</h2>
                        <p class="text-sm text-gray-600">Masuk untuk melanjutkan</p>
                    </div>

                    <!-- Session Status -->
                    <x-auth-session-status class="mb-6" :status="session('status')" />

                    <!-- Login Form -->
                    <form method="POST" action="{{ route('login') }}" class="space-y-4">
                        @csrf

                        <!-- NIS/Email Input -->
                        <div>
                            <label for="login" class="block text-sm font-semibold text-gray-900 mb-2">NIS atau
                                Email</label>
                            <input id="login" type="text" name="login" value="{{ old('login') }}" required autofocus
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition"
                                placeholder="Masukkan NIS atau email" />
                            <x-input-error :messages="$errors->get('login')" class="mt-2" />
                        </div>

                        <!-- Password Input -->
                        <div>
                            <label for="password"
                                class="block text-sm font-semibold text-gray-900 mb-2">Password</label>
                            <input id="password" type="password" name="password" required
                                autocomplete="current-password"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition"
                                placeholder="Masukkan password" />
                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                        </div>

                        <!-- Remember & Forgot Password -->
                        <div class="flex items-center justify-between text-sm">
                            <label for="remember_me" class="flex items-center cursor-pointer">
                                <input id="remember_me" type="checkbox" name="remember"
                                    class="w-4 h-4 border-gray-300 text-indigo-600 rounded focus:ring-2 focus:ring-indigo-500 cursor-pointer">
                                <span class="ml-2 text-gray-700">Ingat saya</span>
                            </label>
                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}"
                                    class="text-indigo-600 hover:text-indigo-700 font-medium">
                                    Lupa password?
                                </a>
                            @endif
                        </div>

                        <!-- Submit Button -->
                        <button type="submit"
                            class="w-full bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white font-semibold py-3 px-4 rounded-lg transition duration-200 shadow-md hover:shadow-lg mt-2">
                            Masuk
                        </button>
                    </form>

                    <!-- Divider -->
                    <div class="relative my-6">
                        <div class="absolute inset-0 flex items-center">
                            <div class="w-full border-t border-gray-200"></div>
                        </div>
                        <div class="relative flex justify-center text-xs">
                            <span class="px-3 bg-white text-gray-600">Belum punya akun?</span>
                        </div>
                    </div>

                    <!-- Register Link -->
                    <a href="{{ route('register') }}"
                        class="w-full block text-center bg-gray-100 hover:bg-gray-200 text-gray-900 font-semibold py-3 px-4 rounded-lg transition duration-200">
                        Daftar Sekarang
                    </a>
                </div>


            </div>
        </div>

        <!-- Footer -->
        <div
            class="fixed bottom-0 left-0 right-0 bg-white/90 backdrop-blur-sm py-4 px-6 text-center border-t border-gray-200">
            <p class="text-gray-900 text-sm font-semibold">
                🎓 Sistem Bimbingan Karir Digital
            </p>
            <p class="text-gray-600 text-xs mt-1">
                © 2026 Sistem BK
            </p>
        </div>
</x-guest-layout>