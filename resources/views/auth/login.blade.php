{{-- resources/views/auth/login.blade.php --}}
<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <div class="w-full max-w-md mx-auto">
        <!-- Header dengan Logo -->
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-2xl shadow-lg mb-4">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                </svg>
            </div>
            <h1 class="text-2xl font-bold text-gray-800">Selamat Datang</h1>
            <p class="text-gray-600 mt-1">Masuk ke akun Anda</p>
        </div>

        <form method="POST" action="{{ route('login') }}" class="space-y-6">
            @csrf

            <!-- Pilihan Tipe Login -->
            <div class="mb-6">
                <x-input-label :value="__('Login Sebagai')" class="text-gray-700 font-medium mb-3" />
                <div class="grid grid-cols-2 gap-3">
                    <label class="relative cursor-pointer">
                        <input type="radio" name="login_type" value="email" 
                               {{ old('login_type', 'email') == 'email' ? 'checked' : '' }}
                               class="peer sr-only">
                        <div class="flex items-center justify-center space-x-2 px-4 py-3.5 border-2 border-gray-200 rounded-xl transition-all duration-200 peer-checked:border-indigo-500 peer-checked:bg-indigo-50 peer-checked:shadow-md hover:border-gray-300 peer-checked:hover:border-indigo-600">
                            <svg class="w-5 h-5 text-gray-400 peer-checked:text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            <span class="text-sm font-medium text-gray-700 peer-checked:text-indigo-700">Admin</span>
                        </div>
                        <div class="absolute -top-2 -right-2 w-5 h-5 bg-indigo-500 rounded-full hidden peer-checked:flex items-center justify-center">
                            <svg class="w-3 h-3 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                        </div>
                    </label>
                    
                    <label class="relative cursor-pointer">
                        <input type="radio" name="login_type" value="nisn"
                               {{ old('login_type') == 'nisn' ? 'checked' : '' }}
                               class="peer sr-only">
                        <div class="flex items-center justify-center space-x-2 px-4 py-3.5 border-2 border-gray-200 rounded-xl transition-all duration-200 peer-checked:border-fuchsia-500 peer-checked:bg-fuchsia-50 peer-checked:shadow-md hover:border-gray-300 peer-checked:hover:border-fuchsia-600">
                            <svg class="w-5 h-5 text-gray-400 peer-checked:text-fuchsia-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" />
                            </svg>
                            <span class="text-sm font-medium text-gray-700 peer-checked:text-fuchsia-700">Murid</span>
                        </div>
                        <div class="absolute -top-2 -right-2 w-5 h-5 bg-fuchsia-500 rounded-full hidden peer-checked:flex items-center justify-center">
                            <svg class="w-3 h-3 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                        </div>
                    </label>
                </div>
                <x-input-error :messages="$errors->get('login_type')" class="mt-2" />
            </div>

            <!-- Email/NISN Field (Dinamis) -->
            <div class="space-y-2">
                <x-input-label for="credential" :value="__('Email / NISN')" id="credential-label" 
                    class="text-gray-700 font-medium" />
                <div class="relative group">
                    <div id="credential-icon" class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400">
                        <svg id="email-icon" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                        <svg id="nisn-icon" class="w-5 h-5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2" />
                        </svg>
                    </div>
                    <x-text-input 
                        id="credential" 
                        class="block w-full pl-10 pr-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:border-transparent transition-all duration-200"
                        type="text" 
                        name="credential" 
                        :value="old('credential')" 
                        required 
                        autofocus 
                        autocomplete="username"
                        placeholder="Masukkan email atau NISN" />
                </div>
                <x-input-error :messages="$errors->get('credential')" class="mt-1" />
            </div>

            <!-- Password -->
            <div class="space-y-2">
                <x-input-label for="password" :value="__('Password')" class="text-gray-700 font-medium" />
                <div class="relative">
                    <div class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                    </div>
                    <x-text-input 
                        id="password" 
                        class="block w-full pl-10 pr-10 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:border-transparent transition-all duration-200"
                        type="password"
                        name="password"
                        required 
                        autocomplete="current-password"
                        placeholder="Masukkan password" />
                    <button type="button" onclick="togglePassword()" class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600">
                        <svg id="eye-icon" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                        <svg id="eye-off-icon" class="w-5 h-5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L6.59 6.59m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                        </svg>
                    </button>
                </div>
                <x-input-error :messages="$errors->get('password')" class="mt-1" />
            </div>

            <!-- Remember Me & Forgot Password -->
            <div class="flex items-center justify-between">
                <label for="remember_me" class="inline-flex items-center cursor-pointer">
                    <input id="remember_me" type="checkbox" 
                           class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                           name="remember">
                    <span class="ms-2 text-sm text-gray-600">{{ __('Ingat saya') }}</span>
                </label>

                @if (Route::has('password.request'))
                    <a class="text-sm font-medium text-indigo-600 hover:text-indigo-500 transition-colors" 
                       href="{{ route('password.request') }}">
                        {{ __('Lupa password?') }}
                    </a>
                @endif
            </div>

            <!-- Submit Button -->
            <div class="pt-2">
                <x-primary-button 
                    id="login-button"
                    class="w-full justify-center py-3 px-4 border border-transparent rounded-xl font-medium shadow-sm text-white focus:outline-none focus:ring-2 focus:ring-offset-2 transition-all duration-200 transform hover:-translate-y-0.5 active:translate-y-0">
                    {{ __('Masuk') }}
                </x-primary-button>
            </div>
        </form>

        <!-- Footer -->
        <div class="mt-8 pt-6 border-t border-gray-200 text-center">
            <p class="text-sm text-gray-600">
                Belum punya akun siswa?
                <a href="{{ route('register.siswa') }}" class="font-semibold text-fuchsia-600 hover:text-fuchsia-500 transition-colors">
                    Daftar di sini
                </a>
            </p>
            <p class="text-sm text-gray-600 mt-2">
                Sistem Informasi Manajemen Sarana Prasarana
                <span class="block font-semibold text-indigo-600 mt-1">© 2026 SIMAS</span>
            </p>
        </div>
    </div>

    {{-- JavaScript untuk interaksi dinamis --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const loginTypeRadios = document.querySelectorAll('input[name="login_type"]');
            const credentialLabel = document.getElementById('credential-label');
            const credentialInput = document.getElementById('credential');
            const emailIcon = document.getElementById('email-icon');
            const nisnIcon = document.getElementById('nisn-icon');
            const loginButton = document.getElementById('login-button');
            
            function updateLoginUI() {
                const selectedType = document.querySelector('input[name="login_type"]:checked').value;
                
                if (selectedType === 'email') {
                    // Mode Petugas (Indigo)
                    credentialLabel.textContent = 'Email Petugas';
                    credentialLabel.classList.remove('text-fuchsia-700');
                    credentialLabel.classList.add('text-indigo-700');
                    credentialInput.placeholder = 'contoh: petugas@sekolah.sch.id';
                    credentialInput.type = 'email';
                    credentialInput.autocomplete = 'email';
                    
                    // Icon
                    emailIcon.classList.remove('hidden');
                    nisnIcon.classList.add('hidden');
                    
                    // Input border color
                    credentialInput.classList.remove('border-fuchsia-300', 'focus:ring-fuchsia-500', 'focus:border-fuchsia-500');
                    credentialInput.classList.add('border-gray-200', 'focus:ring-indigo-500', 'focus:border-indigo-500');
                    
                    // Button color
                    loginButton.classList.remove('bg-fuchsia-600', 'hover:bg-fuchsia-700', 'focus:ring-fuchsia-500');
                    loginButton.classList.add('bg-indigo-600', 'hover:bg-indigo-700', 'focus:ring-indigo-500');
                    
                } else {
                    // Mode Murid (Fuchsia)
                    credentialLabel.textContent = 'NISN Murid';
                    credentialLabel.classList.remove('text-indigo-700');
                    credentialLabel.classList.add('text-fuchsia-700');
                    credentialInput.placeholder = 'Masukkan NISN Anda';
                    credentialInput.type = 'text';
                    credentialInput.autocomplete = 'username';
                    
                    // Icon
                    emailIcon.classList.add('hidden');
                    nisnIcon.classList.remove('hidden');
                    
                    // Input border color
                    credentialInput.classList.remove('border-gray-200', 'focus:ring-indigo-500', 'focus:border-indigo-500');
                    credentialInput.classList.add('border-fuchsia-300', 'focus:ring-fuchsia-500', 'focus:border-fuchsia-500');
                    
                    // Button color
                    loginButton.classList.remove('bg-indigo-600', 'hover:bg-indigo-700', 'focus:ring-indigo-500');
                    loginButton.classList.add('bg-fuchsia-600', 'hover:bg-fuchsia-700', 'focus:ring-fuchsia-500');
                }
            }
            
            loginTypeRadios.forEach(radio => {
                radio.addEventListener('change', updateLoginUI);
            });
            
            // Inisialisasi awal
            updateLoginUI();
        });
        
        // Toggle password visibility
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const eyeIcon = document.getElementById('eye-icon');
            const eyeOffIcon = document.getElementById('eye-off-icon');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.classList.add('hidden');
                eyeOffIcon.classList.remove('hidden');
            } else {
                passwordInput.type = 'password';
                eyeIcon.classList.remove('hidden');
                eyeOffIcon.classList.add('hidden');
            }
        }
        
        // Add focus effects
        document.getElementById('credential').addEventListener('focus', function() {
            const selectedType = document.querySelector('input[name="login_type"]:checked').value;
            if (selectedType === 'email') {
                this.classList.add('ring-2', 'ring-indigo-500', 'ring-opacity-30');
            } else {
                this.classList.add('ring-2', 'ring-fuchsia-500', 'ring-opacity-30');
            }
        });
        
        document.getElementById('credential').addEventListener('blur', function() {
            this.classList.remove('ring-2', 'ring-indigo-500', 'ring-opacity-30', 'ring-fuchsia-500');
        });
        
        document.getElementById('password').addEventListener('focus', function() {
            this.classList.add('ring-2', 'ring-indigo-500', 'ring-opacity-30');
        });
        
        document.getElementById('password').addEventListener('blur', function() {
            this.classList.remove('ring-2', 'ring-indigo-500', 'ring-opacity-30');
        });
    </script>
</x-guest-layout>