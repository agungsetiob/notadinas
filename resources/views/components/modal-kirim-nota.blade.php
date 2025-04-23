<div id="sendModal" class="fixed inset-0 bg-gray-800 bg-opacity-50 hidden justify-center items-center z-50">
    <div class="bg-white rounded-lg shadow-xl w-11/12 max-w-3xl p-6 relative">
        <h2 class="text-lg font-bold mb-4">Kirim Nota</h2>

        <form id="sendForm" method="POST" action="" enctype="multipart/form-data">
            @csrf

            @if (Auth::user()->role === 'skpd')
                <p class="mb-4 text-sm text-gray-600">Akan dikirim otomatis ke Asisten terkait SKPD.</p>
            @elseif (Auth::user()->role === 'asisten')
                <p class="mb-4 text-sm text-gray-600">Akan dikirim otomatis ke Sekda.</p>
            @elseif (Auth::user()->role === 'sekda')
                <p class="mb-4 text-sm text-gray-600">Akan dikirim otomatis ke Bupati.</p>
            @endif

            <div class="mb-4">
                <label class="block font-medium mb-1">Catatan</label>
                <textarea name="catatan" rows="3"
                    class="w-full border-gray-300 rounded-md shadow-sm px-3 py-2"></textarea>
            </div>

            {{-- @if (Auth::user()->role === 'skpd') --}}
                <div class="mb-4">
                    <label for="lampiran" class="block text-sm font-medium text-gray-700 mb-1">Lampiran bisa lebih dari 1 (opsional)</label>
                    <input type="file" accept="application/pdf" name="lampiran[]" id="lampiran" multiple class="block w-full text-sm text-gray-700
                                        file:mr-4 file:py-2 file:px-4
                                        file:rounded-full file:border-0
                                        file:text-sm file:font-semibold
                                        file:bg-indigo-50 file:text-indigo-700
                                        hover:file:bg-indigo-100">
                </div>
            {{--@endif--}}

            <div class="flex justify-end gap-2">
                <button type="button" onclick="closeSendModal()"
                    class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">Batal</button>
                <button type="submit" id="sendButton"
                    class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">Kirim</button>
            </div>
        </form>
    </div>
</div>