<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800 leading-tight">Daftar Nota Dinas</h2>
    </x-slot>

    <div class="py-6 mx-2 sm:px-2">
        <div class="max-w-8xl mx-auto sm:px-6 lg:px-6">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-lg sm:text-xl font-semibold text-gray-800">List Persetujuan Nota Dinas</h2>
                </div>

                @if (session('error'))
                    <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-600 rounded">
                        <p>{{ session('error') }}</p>
                    </div>
                @endif

                <div class="overflow-x-auto">
                    <table class="table-auto w-full">
                        <thead>
                            <tr class="bg-gray-300 text-left">
                                <th class="px-4 py-2">Nomor</th>
                                <th class="px-4 py-2">Perihal</th>
                                <th class="px-4 py-2">Tahapan</th>
                                <th class="px-4 py-2">Tanggal</th>
                                <th class="px-4 py-2">Status</th>
                                <th class="px-4 py-2"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($notas as $nota)
                                <tr class="hover:bg-gray-100 transition">
                                    <td class="px-4 py-2">{{ $nota->nomor_nota }}</td>
                                    <td class="px-4 py-2">{{ $nota->perihal }}</td>
                                    <td class="px-4 py-2">
                                        <span class="px-2 py-1 text-sm font-semibold rounded-full bg-cyan-400 text-white">
                                            {{ $nota->tahap_saat_ini }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-2">{{ \Carbon\Carbon::parse($nota->tanggal_pengajuan)->format('d-m-Y') }}</td>
                                    <td class="px-4 py-2">
                                        <span class="px-3 py-1 text-sm font-semibold rounded-full
                                            {{ $nota->status == 'proses' ? 'bg-blue-500 text-white' : '' }}
                                            {{ $nota->status == 'disetujui' ? 'bg-green-500 text-white' : '' }}
                                            {{ $nota->status == 'ditolak' ? 'bg-red-500 text-white' : '' }}">
                                            {{ ucfirst($nota->status) }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-2 flex gap-2">
                                        <button onclick="openHistoriModal({{ $nota->id }})" 
                                            class="px-3 py-1 text-sm font-semibold rounded border border-yellow-500 text-yellow-400 hover:bg-yellow-100">
                                            Histori
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-4 py-2 text-center">Belum ada nota dinas disetujui</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    {{ $notas->links() }}
                </div>
            </div>
        </div>
    </div>
    @include('components.modal-histori-persetujuan')
</x-app-layout>
