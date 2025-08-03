<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HRMS</title>
    <!-- Load Tailwind CSS dari CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Load Alpine.js untuk fungsionalitas dropdown -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.10.3/dist/cdn.min.js"></script>
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f7fafc;
        }
    </style>
</head>
<body class="flex min-h-screen">

    <!-- Sidebar -->
    <aside class="w-64 bg-slate-900 text-white shadow-lg flex-shrink-0 z-50">
        <div class="p-6 border-b border-gray-700">
            <h1 class="text-2xl font-bold tracking-tight"><center>HRMS</center></h1>
        </div>
        <nav class="flex-grow p-4 space-y-2">
            <!-- Dashboard -->
            <a href="{{ route('dashboard') }}" class="flex items-center p-3 rounded-lg transition duration-200 ease-in-out
                {{ request()->routeIs('dashboard') ? 'bg-slate-700 text-white' : 'text-gray-300 hover:bg-slate-700 hover:text-white' }}">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m0 0l-7 7m0-7v10a1 1 0 01-1 1h-3"></path>
                </svg>
                Dashboard
            </a> 

            <!-- Dropdown untuk Manajemen Karyawan -->
            <div x-data="{ open: request()->routeIs('employees.*', 'departments.*', 'users.*') }" class="relative">
                @can('manage-employees')
                <button @click="open = !open" class="w-full flex items-center justify-between p-3 rounded-lg text-gray-300 hover:bg-slate-700 hover:text-white transition duration-200 ease-in-out">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.5v15m7.5-7.5h-15M12 4.5c2.761 0 5 2.239 5 5s-2.239 5-5 5-5-2.239-5-5 2.239-5 5-5z"></path>
                        </svg>
                        Manajemen Karyawan
                    </div>
                    <svg :class="{'transform rotate-180': open, 'transform rotate-0': !open}" class="w-4 h-4 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
                <div x-show="open" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95" class="ml-4 mt-2 space-y-1">
                    <a href="{{ route('employees.index') }}" class="block p-2 rounded-lg text-sm transition duration-200 ease-in-out
                        {{ request()->routeIs('employees.*') ? 'bg-slate-800 text-white' : 'text-gray-400 hover:bg-slate-800 hover:text-white' }}">
                        Daftar Karyawan
                    </a>
                    <a href="{{ route('departments.index') }}" class="block p-2 rounded-lg text-sm transition duration-200 ease-in-out
                        {{ request()->routeIs('departments.*') ? 'bg-slate-800 text-white' : 'text-gray-400 hover:bg-slate-800 hover:text-white' }}">
                        Departemen
                    </a>
                    <a href="{{ route('users.index') }}" class="block p-2 rounded-lg text-sm transition duration-200 ease-in-out
                        {{ request()->routeIs('users.*') ? 'bg-slate-800 text-white' : 'text-gray-400 hover:bg-slate-800 hover:text-white' }}">
                        Users
                    </a>
                </div>
                @endcan
            </div>

            <!-- Manajemen Penggajian -->
            @can('manage-payrolls')
            <a href="{{ route('payrolls.index') }}" class="flex items-center p-3 rounded-lg transition duration-200 ease-in-out
                {{ request()->routeIs('payrolls.index') ? 'bg-slate-700 text-white' : 'text-gray-300 hover:bg-slate-700 hover:text-white' }}">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c1.657 0 3 1.343 3 3s-1.343 3-3 3-3-1.343-3-3 1.343-3 3-3z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14v4"></path>
                </svg>
                Manajemen Penggajian
            </a>
            @endcan

            <!-- Manajemen Cuti -->
            @can('manage-leave-requests')
            <a href="{{ route('leave_requests.index') }}" class="flex items-center p-3 rounded-lg transition duration-200 ease-in-out
                {{ request()->routeIs('leave_requests.index') ? 'bg-slate-700 text-white' : 'text-gray-300 hover:bg-slate-700 hover:text-white' }}">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
                Manajemen Cuti
            </a>
            @endcan

            <!-- Penilaian Kinerja -->
            
            @can('view-my-appraisals')
            <a href="{{ route('performance_appraisals.my-appraisals') }}" class="flex items-center p-3 rounded-lg transition duration-200 ease-in-out
                {{ request()->routeIs('performance_appraisals.my-appraisals') ? 'bg-slate-700 text-white' : 'text-gray-300 hover:bg-slate-700 hover:text-white' }}">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0h6"></path>
                </svg>
                Penilaian Kinerja
            </a>
            @endcan
            
            
            {{-- @if(Auth::user()->employee)
                <!-- Profil Saya -->
                <a href="{{ route('my-profile.show') }}" class="flex items-center p-3 rounded-lg transition duration-200 ease-in-out
                    {{ request()->routeIs('my-profile.show') ? 'bg-slate-700 text-white' : 'text-gray-300 hover:bg-slate-700 hover:text-white' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                    Profil Saya
                </a>
            @endif --}}

            <!-- Kehadiran -->
            <a href="{{ route('attendances.index') }}" class="flex items-center p-3 rounded-lg transition duration-200 ease-in-out
                {{ request()->routeIs('attendances.index') ? 'bg-slate-700 text-white' : 'text-gray-300 hover:bg-slate-700 hover:text-white' }}">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 12v6m0 0l-3-3m3 3l3-3"></path>
                </svg>
                Kehadiran
            </a>

            @can('submit-leave-request')
            <!-- Cuti Saya -->
            <a href="{{ route('leave_requests.my-requests') }}" class="flex items-center p-3 rounded-lg transition duration-200 ease-in-out
                {{ request()->routeIs('leave_requests.my-requests') ? 'bg-slate-700 text-white' : 'text-gray-300 hover:bg-slate-700 hover:text-white' }}">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                Cuti Saya
            </a>
            @endcan
            
            @can('view-my-payrolls')
            <!-- Slip Gaji -->
            <a href="{{ route('payrolls.my-payrolls') }}" class="flex items-center p-3 rounded-lg transition duration-200 ease-in-out
                {{ request()->routeIs('payrolls.my-payrolls') ? 'bg-slate-700 text-white' : 'text-gray-300 hover:bg-slate-700 hover:text-white' }}">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                Slip Gaji
            </a>
            @endcan
            
            <!-- Profil -->
            {{-- <a href="{{ route('profile.edit') }}" class="flex items-center p-3 rounded-lg transition duration-200 ease-in-out
                {{ request()->routeIs('profile.edit') ? 'bg-slate-700 text-white' : 'text-gray-300 hover:bg-slate-700 hover:text-white' }}">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37a1.724 1.724 0 002.572-1.065z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                </svg>
                Profil
            </a> --}}
            @if(Auth::user()->employee)
                <!-- Profil Saya -->
                <a href="{{ route('my-profile.show') }}" class="flex items-center p-3 rounded-lg transition duration-200 ease-in-out
                    {{ request()->routeIs('my-profile.show') ? 'bg-slate-700 text-white' : 'text-gray-300 hover:bg-slate-700 hover:text-white' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                    Profil Saya
                </a>
            @endif
            
            <!-- Logout Form -->
            <form method="POST" action="{{ route('logout') }}" class="block">
                @csrf
                <button type="submit" class="w-full flex items-center p-3 rounded-lg text-gray-300 hover:bg-red-600 hover:text-white transition duration-200 ease-in-out">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                    </svg>
                    Log Out
                </button>
            </form>
        </nav>
    </aside>

    <!-- Main Content Area -->
    <div class="flex-grow flex flex-col">
        <!-- Top Navbar (opsional) -->
        <header class="bg-white shadow-sm p-4">
            <div class="container mx-auto flex justify-between items-center">
                <h2 class="text-xl font-semibold text-gray-800">
                    {{-- Judul Halaman dari Slot Header --}}
                    {{ $header ?? '' }}
                </h2>
                <!-- User info -->
                <div class="relative">
                    <span class="text-gray-700 font-medium">{{ Auth::user()->name }}</span>
                    <!-- User Icon -->
                    <svg class="w-6 h-6 text-gray-400 inline-block" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A7.96 7.96 0 0112 15c2.203 0 4.225.864 5.76 2.296A8 8 0 105.12 17.804z"></path>
                    </svg>
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <main class="flex-grow p-8">
            <!-- Slot untuk konten halaman -->
            {{ $slot }}
        </main>
    </div>
</body>
</html>
