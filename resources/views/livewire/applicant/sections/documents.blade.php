<div class="space-y-6">
    <p class="text-sm text-gray-600 mb-4">Upload dokumen yang diperlukan. File maksimal 2MB (PDF, JPG, PNG)</p>

    <!-- CV/Resume -->
    <div class="border rounded-lg p-4">
        <div class="flex justify-between items-center mb-3">
            <div>
                <h4 class="font-semibold">CV/Resume *</h4>
                <p class="text-xs text-gray-500">Upload CV atau Resume terbaru Anda</p>
            </div>
            @php $cvDoc = $documents->firstWhere('document_type', 'cv'); @endphp
            @if($cvDoc)
                <span class="text-green-600 text-sm">✓ Uploaded</span>
            @else
                <span class="text-red-500 text-sm">⚠ Required</span>
            @endif
        </div>
        @if($cvDoc)
            <div class="bg-gray-50 p-3 rounded flex justify-between items-center">
                <div>
                    <p class="text-sm font-medium">{{ $cvDoc->original_filename }}</p>
                    <p class="text-xs text-gray-500">{{ number_format($cvDoc->file_size/1024,2) }} KB</p>
                </div>
                <button wire:click="deleteDocument({{ $cvDoc->id }})" class="text-red-600 text-sm">Hapus</button>
            </div>
        @else
            <input type="file" wire:model="cv_file" class="w-full px-4 py-2 border rounded-lg" accept=".pdf,.doc,.docx">
            @if($cv_file)
                <button wire:click="uploadCV" class="mt-2 px-4 py-2 bg-blue-600 text-white rounded text-sm">Upload CV</button>
            @endif
        @endif
    </div>

    <!-- KTP -->
    <div class="border rounded-lg p-4">
        @php $ktpDoc = $documents->firstWhere('document_type', 'ktp'); @endphp
        <div class="flex justify-between items-center mb-3">
            <div>
                <h4 class="font-semibold">KTP *</h4>
                <p class="text-xs text-gray-500">Scan/Foto KTP yang masih berlaku</p>
            </div>
            @if($ktpDoc)
                <span class="text-green-600 text-sm">✓ Uploaded</span>
            @else
                <span class="text-red-500 text-sm">⚠ Required</span>
            @endif
        </div>
        @if($ktpDoc)
            <div class="bg-gray-50 p-3 rounded flex justify-between items-center">
                <div>
                    <p class="text-sm font-medium">{{ $ktpDoc->original_filename }}</p>
                    <p class="text-xs text-gray-500">{{ number_format($ktpDoc->file_size/1024,2) }} KB</p>
                </div>
                <button wire:click="deleteDocument({{ $ktpDoc->id }})" class="text-red-600 text-sm">Hapus</button>
            </div>
        @else
            <input type="file" wire:model="ktp_file" class="w-full px-4 py-2 border rounded-lg" accept=".pdf,.jpg,.jpeg,.png">
            @if($ktp_file)
                <button wire:click="uploadKTP" class="mt-2 px-4 py-2 bg-blue-600 text-white rounded text-sm">Upload KTP</button>
            @endif
        @endif
    </div>

    <!-- Ijazah -->
    <div class="border rounded-lg p-4">
        @php $ijazahDoc = $documents->firstWhere('document_type', 'ijazah'); @endphp
        <div class="flex justify-between items-center mb-3">
            <div>
                <h4 class="font-semibold">Ijazah *</h4>
                <p class="text-xs text-gray-500">Ijazah pendidikan terakhir</p>
            </div>
            @if($ijazahDoc)
                <span class="text-green-600 text-sm">✓ Uploaded</span>
            @else
                <span class="text-red-500 text-sm">⚠ Required</span>
            @endif
        </div>
        @if($ijazahDoc)
            <div class="bg-gray-50 p-3 rounded flex justify-between items-center">
                <div>
                    <p class="text-sm font-medium">{{ $ijazahDoc->original_filename }}</p>
                    <p class="text-xs text-gray-500">{{ number_format($ijazahDoc->file_size/1024,2) }} KB</p>
                </div>
                <button wire:click="deleteDocument({{ $ijazahDoc->id }})" class="text-red-600 text-sm">Hapus</button>
            </div>
        @else
            <input type="file" wire:model="ijazah_file" class="w-full px-4 py-2 border rounded-lg" accept=".pdf,.jpg,.jpeg,.png">
            @if($ijazah_file)
                <button wire:click="uploadIjazah" class="mt-2 px-4 py-2 bg-blue-600 text-white rounded text-sm">Upload Ijazah</button>
            @endif
        @endif
    </div>

    <!-- Pas Foto -->
    <div class="border rounded-lg p-4">
        @php $fotoDoc = $documents->firstWhere('document_type', 'foto'); @endphp
        <div class="flex justify-between items-center mb-3">
            <div>
                <h4 class="font-semibold">Pas Foto</h4>
                <p class="text-xs text-gray-500">Foto formal ukuran 3x4 atau 4x6</p>
            </div>
            @if($fotoDoc)
                <span class="text-green-600 text-sm">✓ Uploaded</span>
            @else
                <span class="text-gray-400 text-sm">Optional</span>
            @endif
        </div>
        @if($fotoDoc)
            <div class="bg-gray-50 p-3 rounded flex justify-between items-center">
                <div>
                    <p class="text-sm font-medium">{{ $fotoDoc->original_filename }}</p>
                    <p class="text-xs text-gray-500">{{ number_format($fotoDoc->file_size/1024,2) }} KB</p>
                </div>
                <button wire:click="deleteDocument({{ $fotoDoc->id }})" class="text-red-600 text-sm">Hapus</button>
            </div>
        @else
            <input type="file" wire:model="foto_file" class="w-full px-4 py-2 border rounded-lg" accept=".jpg,.jpeg,.png">
            @if($foto_file)
                <button wire:click="uploadFoto" class="mt-2 px-4 py-2 bg-blue-600 text-white rounded text-sm">Upload Foto</button>
            @endif
        @endif
    </div>
</div>
