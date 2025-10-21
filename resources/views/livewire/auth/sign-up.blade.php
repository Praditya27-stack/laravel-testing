<div>
    <!-- Progress Indicator -->
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div class="flex items-center {{ $current_step >= 1 ? 'text-blue-600' : 'text-gray-400' }}">
                <div class="w-8 h-8 rounded-full {{ $current_step >= 1 ? 'bg-blue-600 text-white' : 'bg-gray-300' }} flex items-center justify-center font-bold">
                    1
                </div>
                <span class="ml-2 text-sm font-medium">NIK</span>
            </div>
            <div class="flex-1 h-1 mx-2 {{ $current_step >= 2 ? 'bg-blue-600' : 'bg-gray-300' }}"></div>
            <div class="flex items-center {{ $current_step >= 2 ? 'text-blue-600' : 'text-gray-400' }}">
                <div class="w-8 h-8 rounded-full {{ $current_step >= 2 ? 'bg-blue-600 text-white' : 'bg-gray-300' }} flex items-center justify-center font-bold">
                    2
                </div>
                <span class="ml-2 text-sm font-medium">Data Diri</span>
            </div>
            <div class="flex-1 h-1 mx-2 {{ $current_step >= 3 ? 'bg-blue-600' : 'bg-gray-300' }}"></div>
            <div class="flex items-center {{ $current_step >= 3 ? 'text-blue-600' : 'text-gray-400' }}">
                <div class="w-8 h-8 rounded-full {{ $current_step >= 3 ? 'bg-blue-600 text-white' : 'bg-gray-300' }} flex items-center justify-center font-bold">
                    3
                </div>
                <span class="ml-2 text-sm font-medium">Kesehatan</span>
            </div>
        </div>
    </div>

    <!-- Success Message -->
    @if (session()->has('success'))
        <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
            {{ session('success') }}
        </div>
    @endif

    <!-- Error Messages -->
    @if ($errors->any())
        <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Step 1: NIK Verification -->
    @if ($current_step == 1)
        <div>
            <h3 class="text-xl font-bold text-gray-900 mb-4">Verifikasi NIK</h3>
            
            @if (!$nik_verified)
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            NIK (Nomor Induk Kependudukan) <span class="text-red-500">*</span>
                        </label>
                        <input type="text" wire:model="nik" maxlength="16" 
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            placeholder="Masukkan 16 digit NIK">
                        @error('nik') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <button wire:click="verifyNIK" type="button"
                        class="w-full bg-blue-600 text-white py-3 rounded-lg hover:bg-blue-700 font-semibold">
                        Verifikasi NIK
                    </button>
                </div>
            @else
                <div class="space-y-4">
                    <div class="p-4 bg-green-50 border border-green-200 rounded-lg">
                        <p class="text-green-800 font-semibold">✓ NIK Terverifikasi</p>
                        <p class="text-gray-700 mt-2">NIK: {{ $nik }}</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Tanggal Lahir (dari NIK)
                        </label>
                        <input type="date" wire:model="birth_date" 
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>

                    <button wire:click="confirmBirthDate" type="button"
                        class="w-full bg-blue-600 text-white py-3 rounded-lg hover:bg-blue-700 font-semibold">
                        Konfirmasi & Lanjut
                    </button>
                </div>
            @endif
        </div>
    @endif

    <!-- Step 2: Account Info -->
    @if ($current_step == 2)
        <div>
            <h3 class="text-xl font-bold text-gray-900 mb-4">Data Akun</h3>
            
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Nama Lengkap <span class="text-red-500">*</span>
                    </label>
                    <input type="text" wire:model="full_name" 
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        placeholder="Nama sesuai KTP">
                    @error('full_name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Email <span class="text-red-500">*</span>
                    </label>
                    <input type="email" wire:model="email" 
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        placeholder="email@example.com">
                    @error('email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Nomor HP/WhatsApp <span class="text-red-500">*</span>
                    </label>
                    <input type="text" wire:model="phone" 
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        placeholder="08xxxxxxxxxx">
                    @error('phone') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Password <span class="text-red-500">*</span>
                    </label>
                    <input type="password" wire:model="password" 
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        placeholder="Minimal 8 karakter">
                    @error('password') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Konfirmasi Password <span class="text-red-500">*</span>
                    </label>
                    <input type="password" wire:model="password_confirmation" 
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        placeholder="Ulangi password">
                </div>

                <button wire:click="nextStep" type="button"
                    class="w-full bg-blue-600 text-white py-3 rounded-lg hover:bg-blue-700 font-semibold">
                    Lanjut
                </button>
            </div>
        </div>
    @endif

    <!-- Step 3: Disability Questions -->
    @if ($current_step == 3)
        <div>
            <h3 class="text-xl font-bold text-gray-900 mb-4">Informasi Kesehatan</h3>
            
            <div class="space-y-6">
                <!-- Question 1: Disability -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Apakah Anda memiliki disabilitas?
                    </label>
                    <div class="space-y-2">
                        <label class="flex items-center">
                            <input type="radio" wire:model="has_disability" value="0" class="mr-2">
                            <span>Tidak</span>
                        </label>
                        <label class="flex items-center">
                            <input type="radio" wire:model="has_disability" value="1" class="mr-2">
                            <span>Ya</span>
                        </label>
                    </div>
                </div>

                @if ($has_disability)
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Jenis Disabilitas
                        </label>
                        <input type="text" wire:model="disability_type" 
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            placeholder="Sebutkan jenis disabilitas">
                    </div>
                @endif

                <!-- Question 2: Colorblind -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Apakah Anda buta warna?
                    </label>
                    <div class="space-y-2">
                        <label class="flex items-center">
                            <input type="radio" wire:model="is_colorblind" value="0" class="mr-2">
                            <span>Tidak</span>
                        </label>
                        <label class="flex items-center">
                            <input type="radio" wire:model="is_colorblind" value="1" class="mr-2">
                            <span>Ya</span>
                        </label>
                    </div>
                </div>

                <!-- Question 3: Vision Correction -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Apakah Anda menggunakan kacamata/lensa kontak?
                    </label>
                    <div class="space-y-2">
                        <label class="flex items-center">
                            <input type="radio" wire:model="has_vision_correction" value="0" class="mr-2">
                            <span>Tidak</span>
                        </label>
                        <label class="flex items-center">
                            <input type="radio" wire:model="has_vision_correction" value="1" class="mr-2">
                            <span>Ya</span>
                        </label>
                    </div>
                </div>

                @if ($has_vision_correction)
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Detail Penglihatan (Plus/Minus)
                        </label>
                        <input type="text" wire:model="vision_details" 
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            placeholder="Contoh: Minus 2.5 / Plus 1.0">
                    </div>
                @endif

                <!-- reCAPTCHA placeholder -->
                <div class="p-4 bg-gray-100 border border-gray-300 rounded-lg text-center">
                    <p class="text-gray-600">[ reCAPTCHA akan ditambahkan di sini ]</p>
                </div>

                <button wire:click="register" type="button"
                    class="w-full bg-green-600 text-white py-3 rounded-lg hover:bg-green-700 font-semibold">
                    Daftar Sekarang
                </button>
            </div>
        </div>
    @endif
</div>
