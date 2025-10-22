<div class="space-y-8">
    <!-- 1. Status Pernikahan -->
    <div class="border-b pb-6">
        <h3 class="font-bold mb-4">1. Status Pernikahan</h3>
        <div class="grid grid-cols-3 gap-4">
            <div><label class="block text-sm mb-2">Status KTP *</label><select wire:model="marital_status_ktp" class="w-full px-4 py-2 border rounded"><option value="">Pilih</option><option value="single">Single</option><option value="engaged">Tunangan</option><option value="married">Menikah</option><option value="divorced">Bercerai</option></select></div>
            <div><label class="block text-sm mb-2">Status Aktual *</label><select wire:model="marital_status_actual" class="w-full px-4 py-2 border rounded"><option value="">Pilih</option><option value="single">Single</option><option value="engaged">Tunangan</option><option value="married">Menikah</option><option value="divorced">Bercerai</option></select></div>
            <div><label class="block text-sm mb-2">Tanggal (jika tunangan/menikah)</label><input type="date" wire:model="marital_date" class="w-full px-4 py-2 border rounded"></div>
        </div>
    </div>

    <!-- 2. Istri/Suami & Anak -->
    <div class="border-b pb-6">
        <h3 class="font-bold mb-4">2. Data Istri/Suami & Anak</h3>
        @if($marital_status_actual === 'married')
        <div class="space-y-4">
            <div class="bg-gray-50 p-4 rounded">
                <h4 class="font-semibold mb-3">Istri/Suami</h4>
                <div class="grid grid-cols-5 gap-3">
                    <div><label class="block text-xs mb-1">Nama</label><input type="text" wire:model="spouse_name" class="w-full px-3 py-2 border rounded text-sm"></div>
                    <div><label class="block text-xs mb-1">L/P</label><select wire:model="spouse_gender" class="w-full px-3 py-2 border rounded text-sm"><option value="">-</option><option value="L">L</option><option value="P">P</option></select></div>
                    <div><label class="block text-xs mb-1">Tempat & Tgl Lahir</label><input type="text" wire:model="spouse_birth" class="w-full px-3 py-2 border rounded text-sm"></div>
                    <div><label class="block text-xs mb-1">Pendidikan</label><input type="text" wire:model="spouse_education" class="w-full px-3 py-2 border rounded text-sm"></div>
                    <div><label class="block text-xs mb-1">Pekerjaan</label><input type="text" wire:model="spouse_occupation" class="w-full px-3 py-2 border rounded text-sm"></div>
                </div>
            </div>
            <button wire:click="addChild" type="button" class="px-4 py-2 bg-green-600 text-white rounded text-sm">+ Tambah Anak</button>
            @foreach($children as $index => $child)
            <div class="bg-gray-50 p-4 rounded">
                <div class="flex justify-between mb-2"><h4 class="font-semibold">Anak {{$index+1}}</h4><button wire:click="removeChild({{$index}})" type="button" class="text-red-600 text-sm">Hapus</button></div>
                <div class="grid grid-cols-5 gap-3">
                    <div><input type="text" wire:model="children.{{$index}}.name" placeholder="Nama" class="w-full px-3 py-2 border rounded text-sm"></div>
                    <div><select wire:model="children.{{$index}}.gender" class="w-full px-3 py-2 border rounded text-sm"><option value="">L/P</option><option value="L">L</option><option value="P">P</option></select></div>
                    <div><input type="text" wire:model="children.{{$index}}.birth" placeholder="Tempat & Tgl Lahir" class="w-full px-3 py-2 border rounded text-sm"></div>
                    <div><input type="text" wire:model="children.{{$index}}.education" placeholder="Pendidikan" class="w-full px-3 py-2 border rounded text-sm"></div>
                    <div><input type="text" wire:model="children.{{$index}}.occupation" placeholder="Pekerjaan" class="w-full px-3 py-2 border rounded text-sm"></div>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <p class="text-gray-500 text-sm">Isi status pernikahan terlebih dahulu</p>
        @endif
    </div>

    <!-- 3. Susunan Keluarga -->
    <div>
        <h3 class="font-bold mb-4">3. Susunan Keluarga (Ayah, Ibu, Saudara Kandung)</h3>
        <div class="space-y-4">
            <div class="bg-gray-50 p-4 rounded">
                <h4 class="font-semibold mb-3">Ayah</h4>
                <div class="grid grid-cols-5 gap-3">
                    <div><input type="text" wire:model="father_name" placeholder="Nama" class="w-full px-3 py-2 border rounded text-sm"></div>
                    <div><input type="text" value="L" disabled class="w-full px-3 py-2 border rounded text-sm bg-gray-100"></div>
                    <div><input type="text" wire:model="father_birth" placeholder="Tempat & Tgl Lahir" class="w-full px-3 py-2 border rounded text-sm"></div>
                    <div><input type="text" wire:model="father_education" placeholder="Pendidikan" class="w-full px-3 py-2 border rounded text-sm"></div>
                    <div><input type="text" wire:model="father_occupation" placeholder="Pekerjaan" class="w-full px-3 py-2 border rounded text-sm"></div>
                </div>
            </div>
            <div class="bg-gray-50 p-4 rounded">
                <h4 class="font-semibold mb-3">Ibu</h4>
                <div class="grid grid-cols-5 gap-3">
                    <div><input type="text" wire:model="mother_name" placeholder="Nama" class="w-full px-3 py-2 border rounded text-sm"></div>
                    <div><input type="text" value="P" disabled class="w-full px-3 py-2 border rounded text-sm bg-gray-100"></div>
                    <div><input type="text" wire:model="mother_birth" placeholder="Tempat & Tgl Lahir" class="w-full px-3 py-2 border rounded text-sm"></div>
                    <div><input type="text" wire:model="mother_education" placeholder="Pendidikan" class="w-full px-3 py-2 border rounded text-sm"></div>
                    <div><input type="text" wire:model="mother_occupation" placeholder="Pekerjaan" class="w-full px-3 py-2 border rounded text-sm"></div>
                </div>
            </div>
            <button wire:click="addSibling" type="button" class="px-4 py-2 bg-green-600 text-white rounded text-sm">+ Tambah Saudara</button>
            @foreach($siblings as $index => $sibling)
            <div class="bg-gray-50 p-4 rounded">
                <div class="flex justify-between mb-2"><h4 class="font-semibold">Anak {{$index+1}}</h4><button wire:click="removeSibling({{$index}})" type="button" class="text-red-600 text-sm">Hapus</button></div>
                <div class="grid grid-cols-5 gap-3">
                    <div><input type="text" wire:model="siblings.{{$index}}.name" placeholder="Nama" class="w-full px-3 py-2 border rounded text-sm"></div>
                    <div><select wire:model="siblings.{{$index}}.gender" class="w-full px-3 py-2 border rounded text-sm"><option value="">L/P</option><option value="L">L</option><option value="P">P</option></select></div>
                    <div><input type="text" wire:model="siblings.{{$index}}.birth" placeholder="Tempat & Tgl Lahir" class="w-full px-3 py-2 border rounded text-sm"></div>
                    <div><input type="text" wire:model="siblings.{{$index}}.education" placeholder="Pendidikan" class="w-full px-3 py-2 border rounded text-sm"></div>
                    <div><input type="text" wire:model="siblings.{{$index}}.occupation" placeholder="Pekerjaan" class="w-full px-3 py-2 border rounded text-sm"></div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <div class="mt-6 flex justify-end"><button wire:click="saveFamily" type="button" class="px-6 py-3 bg-blue-600 text-white rounded-lg">Simpan Data Keluarga</button></div>
</div>
