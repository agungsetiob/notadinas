<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\NotaPersetujuan;
use App\Models\NotaDinas;

class NotaPersetujuanController extends Controller
{
    
    public function index()
    {
        $user = Auth::user();
    
        if ($user->role == 'skpd') {
            $notas = NotaDinas::whereHas('persetujuans')->where('skpd_id', $user->skpd_id)
                ->paginate(10);
        } elseif ($user->role == 'asisten') {
            $notas = NotaDinas::whereHas('persetujuans')->where('asisten_id', $user->id)
                ->paginate(10);
        } elseif ($user->role == 'sekda' || $user->role == 'bupati') {
            $notas = NotaDinas::whereHas('persetujuans')
                ->paginate(10);
        } elseif ($user->role == 'admin') {
            $notas = NotaDinas::whereHas('persetujuans')
                ->paginate(10);
        }
    
        return view('nota_dinas.approval', compact('notas'));
    }
    
    public function approvalHistories($notaId)
    {
        try {
            $nota = NotaDinas::findOrFail($notaId);
            $persetujuanHistories = $nota->persetujuans()->with(['skpd', 'approver'])->latest('tanggal_update')->get();

            return response()->json([
                'success' => true,
                'message' => 'Berhasil mendapat data persetujuan',
                'data' => $persetujuanHistories,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }
}
