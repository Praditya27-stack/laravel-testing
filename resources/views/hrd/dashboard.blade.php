@extends('layouts.app')

@section('title', 'HRD Dashboard - ERP System')

@push('styles')
<style>
    .sidebar-link {
        transition: all 0.3s ease;
    }
    .sidebar-link:hover {
        background-color: #f9fafb;
    }
</style>
@endpush

@section('content')
<div class="flex h-screen bg-gray-50">
    <!-- Sidebar -->
    <aside class="w-64 bg-white shadow-lg flex flex-col">
        <div class="p-6">
            <h1 class="text-2xl font-bold text-gray-800">ERP System</h1>
            <p class="text-sm text-gray-500 mt-1">Human Resources</p>
        </div>
        
        <nav class="mt-6 flex-1">
            <a href="#" class="flex items-center px-6 py-3 text-gray-700 bg-blue-50 border-r-4 border-blue-600">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                </svg>
                Dashboard
            </a>
            
            <a href="#" class="sidebar-link flex items-center px-6 py-3 text-gray-600">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                </svg>
                Karyawan
            </a>
            
            <a href="{{ route('hrd.absensi') }}" class="sidebar-link flex items-center px-6 py-3 text-gray-600">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
                Absensi
            </a>
            
            <a href="#" class="sidebar-link flex items-center px-6 py-3 text-gray-600">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                </svg>
                Cuti & Izin
            </a>
            
            <a href="#" class="sidebar-link flex items-center px-6 py-3 text-gray-600">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                Penggajian
            </a>
            
            <a href="#" class="sidebar-link flex items-center px-6 py-3 text-gray-600">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                </svg>
                Rekrutmen
            </a>
            
            <a href="#" class="sidebar-link flex items-center px-6 py-3 text-gray-600">
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
                    <h2 class="text-2xl font-bold text-gray-800">Dashboard HRD</h2>
                    <p class="text-sm text-gray-500 mt-1">Selamat datang di sistem manajemen SDM</p>
                </div>
                
                <div class="flex items-center space-x-4">
                    <button class="relative p-2 text-gray-600 hover:bg-gray-100 rounded-lg">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                        </svg>
                        <span class="absolute top-1 right-1 w-2 h-2 bg-red-500 rounded-full"></span>
                    </button>
                    
                    <div class="text-right">
                        <p class="text-sm font-medium text-gray-700">{{ date('l, d F Y') }}</p>
                        <p class="text-xs text-gray-500" id="current-time"></p>
                    </div>
                </div>
            </div>
        </header>
        
        <!-- Dashboard Content -->
        <div class="p-8">
            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <!-- Total Karyawan -->
                <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 hover:shadow-md transition-shadow">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Total Karyawan</p>
                            <h3 class="text-3xl font-bold text-gray-800 mt-2">248</h3>
                            <p class="text-xs text-green-600 mt-2 flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 9.707a1 1 0 010-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 01-1.414 1.414L11 7.414V15a1 1 0 11-2 0V7.414L6.707 9.707a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                                </svg>
                                +12 bulan ini
                            </p>
                        </div>
                        <div class="w-14 h-14 bg-blue-100 rounded-full flex items-center justify-center">
                            <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                        </div>
                    </div>
                </div>
                
                <!-- Hadir Hari Ini -->
                <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 hover:shadow-md transition-shadow">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Hadir Hari Ini</p>
                            <h3 class="text-3xl font-bold text-gray-800 mt-2">235</h3>
                            <p class="text-xs text-gray-600 mt-2">
                                94.8% dari total karyawan
                            </p>
                        </div>
                        <div class="w-14 h-14 bg-green-100 rounded-full flex items-center justify-center">
                            <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                </div>
                
                <!-- Cuti Pending -->
                <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 hover:shadow-md transition-shadow">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Pengajuan Cuti</p>
                            <h3 class="text-3xl font-bold text-gray-800 mt-2">8</h3>
                            <p class="text-xs text-orange-600 mt-2">
                                Menunggu persetujuan
                            </p>
                        </div>
                        <div class="w-14 h-14 bg-orange-100 rounded-full flex items-center justify-center">
                            <svg class="w-8 h-8 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                </div>
                
                <!-- Rekrutmen Aktif -->
                <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 hover:shadow-md transition-shadow">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Rekrutmen Aktif</p>
                            <h3 class="text-3xl font-bold text-gray-800 mt-2">5</h3>
                            <p class="text-xs text-purple-600 mt-2">
                                42 pelamar baru
                            </p>
                        </div>
                        <div class="w-14 h-14 bg-purple-100 rounded-full flex items-center justify-center">
                            <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Charts and Tables Row -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
                <!-- Absensi Chart -->
                <div class="lg:col-span-2 bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-lg font-semibold text-gray-800">Statistik Absensi Mingguan</h3>
                        <select class="text-sm border border-gray-300 rounded-lg px-3 py-1.5 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option>Minggu Ini</option>
                            <option>Minggu Lalu</option>
                            <option>Bulan Ini</option>
                        </select>
                    </div>
                    
                    <div class="h-64">
                        <canvas id="attendanceChart"></canvas>
                    </div>
                </div>
                
                <!-- Department Distribution -->
                <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                    <h3 class="text-lg font-semibold text-gray-800 mb-6">Distribusi Departemen</h3>
                    
                    <div class="space-y-4">
                        <div>
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-sm font-medium text-gray-700">IT & Development</span>
                                <span class="text-sm font-semibold text-gray-800">45</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="bg-blue-600 h-2 rounded-full" style="width: 45%"></div>
                            </div>
                        </div>
                        
                        <div>
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-sm font-medium text-gray-700">Marketing</span>
                                <span class="text-sm font-semibold text-gray-800">38</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="bg-green-600 h-2 rounded-full" style="width: 38%"></div>
                            </div>
                        </div>
                        
                        <div>
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-sm font-medium text-gray-700">Finance</span>
                                <span class="text-sm font-semibold text-gray-800">32</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="bg-purple-600 h-2 rounded-full" style="width: 32%"></div>
                            </div>
                        </div>
                        
                        <div>
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-sm font-medium text-gray-700">Operations</span>
                                <span class="text-sm font-semibold text-gray-800">58</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="bg-orange-600 h-2 rounded-full" style="width: 58%"></div>
                            </div>
                        </div>
                        
                        <div>
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-sm font-medium text-gray-700">HR & Admin</span>
                                <span class="text-sm font-semibold text-gray-800">28</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="bg-pink-600 h-2 rounded-full" style="width: 28%"></div>
                            </div>
                        </div>
                        
                        <div>
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-sm font-medium text-gray-700">Customer Service</span>
                                <span class="text-sm font-semibold text-gray-800">47</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="bg-indigo-600 h-2 rounded-full" style="width: 47%"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Recent Activities and Pending Requests -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Pengajuan Cuti Terbaru -->
                <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-lg font-semibold text-gray-800">Pengajuan Cuti Terbaru</h3>
                        <a href="#" class="text-sm text-blue-600 hover:text-blue-700 font-medium">Lihat Semua</a>
                    </div>
                    
                    <div class="space-y-4">
                        @for($i = 0; $i < 4; $i++)
                        <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-blue-500 rounded-full flex items-center justify-center text-white font-semibold">
                                    {{ ['BW', 'SA', 'RP', 'DK'][$i] }}
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-gray-800">{{ ['Budi Wijaya', 'Siti Aminah', 'Rudi Pratama', 'Dewi Kartika'][$i] }}</p>
                                    <p class="text-xs text-gray-500">{{ ['Cuti Tahunan - 3 hari', 'Cuti Sakit - 2 hari', 'Izin Keluarga - 1 hari', 'Cuti Tahunan - 5 hari'][$i] }}</p>
                                </div>
                            </div>
                            <div class="flex items-center space-x-2">
                                <button class="px-3 py-1 bg-green-100 text-green-700 text-xs font-medium rounded-lg hover:bg-green-200">
                                    Setuju
                                </button>
                                <button class="px-3 py-1 bg-red-100 text-red-700 text-xs font-medium rounded-lg hover:bg-red-200">
                                    Tolak
                                </button>
                            </div>
                        </div>
                        @endfor
                    </div>
                </div>
                
                <!-- Aktivitas Terbaru -->
                <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-lg font-semibold text-gray-800">Aktivitas Terbaru</h3>
                        <a href="#" class="text-sm text-blue-600 hover:text-blue-700 font-medium">Lihat Semua</a>
                    </div>
                    
                    <div class="space-y-4">
                        <div class="flex items-start">
                            <div class="w-2 h-2 bg-green-500 rounded-full mt-2 mr-3"></div>
                            <div class="flex-1">
                                <p class="text-sm text-gray-800">
                                    <span class="font-medium">Ahmad Fauzi</span> telah check-in
                                </p>
                                <p class="text-xs text-gray-500 mt-1">2 menit yang lalu</p>
                            </div>
                        </div>
                        
                        <div class="flex items-start">
                            <div class="w-2 h-2 bg-blue-500 rounded-full mt-2 mr-3"></div>
                            <div class="flex-1">
                                <p class="text-sm text-gray-800">
                                    Karyawan baru <span class="font-medium">Linda Susanti</span> ditambahkan
                                </p>
                                <p class="text-xs text-gray-500 mt-1">15 menit yang lalu</p>
                            </div>
                        </div>
                        
                        <div class="flex items-start">
                            <div class="w-2 h-2 bg-orange-500 rounded-full mt-2 mr-3"></div>
                            <div class="flex-1">
                                <p class="text-sm text-gray-800">
                                    Pengajuan cuti <span class="font-medium">Eko Prasetyo</span> disetujui
                                </p>
                                <p class="text-xs text-gray-500 mt-1">1 jam yang lalu</p>
                            </div>
                        </div>
                        
                        <div class="flex items-start">
                            <div class="w-2 h-2 bg-purple-500 rounded-full mt-2 mr-3"></div>
                            <div class="flex-1">
                                <p class="text-sm text-gray-800">
                                    Lowongan <span class="font-medium">Senior Developer</span> dipublikasikan
                                </p>
                                <p class="text-xs text-gray-500 mt-1">2 jam yang lalu</p>
                            </div>
                        </div>
                        
                        <div class="flex items-start">
                            <div class="w-2 h-2 bg-red-500 rounded-full mt-2 mr-3"></div>
                            <div class="flex-1">
                                <p class="text-sm text-gray-800">
                                    <span class="font-medium">Maya Sari</span> terlambat check-in
                                </p>
                                <p class="text-xs text-gray-500 mt-1">3 jam yang lalu</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Update current time
    function updateTime() {
        const now = new Date();
        const timeString = now.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit', second: '2-digit' });
        document.getElementById('current-time').textContent = timeString;
    }
    updateTime();
    setInterval(updateTime, 1000);
    
    // Attendance Chart
    const ctx = document.getElementById('attendanceChart').getContext('2d');
    const attendanceChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'],
            datasets: [{
                label: 'Hadir',
                data: [235, 242, 238, 245, 240, 180, 0],
                borderColor: 'rgb(59, 130, 246)',
                backgroundColor: 'rgba(59, 130, 246, 0.1)',
                tension: 0.4,
                fill: true
            }, {
                label: 'Terlambat',
                data: [8, 5, 7, 3, 6, 4, 0],
                borderColor: 'rgb(251, 146, 60)',
                backgroundColor: 'rgba(251, 146, 60, 0.1)',
                tension: 0.4,
                fill: true
            }, {
                label: 'Izin/Sakit',
                data: [5, 1, 3, 0, 2, 1, 0],
                borderColor: 'rgb(168, 85, 247)',
                backgroundColor: 'rgba(168, 85, 247, 0.1)',
                tension: 0.4,
                fill: true
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                },
                tooltip: {
                    mode: 'index',
                    intersect: false,
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 50
                    }
                }
            }
        }
    });
</script>
@endpush
