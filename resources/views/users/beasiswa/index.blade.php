<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Pengumuman</title>
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

<body class="antiliased">
    <div class="max-w-lg mx-auto h-full min-h-screen border shadow-lg">
        {{-- Header --}}
        <div class="w-full bg-[#226597] z-0 rounded-b-[40px] p-6">
            <div class="flex flex-row justify-between items-center">
                <div class="relative">
                    <div class="flex items-center space-x-2">
                        <button id="profile" onclick="toggleDropdown()"
                            class="flex items-center justify-center w-8 h-8 bg-white rounded-full hover:cursor-pointer">
                            <i class="fa-solid fa-user"></i>
                        </button>
                        <p class="text-white font-medium bold">Halo, {{auth()->user()->first_name}}</p>
                    </div>
                    <!-- Dropdown menu -->
                    <div id="profileDropdown"
                        class="hidden absolute left-0 mt-2 w-48 bg-white border rounded-lg shadow-lg z-50">
                        <div class="py-1">
                            <a href="{{route('profile')}}"
                                class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Profile</a>
                            <a href="{{route('logout')}}"
                                class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Logout</a>
                        </div>
                    </div>
                </div>
                <a href="{{route('announcement.index')}}" class="relative inline-block">
                    <i class="fa-solid fa-envelope fa-xl p-1 text-white"></i>
                    @if($notificationCount>0)
                    <div class="absolute top-0 right-0 w-1.5 h-1.5 bg-red-500 rounded-full"></div>
                    @endif
                </a>
            </div>
            <form method="get" action="{{route('dashboard')}}" class="mt-4">
                <label for="default-search"
                    class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-white">Search</label>
                <div class="relative w-full">
                    <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                        <svg class="w-4 h-4 text-[#226597]" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                            fill="none" viewBox="0 0 20 20">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                        </svg>
                    </div>
                    <input type="search" id="default-search" name="search"
                        class="block w-full p-2 ps-10 text-sm text-gray-900 border border-gray-300 rounded-full focus:ring-blue-500 focus:border-blue-500 placeholder:text-[#226597] placeholder:font-medium"
                        placeholder="Cari Beasiswa..." required />
                </div>
            </form>
        </div>

        {{-- Konten Beasiswa --}}
        <div class="space-y-6 p-6">
            <a href="{{route('dashboard')}}" class="text-xs underline text-blue-500">Kembali ke halaman utama</a>
            <p class="text-xl font-bold">{{$beasiswa->nama}}</p>
            <img src="{{asset('img/beasiswa/'.$beasiswa->banner)}}" alt="banner beasiswa" class="border rounded-lg">
            <div class="p-2 border bg-[#F5F5F5] text-sm">
                <p class="font-bold">Persyaratan yang diperlukan</p>
                {{-- Persyaratan --}}
                {!! $beasiswa->deskripsi !!}
            </div>
            {{-- session error --}}
            @if(session('error'))
            <div class="p-2 border bg-red-100 text-red-700 rounded-lg">
                {{session('error')}}
            </div>
            @endif
            {{-- session success --}}
            @if(session('success'))
            <div class="p-2 border bg-green-100 text-green-700 rounded-lg">
                {{session('success')}}
            </div>
            @endif

            @if(auth()->user()->ipk >= $beasiswa->min_ipk)
            <div class="p-4 w-full text-center">
                <a href="{{route('scholarship.apply',$beasiswa->id)}}"
                    class="p-4 text-white bg-gray-500 rounded-full font-bold">DAFTAR
                    BEASISWA</a>
            </div>
            @else
            <div class="p-4 w-full text-center">
                <span class="text-red-500">Tidak memenuhi persyaratan minimal IPK</span>
            </div>
            @endif
        </div>



        {{-- Scripts --}}
        <script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.js"></script>
        <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.js"></script>
        <script>
            function toggleDropdown() {
                const dropdown = document.getElementById('profileDropdown');
                dropdown.classList.toggle('hidden');

                // Close dropdown when clicking outside
                document.addEventListener('click', function(event) {
                    const isClickInside = document.getElementById('profileButton').contains(event.target);
                    const dropdownMenu = document.getElementById('profileDropdown');

                    if (!isClickInside && !dropdownMenu.classList.contains('hidden')) {
                        dropdownMenu.classList.add('hidden');
                    }
                });
            }
        </script>
</body>

</html>
