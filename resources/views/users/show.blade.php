<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Detail User') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    {{-- Header --}}
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                            Detail User
                        </h2>
                        <a href="{{ route('users.index') }}"
                            class="inline-flex items-center px-4 py-2 bg-gray-400 text-white text-xs font-semibold rounded-md uppercase tracking-widest hover:bg-gray-500 transition">
                            Kembali
                        </a>
                    </div>

                    {{-- Detail Section --}}
                    <div class="space-y-4">
                        <div class="flex">
                            <span class="w-40 font-medium text-gray-700 dark:text-gray-300">Nama</span>
                            <span class="ml-2">: {{ $user->name }}</span>
                        </div>
                        <div class="flex">
                            <span class="w-40 font-medium text-gray-700 dark:text-gray-300">Email</span>
                            <span class="ml-2">: {{ $user->email }}</span>
                        </div>
                        <div class="flex">
                            <span class="w-40 font-medium text-gray-700 dark:text-gray-300">Role</span>
                            <span class="ml-2">: {{ ucfirst($user->role) ?? '-' }}</span>
                        </div>
                        <div class="flex">
                            <span class="w-40 font-medium text-gray-700 dark:text-gray-300">Role</span>
                            <span class="ml-2">: {{ $user->division->name ?? '-' }}</span>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
