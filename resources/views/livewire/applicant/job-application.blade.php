<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Job Info Header -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <div class="flex items-start gap-4">
                <div class="w-16 h-16 bg-blue-100 rounded-lg flex items-center justify-center flex-shrink-0">
                    <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                </div>
                <div class="flex-1">
                    <h1 class="text-2xl font-bold text-gray-900">{{ $job->title }}</h1>
                    <p class="text-gray-600 mt-1">{{ $job->department }} • {{ $job->location }}</p>
                    <div class="flex gap-4 mt-3 text-sm">
                        <span class="text-gray-500">💼 {{ ucfirst($job->employment_type) }}</span>
                        <span class="text-gray-500">📍 {{ $job->location }}</span>
                        <span class="text-gray-500">💰 Rp {{ number_format($job->salary_min) }} - {{ number_format($job->salary_max) }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Application Form -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-bold text-gray-900 mb-6">Form Lamaran</h2>

            <form wire:submit.prevent="submitApplication" class="space-y-6">
                <!-- Cover Letter -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Cover Letter / Surat Lamaran *
                    </label>
                    <p class="text-xs text-gray-500 mb-2">Ceritakan mengapa Anda tertarik dengan posisi ini dan mengapa Anda cocok untuk posisi ini. Minimal 100 karakter.</p>
                    <textarea 
                        wire:model="coverLetter" 
                        rows="8" 
                        class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        placeholder="Contoh: Saya tertarik dengan posisi ini karena..."
                    ></textarea>
                    @error('coverLetter') 
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                    <p class="text-xs text-gray-400 mt-1">{{ strlen($coverLetter) }} karakter</p>
                </div>

                <!-- Expected Salary -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Ekspektasi Gaji (Opsional)
                    </label>
                    <div class="relative">
                        <span class="absolute left-4 top-3 text-gray-500">Rp</span>
                        <input 
                            type="number" 
                            wire:model="expectedSalary" 
                            class="w-full pl-12 pr-4 py-3 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                            placeholder="5000000"
                        >
                    </div>
                    @error('expectedSalary') 
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Available Start Date -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Kapan Anda bisa mulai bekerja? *
                    </label>
                    <input 
                        type="date" 
                        wire:model="availableStartDate" 
                        class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        min="{{ date('Y-m-d', strtotime('+1 day')) }}"
                    >
                    @error('availableStartDate') 
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Info Box -->
                <div class="bg-blue-50 border-l-4 border-blue-500 p-4 rounded">
                    <div class="flex items-start">
                        <svg class="w-5 h-5 text-blue-600 mt-0.5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <div class="text-sm text-blue-800">
                            <p class="font-semibold mb-1">Informasi Penting:</p>
                            <ul class="list-disc list-inside space-y-1 text-blue-700">
                                <li>Data profil Anda akan otomatis dikirim bersama lamaran ini</li>
                                <li>Pastikan semua data profil sudah benar sebelum submit</li>
                                <li>Anda akan menerima notifikasi jika lolos tahap seleksi</li>
                                <li>Proses seleksi biasanya memakan waktu 1-2 minggu</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex gap-4 pt-4 border-t">
                    <a href="{{ route('jobs.show', $job->id) }}" class="px-6 py-3 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 font-semibold">
                        Batal
                    </a>
                    <button 
                        type="submit" 
                        class="flex-1 px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-semibold disabled:opacity-50 disabled:cursor-not-allowed"
                        wire:loading.attr="disabled"
                    >
                        <span wire:loading.remove>Kirim Lamaran</span>
                        <span wire:loading>Mengirim...</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
