<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Skpd;

class DashboardController extends Controller
{
    public function index()
    {
        $role = auth()->user()->role;
        $totalUsers = User::count();
        $totalSkpds = Skpd::count();

        return match ($role) {
            'admin' => view('dashboard.admin', compact('totalUsers', 'totalSkpds')),
            'skpd' => view('dashboard.skpd'),
            'asisten' => view('dashboard.asisten'),
            'sekda' => view('dashboard.sekda'),
            'bupati' => view('dashboard.bupati'),
            default => abort(403),
        };
    }
}

