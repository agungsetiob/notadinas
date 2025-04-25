<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800 leading-tight">
            {{ __('Histori Nota Dinas') }}
        </h2>
    </x-slot>

    <div class="py-6 mx-2 sm:px-2">
        <div class="max-w-8xl mx-auto sm:px-6 lg:px-6">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                
                <div class="mb-6">
                    <h3 class="text-lg font-semibold text-gray-700">Perihal:</h3>
                    <p class="text-gray-900 text-base mt-1">{{ $nota->perihal }}</p>
                </div>

                <div class="overflow-x-auto">
                    <table class="table-auto w-full text-sm">
                        <thead>
                            <tr class="bg-gray-200 text-left">
                                <th class="px-4 py-2 border">Tanggal</th>
                                <th class="px-4 py-2 border">Jenis</th>
                                <th class="px-4 py-2 border">Dari / Oleh</th>
                                <th class="px-4 py-2 border">Ke</th>
                                <th class="px-4 py-2 border">Catatan</th>
                                <th class="px-4 py-2 border">Lampiran</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pengiriman as $item)
                                <tr class="even:bg-gray-100 hover:bg-gray-50 transition">
                                    <td class="px-4 py-2">{{ \Carbon\Carbon::parse($item->tanggal_kirim)->format('d M Y H:i') }}</td>
                                    <td class="px-4 py-2">Pengiriman</td>
                                    <td class="px-4 py-2 capitalize">{{ $item->dikirim_dari }} - {{ $item->pengirim->name ?? '-' }}</td>
                                    <td class="px-4 py-2 capitalize">{{ $item->dikirim_ke }}</td>
                                    <td class="px-4 py-2">{{ $item->catatan ?? '-' }}</td>
                                    <td class="px-4 py-2">
                                        <button onclick="openLampiranModal({{ $item->id }}, 'pengiriman')" class="px-3 py-1 text-xs sm:text-sm font-semibold rounded border transition border-gray-500 text-blue-400 hover:bg-yellow-200">Lihat</button>
                                    </td>
                                </tr>
                            @endforeach

                            {{--@foreach ($historiPersetujuans as $item)
                                <tr class="even:bg-gray-100 hover:bg-gray-50 transition">
                                    <td class="px-4 py-2">{{ \Carbon\Carbon::parse($item->waktu_catatan)->format('d M Y H:i') }}</td>
                                    <td class="px-4 py-2">Persetujuan</td>
                                    <td class="px-4 py-2">{{ $item->approver->name ?? '-' }}</td>
                                    <td class="px-4 py-2 capitalize">{{ $item->status }}</td>
                                    <td class="px-4 py-2">{{ $item->catatan ?? '-' }}</td>
                                    <td class="px-4 py-2">
                                        <button onclick="openLampiranModal({{ $item->id }}, 'persetujuan')" 
                                        class="px-3 py-1 text-xs sm:text-sm font-semibold rounded border transition border-gray-500 text-blue-400 hover:bg-yellow-200">Lihat</button>
                                    </td>
                                </tr>
                            @endforeach--}}

                            @if ($pengiriman->isEmpty())
                                <tr>
                                    <td colspan="6" class="text-center py-4 text-gray-500">
                                        Belum ada histori.
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>

                <div class="mt-6">
                    <a href="{{ url()->previous() }}" class="text-blue-600 hover:underline text-sm">← Kembali</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Lampiran -->
    <div id="lampiranModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
        <div class="bg-white rounded-lg shadow-xl w-11/12 max-w-3xl p-6 relative">
            <h3 class="text-lg font-semibold mb-4">Daftar Lampiran</h3>
            <ul id="lampiranList" class="list-disc pl-5 text-sm text-gray-700">
                <li>Loading...</li>
            </ul>
            <div class="mt-4 text-right">
                <button onclick="closeLampiranModal()" class="px-4 py-2 bg-gray-300 text-gray-700 rounded hover:bg-gray-400">
                    Tutup
                </button>
            </div>
        </div>
    </div>

    <script>
        function openLampiranModal(id, tipe) {
            const modal = document.getElementById('lampiranModal');
            const list = document.getElementById('lampiranList');
            list.innerHTML = '<li>Loading...</li>';
            modal.classList.remove('hidden');
            modal.classList.add('flex');

            fetch(`/nota/lampiran/${tipe}/${id}`)
                .then(res => res.json())
                .then(data => {
                    if (data.length > 0) {
                        list.innerHTML = data.map(file => 
                            `<li>
                            <a href="${file.url}" target="_blank" class="text-blue-600 hover:underline">${file.name}</a>
                            <span class="text-gray-500 text-xs">(${new Date(file.created_at).toLocaleString()})</span>
                            </li>`
                        ).join('');
                    } else {
                        list.innerHTML = '<li>Tidak ada lampiran.</li>';
                    }
                });
        }

        function closeLampiranModal() {
            const modal = document.getElementById('lampiranModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }
    </script>
</x-app-layout>
