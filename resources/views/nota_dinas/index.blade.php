<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800 leading-tight">Daftar Nota Dinas</h2>
    </x-slot>

    <div class="py-6 mx-2 sm:px-2">
        <div class="max-w-8xl mx-auto sm:px-6 lg:px-6">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-lg sm:text-xl font-semibold text-gray-800">Nota Dinas</h2>
                    
                    @if (auth()->user()->role === 'skpd')
                        <button onclick="openCreateModal()"
                            class="inline-flex items-center px-3 sm:px-4 py-2 bg-indigo-500 text-white text-sm sm:text-base font-medium rounded hover:bg-indigo-700">
                            + Tambah Nota
                        </button>
                    @endif
                </div>
                @if ($errors->any())
                    <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-600 rounded">
                        <ul class="list-disc list-inside mt-2 text-sm">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                @if (session('error'))
                    <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-600 rounded">
                        <p>{{ session('error') }}</p>
                    </div>
                @endif
                <div class="overflow-x-auto">
                    <table class="table-auto w-full">
                        <thead>
                            <tr class="bg-gray-300 text-left">
                                <th class="px-3 py-2">Nomor</th>
                                <th class="px-3 py-2">Perihal</th>
                                <th class="px-3 py-2">Posisi</th>
                                <th class="px-3 py-2">Tanggal</th>
                                <th class="px-3 py-2">Status</th>
                                <th class="px-3 py-2"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($notas as $nota)
                                <tr class="hover:bg-red-50 transition even:bg-gray-100">
                                    <td class="px-3 py-2">{{ $nota->nomor_nota }}</td>
                                    <td class="px-3 py-2">{{ $nota->perihal }}</td>
                                    <td class="px-3 py-2"><span class="px-2 py-1 text-sm font-semibold rounded-full transition bg-cyan-400 text-white hover:bg-cyan-600">{{ $nota->tahap_saat_ini }}</span></td>
                                    <td class="px-3 py-2">{{ \Carbon\Carbon::parse($nota->tanggal_pengajuan)->format('d-m-Y') }}</td>
                                    <td class="px-3 py-2">
                                        <span class="
                                            px-3 py-1 text-sm font-semibold rounded-full transition 
                                            {{ $nota->status == 'draft' ? 'bg-gray-500 text-white hover:bg-gray-600' : '' }}
                                            {{ $nota->status == 'proses' ? 'bg-blue-500 text-white hover:bg-blue-600' : '' }}
                                            {{ $nota->status == 'disetujui' ? 'bg-green-500 text-white hover:bg-green-600' : '' }}
                                            {{ $nota->status == 'ditolak' ? 'bg-red-500 text-white hover:bg-red-600' : '' }}
                                            {{ $nota->status == 'dikembalikan' ? 'bg-yellow-500 text-white hover:bg-yellow-600' : '' }}
                                        ">
                                            {{ ucfirst($nota->status) }}
                                        </span>
                                    </td>
                                    <td class="px-3 py-4 flex gap-2">
                                        @if (auth()->user()->role === 'skpd' && in_array($nota->status, ['draft', 'dikembalikan']))
                                            <button onclick="openEditModal({{ $nota->id }}, '{{ $nota->nomor_nota }}', '{{ $nota->perihal }}', '{{ $nota->anggaran }}', '{{ $nota->tanggal_pengajuan }}')"
                                                class="px-2 py-1 text-xs sm:text-sm font-semibold rounded border transition border-blue-500 text-blue-400 hover:bg-blue-100">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <form action="{{ route('nota-dinas.destroy', $nota) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="px-2 py-1 text-xs sm:text-sm font-semibold rounded border transition border-red-500 text-red-500 hover:bg-red-100">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                            <button onclick="openSendModal({{ $nota->id }})"
                                                class="px-2 py-1 text-xs sm:text-sm font-semibold rounded border transition border-green-500 text-green-600 hover:bg-green-100">
                                                <i class="fas fa-paper-plane"></i>
                                            </button>
                                        @endif

                                        @if (
                                            (auth()->user()->role === 'asisten' && $nota->tahap_saat_ini === 'asisten') ||
                                            (auth()->user()->role === 'sekda' && $nota->tahap_saat_ini === 'sekda')
                                        )
                                            <button onclick="openSendModal({{ $nota->id }})"
                                                class="px-2 py-1 text-xs sm:text-sm font-semibold rounded border transition border-green-500 text-green-600 hover:bg-green-100">
                                                <i class="fas fa-paper-plane"></i>
                                            </button>
                                            <button onclick="openReturnModal({{ $nota->id }})"
                                                class="px-2 py-1 text-xs sm:text-sm font-semibold rounded border transition border-red-500 text-red-600 hover:bg-red-100">
                                                <i class="fas fa-undo"></i>
                                            </button>
                                        @elseif (auth()->user()->role === 'bupati' && $nota->tahap_saat_ini === 'bupati')
                                            <button onclick="openReturnModal({{ $nota->id }})"
                                                class="px-2 py-1 text-xs sm:text-sm font-semibold rounded border transition border-red-500 text-red-600 hover:bg-red-100">
                                                <i class="fas fa-undo"></i>
                                            </button>
                                            <button onclick="openApprovalModal()"
                                                class="px-3 py-1 text-sm font-semibold rounded border transition border-blue-500 text-gray-600 hover:bg-blue-200">
                                                <i class="fas fa-check text-green-500"></i> or <i class="fas fa-x text-red-500"></i>
                                            </button>
                                        @endif
                                        <button onclick="openLampiranModal({{ $nota->id }})" 
                                            class="px-2 py-1 text-xs sm:text-sm font-semibold rounded border transition border-gray-500 text-gray-600 hover:bg-gray-200">
                                            <i class="fas fa-paperclip"></i>
                                        </button>
                                        <a href="{{ route('nota.pengiriman.history', $nota->id) }}" 
                                            class="px-3 py-1 text-xs sm:text-sm font-semibold rounded border transition border-yellow-500 text-yellow-400 hover:bg-yellow-100">
                                            Histori
                                        </a>
                                        </td>
                                </tr>
                            @empty
                                <tr class="hover:bg-red-100 transition">
                                    <td colspan="6" class="px-3 py-2 text-center">Belum ada nota dinas</td>
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

    @if (auth()->user()->role === 'skpd')
        @include('components.tambah-nota-dinas')
    @endif
    @if (auth()->user()->role === 'bupati' && $notas->isNotEmpty())
        @include('components.modal-persetujuan')
    @endif
    @include('components.modal-kirim-nota')
    @include('components.modal-pengembalian')
    @include('components.modal-lampiran')

    <script>
        function openCreateModal() {
            document.getElementById('modalTitle').innerText = 'Tambah Nota Dinas';
            document.getElementById('notaForm').action = '{{ route('nota-dinas.store') }}';
            document.getElementById('nomorNotaField').value = '';
            document.getElementById('perihalField').value = '';
            document.getElementById('anggaranField').value = '';
            document.getElementById('tanggalField').value = '';
            document.getElementById('notaModal').classList.remove('hidden');
            document.getElementById('notaModal').classList.add('flex');
        }

        function openEditModal(id, nomor, perihal, anggaran, tanggal) {
            const editUrl = `{{ url('nota-dinas') }}/${id}`;
            document.getElementById('modalTitle').innerText = 'Edit Nota Dinas';
            document.getElementById('notaForm').action = editUrl;
            document.getElementById('methodField').value = 'PUT';
            document.getElementById('notaId').value = id;
            document.getElementById('nomorNotaField').value = nomor;
            document.getElementById('perihalField').value = perihal;
            document.getElementById('anggaranField').value = anggaran;
            document.getElementById('tanggalField').value = tanggal;
            document.getElementById('notaModal').classList.remove('hidden');
            document.getElementById('notaModal').classList.add('flex');
        }

        function closeModal() {
            document.getElementById('notaModal').classList.add('hidden');
            document.getElementById('notaModal').classList.remove('flex');
            document.getElementById('notaForm').reset();
        }

        function openSendModal(notaId) {
            document.getElementById('sendForm').action = `/nota-dinas/${notaId}/kirim`;
            document.getElementById('sendModal').classList.remove('hidden');
            document.getElementById('sendModal').classList.add('flex');
        }

        function closeSendModal() {
            document.getElementById('sendModal').classList.add('hidden');
            document.getElementById('sendModal').classList.remove('flex');
        }

        function openReturnModal(notaId) {
            document.getElementById('returnForm').action = `/nota-dinas/${notaId}/kembalikan`;
            document.getElementById('notaReturnId').value = notaId;
            document.getElementById('returnModal').classList.remove('hidden');
            document.getElementById('returnModal').classList.add('flex');
        }

        function closeReturnModal() {
            document.getElementById('returnModal').classList.add('hidden');
            document.getElementById('returnModal').classList.remove('flex');
        }

        function openApprovalModal(){
            document.getElementById('approvalModal').classList.remove('hidden');
            document.getElementById('approvalModal').classList.add('flex');
        }

        function closeApprovalModal() {
            document.getElementById('approvalModal').classList.add('hidden');
            document.getElementById('approvalModal').classList.remove('flex');
        }
    </script>
</x-app-layout>
