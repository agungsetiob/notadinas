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

        fetch(`/nota/lampiran/${id}`)
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
