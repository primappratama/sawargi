<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller {
    public function index() {
        if (session('admin_logged_in')) {
            return redirect()->route('admin.overview');
        }
        return view('auth.login');
    }

    public function login(Request $request) {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        $admin = Admin::where('username', $request->username)->first();

        if (!$admin || !Hash::check($request->password, $admin->password)) {
            return back()->withErrors(['username' => 'Username atau password salah']);
        }

        session([
            'admin_logged_in' => true,
            'admin_id'        => $admin->id,
            'admin_name'      => $admin->name,
            'admin_username'  => $admin->username,
        ]);

        return redirect()->route('admin.overview');
    }

    public function logout() {
        session()->flush();
        return redirect()->route('login');
    }
}