<x-app-layout>
    <x-slot name="header"></x-slot>

    <div class="py-6 mx-2 sm:px-2">
        <div class="max-w-8xl mx-auto sm:px-6 lg:px-6">
            <!-- <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <p class="text-lg font-semibold">Selamat datang, {{ Auth::user()->name }}!</p>
            </div> -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mt-2">
                <!-- Jumlah User -->
                <div class="bg-gray-100 rounded-lg p-6 flex flex-col items-center shadow-md">
                    <i class="fas fa-users text-3xl text-orange-500"></i>
                    <p class="text-lg font-medium mt-2">Akun</p>
                    <p class="text-2xl font-bold">{{ $totalUsers }}</p>
                </div>

                <!-- Jumlah SKPD -->
                <div class="bg-gray-100 rounded-lg p-6 flex flex-col items-center shadow-md">
                    <i class="fas fa-building text-3xl text-red-700"></i>
                    <p class="text-lg font-medium mt-2">SKPD</p>
                    <p class="text-2xl font-bold">{{ $totalSkpds }}</p>
                </div>

                <div class="bg-gray-100 rounded-lg p-6 flex flex-col items-center shadow-md">
                    <i class="fas fa-file-zipper text-3xl text-indigo-600"></i>
                    <p class="text-lg font-medium mt-2">Nota Dinas</p>
                    <p class="text-2xl font-bold">{{ $notaDinas }}</p>
                </div>

                <div class="bg-gray-100 rounded-lg p-6 flex flex-col items-center shadow-md">
                    <i class="fas fa-square-check text-3xl text-green-700"></i>
                    <p class="text-lg font-medium mt-2">Selesai</p>
                    <p class="text-2xl font-bold">{{ $notaSelesai }}</p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
