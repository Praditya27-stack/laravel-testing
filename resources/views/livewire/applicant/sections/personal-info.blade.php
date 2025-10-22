<form wire:submit.prevent="savePersonalInfo">
    <div class="space-y-6">
        <!-- Profile Photo & Name -->
        <div class="flex items-start gap-6 pb-6 border-b">
            <div class="w-32 h-32 bg-gray-200 rounded-lg flex items-center justify-center">
                <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
            </div>
            <div class="flex-1">
                <h3 class="text-2xl font-bold text-gray-900">{{ $full_name ?: 'Nama Lengkap' }}</h3>
                @if(!$profile->isPersonalInfoComplete())
                <p class="text-red-500 text-sm mt-1">⚠ Data Belum Lengkap</p>
                @endif
            </div>
        </div>

        <!-- Form Fields -->
        <div class="grid grid-cols-2 gap-x-8 gap-y-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap *</label>
                <input type="text" wire:model="full_name" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500">
                @error('full_name')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Jenis Kelamin *</label>
                <select wire:model="gender" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500">
                    <option value="">Pilih</option>
                    <option value="male">Laki-laki</option>
                    <option value="female">Perempuan</option>
                </select>
                @error('gender')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Lahir *</label>
                <input type="date" wire:model="birth_date" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500">
                @error('birth_date')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Tempat Lahir</label>
                <input type="text" wire:model="birth_place" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Nomor HP *</label>
                <input type="text" wire:model="phone" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500" placeholder="+62">
                @error('phone')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                <input type="email" value="{{ auth()->user()->email }}" disabled class="w-full px-4 py-2 border rounded-lg bg-gray-50">
            </div>

            <div class="col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-2">Domisili *</label>
                <textarea wire:model="address" rows="3" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500" placeholder="Alamat lengkap"></textarea>
                @error('address')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Kota *</label>
                <input type="text" wire:model="city" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500">
                @error('city')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Provinsi</label>
                <input type="text" wire:model="province" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Nomor KTP *</label>
                <input type="text" wire:model="id_card_number" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500" maxlength="16">
                @error('id_card_number')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Agama</label>
                <input type="text" wire:model="religion" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Status Pernikahan</label>
                <select wire:model="marital_status" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500">
                    <option value="">Pilih</option>
                    <option value="single">Belum Menikah</option>
                    <option value="married">Menikah</option>
                    <option value="divorced">Cerai</option>
                </select>
            </div>
        </div>

        <!-- Save Button -->
        <div class="flex justify-end pt-6 border-t">
            <button type="submit" class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-semibold">
                Simpan Data
            </button>
        </div>
    </div>
</form>
