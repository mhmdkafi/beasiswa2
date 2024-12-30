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
            <h1 class="text-2xl font-bold">Daftar Beasiswa</h1>
            <button onclick="openModal('addBeasiswaModal')" class="p-3 bg-blue-500 rounded-lg text-white font-medium">
                Tambah Beasiswa
            </button>
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
                        <th class="px-4 py-2 whitespace-nowrap">Nama</th>
                        <th class="px-4 py-2 whitespace-nowrap">Instansi</th>
                        <th class="px-4 py-2 whitespace-nowrap">Jumlah Pendaftar</th>
                        <th class="px-4 py-2 whitespace-nowrap">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @if($listBeasiswa->isEmpty())
                    <tr>
                        <td class="border px-4 py-2 text-center" colspan="5">Tidak ada data</td>
                    </tr>
                    @else
                    @foreach ($listBeasiswa as $beasiswa)
                    <tr>
                        <td class="border px-4 py-2 text-center">{{$loop->iteration}}</td>
                        <td class="border px-4 py-2">{{$beasiswa->nama}}</td>
                        <td class="border px-4 py-2">{{$beasiswa->instansi}}</td>
                        <td class="border px-4 py-2">{{$beasiswa->penerima->count()}}</td>
                        <td class="border px-4 py-2 text-center">
                            <div class="flex flex-col sm:flex-row gap-2 justify-center">
                                <button onclick="openModal('editBeasiswaModal', {{$beasiswa->id}})"
                                    class="bg-blue-500 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded">Edit</button>
                                <button onclick="openModal('deleteBeasiswaModal', {{$beasiswa->id}})"
                                    class="bg-red-500 hover:bg-red-700 text-white font-medium py-2 px-4 rounded">Hapus</button>
                                <a href="{{route('admin.scholarship.pendaftar',$beasiswa->id)}}"
                                    class="bg-green-500 hover:bg-green-700 text-white font-medium py-2 px-4 rounded">Lihat
                                    Pendaftar</a>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </div>

    {{-- Modal Add Beasiswa --}}
    <div id="addBeasiswaModal"
        class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50 hidden">
        <div class="relative top-20 mx-auto p-5 border max-w-md shadow-lg rounded-md bg-white">
            <div class="mt-3 text-center">
                <h3 class="text-lg leading-6 font-medium text-gray-900">Tambah Beasiswa</h3>
                <form action="{{ route('admin.scholarship.store') }}" method="POST" enctype="multipart/form-data"
                    class="mt-2">
                    @csrf
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Nama Beasiswa</label>
                            <input type="text" name="nama" class="mt-1 block w-full rounded-md border-gray-300"
                                required>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Tingat Pendidikan</label>
                                <select name="tingkat_pendidikan" class="mt-1 block w-full rounded-md border-gray-300"
                                    required>
                                    <option value="SMA">SMA</option>
                                    <option value="D3">D3</option>
                                    <option value="S1">S1</option>
                                    <option value="S2">S2</option>
                                    <option value="S3">S3</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Min IPK Pendaftaran</label>
                                <input type="number" step="0.01" name="min_ipk"
                                    class="mt-1 block w-full rounded-md border-gray-300" required>
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Nama Instansi</label>
                                <input type="text" name="instansi" class="mt-1 block w-full rounded-md border-gray-300"
                                    required>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Logo Instansi</label>
                                <input type="file" name="logo_instansi"
                                    class="mt-1 border block w-full rounded-md border-gray-300" required>
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Deskripsi Persyaratan</label>
                            <textarea id="editor" name="deskripsi"></textarea>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Thumbnail</label>
                            <input type="file" name="thumbnail"
                                class="mt-1 border block w-full rounded-md border-gray-300" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Banner</label>
                            <input type="file" name="banner" class="mt-1 border block w-full rounded-md border-gray-300"
                                required>
                        </div>
                        <div class="flex justify-end mt-4">
                            <button type="button" onclick="closeModal('addBeasiswaModal')"
                                class="mr-2 px-4 py-2 bg-gray-200 rounded-md">Cancel</button>
                            <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-md">Save</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Modal Edit Beasiswa --}}
    <div id="editBeasiswaModal"
        class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50 hidden">
        <div class="relative top-20 mx-auto p-5 border max-w-md shadow-lg rounded-md bg-white">
            <div class="mt-3 text-center">
                <h3 class="text-lg leading-6 font-medium text-gray-900">Edit Beasiswa</h3>
                <form id="editBeasiswaForm" action="" method="POST" enctype="multipart/form-data"="mt-2">
                    @csrf
                    @method('PUT')
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Nama Beasiswa</label>
                            <input type="text" name="nama" class="mt-1 block w-full rounded-md border-gray-300"
                                required>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Tingat Pendidikan</label>
                                <select name="tingkat_pendidikan" class="mt-1 block w-full rounded-md border-gray-300"
                                    required>
                                    <option value="SMA">SMA</option>
                                    <option value="D3">D3</option>
                                    <option value="S1">S1</option>
                                    <option value="S2">S2</option>
                                    <option value="S3">S3</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Min IPK Pendaftaran</label>
                                <input type="number" step="0.01" name="min_ipk"
                                    class="mt-1 block w-full rounded-md border-gray-300" required>
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Nama Instansi</label>
                                <input type="text" name="instansi" class="mt-1 block w-full rounded-md border-gray-300"
                                    required>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Ganti Logo Instansi</label>
                                <input type="file" name="logo_instansi"
                                    class="mt-1 border block w-full rounded-md border-gray-300">
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Deskripsi Persyaratan</label>
                            <textarea id="editor-edit" name="deskripsi"></textarea>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Ganti Thumbnail</label>
                            <input type="file" name="thumbnail"
                                class="mt-1 border block w-full rounded-md border-gray-300">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Ganti Banner</label>
                            <input type="file" name="banner"
                                class="mt-1 border block w-full rounded-md border-gray-300">
                        </div>
                    </div>
                    <div class="flex justify-end mt-4">
                        <button type="button" onclick="closeModal('editBeasiswaModal')"
                            class="mr-2 px-4 py-2 bg-gray-200 rounded-md">Cancel</button>
                        <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-md">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Modal Delete Beasiswa --}}
    <div id="deleteBeasiswaModal"
        class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50 hidden">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3 text-center">
                <h3 class="text-lg leading-6 font-medium text-gray-900">Hapus Beasiswa</h3>
                <p class="mt-2 text-sm text-gray-600">Apakah Anda yakin ingin menghapus beasiswa ini?</p>
                <form id="deleteBeasiswaForm" action="" method="POST" class="mt-2">
                    @csrf
                    @method('DELETE')
                    <div class="flex justify-end mt-4">
                        <button type="button" onclick="closeModal('deleteBeasiswaModal')"
                            class="mr-2 px-4 py-2 bg-gray-200 rounded-md">Cancel</button>
                        <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded-md">Delete</button>
                    </div>
                </form>
            </div>
        </div>
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

    {{-- Toggle Mdal --}}
    <script>
        let editorAdd;
        let editorEdit;

        // Initialize CKEditor instances
        ClassicEditor
            .create(document.querySelector('#editor'), {
                toolbar: ['bold', 'italic', '|', 'bulletedList', 'numberedList', '|', 'link'],
                removePlugins: ['MediaEmbed', 'Table', 'TableToolbar', 'BlockQuote'],
                link: { defaultProtocol: 'https://' }
            })
            .then(editor => {
                editorAdd = editor;
            })
            .catch(error => {
                console.error(error);
            });

        ClassicEditor
            .create(document.querySelector('#editor-edit'), {
                toolbar: ['bold', 'italic', '|', 'bulletedList', 'numberedList', '|', 'link'],
                removePlugins: ['MediaEmbed', 'Table', 'TableToolbar', 'BlockQuote'],
                link: { defaultProtocol: 'https://' }
            })
            .then(editor => {
                editorEdit = editor;
            })
            .catch(error => {
                console.error(error);
            });

        const beasiswa = @json($listBeasiswa);
        // Function to open modal
        function openModal(modalId, beasiswaId = null) {

            const modal = document.getElementById(modalId);
            modal.classList.remove('hidden');

            if (beasiswaId !== null) {
                const data = beasiswa.find(data => data.id === beasiswaId);

                if (modalId === 'editBeasiswaModal') {
                    const form = document.getElementById('editBeasiswaForm');
                    form.action = `/admin/scholarship/${beasiswaId}`;

                    // Populate form fields
                    form.querySelector('[name="nama"]').value = data.nama;
                    form.querySelector('[name="min_ipk"]').value = data.min_ipk;
                    form.querySelector('[name="instansi"]').value = data.instansi;
                    form.querySelector('[name="tingkat_pendidikan"]').value = data.tingkat_pendidikan;
                    editorEdit.setData(data.deskripsi);

                } else if (modalId === 'deleteBeasiswaModal') {
                    const form = document.getElementById('deleteBeasiswaForm');
                    form.action = `/admin/scholarship/${beasiswaId}`;
                }
            }
        }

        // Function to close modal
        function closeModal(modalId) {
            const modal = document.getElementById(modalId);
            modal.classList.add('hidden');

            if (modalId === 'editBeasiswaModal') {
                editorEdit.setData('');
            }
        }

        // Add event listeners to buttons
        document.addEventListener('DOMContentLoaded', () => {
            // Add User Button
            const addUserBtn = document.querySelector('button[x-click]');
            if (addUserBtn) {

                addUserBtn.addEventListener('click', () => openModal('addBeasiswaModal'));
            }

            // Edit User Buttons
            const editButtons = document.querySelectorAll('button[x-click]');
            editButtons.forEach(btn => {
                btn.addEventListener('click', () => {
                    const beasiswaId = btn.getAttribute('data-user-id');
                    openModal('editBeasiswaModal', beasiswaId);
                });
            });

            // Delete User Buttons
            const deleteButtons = document.querySelectorAll('button[x-click]');
            deleteButtons.forEach(btn => {
                btn.addEventListener('click', () => {
                    const beasiswaId = btn.getAttribute('data-user-id');
                    openModal('deleteBeasiswaModal', beasiswaId);
                });
            });
        });
    </script>

</body>

</html>