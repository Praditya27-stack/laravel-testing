<div class="space-y-6">
  <div>
    <label class="block font-medium mb-2"
      >1. Keahlian apa yang anda miliki?</label
    >
    <textarea
      wire:model="motivation_skills"
      rows="3"
      class="w-full px-4 py-2 border rounded"
      placeholder="Welding, instalasi listrik, MS Office, dll"
    ></textarea>
  </div>

  <div>
    <label class="block font-medium mb-2"
      >2. Apa yang mendorong anda ingin bekerja?</label
    >
    <textarea
      wire:model="motivation_reason"
      rows="3"
      class="w-full px-4 py-2 border rounded"
    ></textarea>
  </div>

  <div>
    <label class="block font-medium mb-2"
      >3. Mengapa anda ingin bekerja di perusahaan kami?</label
    >
    <textarea
      wire:model="motivation_why_company"
      rows="3"
      class="w-full px-4 py-2 border rounded"
    ></textarea>
  </div>

  <div>
    <label class="block font-medium mb-2"
      >4. Sebutkan gaji yang anda inginkan *</label
    >
    <input
      type="number"
      wire:model="motivation_expected_salary"
      class="w-full px-4 py-2 border rounded"
    />
  </div>

  <div>
    <label class="block font-medium mb-2"
      >5. Kapan anda bisa mulai bekerja? *</label
    >
    <input
      type="date"
      wire:model="motivation_start_date"
      class="w-full px-4 py-2 border rounded"
    />
  </div>

  <div>
    <label class="block font-medium mb-2"
      >6. Apakah ada kenalan/kerabat/keluarga yang bekerja di PT Aisin?</label
    >
    <div class="grid grid-cols-2 gap-4">
      <input
        type="text"
        wire:model="motivation_relative_name"
        placeholder="Nama"
        class="w-full px-4 py-2 border rounded"
      />
      <input
        type="text"
        wire:model="motivation_relative_relation"
        placeholder="Hubungan"
        class="w-full px-4 py-2 border rounded"
      />
    </div>
  </div>

  <!-- <div>
    <label class="block font-medium mb-2"
      >7. Pilih 3 bidang pekerjaan sesuai prioritas (1-3)</label
    >
    <div class="space-y-2">
      @foreach(['Production', 'Quality', 'Maintenance', 'Logistics',
      'Engineering'] as $dept)
      <div class="flex items-center gap-4">
        <span class="w-32">{{$dept}}</span>
        <select
          wire:model="dept_pref_{{strtolower($dept)}}"
          class="px-4 py-2 border rounded"
        >
          <option value="">-</option>
          <option value="1">1</option>
          <option value="2">2</option>
          <option value="3">3</option>
        </select>
      </div>
      @endforeach
    </div>
  </div> -->

  <div class="mt-6 flex justify-end">
    <button
      wire:click="saveMotivation"
      type="button"
      class="px-6 py-3 bg-blue-600 text-white rounded-lg"
    >
      Simpan
    </button>
  </div>
</div>
