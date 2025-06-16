<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController
{
    public function index()
    {
        try {
            $data = User::all();
            return view('pages.index-admin', ["data" => $data]);
        } catch (\Exception $err) {
        }
    }
    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|string|min:6',
            ]);

            User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            return redirect()->back()->with('success', 'Administrator berhasil ditambahkan.');
        } catch (\Exception $err) {
            return redirect()->back()->with('error', 'Gagal menyimpan: ' . $err->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email,' . $id,
                'password' => 'nullable|string|min:6',
            ]);

            $user = User::findOrFail($id);
            $user->name = $request->name;
            $user->email = $request->email;

            if ($request->filled('password')) {
                $user->password = Hash::make($request->password);
            }

            $user->save();

            return redirect()->back()->with('success', 'Administrator berhasil diperbarui.');
        } catch (\Exception $err) {
            return redirect()->back()->with('error', 'Gagal memperbarui: ' . $err->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $user = User::findOrFail($id);
            $user->delete();

            return redirect()->back()->with('success', 'Administrator berhasil dihapus.');
        } catch (\Exception $err) {
            return redirect()->back()->with('error', 'Gagal menghapus: ' . $err->getMessage());
        }
    }
}
