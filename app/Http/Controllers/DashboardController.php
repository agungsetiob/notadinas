<?php

namespace App\Http\Controllers;

use App\Models\NotaDinas;
use App\Models\User;
use App\Models\Skpd;

class DashboardController extends Controller
{
    public function index()
    {
        $role = auth()->user()->role;
        $totalUsers = User::count();
        $totalSkpds = Skpd::count();
        $notaDinas = NotaDinas::count();
        $notaSelesai = NotaDinas::where('tahap_saat_ini', 'selesai')->count();

        return match ($role) {
            'admin' => view('dashboard.admin', compact('totalUsers', 'totalSkpds', 'notaDinas', 'notaSelesai')),
            'skpd' => view('dashboard.skpd'),
            'asisten' => view('dashboard.asisten'),
            'sekda' => view('dashboard.sekda'),
            'bupati' => view('dashboard.bupati'),
            default => abort(403),
        };
    }
}

