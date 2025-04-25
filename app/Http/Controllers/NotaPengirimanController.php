<?php

namespace App\Http\Controllers;

use App\Models\NotaDinas;
use App\Models\NotaPengiriman;
use App\Models\NotaPersetujuan;
use App\Models\NotaLampiran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotaPengirimanController extends Controller
{
    public function store(Request $request, $notaId)
    {
        $nota = NotaDinas::findOrFail($notaId);
        $pengirim = Auth::user();

        $request->validate([
            'catatan'       => 'nullable|string|max:500',
            'lampiran.*'    => 'nullable|file|max:4096',
            'dikirim_ke'    => 'nullable|in:asisten,sekda,bupati,skpd',
        ]);

        // Tentukan tujuan pengiriman berdasarkan tahap nota saat ini
        $dari = $nota->tahap_saat_ini;
        if ($dari === 'skpd') {
            $ke = 'asisten';
        } elseif ($dari === 'asisten') {
            $ke = 'sekda';
        } elseif ($dari === 'sekda') {
            $ke = 'bupati';
        } else {
            $ke = $request->dikirim_ke ?? abort(400, 'Tujuan pengiriman tidak valid.');
        }

        // Buat data pengiriman baru
        $pengiriman = NotaPengiriman::create([
            'nota_dinas_id' => $nota->id,
            'dikirim_dari'  => $dari,
            'dikirim_ke'    => $ke,
            'pengirim_id'   => $pengirim->id,
            'catatan'       => $request->catatan,
        ]);

        // Kumpulan array untuk menyimpan id lampiran yang akan dipasang di pivot
        $lampiranIds = [];

        if ($request->hasFile('lampiran')) {
            // Jika ada lampiran baru, simpan tiap file dan simpan record NotaLampiran baru
            foreach ($request->file('lampiran') as $file) {
                $path = $file->store('lampiran_nota', 'public');

                $lampiran = NotaLampiran::create([
                    'nota_dinas_id' => $nota->id,
                    'nama_file'     => $file->getClientOriginalName(),
                    'path'          => $path,
                ]);

                $lampiranIds[] = $lampiran->id;
            }
        } else {
            // Jika tidak ada lampiran baru, ambil lampiran dari pengiriman terakhir sebelum pengiriman baru
            $prevPengiriman = NotaPengiriman::where('nota_dinas_id', $nota->id)
                ->where('id', '<', $pengiriman->id)
                ->orderBy('created_at', 'desc')
                ->first();

            if ($prevPengiriman) {
                $lampiranIds = $prevPengiriman->lampirans()->pluck('nota_lampirans.id')->toArray();
            }
        }

        // Jika ada lampiran (baik baru maupun dari pengiriman sebelumnya), attach ke pengiriman via tabel pivot
        if (!empty($lampiranIds)) {
            $pengiriman->lampirans()->attach($lampiranIds);
        }

        // Jika pengirim memiliki role asisten/sekda, catat persetujuan
        if (in_array($pengirim->role, ['asisten', 'sekda'])) {
            NotaPersetujuan::create([
                'nota_dinas_id'    => $nota->id,
                'approver_id'      => $pengirim->id,
                'skpd_id'          => $nota->skpd_id,
                'role_approver'    => $pengirim->role,
                'urutan'           => $pengirim->role === 'asisten' ? 1 : 2,
                'status'           => 'disetujui',
                'catatan_terakhir' => $request->catatan,
                'tanggal_update'   => now(),
            ]);
        }

        // Perbarui status dan tahap nota
        $nota->update([
            'tahap_saat_ini' => $ke,
            'status'         => 'proses',
        ]);

        return redirect()
            ->back()
            ->with('success', "Nota berhasil dikirim ke " . ucfirst($ke) . " dan dicatat sebagai persetujuan.");
    }    

    public function history($id)
    {
        $nota = NotaDinas::findOrFail($id);
        $pengiriman = $nota->pengirimans()->with(['pengirim'])->latest('tanggal_kirim')->get();
        //$historiPersetujuans = $nota->persetujuanHistories()->with('approver')->orderBy('urutan')->get();

        return view('nota_dinas.histori_pengiriman', compact('nota', 'pengiriman'));
    }
    public function returnNota(Request $request)
    {
        if (!in_array(auth()->user()->role, ['asisten', 'sekda', 'bupati'])) {
            return abort(403, 'Akses tidak diizinkan');
        }

        $request->validate([
            'catatan' => 'required|string|max:500',
            'nota_dinas_id' => 'required|exists:nota_dinas,id'
        ]);

        $notaDinas = NotaDinas::findOrFail($request->nota_dinas_id);

        NotaPengiriman::create([
            'nota_dinas_id' => $notaDinas->id,
            'dikirim_dari' => auth()->user()->role,
            'dikirim_ke' => 'skpd',
            'pengirim_id' => auth()->user()->id,
            'tanggal_kirim' => now(),
            'catatan' => $request->catatan,
        ]);

        $notaDinas->update([
            'status' => 'dikembalikan',
            'tahap_saat_ini' => 'skpd',
        ]);

        return redirect()->route('nota-dinas.index')->with('success', 'Nota telah dikembalikan ke SKPD.');
    }
}
