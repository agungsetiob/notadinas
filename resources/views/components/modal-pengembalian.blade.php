<div id="returnModal" class="fixed inset-0 bg-gray-800 bg-opacity-50 hidden justify-center items-center z-50">
    <div class="bg-white rounded-lg shadow-xl w-11/12 max-w-3xl p-6 relative">
        <h2 class="text-lg font-bold mb-4">Kembalikan Nota Dinas</h2>

        <form id="returnForm" method="POST" action="">
            @csrf
            <input type="hidden" id="notaReturnId" name="nota_dinas_id">

            <div class="mb-4">
                <label class="block font-medium mb-1">Alasan Pengembalian</label>
                <textarea name="catatan" rows="3" required
                    class="w-full border-gray-300 rounded-md shadow-sm px-3 py-2"></textarea>
            </div>

            <div class="flex justify-end gap-2">
                <button type="button" onclick="closeReturnModal()"
                    class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">Batal</button>
                <button type="submit"
                    class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">Kembalikan</button>
            </div>
        </form>
    </div>
</div>
<script>    
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
</script>