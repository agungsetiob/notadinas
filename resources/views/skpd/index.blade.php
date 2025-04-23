<x-app-layout>
    <x-slot name="header"></x-slot>

    <div class="py-6 mx-2 sm:px-2">
        <div class="max-w-8xl mx-auto sm:px-6 lg:px-6">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-lg sm:text-xl font-semibold text-gray-800">{{ __('Daftar SKPD') }}</h2>
                    <button onclick="openCreateModal()" 
                        class="inline-flex items-center px-3 sm:px-4 py-2 bg-indigo-500 text-white text-sm sm:text-base font-medium rounded hover:bg-indigo-700">
                        + Tambah SKPD
                    </button>
                </div>
                <div class="overflow-x-auto">
                    <table class="table-auto w-full">
                        <thead>
                            <tr class="bg-gray-300 text-left">
                                <th class="px-3 py-2 ">Nama SKPD</th>
                                <th class="px-3 py-2 ">Asisten</th>
                                <th class="px-3 py-2 ">Status</th>
                                <th class="px-3 py-2 "></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($skpds as $skpd)
                                <tr class="hover:bg-red-50 transition even:bg-gray-100">
                                    <td class="px-3 py-2 ">{{ $skpd->nama_skpd }}</td>
                                    <td class="px-3 py-2 ">
                                        {{ $skpd->asisten?->name ?? '-' }}
                                    </td>
                                    <td class="px-3 py-2 ">
                                        <form action="{{ route('skpds.toggle-status', $skpd) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit"
                                                class="px-2 py-1 text-xs sm:text-sm font-semibold rounded-full border transition 
                                                    {{ $skpd->status ? 'border-green-500 text-green-500 w-20 hover:bg-green-100' : 'border-red-500 text-red-500 w-28 hover:bg-red-100' }}">
                                                {{ $skpd->status ? 'Aktif' : 'Nonaktif' }}
                                            </button>
                                        </form>
                                    </td>
                                    <td class="px-3 py-2 flex gap-2">
                                        <button onclick="openEditModal({{ $skpd->id }}, '{{ $skpd->nama_skpd }}', {{ $skpd->asisten_id ?? 'null' }})"
                                            class="px-2 py-1 text-xs sm:text-sm font-semibold rounded border transition border-blue-500 text-blue-400 w-20 hover:bg-blue-100">
                                            Edit
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr class="hover:bg-red-100 transition">
                                    <td colspan="4" class="px-3 py-2 text-center">Belum ada SKPD</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                <div class="mt-4">
                    {{ $skpds->links() }}
                </div>
            </div>
        </div>
    </div>

    <!-- Modal-->
    <div id="skpdModal" class="fixed z-50 inset-0 bg-gray-800 bg-opacity-50 hidden justify-center items-center">
        <div class="bg-white p-4 sm:p-6 rounded-lg w-11/12 sm:w-full max-w-2xl">
            <h3 id="modalTitle" class="text-lg font-semibold mb-4">Tambah SKPD</h3>
            <form id="skpdForm" method="POST" action="{{ route('skpds.store') }}">
                @csrf
                <input type="hidden" name="_method" id="methodField" value="POST">
                <input type="hidden" name="id" id="skpdId">

                <div class="mb-4">
                    <label for="nama_skpd" class="block text-sm font-medium text-gray-700">Nama SKPD</label>
                    <input type="text" name="nama_skpd" id="namaSkpdField" required
                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm px-3 py-2 text-sm sm:text-base">
                </div>

                <div class="mb-4">
                    <label for="asisten_id" class="block text-sm font-medium text-gray-700">Asisten Penanggung Jawab</label>
                    <select name="asisten_id" id="asistenSelect"
                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm px-3 py-2 text-sm sm:text-base">
                        <option value="">-- Pilih Asisten --</option>
                        @foreach ($asistens as $asisten)
                            <option value="{{ $asisten->id }}">{{ $asisten->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="flex justify-end gap-2">
                    <button type="button" onclick="closeModal()" 
                        class="px-3 py-2 bg-gray-300 text-gray-700 text-sm sm:text-base rounded hover:bg-gray-400">
                        Batal
                    </button>
                    <button type="submit"
                        class="px-3 py-2 bg-indigo-600 text-white text-sm sm:text-base rounded hover:bg-indigo-700">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Script -->
    <script>
        function openCreateModal() {
            document.getElementById('modalTitle').innerText = 'Tambah SKPD';
            document.getElementById('skpdForm').action = '{{ route('skpds.store') }}';
            document.getElementById('methodField').value = 'POST';
            document.getElementById('skpdId').value = '';
            document.getElementById('namaSkpdField').value = '';
            document.getElementById('skpdModal').classList.remove('hidden');
            document.getElementById('skpdModal').classList.add('flex');
        }

        function openEditModal(id, nama, asistenId = null) {
            const editUrl = `{{ url('skpds') }}/${id}`;
            document.getElementById('modalTitle').innerText = 'Edit SKPD';
            document.getElementById('skpdForm').action = editUrl;
            document.getElementById('methodField').value = 'PUT';
            document.getElementById('skpdId').value = id;
            document.getElementById('namaSkpdField').value = nama;
            document.getElementById('asistenSelect').value = asistenId ?? '';
            document.getElementById('skpdModal').classList.remove('hidden');
            document.getElementById('skpdModal').classList.add('flex');
        }

        function closeModal() {
            document.getElementById('skpdModal').classList.add('hidden');
            document.getElementById('skpdModal').classList.remove('flex');
            document.getElementById('skpdId').value = '';
            document.getElementById('namaSkpdField').value = '';
            document.getElementById('asistenSelect').value = '';
        }
    </script>

</x-app-layout>
