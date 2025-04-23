<x-app-layout>
    <x-slot name="header"></x-slot>

    <div class="py-6 mx-2 sm:px-2">
        <div class="max-w-8xl mx-auto sm:px-6 lg:px-6">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-xl font-semibold text-gray-800">{{ __('Daftar Pengguna') }}</h2>
                    <a href="{{ route('register') }}"
                    class="inline-flex items-center px-3 sm:px-4 py-2 bg-indigo-500 text-white text-sm sm:text-base font-medium rounded hover:bg-indigo-700">
                        + Tambah Pengguna
                    </a>
                </div>
                <div class="overflow-x-auto">
                    <table class="table-auto w-full">
                        <thead>
                            <tr class="bg-gray-300 text-left">
                                <th class="px-4 py-2">Nama</th>
                                <th class="px-4 py-2">Email</th>
                                <th class="px-4 py-2">SKPD</th>
                                <th class="px-4 py-2">Role</th>
                                <th class="px-4 py-2">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($users as $user)
                                <tr class="hover:bg-red-50 transition even:bg-gray-100">
                                    <td class="px-4 py-2">{{ $user->name }}</td>
                                    <td class="px-4 py-2">{{ $user->email }}</td>
                                    <td class="px-4 py-2">{{ $user->skpd->nama_skpd ?? '-' }}</td>
                                    <td class="px-4 py-2">{{ ucfirst($user->role) }}</td>
                                    <td class="px-4 py-2">
                                        <form action="{{ route('users.toggle-status', $user) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit"
                                                class="px-2 py-1 text-sm font-semibold rounded-full border transition 
                                                    {{ $user->status ? 'border-green-500 text-green-500 w-24 hover:bg-green-100' : 'border-red-500 text-red-500 w-32 hover:bg-red-100' }}">
                                                {{ $user->status ? 'Aktif' : 'Nonaktif' }}
                                            </button>
                                            <input type="hidden" name="status" value="{{ $user->status ? 0 : 1 }}">
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-4 py-2 text-center">Belum ada pengguna</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="mt-4">
                    {{ $users->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>