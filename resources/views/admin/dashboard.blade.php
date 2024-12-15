<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>

    {{-- Fontawosome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css"
        integrity="sha512-5Hs3dF2AEPkpNAR7UiOHba+lRSJNeM2ECkwxUIxC1Q/FLycGTbNapWXB4tP889k5T5Ju8fs4b1P5z/iB4nMfSQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/js/all.min.js"
        integrity="sha512-1JkMy1LR9bTo3psH+H4SV5bO2dFylgOy+UJhMus1zF4VEFuZVu5lsi4I6iIndE4N9p01z1554ZDcvMSjMaqCBQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    {{-- Vite Development --}}
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
</head>

<body class="bg-gray-100  min-h-screen flex">
    <!-- Sidebar -->
    <div id="sidebar" class="w-64 bg-white shadow-md border-r border-gray-200 transition-all duration-300 ease-in-out">
        <div id="divTitle"
            class="flex flex-row items-center justify-between h-16 bg-[#226597] shadow-lg text-white px-4">
            <h1 id="logoDashboard" class="text-2xl font-bold">Admin</h1>
            <button id="sidebarToggle" class="lg:hidden">
                <i class="fas fa-bars text-xl"></i>
            </button>
        </div>
        <ul class="mt-6">
            <li class="px-6 py-3 border-r-4 border-[#226597]">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center">
                    <div class="flex justify-center items-center w-4 h-4">
                        <i class="fas fa-tachometer-alt"></i>
                    </div>
                    <span class="mx-4 font-medium sidebar-text ms-2">Dashboard</span>
                </a>
            </li>
            <li class="px-6 py-3">
                <a href="{{route('admin.users.index')}}" class="flex items-center">
                    <div class="flex justify-center items-center w-4 h-4">
                        <i class="fas fa-users"></i>
                    </div>
                    <span class="mx-4 font-medium sidebar-text ms-2">Users</span>
                </a>
            </li>
            <li class="px-6 py-3">
                <a href="{{route('admin.scholarship.index')}}" class="flex items-center">
                    <div class="flex justify-center items-center w-4 h-4">
                        <i class="fa-solid fa-graduation-cap"></i>
                    </div>
                    <span class="mx-4 font-medium sidebar-text ms-2">Beasiswa</span>
                </a>
            </li>
            <li class="px-6 py-3">
                <a href="{{route('logout')}}" class="flex items-center">
                    <div class="flex justify-center items-center w-4 h-4">
                        <i class="fa-solid fa-right-from-bracket"></i>
                    </div>
                    <span class="mx-4 font-medium sidebar-text ms-2">Logout</span>
                </a>
            </li>
        </ul>
    </div>

    <!-- Content -->
    <div class="flex-1 p-12">
        <h1 class="text-2xl font-bold">Dashboard</h1>
        <div class="mt-6">
            <div class="flex flex-wrap justify-between space-y-4">
                <div class="w-full">
                    <div class="bg-white p-6 rounded-lg shadow-lg border">
                        <div class="flex items-center justify-between">
                            <div>
                                <h1 class="text-2xl font-bold">{{$userCount}}</h1>
                                <p class="text-gray-600">Users</p>
                            </div>
                            <i class="fas fa-users fa-2x"></i>
                        </div>
                    </div>
                </div>
                <div class="w-full">
                    <div class="bg-white p-6 rounded-lg shadow-lg border">
                        <div class="flex items-center justify-between">
                            <div>
                                <h1 class="text-2xl font-bold">{{$beasiswaCount}}</h1>
                                <p class="text-gray-600">Berita Beasiswa</p>
                            </div>
                            <i class="fas fa-clipboard-list fa-2x"></i>
                        </div>
                    </div>
                </div>
                <div class="w-full">
                    <div class="bg-white p-6 rounded-lg shadow-lg border">
                        <div class="flex items-center justify-between">
                            <div>
                                <h1 class="text-2xl font-bold">{{$pendaftarBeasiswaCount}}</h1>
                                <p class="text-gray-600">Pendaftar Beasiswa</p>
                            </div>
                            <i class="fa-solid fa-address-card fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- AlpineJS -->
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>

    {{-- Toggle sidebar --}}
    <script>
        const sidebar = document.getElementById('sidebar');
        const sidebarToggle = document.getElementById('sidebarToggle');
        const sidebarTexts = document.querySelectorAll('.sidebar-text');
        const sidebarTitle =  document.getElementById('logoDashboard');
        const divTitle = document.getElementById('divTitle');

        sidebarToggle.addEventListener('click', () => {
            if (sidebar.classList.contains('w-64')) {
                sidebar.classList.remove('w-64');
                sidebar.classList.add('w-20');
                sidebarTitle.classList.add('hidden');
                divTitle.classList.remove('justify-between');
                divTitle.classList.add('justify-center');
                sidebarTexts.forEach(text => text.classList.add('hidden'));
            } else {
                sidebar.classList.remove('w-20');
                sidebar.classList.add('w-64');
                sidebarTitle.classList.remove('hidden');
                divTitle.classList.remove('justify-center');
                divTitle.classList.add('justify-between');
                sidebarTexts.forEach(text => text.classList.remove('hidden'));
            }
        });
    </script>
</body>

</html>
