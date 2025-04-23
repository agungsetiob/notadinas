<!-- Modal -->
    <div id="notaModal" class="fixed z-50 inset-0 bg-gray-800 bg-opacity-50 hidden justify-center items-center">
        <div class="bg-white p-4 sm:p-6 rounded-lg w-11/12 sm:w-full max-w-5xl">
            <h3 id="modalTitle" class="text-lg font-semibold mb-4">Tambah Nota Dinas</h3>
            <form id="notaForm" method="POST" action="{{ route('nota-dinas.store') }}" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="_method" id="methodField" value="POST"> 
                <input type="hidden" name="id" id="notaId">
                <div class="mb-4">
                    <label for="nomor_nota" class="block text-sm font-medium text-gray-700">Nomor Nota</label>
                    <input type="text" name="nomor_nota" id="nomorNotaField" required
                        class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 text-sm sm:text-base">
                </div>

                <div class="mb-4">
                    <label for="perihal" class="block text-sm font-medium text-gray-700">Perihal</label>
                    <input type="text" name="perihal" id="perihalField" required
                        class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 text-sm sm:text-base">
                </div>

                <div class="mb-4">
                    <label for="anggaran" class="block text-sm font-medium text-gray-700">Anggaran</label>
                    <input type="text" name="anggaran" id="anggaranField" required
                        class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 text-sm sm:text-base">
                </div>

                <div class="mb-4">
                    <label for="tanggal_pengajuan" class="block text-sm font-medium text-gray-700">Tanggal Pengajuan</label>
                    <input type="date" name="tanggal_pengajuan" id="tanggalField" required
                        class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 text-sm sm:text-base">
                </div>

                {{--<div class="mb-4">
                    <label for="lampiran" class="block text-sm font-medium text-gray-700 mb-1">Lampiran (opsional)</label>
                    <input type="file" name="lampiran[]" id="lampiran" multiple
                        class="block w-full text-sm text-gray-700 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                </div>--}}

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