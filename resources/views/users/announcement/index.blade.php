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
        <div class="relative flex flex-row justify-center items-center bg-[#226597] p-6">
            <a href="{{route('dashboard')}}" class="absolute left-6">
                <i class="fa-solid fa-arrow-left text-white fa-lg"></i>
            </a>
            <p class="text-white text-xl font-medium">Pengumuman</p>
        </div>

        {{-- Konten Pengumuman --}}
        <div class="flex flex-col space-y-4 p-6">
            @foreach($listPengumuman as $month => $pengumumans)
            <div class="flex flex-col space-y-2">
                <p class="text-gray-600 font-medium">{{ $month }}</p>
                <hr>
                @foreach ($pengumumans as $item)
                <a href="{{ route('announcement.show', $item->id) }}"
                    class="px-4 py-2 bg-[#F5F5F5] space-y-2 rounded-lg border">
                    <div class="flex flex-row space-x-4 items-center">
                        <img src="{{ asset('img/kampus/' . $item->beasiswa->logo_instansi) }}" alt=""
                            class="w-8 h-8 rounded-full bg-white object-fill object-center">
                        <span class="font-medium text-lg">{{ $item->beasiswa->nama }}</span>
                    </div>

                    @if($item->status == 'accept')
                    <p class="">Selamat! Anda dinyatakan <b>LULUS</b> seleksi {{
                        $item->beasiswa->nama }}.</p>
                    @elseif($item->status == 'reject')
                    <p class="">Mohon maaf, Anda dinyatakan <b>TIDAK LULUS</b> seleksi {{
                        $item->beasiswa->nama }}. Tetap semangat!</p>
                    @endif
                    <p class="text-sm text-gray-600 font-medium">{{ $item->updated_at->format('d F Y') }}</p>
                </a>
                @endforeach
            </div>
            @endforeach
        </div>
    </div>
    {{-- Scripts --}}
    <script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.js"></script>
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.js"></script>
</body>

</html>
