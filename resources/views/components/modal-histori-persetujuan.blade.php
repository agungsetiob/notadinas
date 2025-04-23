<div id="modalHistoriPersetujuan" class="fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center hidden">
    <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-6xl">
        <div class="flex justify-between items-center border-b pb-3">
            <h2 class="text-lg font-semibold text-gray-800">Histori Persetujuan Nota Dinas</h2>
            <button onclick="closeHistoriModal()" class="text-gray-500 hover:text-gray-700 text-xl">&times;</button>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full table-auto text-left">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="px-4 py-2">Tanggal Update</th>
                        <th class="px-4 py-2">Persetujuan Oleh</th>
                        <th class="px-4 py-2">SKPD</th>
                        <th class="px-4 py-2">Status</th>
                        <th class="px-4 py-2">Catatan</th>
                    </tr>
                </thead>
                <tbody id="historiPersetujuanBody">
                    <tr>
                        <td colspan="5" class="px-4 py-2 text-center">Loading...</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
<script>
    function openHistoriModal(notaId) {
        document.getElementById('modalHistoriPersetujuan').classList.remove('hidden');

        fetch(`/api/histori-persetujuan/${notaId}`)
            .then(response => response.json())
            .then(data => {
                let historiBody = document.getElementById('historiPersetujuanBody');
                historiBody.innerHTML = '';

                if (data.success) {
                    if (data.data.length > 0) {
                        data.data.forEach(history => {
                            let row = `<tr class="hover:bg-gray-100 transition">
                                <td class="px-4 py-2">${new Date(history.tanggal_update).toLocaleString()}</td>
                                <td class="px-4 py-2">${history.approver.name} (${history.role_approver})</td>
                                <td class="px-4 py-2">${history.skpd.nama_skpd}</td>
                                <td class="px-4 py-2">
                                    <span class="px-3 py-1 text-sm font-semibold rounded-full
                                        ${history.status === 'disetujui' ? 'bg-green-500 text-white' : ''}
                                        ${history.status === 'ditolak' ? 'bg-red-500 text-white' : ''}">
                                        ${history.status.charAt(0).toUpperCase() + history.status.slice(1)}
                                    </span>
                                </td>
                                <td class="px-4 py-2">${history.catatan_terakhir || '-'}</td>
                            </tr>`;
                            historiBody.innerHTML += row;
                        });
                    } else {
                        historiBody.innerHTML = `<tr><td colspan="5" class="px-4 py-2 text-center">Tidak ada histori persetujuan.</td></tr>`;
                    }
                } else {
                    historiBody.innerHTML = `<tr><td colspan="5" class="px-4 py-2 text-center text-red-500">Terjadi kesalahan: ${data.message}</td></tr>`;
                }
            })
            .catch(error => {
                console.error('Error fetching data:', error);
                document.getElementById('historiPersetujuanBody').innerHTML =
                    `<tr><td colspan="5" class="px-4 py-2 text-center text-red-500">Gagal memuat data.</td></tr>`;
            });
    }

    function closeHistoriModal() {
        document.getElementById('modalHistoriPersetujuan').classList.add('hidden');
    }
</script>