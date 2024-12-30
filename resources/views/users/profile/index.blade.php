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
                <a href="{{route('dashboard')}}"><i class="fa-solid fa-arrow-left-long fa-xl text-white"></i></a>
                <a href="{{route('announcement.index')}}" class="relative inline-block">
                    <i class="fa-solid fa-envelope fa-xl p-1 text-white"></i>
                    @if($notificationCount>0)
                    <div class="absolute top-0 right-0 w-1.5 h-1.5 bg-red-500 rounded-full"></div>
                    @endif
                </a>
            </div>
        </div>

        {{-- Konten Profil --}}
        <div class="space-y-6 p-6">
            {{-- Show Error modal --}}
            @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                <strong class="font-bold">Error!</strong>
                <ul class="mt-2 list-disc list-inside">
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
                    <svg onclick="this.parentElement.parentElement.style.display='none'"
                        class="fill-current h-6 w-6 text-red-500" role="button" xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 20 20">
                        <title>Close</title>
                        <path
                            d="M14.348 14.849a1 1 0 0 1-1.497 1.32l-2.851-2.679-2.852 2.68a1 1 0 1 1-1.497-1.32l2.852-2.68-2.852-2.68a1 1 0 1 1 1.497-1.32l2.852 2.68 2.851-2.68a1 1 0 0 1 1.497 1.32l-2.851 2.68 2.851 2.679a1 1 0 0 1 0 1.32z" />
                    </svg>
                </span>
            </div>
            @endif

            {{-- Show Success modal --}}
            @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                <strong class="font-bold">Success!</strong>
                <span class="block sm:inline">{{ session('success') }}</span>
                <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
                    <svg onclick="this.parentElement.parentElement.style.display='none'"
                        class="fill-current h-6 w-6 text-green-500" role="button" xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 20 20">
                        <title>Close</title>
                    </svg>
                </span>
            </div>
            @endif

            <div class="relative flex flex-row items-center w-full bg-[#F5F5F5] p-4">
                <img src="{{ auth()->user()->image ? asset('img/profile/' . auth()->user()->image) : asset('img/profile/default.jpg') }}"
                    alt="Profile Picture" class="w-16 h-16 rounded-full object-cover object-center">
                <p class="ms-2 font-medium">{{auth()->user()->full_name}}</p>
                <button data-modal="imageModal"
                    class="absolute top-4 right-4 px-2 bg-gray-400 font-medium">Edit</button>
            </div>
            <div class="relative flex flex-col w-full bg-[#F5F5F5] p-4">
                <p class="font-medium text-lg mb-4">Personal Information</p>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <p class="font-medium">Nama Depan</p>
                        <p class="text-gray-600">{{auth()->user()->first_name ?? '-'}}</p>
                    </div>
                    <div>
                        <p class="font-medium">Nama Belakang</p>
                        <p class="text-gray-600">{{auth()->user()->last_name ?? '-'}}</p>
                    </div>
                    <div>
                        <p class="font-medium">Email</p>
                        <p class="text-gray-600">{{auth()->user()->email ?? '-'}}</p>
                    </div>
                    <div>
                        <p class="font-medium">Nomor Telepon</p>
                        <p class="text-gray-600">{{auth()->user()->phone ?? '-'}}</p>
                    </div>
                </div>
                <button data-modal="personalModal"
                    class="absolute top-4 right-4 px-2 bg-gray-400 font-medium">Edit</button>
            </div>
            <div class="relative flex flex-col w-full bg-[#F5F5F5] p-4">
                <p class="font-medium text-lg mb-4">List IPK & TOEFL</p>
                <div class="flex flex-wrap justify-between gap-4">
                    <div>
                        <p class="font-medium">IPK</p>
                        <p class="text-gray-600">{{auth()->user()->ipk ?? '-'}}</p>
                    </div>
                    <div>
                        <p class="font-medium">Min. IPK</p>
                        <p class="text-gray-600">{{auth()->user()->min_ipk ?? '-'}}</p>
                    </div>
                    <div>
                        <p class="font-medium">Max. IPK</p>
                        <p class="text-gray-600">{{auth()->user()->max_ipk ??'-'}}</p>
                    </div>
                    <div>
                        <p class="font-medium">TOEFL</p>
                        <p class="text-gray-600">{{auth()->user()->toefl ?? '-'}}</p>
                    </div>
                </div>
                <button data-modal="ipkModal" class="absolute top-4 right-4 px-2 bg-gray-400 font-medium">Edit</button>
            </div>
        </div>

        {{-- Modal edit image --}}
        <div id="imageModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
            <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
                <div class="mt-3 text-center">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">Update Profile Picture</h3>
                    <form action="{{ route('profile.update.image') }}" method="POST" enctype="multipart/form-data"
                        class="mt-2">
                        @csrf
                        @method('PUT')
                        <div class="mt-2">
                            <input type="file" name="image" class="w-full">
                        </div>
                        <div class="flex justify-end mt-4">
                            <button type="button" onclick="toggleModal('imageModal')"
                                class="mr-2 px-4 py-2 bg-gray-200 rounded-md">Cancel</button>
                            <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-md">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- Modal edit personal information --}}
        <div id="personalModal"
            class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
            <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
                <div class="mt-3">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">Update Personal Information</h3>
                    <form action="{{ route('profile.update.personal-info') }}" method="POST" class="mt-2">
                        @csrf
                        @method('PUT')
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">First Name</label>
                                <input type="text" name="first_name" value="{{ auth()->user()->first_name }}"
                                    class="mt-1 block w-full rounded-md border-gray-300">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Last Name</label>
                                <input type="text" name="last_name" value="{{ auth()->user()->last_name }}"
                                    class="mt-1 block w-full rounded-md border-gray-300">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Email</label>
                                <input type="email" name="email" value="{{ auth()->user()->email }}"
                                    class="mt-1 block w-full rounded-md border-gray-300">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Phone</label>
                                <input type="text" name="phone" value="{{ auth()->user()->phone }}"
                                    class="mt-1 block w-full rounded-md border-gray-300">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Password</label>
                                <input type="password" name="password"
                                    class="mt-1 block w-full rounded-md border-gray-300">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Confirm Password</label>
                                <input type="password" name="password_confirmation"
                                    class="mt-1 block w-full rounded-md border-gray-300">
                            </div>
                        </div>
                        <div class="flex justify-end mt-4">
                            <button type="button" onclick="toggleModal('personalModal')"
                                class="mr-2 px-4 py-2 bg-gray-200 rounded-md">Cancel</button>
                            <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-md">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- Modal edit ipk & toefl --}}
        <div id="ipkModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
            <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
                <div class="mt-3">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">Update IPK & TOEFL</h3>
                    <form action="{{ route('profile.update.ipk') }}" method="POST" class="mt-2">
                        @csrf
                        @method('PUT')
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">IPK</label>
                                <input type="number" step="0.01" min="0" max="4" name="ipk" value="{{ auth()->user()->ipk }}"
                                    class="mt-1 block w-full rounded-md border-gray-300">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Min. IPK</label>
                                <input type="number" step="0.01"  min="0" max="4" name="min_ipk" value="{{ auth()->user()->min_ipk }}"
                                    class="mt-1 block w-full rounded-md border-gray-300">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Max. IPK</label>
                                <input type="number" step="0.01"  min="0" max="4" name="max_ipk" value="{{ auth()->user()->max_ipk }}"
                                    class="mt-1 block w-full rounded-md border-gray-300">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">TOEFL Score</label>
                                <input type="number" name="toefl" min="0" value="{{ auth()->user()->toefl }}"
                                    class="mt-1 block w-full rounded-md border-gray-300">
                            </div>
                        </div>
                        <div class="flex justify-end mt-4">
                            <button type="button" onclick="toggleModal('ipkModal')"
                                class="mr-2 px-4 py-2 bg-gray-200 rounded-md">Cancel</button>
                            <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-md">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- Scripts --}}
        <script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.js"></script>
        <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.js"></script>

        <script>
            function toggleModal(modalId) {
                const modal = document.getElementById(modalId);
                if(modal.classList.contains('hidden')) {
                    modal.classList.remove('hidden');
                } else {
                    modal.classList.add('hidden');
                }
            }

            // Update button click handlers
            document.querySelectorAll('button').forEach(button => {
                if(button.textContent.trim() === 'Edit') {
                    button.addEventListener('click', function() {
                        const section = this.closest('div').querySelector('p').textContent;
                        if(section.includes('Personal Information')) {
                            toggleModal('personalModal');
                        } else if(section.includes('List IPK')) {
                            toggleModal('ipkModal');
                        } else {
                            toggleModal('imageModal');
                        }
                    });
                }
            });
        </script>
</body>

</html>
