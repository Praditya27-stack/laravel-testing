<div class="space-y-6">
    <form wire:submit.prevent="addExperience" class="bg-gray-50 p-6 rounded-lg">
        <h3 class="font-semibold mb-4">Tambah Pengalaman Kerja</h3>
        <div class="grid grid-cols-2 gap-4">
            <div><label class="block text-sm mb-2">Perusahaan *</label><input type="text" wire:model="exp_company" class="w-full px-4 py-2 border rounded-lg"></div>
            <div><label class="block text-sm mb-2">Posisi *</label><input type="text" wire:model="exp_position" class="w-full px-4 py-2 border rounded-lg"></div>
            <div class="col-span-2"><label class="block text-sm mb-2">Deskripsi Pekerjaan</label><textarea wire:model="exp_description" rows="3" class="w-full px-4 py-2 border rounded-lg"></textarea></div>
            <div><label class="block text-sm mb-2">Tanggal Mulai *</label><input type="date" wire:model="exp_start_date" class="w-full px-4 py-2 border rounded-lg"></div>
            <div><label class="block text-sm mb-2">Tanggal Selesai</label><input type="date" wire:model="exp_end_date" class="w-full px-4 py-2 border rounded-lg" {{ $exp_is_current ? 'disabled' : '' }}></div>
            <div class="col-span-2"><label class="flex items-center"><input type="checkbox" wire:model="exp_is_current" class="mr-2"><span class="text-sm">Masih bekerja di sini</span></label></div>
        </div>
        <button type="submit" class="mt-4 px-6 py-2 bg-blue-600 text-white rounded-lg">+ Tambah</button>
    </form>

    <div class="space-y-4">
        @forelse($experiences as $exp)
        <div class="border rounded-lg p-4 flex justify-between hover:shadow-md transition">
            <div>
                <h4 class="font-semibold">{{ $exp->position }}</h4>
                <p class="text-sm text-gray-600">{{ $exp->company_name }}</p>
                <p class="text-xs text-gray-500">{{ $exp->start_date->format('M Y') }} - {{ $exp->is_current ? 'Sekarang' : $exp->end_date->format('M Y') }}</p>
            </div>
            <button wire:click="deleteExperience({{ $exp->id }})" class="text-red-600 text-sm">Hapus</button>
        </div>
        @empty
        <p class="text-gray-500 text-center py-8">Belum ada pengalaman kerja. Tambahkan minimal 1 data.</p>
        @endforelse
    </div>
</div>
