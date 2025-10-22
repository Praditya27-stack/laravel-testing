@extends('layouts.app')

@section('title', 'Absensi -  ')

@section('content')
<div class="flex h-screen bg-gray-50">
    <!-- Sidebar -->
    <aside class="w-64 bg-white shadow-lg flex flex-col">
        <div class="p-6">
            <h1 class="text-2xl font-bold text-gray-800">Human Resources </h1>
            <p class="text-sm text-gray-500 mt-1"></p>
        </div>

        <nav class="mt-6 flex-1">
            <a href="{{ route('hrd.dashboard') }}" class="flex items-center px-6 py-3 text-gray-600 hover:bg-gray-50 transition-colors">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                </svg>
                Dashboard
            </a>

            <a href="#" class="flex items-center px-6 py-3 text-gray-600 hover:bg-gray-50 transition-colors">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                </svg>
                Karyawan
            </a>

            <a href="{{ route('hrd.absensi') }}" class="flex items-center px-6 py-3 text-gray-700 bg-blue-50 border-r-4 border-blue-600">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
                Absensi
            </a>

            <a href="#" class="flex items-center px-6 py-3 text-gray-600 hover:bg-gray-50 transition-colors">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                </svg>
                Cuti & Izin
            </a>

            <a href="#" class="flex items-center px-6 py-3 text-gray-600 hover:bg-gray-50 transition-colors">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                Penggajian
            </a>

            <a href="#" class="flex items-center px-6 py-3 text-gray-600 hover:bg-gray-50 transition-colors">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                </svg>
                Rekrutmen
            </a>

            <a href="#" class="flex items-center px-6 py-3 text-gray-600 hover:bg-gray-50 transition-colors">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                Laporan
            </a>
        </nav>

        <div class="p-6 border-t">
            <div class="flex items-center">
                <div class="w-10 h-10 bg-blue-600 rounded-full flex items-center justify-center text-white font-semibold">
                    AD
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-gray-700">Admin HRD</p>
                    <p class="text-xs text-gray-500">admin@erp.com</p>
                </div>
            </div>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 overflow-y-auto">
        <!-- Header -->
        <header class="bg-white shadow-sm">
            <div class="flex items-center justify-between px-8 py-4">
                <div>
                    <h2 class="text-2xl font-bold text-gray-800">Data Absensi</h2>
                    <p class="text-sm text-gray-500 mt-1">Kelola dan monitor kehadiran karyawan</p>
                </div>

                <div class="flex items-center space-x-4">
                    <button class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        Input Absensi Manual
                    </button>

                    <button class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        Export Excel
                    </button>
                </div>
            </div>
        </header>

        <!-- Content -->
        <div class="p-8">
            <!-- Filter Section -->
            <div class="bg-white rounded-xl shadow-sm p-6 mb-6 border border-gray-100">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Filter Data</h3>
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal</label>
                        <input type="date" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" value="{{ date('Y-m-d') }}">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Departemen</label>
                        <select class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option>Semua Departemen</option>
                            <option>IT & Development</option>
                            <option>Marketing</option>
                            <option>Finance</option>
                            <option>Operations</option>
                            <option>HR & Admin</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                        <select class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option>Semua Status</option>
                            <option>Hadir</option>
                            <option>Terlambat</option>
                            <option>Izin</option>
                            <option>Sakit</option>
                            <option>Alpha</option>
                        </select>
                    </div>

                    <div class="flex items-end">
                        <button class="w-full px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                            Terapkan Filter
                        </button>
                    </div>
                </div>
            </div>

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-5 gap-4 mb-6">
                <div class="bg-white rounded-xl shadow-sm p-4 border border-gray-100">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs font-medium text-gray-500">Total Karyawan</p>
                            <h3 class="text-2xl font-bold text-gray-800 mt-1">248</h3>
                        </div>
                        <div class="w-12 h-12 bg-gray-100 rounded-full flex items-center justify-center">
                            <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-sm p-4 border border-gray-100">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs font-medium text-gray-500">Hadir</p>
                            <h3 class="text-2xl font-bold text-green-600 mt-1">235</h3>
                        </div>
                        <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-sm p-4 border border-gray-100">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs font-medium text-gray-500">Terlambat</p>
                            <h3 class="text-2xl font-bold text-orange-600 mt-1">8</h3>
                        </div>
                        <div class="w-12 h-12 bg-orange-100 rounded-full flex items-center justify-center">
                            <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-sm p-4 border border-gray-100">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs font-medium text-gray-500">Izin/Sakit</p>
                            <h3 class="text-2xl font-bold text-blue-600 mt-1">3</h3>
                        </div>
                        <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-sm p-4 border border-gray-100">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs font-medium text-gray-500">Alpha</p>
                            <h3 class="text-2xl font-bold text-red-600 mt-1">2</h3>
                        </div>
                        <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center">
                            <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Table -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50 border-b border-gray-200">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">No</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Nama Karyawan</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">NIK</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Departemen</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Check In</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Check Out</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @php
                            $data = [
                                ['nama' => 'Ahmad Fauzi', 'nik' => 'EMP001', 'dept' => 'IT & Development', 'in' => '08:00', 'out' => '17:05', 'status' => 'Hadir'],
                                ['nama' => 'Siti Aminah', 'nik' => 'EMP002', 'dept' => 'Marketing', 'in' => '08:15', 'out' => '17:10', 'status' => 'Terlambat'],
                                ['nama' => 'Budi Santoso', 'nik' => 'EMP003', 'dept' => 'Finance', 'in' => '07:55', 'out' => '17:00', 'status' => 'Hadir'],
                                ['nama' => 'Dewi Kartika', 'nik' => 'EMP004', 'dept' => 'HR & Admin', 'in' => '-', 'out' => '-', 'status' => 'Izin'],
                                ['nama' => 'Eko Prasetyo', 'nik' => 'EMP005', 'dept' => 'Operations', 'in' => '08:05', 'out' => '17:15', 'status' => 'Hadir'],
                                ['nama' => 'Linda Susanti', 'nik' => 'EMP006', 'dept' => 'Customer Service', 'in' => '08:20', 'out' => '17:00', 'status' => 'Terlambat'],
                                ['nama' => 'Rudi Pratama', 'nik' => 'EMP007', 'dept' => 'IT & Development', 'in' => '07:50', 'out' => '17:20', 'status' => 'Hadir'],
                                ['nama' => 'Maya Sari', 'nik' => 'EMP008', 'dept' => 'Marketing', 'in' => '-', 'out' => '-', 'status' => 'Sakit'],
                                ['nama' => 'Agus Wijaya', 'nik' => 'EMP009', 'dept' => 'Finance', 'in' => '08:00', 'out' => '17:05', 'status' => 'Hadir'],
                                ['nama' => 'Rina Wati', 'nik' => 'EMP010', 'dept' => 'Operations', 'in' => '-', 'out' => '-', 'status' => 'Alpha'],
                            ];
                            @endphp

                            @foreach($data as $index => $item)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 text-sm text-gray-700">{{ $index + 1 }}</td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        <div class="w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center text-white text-xs font-semibold">
                                            {{ substr($item['nama'], 0, 2) }}
                                        </div>
                                        <span class="ml-3 text-sm font-medium text-gray-800">{{ $item['nama'] }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-700">{{ $item['nik'] }}</td>
                                <td class="px-6 py-4 text-sm text-gray-700">{{ $item['dept'] }}</td>
                                <td class="px-6 py-4 text-sm text-gray-700">{{ $item['in'] }}</td>
                                <td class="px-6 py-4 text-sm text-gray-700">{{ $item['out'] }}</td>
                                <td class="px-6 py-4">
                                    @if($item['status'] == 'Hadir')
                                        <span class="px-3 py-1 text-xs font-semibold text-green-700 bg-green-100 rounded-full">Hadir</span>
                                    @elseif($item['status'] == 'Terlambat')
                                        <span class="px-3 py-1 text-xs font-semibold text-orange-700 bg-orange-100 rounded-full">Terlambat</span>
                                    @elseif($item['status'] == 'Izin')
                                        <span class="px-3 py-1 text-xs font-semibold text-blue-700 bg-blue-100 rounded-full">Izin</span>
                                    @elseif($item['status'] == 'Sakit')
                                        <span class="px-3 py-1 text-xs font-semibold text-purple-700 bg-purple-100 rounded-full">Sakit</span>
                                    @else
                                        <span class="px-3 py-1 text-xs font-semibold text-red-700 bg-red-100 rounded-full">Alpha</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <button class="text-blue-600 hover:text-blue-800 mr-3">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        </svg>
                                    </button>
                                    <button class="text-green-600 hover:text-green-800">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="bg-gray-50 px-6 py-4 flex items-center justify-between border-t border-gray-200">
                    <div class="text-sm text-gray-600">
                        Menampilkan <span class="font-semibold">1-10</span> dari <span class="font-semibold">248</span> data
                    </div>
                    <div class="flex space-x-2">
                        <button class="px-3 py-1 border border-gray-300 rounded-lg text-sm text-gray-600 hover:bg-gray-100 transition-colors">
                            Previous
                        </button>
                        <button class="px-3 py-1 bg-blue-600 text-white rounded-lg text-sm">1</button>
                        <button class="px-3 py-1 border border-gray-300 rounded-lg text-sm text-gray-600 hover:bg-gray-100 transition-colors">2</button>
                        <button class="px-3 py-1 border border-gray-300 rounded-lg text-sm text-gray-600 hover:bg-gray-100 transition-colors">3</button>
                        <button class="px-3 py-1 border border-gray-300 rounded-lg text-sm text-gray-600 hover:bg-gray-100 transition-colors">
                            Next
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>
@endsection
