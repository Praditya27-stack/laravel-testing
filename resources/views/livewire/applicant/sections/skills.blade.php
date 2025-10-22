<div class="space-y-6">
    <form wire:submit.prevent="addSkill" class="bg-gray-50 p-6 rounded-lg">
        <h3 class="font-semibold mb-4">Tambah Keahlian</h3>
        <div class="grid grid-cols-2 gap-4">
            <div><label class="block text-sm mb-2">Nama Keahlian *</label><input type="text" wire:model="skill_name" class="w-full px-4 py-2 border rounded-lg" placeholder="Contoh: Microsoft Excel, Las, dll"></div>
            <div><label class="block text-sm mb-2">Tingkat Kemahiran</label><select wire:model="skill_proficiency" class="w-full px-4 py-2 border rounded-lg"><option value="beginner">Pemula</option><option value="intermediate">Menengah</option><option value="advanced">Mahir</option><option value="expert">Ahli</option></select></div>
        </div>
        <button type="submit" class="mt-4 px-6 py-2 bg-blue-600 text-white rounded-lg">+ Tambah</button>
    </form>

    <div class="grid grid-cols-3 gap-4">
        @forelse($skills as $skill)
        <div class="border rounded-lg p-4 flex justify-between items-center hover:shadow-md transition">
            <div>
                <h4 class="font-semibold text-sm">{{ $skill->skill_name }}</h4>
                <p class="text-xs text-gray-500">{{ ucfirst($skill->proficiency_level) }}</p>
            </div>
            <button wire:click="deleteSkill({{ $skill->id }})" class="text-red-600">×</button>
        </div>
        @empty
        <p class="text-gray-500 text-center py-8 col-span-3">Belum ada keahlian. Tambahkan minimal 3 keahlian.</p>
        @endforelse
    </div>
</div>
