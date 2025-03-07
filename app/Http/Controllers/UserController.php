<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use RealRashid\SweetAlert\Facades\Alert;

class UserController extends Controller
{
    public function index()
    {
        $user = User::where('role', '!=', 'admin')->paginate(10);
        return view('menu.user.index', compact('user'));
    }

    public function add()
    {
        return view('menu.user.add');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'role' => 'required|',
        ]);

        // Simpan data ke database
        User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => bcrypt($request->password), // Hash password
            'role' => $request->role,
        ]);

        // Alert
        Alert::success('Berhasil', 'Sukses menambahkan data');

        // Redirect ke halaman user dengan pesan sukses
        return redirect()->route('user.view')->with('success', 'User berhasil ditambahkan!');
    }

    public function edit($id)
    {

    }

    public function update(Request $request, $id)
    {

    }

    public function destroy($id)
    {
        // Cari user berdasarkan ID
        $user = User::findOrFail($id);

        // Hapus user dari database
        $user->delete();

        // Kirim flash message ke session untuk SweetAlert
        return redirect()->route('user.view')->with('success', 'User berhasil dihapus!');
    }

}
