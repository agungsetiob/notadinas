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
    function openLampiranModal(id) {
        const modal = document.getElementById('lampiranModal');
        const list = document.getElementById('lampiranList');
        list.innerHTML = '<li>Loading...</li>';
        modal.classList.remove('hidden');
        modal.classList.add('flex');

        fetch(`/nota/lampiran/${id}`)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(result => {
                if (result.success && result.data.length > 0) {
                    list.innerHTML = result.data.map(file => 
                        `<li class="mb-2">
                            <a href="${file.url}" target="_blank" class="text-blue-600 hover:underline">${file.name}</a>
                            <span class="text-gray-500 text-xs">(${new Date(file.created_at).toLocaleString()})</span>
                        </li>`
                    ).join('');
                } else {
                    list.innerHTML = '<li class="text-gray-500">Tidak ada lampiran.</li>';
                }
            })
            .catch(error => {
                console.error('Error:', error);
                list.innerHTML = '<li class="text-red-500">Gagal memuat lampiran.</li>';
            });
    }

    function closeLampiranModal() {
        document.getElementById('lampiranModal').classList.add('hidden');
        document.getElementById('lampiranModal').classList.remove('flex');
    }
</script>