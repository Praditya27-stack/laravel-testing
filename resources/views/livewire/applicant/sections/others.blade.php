<div class="space-y-6">
  <div>
    <label class="block font-medium mb-2">1. Pernah ikut psikotes Aisin?</label>
    <select wire:model="prev_psychotest" class="w-full px-4 py-2 border rounded">
      <option value="belum">Belum</option>
      <option value="pernah">Pernah</option>
    </select>
    @if($prev_psychotest==='pernah')
    <button
      wire:click="addPrevPsychotest"
      type="button"
      class="mt-2 px-4 py-2 bg-green-600 text-white rounded text-sm"
    >
      + Tambah Detail
    </button>
    @foreach($prevPsychotests as $i => $p)
    <div class="grid grid-cols-4 gap-2 mt-2">
      <input
        type="text"
        wire:model="prevPsychotests.{{$i}}.organizer"
        placeholder="Penyelenggara"
        class="px-3 py-2 border rounded text-sm"
      />
      <input
        type="text"
        wire:model="prevPsychotests.{{$i}}.process"
        placeholder="Proses"
        class="px-3 py-2 border rounded text-sm"
      />
      <input
        type="text"
        wire:model="prevPsychotests.{{$i}}.time"
        placeholder="Waktu"
        class="px-3 py-2 border rounded text-sm"
      />
      <button
        wire:click="removePrevPsychotest({{$i}})"
        type="button"
        class="text-red-600 text-sm"
      >
        Hapus
      </button>
    </div>
    @endforeach @endif
  </div>

  <div>
    <label class="block font-medium mb-2">2. Hobby dan kegemaran anda?</label>
    <textarea
      wire:model="hobbies"
      rows="2"
      class="w-full px-4 py-2 border rounded"
    ></textarea>
  </div>

  <div>
    <label class="block font-medium mb-2"
      >3. Bagaimana anda mengisi waktu luang?</label
    >
    <textarea
      wire:model="free_time_activity"
      rows="2"
      class="w-full px-4 py-2 border rounded"
    ></textarea>
  </div>

  <div>
    <label class="block font-medium mb-2"
      >4. Sebutkan minimal 3 kelebihan sifat anda (strong point)</label
    >
    <textarea
      wire:model="strengths"
      rows="3"
      class="w-full px-4 py-2 border rounded"
      placeholder="1. ...&#10;2. ...&#10;3. ..."
    ></textarea>
  </div>

  <div>
    <label class="block font-medium mb-2"
      >5. Sebutkan minimal 3 kekurangan sifat anda (weak point)</label
    >
    <textarea
      wire:model="weaknesses"
      rows="3"
      class="w-full px-4 py-2 border rounded"
      placeholder="1. ...&#10;2. ...&#10;3. ..."
    ></textarea>
  </div>

  <div>
    <label class="block font-medium mb-2"
      >6. Pernahkah anda menderita penyakit yang lama sembuh?</label
    >
    <select
      wire:model="has_medical_history"
      class="w-full px-4 py-2 border rounded"
    >
      <option value="tidak">Tidak</option>
      <option value="pernah">Pernah</option>
    </select>
    @if($has_medical_history==='pernah')
    <button
      wire:click="addMedicalHistory"
      type="button"
      class="mt-2 px-4 py-2 bg-green-600 text-white rounded text-sm"
    >
      + Tambah
    </button>
    @foreach($medicalHistories as $i => $m)
    <div class="grid grid-cols-5 gap-2 mt-2">
      <input
        type="text"
        wire:model="medicalHistories.{{$i}}.disease"
        placeholder="Nama Penyakit"
        class="px-3 py-2 border rounded text-sm"
      />
      <select
        wire:model="medicalHistories.{{$i}}.status"
        class="px-3 py-2 border rounded text-sm"
      >
        <option value="">Status</option>
        <option value="ya">Ya</option>
        <option value="tidak">Tidak</option>
        <option value="sudah_tidak">Sudah Tidak</option>
      </select>
      <input
        type="text"
        wire:model="medicalHistories.{{$i}}.since"
        placeholder="Diderita sejak"
        class="px-3 py-2 border rounded text-sm"
      />
      <input
        type="text"
        wire:model="medicalHistories.{{$i}}.notes"
        placeholder="Keterangan"
        class="px-3 py-2 border rounded text-sm"
      />
      <button
        wire:click="removeMedicalHistory({{$i}})"
        type="button"
        class="text-red-600 text-sm"
      >
        Hapus
      </button>
    </div>
    @endforeach @endif
  </div>

  <div class="mt-6 flex justify-end">
    <button
      wire:click="saveOthers"
      type="button"
      class="px-6 py-3 bg-blue-600 text-white rounded-lg"
    >
      Simpan
    </button>
  </div>
</div>
