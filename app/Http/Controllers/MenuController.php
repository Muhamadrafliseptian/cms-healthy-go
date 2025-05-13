<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class MenuController extends Controller
{
    public function index()
    {
        try {
            $data = Menu::all();
            return response()->json([
                'status' => 'success',
                'message' => 'Data menu berhasil diambil',
                'data' => $data
            ], 200);
        } catch (\Exception $e) {
            Log::error('Menu Index Error: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat mengambil data menu',
                'data' => null
            ], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'dinner_menu' => 'nullable|string',
                'lunch_menu' => 'nullable|string',
                'img_menu' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            ]);

            $imgPath = null;
            if ($request->hasFile('img_menu')) {
                $imgPath = $request->file('img_menu')->store('menu', 'public');
            }

            $menu = Menu::create([
                'dinner_menu' => $request->dinner_menu,
                'lunch_menu' => $request->lunch_menu,
                'img_menu' => $imgPath,
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Menu berhasil ditambahkan',
                'data' => $menu
            ], 201);
        } catch (\Exception $e) {
            Log::error('Menu Store Error: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat menyimpan menu',
                'data' => null
            ], 500);
        }
    }

    public function show($id)
    {
        try {
            $menu = Menu::find($id);

            if (!$menu) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Menu tidak ditemukan',
                    'data' => null
                ], 404);
            }

            return response()->json([
                'status' => 'success',
                'message' => 'Detail menu berhasil diambil',
                'data' => $menu
            ], 200);
        } catch (\Exception $e) {
            Log::error('Menu Show Error: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat mengambil detail menu',
                'data' => null
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $menu = Menu::find($id);

            if (!$menu) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Menu tidak ditemukan',
                    'data' => null
                ], 404);
            }

            $request->validate([
                'dinner_menu' => 'nullable|string',
                'lunch_menu' => 'nullable|string',
                'img_menu' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            ]);

            if ($request->hasFile('img_menu')) {
                if ($menu->img_menu && Storage::disk('public')->exists($menu->img_menu)) {
                    Storage::disk('public')->delete($menu->img_menu);
                }

                $menu->img_menu = $request->file('img_menu')->store('menu', 'public');
            }

            $menu->dinner_menu = $request->dinner_menu;
            $menu->lunch_menu = $request->lunch_menu;
            $menu->save();

            return response()->json([
                'status' => 'success',
                'message' => 'Menu berhasil diperbarui',
                'data' => $menu
            ], 200);
        } catch (\Exception $e) {
            Log::error('Menu Update Error: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat memperbarui menu',
                'data' => null
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $menu = Menu::find($id);

            if (!$menu) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Menu tidak ditemukan',
                    'data' => null
                ], 404);
            }

            if ($menu->img_menu && Storage::disk('public')->exists($menu->img_menu)) {
                Storage::disk('public')->delete($menu->img_menu);
            }

            $menu->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Menu berhasil dihapus',
                'data' => null
            ], 200);
        } catch (\Exception $e) {
            Log::error('Menu Delete Error: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat menghapus menu',
                'data' => null
            ], 500);
        }
    }
}
