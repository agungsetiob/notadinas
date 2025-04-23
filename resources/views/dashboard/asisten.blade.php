<x-app-layout>
    <x-slot name="header"></x-slot>

    <div class="py-6 mx-2 sm:px-2">
        <div class="max-w-8xl mx-auto sm:px-6 lg:px-6">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <p>Selamat datang, {{ Auth::user()->name }}</p>
            </div>
        </div>
    </div>
</x-app-layout>
