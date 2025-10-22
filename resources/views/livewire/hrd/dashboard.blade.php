<div class="p-6">
    <h1 class="text-2xl font-bold text-gray-900 mb-6">HRD Dashboard</h1>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-6 gap-4 mb-8">
        <div class="bg-white rounded-lg shadow p-4">
            <p class="text-sm text-gray-600">Total Lamaran</p>
            <p class="text-2xl font-bold text-gray-900">{{ $stats['total_applications'] }}</p>
        </div>
        <div class="bg-blue-50 rounded-lg shadow p-4">
            <p class="text-sm text-blue-600">Lamaran Baru</p>
            <p class="text-2xl font-bold text-blue-900">{{ $stats['new_applications'] }}</p>
        </div>
        <div class="bg-yellow-50 rounded-lg shadow p-4">
            <p class="text-sm text-yellow-600">Dalam Proses</p>
            <p class="text-2xl font-bold text-yellow-900">{{ $stats['in_progress'] }}</p>
        </div>
        <div class="bg-green-50 rounded-lg shadow p-4">
            <p class="text-sm text-green-600">Diterima</p>
            <p class="text-2xl font-bold text-green-900">{{ $stats['hired'] }}</p>
        </div>
        <div class="bg-red-50 rounded-lg shadow p-4">
            <p class="text-sm text-red-600">Ditolak</p>
            <p class="text-2xl font-bold text-red-900">{{ $stats['rejected'] }}</p>
        </div>
        <div class="bg-purple-50 rounded-lg shadow p-4">
            <p class="text-sm text-purple-600">Lowongan Aktif</p>
            <p class="text-2xl font-bold text-purple-900">{{ $stats['active_jobs'] }}</p>
        </div>
    </div>

    <!-- Filters -->
    <div class="bg-white rounded-lg shadow p-4 mb-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Cari Pelamar</label>
                <input type="text" wire:model.live="search" placeholder="Nama, email, atau nomor lamaran..." class="w-full px-4 py-2 border rounded-lg">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                <select wire:model.live="filterStatus" class="w-full px-4 py-2 border rounded-lg">
                    <option value="all">Semua Status</option>
                    <option value="submitted">Baru Masuk</option>
                    <option value="screening">Screening</option>
                    <option value="interview">Interview</option>
                    <option value="assessment">Assessment</option>
                    <option value="hired">Diterima</option>
                    <option value="rejected">Ditolak</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Posisi</label>
                <select wire:model.live="filterJob" class="w-full px-4 py-2 border rounded-lg">
                    <option value="all">Semua Posisi</option>
                    @foreach($jobs as $job)
                        <option value="{{ $job->id }}">{{ $job->title }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>

    <!-- Applications Table -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">No. Lamaran</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Pelamar</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Posisi</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal Lamar</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($applications as $app)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                        {{ $app->application_number }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div>
                            <div class="text-sm font-medium text-gray-900">{{ $app->user->name }}</div>
                            <div class="text-sm text-gray-500">{{ $app->user->email }}</div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        {{ $app->job->title }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        {{ $app->applied_at->format('d M Y') }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        @php
                            $statusColors = [
                                'submitted' => 'bg-blue-100 text-blue-800',
                                'screening' => 'bg-yellow-100 text-yellow-800',
                                'interview' => 'bg-purple-100 text-purple-800',
                                'assessment' => 'bg-indigo-100 text-indigo-800',
                                'hired' => 'bg-green-100 text-green-800',
                                'rejected' => 'bg-red-100 text-red-800',
                            ];
                            $statusLabels = [
                                'submitted' => 'Baru Masuk',
                                'screening' => 'Screening',
                                'interview' => 'Interview',
                                'assessment' => 'Assessment',
                                'hired' => 'Diterima',
                                'rejected' => 'Ditolak',
                            ];
                        @endphp
                        <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $statusColors[$app->status] ?? 'bg-gray-100 text-gray-800' }}">
                            {{ $statusLabels[$app->status] ?? ucfirst($app->status) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                        <a href="#" class="text-blue-600 hover:text-blue-900 font-medium">
                            Lihat Detail →
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                        <svg class="w-12 h-12 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        <p class="font-medium">Belum ada lamaran</p>
                        <p class="text-sm">Lamaran yang masuk akan muncul di sini</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>

        <!-- Pagination -->
        <div class="px-6 py-4 border-t">
            {{ $applications->links() }}
        </div>
    </div>
</div>
