<?php

namespace App\Http\Controllers;
use App\Models\Skpd;
use App\Models\User;

use Illuminate\Http\Request;

class SkpdController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $skpds = Skpd::paginate(10);
        $asistens = User::where('role', 'asisten')->where('status', 1)->get();
        return view('skpd.index', compact('skpds', 'asistens'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_skpd' => 'required|string|max:255',
            'asisten_id' => 'nullable|exists:users,id',
        ]);

        Skpd::create([
            'nama_skpd' => $request->nama_skpd,
            'status' => true,
            'asisten_id' => $request->asisten_id,
        ]);

        return redirect()->route('skpds.index')->with('success', 'SKPD berhasil ditambahkan.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Skpd $skpd)
    {
        $request->validate([
            'nama_skpd' => 'required|string|max:255',
            'asisten_id' => 'nullable|exists:users,id',
        ]);
    
        $skpd->update([
            'nama_skpd' => $request->nama_skpd,
            'asisten_id' => $request->asisten_id,
        ]);
    
        return redirect()->route('skpds.index')->with('success', 'SKPD berhasil diupdate.');
    }

    public function toggleStatus(Skpd $skpd)
    {
        $skpd->update(['status' => !$skpd->status]);
        return redirect()->back()->with('success', 'Status SKPD berhasil diubah.');
    }
}
