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

    {{-- CKEDITOR --}}
    <script src="https://cdn.ckeditor.com/ckeditor5/40.1.0/classic/ckeditor.js"></script>
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
                            <img src="{{asset('img/profile/'. auth()->user()->image)}}" alt="" class="rounded-full">
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
                <label for="default-search" class="mb-2 text-sm font-medium text-gray-900 sr-only">Search</label>
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

        <div class="p-6 space-y-6">
            <a href="{{route('dashboard')}}" class="text-xs underline text-blue-500">Kembali ke halaman utama</a>

            {{-- Error any() --}}
            @if ($errors->any())
            <div class="p-2 border bg-red-100 text-red-700 rounded-lg">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            {{-- Formulir Beasiswa --}}
            <form action="{{route('scholarship.apply.submit',$beasiswa->id)}}" method="POST"
                enctype="multipart/form-data" class="space-y-6">
                @csrf
                <div class="p-2 border bg-[#F5F5F5] space-y-4">
                    <p class="text-xl font-bold">Formulir Beasiswa</p>
                    {{-- File Transkrip --}}
                    <div>
                        <label class="block mb-2 font-bold text-gray-900" for="file_input">Transkrip Nilai</label>
                        <input accept=".pdf,.jpg,.jpeg,.png"
                            class="block w-full text-sm text-gray-900 border @error('transkrip_file') border-red-500 @enderror rounded-lg cursor-pointer bg-gray-50"
                            id="file_input" name="transkrip_file" type="file">
                        @error('transkrip_file')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    {{-- Biodata --}}
                    <div>
                        <label class="block mb-2 font-bold text-gray-900 " for="biodata">Biodata Diri</label>
                        <textarea id="editor" name="biodata"></textarea>
                    </div>
                    {{-- Email --}}
                    <div>
                        <label class="block mb-2 font-bold text-gray-900" for="email">Email</label>
                        <input type="email" id="email" name="email" value="{{ old('email') }}"
                            class="block w-full text-sm text-gray-900 border @error('email') border-red-500 @enderror rounded-lg"
                            required>
                        @error('email')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    {{-- Data Keuangan --}}
                    <div>
                        <label class="block mb-2 font-bold text-gray-900" for="penghasilan_orang_tua">Penghasilan Orang
                            Tua</label>
                        <input type="number" min="0" id="penghasilan_orang_tua" name="penghasilan_orang_tua"
                            value="{{ old('penghasilan_orang_tua') }}"
                            class="block w-full text-sm text-gray-900 border @error('penghasilan_orang_tua') border-red-500 @enderror rounded-lg"
                            required>
                        @error('penghasilan_orang_tua')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <div class="text-center">
                    <button type="submit" class="p-4 text-white bg-gray-500 rounded-full font-bold">Kirim
                        Formulir</button>
                </div>
            </form>


        </div>


        {{-- Scripts --}}
        <script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.js"></script>
        <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.js"></script>

        {{-- Buat profil --}}
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

        {{-- CKEDITOR (text editor) --}}
        <script>
            ClassicEditor
                .create(document.querySelector('#editor'), {
                    toolbar: ['bold', 'italic', '|', 'bulletedList', 'numberedList', '|', 'link'],
                    removePlugins: ['MediaEmbed', 'Table', 'TableToolbar', 'BlockQuote'],
                    link: {
                        defaultProtocol: 'https://'
                    }
                })
                .catch(error => {
                    console.error(error);
                });
        </script>
</body>

</html>
