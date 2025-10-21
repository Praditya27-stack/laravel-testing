<div>
    <!-- Error Message -->
    @if (session()->has('error'))
        <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg">
            {{ session('error') }}
        </div>
    @endif

    <!-- Warning Message -->
    @if (session()->has('warning'))
        <div class="mb-4 p-4 bg-yellow-100 border border-yellow-400 text-yellow-700 rounded-lg">
            {{ session('warning') }}
        </div>
    @endif

    <!-- Sign In Form -->
    <form wire:submit.prevent="login">
        <div class="space-y-6">
            <!-- NIK/Email Input -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    NIK atau Email <span class="text-red-500">*</span>
                </label>
                <input 
                    type="text" 
                    wire:model="nik" 
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-lg"
                    placeholder="Masukkan NIK (16 digit) atau Email"
                    autofocus
                >
                <p class="text-xs text-gray-500 mt-1">Pelamar gunakan NIK, Staff gunakan Email</p>
                @error('nik') 
                    <span class="text-red-500 text-sm mt-1">{{ $message }}</span> 
                @enderror
            </div>

            <!-- Password Input -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Password <span class="text-red-500">*</span>
                </label>
                <input 
                    type="password" 
                    wire:model="password"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-lg"
                    placeholder="Masukkan password"
                >
                @error('password') 
                    <span class="text-red-500 text-sm mt-1">{{ $message }}</span> 
                @enderror
            </div>

            <!-- Remember Me -->
            <div class="flex items-center">
                <input 
                    type="checkbox" 
                    wire:model="remember" 
                    id="remember"
                    class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500"
                >
                <label for="remember" class="ml-2 text-sm text-gray-700">
                    Ingat saya
                </label>
            </div>

            <!-- Submit Button -->
            <button 
                type="submit"
                class="w-full bg-blue-600 text-white py-3 rounded-lg hover:bg-blue-700 font-semibold text-lg transition duration-300"
            >
                Sign In
            </button>

            <!-- Forgot Password Link -->
            <div class="text-center">
                <a href="#" class="text-sm text-blue-600 hover:text-blue-800">
                    Lupa password?
                </a>
            </div>
        </div>
    </form>

    <!-- Info Box -->
    <div class="mt-6 p-4 bg-blue-50 border border-blue-200 rounded-lg">
        <p class="text-sm text-blue-800">
            <strong>💡 Tips:</strong> Gunakan NIK yang Anda daftarkan saat Sign Up.
        </p>
    </div>
</div>
