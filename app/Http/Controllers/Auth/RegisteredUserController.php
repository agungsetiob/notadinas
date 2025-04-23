<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Skpd;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    public function index(): View
    {
        $users = User::with('skpd')->paginate(10);
        return view('users.index', compact('users'));
    }
    
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        $skpds = Skpd::all();
        return view('auth.register', compact('skpds'));
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => ['required', Rule::in(['skpd', 'asisten', 'sekda', 'bupati', 'admin'])],
            'jabatan' => ['nullable', 'string', 'max:255'],
            'skpd_id' => ['nullable', 'exists:skpds,id'],
        ]);
    
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'jabatan' => $request->jabatan,
            'skpd_id' => $request->skpd_id,
        ]);
    
        event(new Registered($user));
    
        //Auth::login($user);
    
        return redirect()->route('users.index');
    }
    public function toggleStatus(Request $request, User $user)
    {
        $request->validate([
            'status' => ['required', 'boolean'],
        ]);
    
        $user->update(['status' => $request->status]);
    
        return redirect()->back()->with('status', 'Status pengguna berhasil diperbarui.');
    }    
}
