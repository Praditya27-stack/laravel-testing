<div class="space-y-8">
    <!-- 1. Pendidikan Formal -->
    <div class="border-b pb-6">
        <h3 class="font-bold mb-4">1. Pendidikan Formal</h3>
        <div class="space-y-4">
            @foreach(['SD', 'SLTP', 'SMK/SMA'] as $level)
            <div class="bg-gray-50 p-4 rounded">
                <h4 class="font-semibold mb-3">{{ $level }}</h4>
                <div class="grid grid-cols-3 gap-4">
                    <div><label class="block text-xs mb-1">Nama Sekolah *</label><input type="text" wire:model="formal_{{strtolower($level)}}_name" class="w-full px-3 py-2 border rounded text-sm"></div>
                    <div><label class="block text-xs mb-1">Jurusan</label><input type="text" wire:model="formal_{{strtolower($level)}}_major" class="w-full px-3 py-2 border rounded text-sm"></div>
                    <div><label class="block text-xs mb-1">Tahun Lulus *</label><input type="number" wire:model="formal_{{strtolower($level)}}_year" class="w-full px-3 py-2 border rounded text-sm"></div>
                    <div><label class="block text-xs mb-1">Tempat</label><input type="text" wire:model="formal_{{strtolower($level)}}_place" class="w-full px-3 py-2 border rounded text-sm"></div>
                    <div><label class="block text-xs mb-1">Rata-rata MTK</label><input type="number" step="0.01" wire:model="formal_{{strtolower($level)}}_math_avg" class="w-full px-3 py-2 border rounded text-sm"></div>
                    <div><label class="block text-xs mb-1">Nilai UN MTK</label><input type="number" step="0.01" wire:model="formal_{{strtolower($level)}}_math_un" class="w-full px-3 py-2 border rounded text-sm"></div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <!-- 2. Pendidikan Non-Formal -->
    <div class="border-b pb-6">
        <h3 class="font-bold mb-4">2. Pendidikan Non-Formal (Kursus/Training)</h3>
        <button wire:click="addNonFormalEducation" type="button" class="mb-3 px-4 py-2 bg-green-600 text-white rounded text-sm">+ Tambah</button>
        <div class="space-y-2">
            @forelse($nonFormalEducations as $index => $edu)
            <div class="grid grid-cols-5 gap-2 items-center bg-gray-50 p-2 rounded">
                <input type="text" wire:model="nonFormalEducations.{{$index}}.name" placeholder="Nama Kursus" class="px-3 py-2 border rounded text-sm">
                <input type="text" wire:model="nonFormalEducations.{{$index}}.place" placeholder="Tempat" class="px-3 py-2 border rounded text-sm">
                <input type="text" wire:model="nonFormalEducations.{{$index}}.period" placeholder="Periode" class="px-3 py-2 border rounded text-sm">
                <input type="text" wire:model="nonFormalEducations.{{$index}}.notes" placeholder="Keterangan" class="px-3 py-2 border rounded text-sm">
                <button wire:click="removeNonFormalEducation({{$index}})" type="button" class="text-red-600">Hapus</button>
            </div>
            @empty
            <p class="text-gray-500 text-sm">Belum ada data</p>
            @endforelse
        </div>
    </div>

    <!-- 3. Bahasa Asing -->
    <div class="border-b pb-6">
        <h3 class="font-bold mb-4">3. Bahasa Asing yang Dikuasai</h3>
        <button wire:click="addLanguageSkill" type="button" class="mb-3 px-4 py-2 bg-green-600 text-white rounded text-sm">+ Tambah</button>
        <div class="space-y-2">
            @forelse($languageSkills as $index => $lang)
            <div class="grid grid-cols-6 gap-2 items-center bg-gray-50 p-2 rounded">
                <input type="text" wire:model="languageSkills.{{$index}}.language" placeholder="Bahasa" class="px-3 py-2 border rounded text-sm">
                <select wire:model="languageSkills.{{$index}}.writing" class="px-3 py-2 border rounded text-sm"><option value="">Tulisan</option><option value="baik">Baik</option><option value="kurang">Kurang</option></select>
                <select wire:model="languageSkills.{{$index}}.reading" class="px-3 py-2 border rounded text-sm"><option value="">Membaca</option><option value="baik">Baik</option><option value="kurang">Kurang</option></select>
                <select wire:model="languageSkills.{{$index}}.grammar" class="px-3 py-2 border rounded text-sm"><option value="">Tata Bahasa</option><option value="baik">Baik</option><option value="kurang">Kurang</option></select>
                <input type="text" wire:model="languageSkills.{{$index}}.notes" placeholder="Keterangan" class="px-3 py-2 border rounded text-sm">
                <button wire:click="removeLanguageSkill({{$index}})" type="button" class="text-red-600">Hapus</button>
            </div>
            @empty
            <p class="text-gray-500 text-sm">Belum ada data</p>
            @endforelse
        </div>
    </div>

    <!-- 4. Pengalaman Organisasi -->
    <div>
        <h3 class="font-bold mb-4">4. Pengalaman Organisasi/Ekstrakurikuler</h3>
        <button wire:click="addOrganization" type="button" class="mb-3 px-4 py-2 bg-green-600 text-white rounded text-sm">+ Tambah</button>
        <div class="space-y-2">
            @forelse($organizations as $index => $org)
            <div class="grid grid-cols-5 gap-2 items-center bg-gray-50 p-2 rounded">
                <input type="text" wire:model="organizations.{{$index}}.name" placeholder="Nama Organisasi" class="px-3 py-2 border rounded text-sm">
                <input type="text" wire:model="organizations.{{$index}}.place" placeholder="Tempat" class="px-3 py-2 border rounded text-sm">
                <input type="text" wire:model="organizations.{{$index}}.position" placeholder="Jabatan" class="px-3 py-2 border rounded text-sm">
                <input type="text" wire:model="organizations.{{$index}}.period" placeholder="Masa Jabatan" class="px-3 py-2 border rounded text-sm">
                <button wire:click="removeOrganization({{$index}})" type="button" class="text-red-600">Hapus</button>
            </div>
            @empty
            <p class="text-gray-500 text-sm">Belum ada data</p>
            @endforelse
        </div>
    </div>

    <div class="mt-6 flex justify-end"><button wire:click="saveEducation" type="button" class="px-6 py-3 bg-blue-600 text-white rounded-lg">Simpan Pendidikan</button></div>
</div>
