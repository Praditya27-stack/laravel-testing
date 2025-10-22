<div class="space-y-6">
    <form wire:submit.prevent="addReference" class="bg-gray-50 p-6 rounded-lg">
        <h3 class="font-semibold mb-4">Tambah Referensi</h3>
        <div class="grid grid-cols-2 gap-4">
            <div><label class="block text-sm mb-2">Nama *</label><input type="text" wire:model="ref_name" class="w-full px-4 py-2 border rounded-lg"></div>
            <div><label class="block text-sm mb-2">Hubungan *</label><input type="text" wire:model="ref_relationship" class="w-full px-4 py-2 border rounded-lg" placeholder="Contoh: Mantan Atasan"></div>
            <div><label class="block text-sm mb-2">Perusahaan *</label><input type="text" wire:model="ref_company" class="w-full px-4 py-2 border rounded-lg"></div>
            <div><label class="block text-sm mb-2">Jabatan</label><input type="text" wire:model="ref_position" class="w-full px-4 py-2 border rounded-lg"></div>
            <div><label class="block text-sm mb-2">Nomor HP *</label><input type="text" wire:model="ref_phone" class="w-full px-4 py-2 border rounded-lg"></div>
            <div><label class="block text-sm mb-2">Email</label><input type="email" wire:model="ref_email" class="w-full px-4 py-2 border rounded-lg"></div>
        </div>
        <button type="submit" class="mt-4 px-6 py-2 bg-blue-600 text-white rounded-lg">+ Tambah</button>
    </form>

    <div class="space-y-4">
        @forelse($references as $ref)
        <div class="border rounded-lg p-4 flex justify-between hover:shadow-md transition">
            <div>
                <h4 class="font-semibold">{{ $ref->name }}</h4>
                <p class="text-sm text-gray-600">{{ $ref->relationship }} di {{ $ref->company }}</p>
                <p class="text-xs text-gray-500">{{ $ref->phone }} @if($ref->email)| {{ $ref->email }}@endif</p>
            </div>
            <button wire:click="deleteReference({{ $ref->id }})" class="text-red-600 text-sm">Hapus</button>
        </div>
        @empty
        <p class="text-gray-500 text-center py-8">Belum ada referensi. Tambahkan minimal 2 referensi.</p>
        @endforelse
    </div>
</div>
