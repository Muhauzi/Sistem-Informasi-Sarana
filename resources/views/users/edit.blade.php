<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit User') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    {{-- Header Form --}}
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                            Form Edit User
                        </h2>
                        <a href="{{ route('users.index') }}"
                            class="inline-flex items-center px-4 py-2 bg-gray-400 text-white text-xs font-semibold rounded-md uppercase tracking-widest hover:bg-gray-500 transition">
                            Kembali
                        </a>
                    </div>

                    {{-- Form Edit Data --}}
                    <form method="POST" action="{{ route('users.update', $user->id) }}" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nama</label>
                            <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white"
                                placeholder="Nama User">
                            @error('name')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Email</label>
                            <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white"
                                placeholder="Email User">
                            @error('email')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Password (Kosongkan jika tidak ingin mengubah)
                            </label>
                            <div class="relative">
                                <input type="password" name="password" id="password"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white pr-10"
                                    placeholder="Password User">
                                <button type="button" tabindex="-1" onclick="togglePassword()" class="absolute inset-y-0 right-0 px-3 flex items-center text-gray-500 dark:text-gray-300 focus:outline-none">
                                    <svg id="eyeIcon" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </button>
                            </div>
                            @error('password')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <script>
                            function togglePassword() {
                                const pwd = document.getElementById('password');
                                const eye = document.getElementById('eyeIcon');
                                if (pwd.type === 'password') {
                                    pwd.type = 'text';
                                    eye.innerHTML = `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a9.956 9.956 0 012.293-3.95m1.414-1.414A9.956 9.956 0 0112 5c4.478 0 8.268 2.943 9.542 7a9.965 9.965 0 01-4.293 5.95M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3l18 18" />`;
                                } else {
                                    pwd.type = 'password';
                                    eye.innerHTML = `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />`;
                                }
                            }
                        </script>

                        <div>
                            <label for="role" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Role</label>
                            <select name="role" id="role" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white">
                                <option value="">Pilih Role</option>
                                <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Admin</option>
                                <option value="pengelola" {{ old('role', $user->role) == 'pengelola' ? 'selected' : '' }}>Pengelola</option>
                                <option value="pegawai" {{ old('role', $user->role) == 'pegawai' ? 'selected' : '' }}>Pegawai</option>
                            </select>
                            @error('role')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="division_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Divisi</label>
                            <select name="division_id" id="division_id" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white">
                                <option value="">Pilih Divisi</option>
                                @foreach($divisions as $division)
                                    <option value="{{ $division->id }}" {{ old('division_id', $user->division_id) == $division->id ? 'selected' : '' }}>
                                        {{ $division->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('division_id')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex items-center justify-end space-x-4">
                            <a href="{{ route('users.index') }}" class="px-4 py-2 bg-red-600 text-white text-sm font-semibold rounded-md shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                Batal
                            </a>
                            <button type="submit"
                                class="px-4 py-2 bg-gray-800 ms-2 text-white text-sm font-semibold rounded-md shadow-sm hover:bg-gray-900 hover:text-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-black transition">
                                Update User
                            </button>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
