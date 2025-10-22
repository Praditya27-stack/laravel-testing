<div class="space-y-6">
    <!-- Add Form -->
    <form wire:submit.prevent="addEducation" class="bg-gray-50 p-6 rounded-lg">
        <h3 class="font-semibold text-gray-900 mb-4">Tambah Pendidikan</h3>
        <div class="grid grid-cols-2 gap-4">
            <div><label class="block text-sm mb-2">Jenjang *</label><select wire:model="edu_level" class="w-full px-4 py-2 border rounded-lg"><option value="">Pilih</option><option value="sma">SMA</option><option value="smk">SMK</option><option value="d3">D3</option><option value="s1">S1</option><option value="s2">S2</option></select></div>
            <div><label class="block text-sm mb-2">Institusi *</label><input type="text" wire:model="edu_institution" class="w-full px-4 py-2 border rounded-lg"></div>
            <div><label class="block text-sm mb-2">Jurusan</label><input type="text" wire:model="edu_major" class="w-full px-4 py-2 border rounded-lg"></div>
            <div><label class="block text-sm mb-2">IPK/Nilai</label><input type="text" wire:model="edu_gpa" class="w-full px-4 py-2 border rounded-lg"></div>
            <div><label class="block text-sm mb-2">Tahun Mulai *</label><input type="number" wire:model="edu_start_year" class="w-full px-4 py-2 border rounded-lg" min="1980" max="2030"></div>
            <div><label class="block text-sm mb-2">Tahun Selesai</label><input type="number" wire:model="edu_end_year" class="w-full px-4 py-2 border rounded-lg" min="1980" max="2030"></div>
        </div>
        <button type="submit" class="mt-4 px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">+ Tambah</button>
    </form>

    <!-- List -->
    <div class="space-y-4">
        @forelse($educations as $edu)
        <div class="border rounded-lg p-4 flex justify-between items-start hover:shadow-md transition">
            <div>
                <h4 class="font-semibold text-gray-900">{{ strtoupper($edu->level) }} - {{ $edu->institution_name }}</h4>
                <p class="text-sm text-gray-600">{{ $edu->major }} @if($edu->gpa)| IPK: {{ $edu->gpa }}@endif</p>
                <p class="text-xs text-gray-500">{{ $edu->start_year }} - {{ $edu->end_year ?? 'Sekarang' }}</p>
            </div>
            <button wire:click="deleteEducation({{ $edu->id }})" class="text-red-600 hover:text-red-800 text-sm">Hapus</button>
        </div>
        @empty
        <p class="text-gray-500 text-center py-8">Belum ada data pendidikan. Tambahkan minimal 1 data.</p>
        @endforelse
    </div>
</div>
