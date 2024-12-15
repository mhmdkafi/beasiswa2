<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Admin Dashboard</title>

    {{-- Fontawosome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css"
        integrity="sha512-5Hs3dF2AEPkpNAR7UiOHba+lRSJNeM2ECkwxUIxC1Q/FLycGTbNapWXB4tP889k5T5Ju8fs4b1P5z/iB4nMfSQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/js/all.min.js"
        integrity="sha512-1JkMy1LR9bTo3psH+H4SV5bO2dFylgOy+UJhMus1zF4VEFuZVu5lsi4I6iIndE4N9p01z1554ZDcvMSjMaqCBQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <!-- AlpineJS -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.13.3/dist/cdn.min.js" defer></script>

    {{-- CKEDITOR --}}
    <script src="https://cdn.ckeditor.com/ckeditor5/40.1.0/classic/ckeditor.js"></script>

    {{-- Vite Development --}}
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
</head>

<body class="bg-gray-100 min-h-screen flex">
    <!-- Sidebar -->
    <div id="sidebar" class="w-64 bg-white shadow-md border-r border-gray-200 transition-all duration-300 ease-in-out">
        <div id="divTitle"
            class="flex flex-row items-center justify-between h-16 bg-[#226597] shadow-lg text-white px-4">
            <h1 id="logoDashboard" class="text-2xl font-bold">Admin</h1>
            <button id="sidebarToggle">
                <i class="fas fa-bars text-xl"></i>
            </button>
        </div>
        <ul class="mt-6">
            <li class="px-6 py-3 ">
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
            <li class="px-6 py-3  border-r-4 border-[#226597]">
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
        <div class="flex justify-between items-center">
            <h1 class="text-2xl font-bold">List Pendaftar Beasiswa</h1>
        </div>

        {{-- Show list of errors --}}
        @if ($errors->any())
        <div class="mt-4 p-4 bg-red-200 text-red-700 rounded">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        {{-- Show success --}}
        @if (session('success'))
        <div class="mt-4 p-4 bg-green-200 text-green-700 rounded">
            {{ session('success') }}
        </div>
        @endif

        {{-- Show list beasiswa table --}}
        <div class="mt-6 w-full overflow-x-auto">
            <table class="w-full table-auto border-collapse bg-white border border-gray-300">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="px-4 py-2 whitespace-nowrap">No</th>
                        <th class="px-4 py-2 whitespace-nowrap">Nama Pendaftar</th>
                        <th class="px-4 py-2 whitespace-nowrap">Tanggal Mendaftar</th>
                        <th class="px-4 py-2 whitespace-nowrap">Status</th>
                        <th class="px-4 py-2 whitespace-nowrap">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @if($listPendaftar->isEmpty())
                    <tr>
                        <td class="border px-4 py-2 text-center" colspan="4">Tidak ada data</td>
                    </tr>
                    @else
                    @foreach ($listPendaftar as $pendaftar)
                    <tr>
                        <td class="border px-4 py-2 text-center">{{$loop->iteration}}</td>
                        <td class="border px-4 py-2">{{$pendaftar->user->full_name}}</td>
                        <td class="border px-4 py-2">{{$pendaftar->created_at->format('j F Y')}}</td>
                        <td class="border px-4 py-2 capitalize">{{$pendaftar->status}}</td>
                        <td class="border px-4 py-2 text-center">
                            <div class="flex flex-col sm:flex-row gap-2 justify-center">
                                <button onclick="openModal({{$beasiswa->id}}, {{$pendaftar->user_id}})"
                                    class="bg-blue-500 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded">Lihat
                                    Detail</button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </div>

    {{-- Modal Detail Pendaftar --}}
    <div id="detailPendaftarModal"
        class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50 hidden">
        <div class="relative top-20 mx-auto p-5 border max-w-md shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <h3 class="text-lg leading-6 font-medium text-gray-900 text-center">Detail Pendaftar</h3>
                <div class="space-y-4">
                    <p>Nama Pendaftar : <span id="namaPendaftar"></span></p>
                    <p>Transkrips Nilai : <a href="" id="transkripPendaftar" download
                            class="text-blue-500 underline">File
                            Transkripsi<i class="ms-1 fa-solid fa-up-right-from-square fa-sm"></i></a></p>
                    <p>Email : <span id="emailPendaftar"></span></p>
                    <p>Penghasilan Orang Tua : <span id="penghasilanOrtuPendaftar"></span></p>
                </div>
            </div>
            <div class="mt-5 flex justify-between items-center">
                <form id="rejectForm" action="" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="status" value="reject">
                    <button type="submit" onclick="confirm('Apakah anda yakin ingin menolak pendaftar ini?')"
                        class="px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-600 transition-colors">
                        Reject
                    </button>
                </form>

                <button onclick="closeModal()"
                    class="px-4 py-2 bg-gray-200 rounded-md hover:bg-gray-300 transition-colors mx-auto">
                    Close
                </button>

                <form id="acceptForm" action="" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="status" value="accept">
                    <button type="submit" onclick="confirm('Apakah anda yakin ingin menerima pendaftar ini?')"
                        class="px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-600 transition-colors">
                        Accept
                    </button>
                </form>
            </div>
        </div>>
    </div>


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

    {{-- Toggle Modal --}}
    <script>
        const modal = document.getElementById('detailPendaftarModal');
        const listPendaftar = @json($listPendaftar);
        function openModal(beasiswaId = null, pendaftarId = null){
            const data = listPendaftar.find(data => data.user_id === pendaftarId && data.beasiswa_id === beasiswaId);
            if(data === undefined) return;

            // Set form actions and user IDs
            const baseUrl = "{{ route('admin.scholarship.pendaftar.update-status', ['id' => ':beasiswaId', 'pendaftarId' => ':pendaftarId']) }}";
            const formAction = baseUrl.replace(':beasiswaId', beasiswaId).replace(':pendaftarId', pendaftarId);

            // Show/hide action buttons based on status
            const rejectForm = document.getElementById('rejectForm');
            const acceptForm = document.getElementById('acceptForm');

            if (data.status === 'pending') {
                rejectForm.classList.remove('hidden');
                acceptForm.classList.remove('hidden');
                rejectForm.action = formAction;
                acceptForm.action = formAction;
            } else {
                rejectForm.classList.add('hidden');
                acceptForm.classList.add('hidden');
            }

            // Update modal content
            document.getElementById('namaPendaftar').textContent = data.user.full_name;
            document.getElementById('emailPendaftar').textContent = data.user.email;
            document.getElementById('penghasilanOrtuPendaftar').textContent = "Rp. "+data.penghasilan_orang_tua;
            document.getElementById('transkripPendaftar').href = `/files/transkrip/${data.transkrip_file}`;
            modal.classList.remove('hidden');
        }

        function closeModal() {
            modal.classList.add('hidden');
        }
    </script>
</body>

</html>
