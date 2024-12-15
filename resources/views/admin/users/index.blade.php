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
            <li class="px-6 py-3 border-r-4 border-[#226597]">
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
        <div class="flex justify-between items-center">
            <h1 class="text-2xl font-bold">Daftar Pengguna</h1>
            <button onclick="openModal('addUserModal')" class="p-3 bg-blue-500 rounded-lg text-white font-medium">
                Tambah User
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

        {{-- Show users table --}}
        <div class="mt-6 w-full overflow-x-auto">
            <table class="w-full table-auto border-collapse bg-white border border-gray-300">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="px-4 py-2 whitespace-nowrap">No</th>
                        <th class="px-4 py-2 whitespace-nowrap">Nama</th>
                        <th class="px-4 py-2 whitespace-nowrap">Email</th>
                        <th class="px-4 py-2 whitespace-nowrap">No. Telepon</th>
                        <th class="px-4 py-2 whitespace-nowrap">Nilai IPK & TOEFL</th>
                        <th class="px-4 py-2 whitespace-nowrap">Role</th>
                        <th class="px-4 py-2 whitespace-nowrap">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @if($users->isEmpty())
                    <tr>
                        <td class="border px-4 py-2 text-center" colspan="7">Tidak ada data</td>
                    </tr>
                    @else
                    @foreach ($users as $user)
                    <tr>
                        <td class="border px-4 py-2 text-center">{{$loop->iteration}}</td>
                        <td class="border px-4 py-2">{{$user->full_name}}</td>
                        <td class="border px-4 py-2">{{$user->email}}</td>
                        <td class="border px-4 py-2">{{$user->phone}}</td>
                        <td class="border px-4 py-2">
                            <p>IPK : {{$user->ipk}}</p>
                            <p>Min. IPK : {{$user->min_ipk}}</p>
                            <p>Max. IPK : {{$user->max_ipk}}</p>
                            <p>TOEFL : {{$user->toefl}}</p>
                        </td>
                        <td class="border px-4 py-2 text-center">{{$user->is_admin ? 'Admin' : 'User'}}</td>
                        <td class="border px-4 py-2 text-center">
                            <div class="flex flex-col sm:flex-row gap-2 justify-center">
                                <button onclick="openModal('editUserModal', {{$user->id}})"
                                    class="bg-blue-500 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded">Edit</button>
                                <button onclick="openModal('deleteUserModal', {{$user->id}})"
                                    class="bg-red-500 hover:bg-red-700 text-white font-medium py-2 px-4 rounded">Hapus</button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </div>

    {{-- Modal Add User --}}
    <div id="addUserModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50 hidden">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3 text-center">
                <h3 class="text-lg leading-6 font-medium text-gray-900">Tambah User</h3>
                <form action="{{ route('admin.users.store') }}" method="POST" class="mt-2">
                    @csrf
                    <div class="space-y-4">
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Nama Depan</label>
                                <input type="text" name="first_name"
                                    class="mt-1 block w-full rounded-md border-gray-300" required>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Nama Belakang</label>
                                <input type="text" name="last_name" class="mt-1 block w-full rounded-md border-gray-300"
                                    required>
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Email</label>
                            <input type="email" name="email" class="mt-1 block w-full rounded-md border-gray-300"
                                required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">No. Telepon</label>
                            <input type="text" name="phone" class="mt-1 block w-full rounded-md border-gray-300"
                                required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Role Pengguna</label>
                            <select name="is_admin" class="mt-1 block w-full rounded-md border-gray-300" required>
                                <option value="0">User</option>
                                <option value="1">Admin</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Password</label>
                            <input type="password" name="password" class="mt-1 block w-full rounded-md border-gray-300"
                                required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Confirm Password</label>
                            <input type="password" name="password_confirmation"
                                class="mt-1 block w-full rounded-md border-gray-300" required>
                        </div>
                    </div>
                    <div class="flex justify-end mt-4">
                        <button type="button" onclick="closeModal('addUserModal')"
                            class="mr-2 px-4 py-2 bg-gray-200 rounded-md">Cancel</button>
                        <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-md">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Modal Edit User --}}
    <div id="editUserModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50 hidden">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3 text-center">
                <h3 class="text-lg leading-6 font-medium text-gray-900">Edit User</h3>
                <form id="editUserForm" action="" method="POST" class="mt-2">
                    @csrf
                    @method('PUT')
                    <div class="space-y-4">
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Nama Depan</label>
                                <input type="text" name="first_name"
                                    class="mt-1 block w-full rounded-md border-gray-300" required>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Nama Belakang</label>
                                <input type="text" name="last_name" class="mt-1 block w-full rounded-md border-gray-300"
                                    required>
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Email</label>
                            <input type="email" name="email" class="mt-1 block w-full rounded-md border-gray-300">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">No. Telepon</label>
                            <input type="text" name="phone" class="mt-1 block w-full rounded-md border-gray-300">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Role Pengguna</label>
                            <select name="is_admin" class="mt-1 block w-full rounded-md border-gray-300">
                                <option value="0">User</option>
                                <option value="1">Admin</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Password</label>
                            <input type="password" name="password" class="mt-1 block w-full rounded-md border-gray-300">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Confirm Password</label>
                            <input type="password" name="password_confirmation"
                                class="mt-1 block w-full rounded-md border-gray-300">
                        </div>
                    </div>
                    <div class="flex justify-end mt-4">
                        <button type="button" onclick="closeModal('editUserModal')"
                            class="mr-2 px-4 py-2 bg-gray-200 rounded-md">Cancel</button>
                        <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-md">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Modal Delete User --}}
    <div id="deleteUserModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50 hidden">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3 text-center">
                <h3 class="text-lg leading-6 font-medium text-gray-900">Hapus User</h3>
                <p class="mt-2 text-sm text-gray-600">Apakah Anda yakin ingin menghapus user ini?</p>
                <form id="deleteUserForm" action="" method="POST" class="mt-2">
                    @csrf
                    @method('DELETE')
                    <div class="flex justify-end mt-4">
                        <button type="button" onclick="closeModal('deleteUserModal')"
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
        const users = @json($users);
        // Function to open modal
        function openModal(modalId, userId = null) {
            const modal = document.getElementById(modalId);
            modal.classList.remove('hidden');

            if (userId !== null) {
                const user = users.find(user => user.id === userId);

                if (modalId === 'editUserModal') {
                    const form = document.getElementById('editUserForm');
                    form.action = `/admin/users/${userId}`;

                    // Populate form fields
                    form.querySelector('[name="first_name"]').value = user.first_name;
                    form.querySelector('[name="last_name"]').value = user.last_name;
                    form.querySelector('[name="email"]').value = user.email;
                    form.querySelector('[name="phone"]').value = user.phone;
                    form.querySelector('[name="is_admin"]').value = user.is_admin;

                } else if (modalId === 'deleteUserModal') {
                    const form = document.getElementById('deleteUserForm');
                    form.action = `/admin/users/${userId}`;
                }
            }
        }

        // Function to close modal
        function closeModal(modalId) {
            const modal = document.getElementById(modalId);
            modal.classList.add('hidden');
        }

        // Add event listeners to buttons
        document.addEventListener('DOMContentLoaded', () => {
            // Add User Button
            const addUserBtn = document.querySelector('button[x-click]');
            if (addUserBtn) {
                addUserBtn.addEventListener('click', () => openModal('addUserModal'));
            }

            // Edit User Buttons
            const editButtons = document.querySelectorAll('button[x-click]');
            editButtons.forEach(btn => {
                btn.addEventListener('click', () => {
                    const userId = btn.getAttribute('data-user-id');
                    openModal('editUserModal', userId);
                });
            });

            // Delete User Buttons
            const deleteButtons = document.querySelectorAll('button[x-click]');
            deleteButtons.forEach(btn => {
                btn.addEventListener('click', () => {
                    const userId = btn.getAttribute('data-user-id');
                    openModal('deleteUserModal', userId);
                });
            });
        });
    </script>
</body>

</html>