<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Dashboard</title>
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
    <div class="relative max-w-lg mx-auto h-full min-h-screen border shadow-lg">
        <div class="absolute top-0 left-0 w-full h-[200px] bg-[#226597] z-0 rounded-b-[40px]"></div>
        <div class="relative z-10 flex flex-col p-6">
            {{-- Header --}}
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
                    @if($notificationCount > 0)
                    <div class="absolute top-0 right-0 w-1.5 h-1.5 bg-red-500 rounded-full"></div>
                    @endif
                </a>
            </div>
            {{-- search --}}
            <form method="get" action="{{route('dashboard')}}" class="mt-4" id="searchForm">
                @if($filter)
                <input type="hidden" name="tingkat_pendidikan" value="{{$filter}}">
                @endif
                <label for="default-search" class="mb-2 text-sm font-medium text-gray-900 sr-only">Search</label>
                <div class="relative w-full">
                    <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                        <svg class="w-4 h-4 text-[#226597]" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                            fill="none" viewBox="0 0 20 20">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                        </svg>
                    </div>
                    <input type="text" id="default-search" name="search" value="{{$search}}"
                        class="block w-full p-2 ps-10 text-sm text-gray-900 border border-gray-300 rounded-full focus:ring-blue-500 focus:border-blue-500 placeholder:text-[#226597] placeholder:font-medium"
                        placeholder="Cari Beasiswa..." />
                    @if($search)
                    <button type="button" onclick="clearSearch()"
                        class="absolute inset-y-0 end-0 flex items-center pe-3">
                        <i class="fas fa-times text-gray-400 hover:text-gray-600"></i>
                    </button>
                    @endif
                </div>
            </form>

            {{-- list nilai dari user --}}
            <div
                class="grid grid-cols-4 items-center justify-between py-4 mt-4 border border-gray-300 bg-[#113F67] rounded-xl divide-x-2">
                <div class="flex flex-col items-center justify-center text-white font-medium">
                    <p>{{auth()->user()->ipk}}</p>
                    <span>IPK</span>
                </div>
                <div class="flex flex-col items-center justify-center text-white font-medium">
                    <p>{{auth()->user()->min_ipk}}</p>
                    <span>MIN IPK</span>
                </div>
                <div class="flex flex-col items-center justify-center text-white font-medium">
                    <p>{{auth()->user()->max_ipk}}</p>
                    <span>MAX IPK</span>
                </div>
                <div class="flex flex-col items-center justify-center text-white font-medium">
                    <p>{{auth()->user()->toefl}}</p>
                    <span>TOEFL</span>
                </div>
            </div>

            {{-- List beasiswa --}}
            <div class="flex flex-col mt-4">
                <h3 class="text-xl font-semibold">Sedang Mencari Beasiswa ?</h3>
                <form action="{{ route('dashboard') }}" method="GET">
                    @if($search)
                    <input type="hidden" name="search" value="{{$search}}">
                    @endif
                    <select name="tingkat_pendidikan" onchange="this.form.submit()"
                        class="mt-2 max-w-[80px] bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full text-center">
                        <option value="" {{ $filter=='' ? 'selected' : '' }}>All</option>
                        <option value="S2" {{ $filter=='S2' ? 'selected' : '' }}>S2</option>
                        <option value="S1" {{ $filter=='S1' ? 'selected' : '' }}>S1</option>
                        <option value="D4" {{ $filter=='D4' ? 'selected' : '' }}>D4</option>
                        <option value="D3" {{ $filter=='D3' ? 'selected' : '' }}>D3</option>
                        <option value="SMA" {{ $filter=='SMA' ? 'selected' : '' }}>SMA</option>
                    </select>
                </form>

                {{-- Beasiswanya disini --}}
                <div class="flex flex-col space-y-4 mt-4">
                    @if($listBeasiswa->isEmpty())
                    <p class="text-center">Tidak ada beasiswa yang tersedia</p>
                    @else
                    @foreach($listBeasiswa as $beasiswa)
                    <a href="{{route('scholarship.show',$beasiswa->id)}}">
                        <p class="font-bold text-lg">{{$beasiswa->nama}}</p>
                        <img src="{{ asset('img/beasiswa/'.$beasiswa->thumbnail) }}" alt="{{$beasiswa->nama}}"
                            class="w-full h-64 rounded-xl shadow-lg object-cover">
                    </a>
                    @endforeach
                    @endif

                </div>
            </div>
        </div>
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
    <script>
        function clearSearch() {
            document.getElementById('default-search').value = '';
            document.getElementById('searchForm').submit();
        }
    </script>
</body>

</html>
