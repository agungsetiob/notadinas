<div id="approvalModal" class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-50 hidden">
    <div class="bg-white rounded-lg p-5 w-full max-w-xl">
        <h2 class="text-lg font-semibold text-gray-700 mb-4">Konfirmasi Persetujuan</h2>
        <form action="{{ route('nota-dinas.approval', $nota->id) }}" method="POST">
            @csrf
            @method('PATCH')

            <div class="mb-4">
                <label class="block font-medium mb-1">Catatan</label>
                <textarea name="catatan" rows="3"
                    class="w-full border-gray-300 rounded-md shadow-sm px-3 py-2"></textarea>
            </div>

            <div class="flex justify-end gap-3 mt-4">
                <button type="submit" name="status" value="disetujui"
                    class="px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600">
                    Setujui
                </button>
                <button type="submit" name="status" value="ditolak"
                    class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600">
                    Tolak
                </button>
                <button type="button" onclick="closeApprovalModal()"
                    class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600">
                    Batal
                </button>
            </div>
        </form>
    </div>
</div>
<script>
    function openApprovalModal(){
        document.getElementById('approvalModal').classList.remove('hidden');
        document.getElementById('approvalModal').classList.add('flex');
    }
    function closeApprovalModal() {
        document.getElementById('approvalModal').classList.add('hidden');
        document.getElementById('approvalModal').classList.remove('flex');
    }
</script>