<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Pengumuman | Detail</title>
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
        <div class="relative flex flex-row justify-center items-center bg-[#226597] p-6">
            <a href="{{route('announcement.index')}}" class="absolute left-6">
                <i class="fa-solid fa-arrow-left text-white fa-lg"></i>
            </a>
            <p class="text-white text-xl font-medium">Pengumuman</p>
        </div>

        {{-- Konten Pengumuman --}}
        <div class="flex flex-col space-y-4 p-6">
            <h2 class="font-bold text-2xl">{{$pendaftar->beasiswa->nama}}</h2>
            <div class="flex justify-between items-center">
                <div class="flex flex-row space-x-4 items-center">
                    <img src="{{asset('img/kampus/'.$pendaftar->beasiswa->logo_instansi)}}" alt=""
                        class="w-8 h-8 rounded-full bg-white object-fill object-center">
                    <span class="font-medium">{{$pendaftar->beasiswa->instansi}}</span>
                </div>
                <p class="text-gray-600 font-medium">{{$pendaftar->updated_at->format('j F Y')}}</p>
            </div>
            <p class="font-bold text-center capitalize">Pengumuman Hasil Seleksi {{$pendaftar->beasiswa->nama}}</p>
            <div class="p-2 border bg-[#F5F5F5] text-sm">
                <p>Nama : {{$pendaftar->user->full_name}}</p>
                <p>Email : {{$pendaftar->email}}</p>
                @if($pendaftar->status == 'accept')
                <div class="space-y-4 mt-4">
                    <p class="font-medium text-justify">
                        Selamat! Anda dinyatakan <strong>LULUS</strong> seleksi beasiswa <span
                            class="capitalize">{{$pendaftar->beasiswa->nama}}</span> dari <span
                            class="capitalize">{{$pendaftar->beasiswa->instansi}}</span>.
                    </p>
                    <p class="text-justify">
                        Kami mengucapkan selamat atas pencapaian Anda. Semoga beasiswa ini dapat membantu Anda mencapai
                        cita-cita dan mengembangkan potensi akademik Anda. Tetap semangat dan jaga prestasi!
                    </p>
                </div>
                <img src="{{asset('img/asset_web/accepted_vector.png')}}" alt="" class="px-12 pt-8">
                <p class="text-[#226597] font-bold text-center text-xl">Selamat, {{auth()->user()->first_name}} !</p>
                @elseif($pendaftar->status == 'reject')
                <div class="space-y-4 mt-4">
                    <p class="font-medium text-justify">
                        Mohon maaf, Anda dinyatakan <strong>TIDAK LULUS</strong> seleksi beasiswa <span
                            class="capitalize">{{$pendaftar->beasiswa->nama}}</span> dari <span
                            class="capitalize">{{$pendaftar->beasiswa->instansi}}</span>.
                    </p>
                    <p class="text-justify">
                        Kami mengucapkan terima kasih atas partisipasi Anda dalam proses seleksi ini. Jangan berkecil
                        hati dan tetap semangat untuk mencoba kesempatan lainnya. Semoga sukses di kesempatan
                        berikutnya!
                    </p>
                </div>
                <img src="{{asset('img/asset_web/rejected_vector.png')}}" alt="" class="px-12 pt-8">
                <p class="text-[#226597] font-bold text-center text-xl">Tetap semangat, {{auth()->user()->first_name}} !
                </p>
                @endif
            </div>

        </div>
    </div>
    {{-- Scripts --}}
    <script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.js"></script>
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.js"></script>
</body>

</html>
