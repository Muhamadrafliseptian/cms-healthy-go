<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\MasterBatch;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class MenuController
{
    public function index(Request $request)
    {
        try {
            $latestBatch = MasterBatch::orderByDesc('start_date')->first();

            if (!$latestBatch) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Batch belum tersedia',
                    'data' => null
                ], 404);
            }

            $menus = Menu::where('batch_id', $latestBatch->id)->orderByRaw("
            FIELD(day, 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu')
        ")->get();

            if ($request->wantsJson()) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Data menu batch terbaru berhasil diambil',
                    'batch' => $latestBatch,
                    'menus' => $menus,
                    "latest_batch" => $latestBatch->get
                ], 200);
            }

            $data = Menu::all();
            $batches = MasterBatch::orderByDesc('start_date')->get();
            return view('pages.food.batch.index-batch', compact('data', 'batches'));
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
                'menus' => 'required|array|min:1',
                'menus.*.day' => 'required|string',
                'menus.*.lunch_menu' => 'required|string',
                'menus.*.dinner_menu' => 'required|string',
                'menus.*.img_menu' => 'required|image|mimes:jpg,jpeg,png|max:2048',
                'batch_id' => 'required|exists:lptm_batch,id',
            ]);

            $existing = Menu::where('batch_id', $request->batch_id)->exists();
            if ($existing) {
                return redirect()->back()->with('error', 'Menu untuk batch ini sudah ada.');
            }

            foreach ($request->menus as $menuData) {
                $imgPath = null;

                if (isset($menuData['img_menu']) && $menuData['img_menu']) {
                    $imgPath = $menuData['img_menu']->store('menu', 'public');
                }

                Menu::create([
                    'batch_id' => $request->batch_id,
                    'day' => $menuData['day'],
                    'lunch_menu' => $menuData['lunch_menu'],
                    'dinner_menu' => $menuData['dinner_menu'],
                    'img_menu' => $imgPath,
                ]);
            }

            return redirect()->back()->with('success', 'Menu mingguan berhasil ditambahkan.');
        } catch (\Exception $e) {
            Log::error('Batch Menu Store Error: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat menyimpan data.');
        }
    }


    public function update(Request $request)
    {
        try {
            $request->validate([
                'id' => 'required|exists:lpt_batch_menu,id',
                // 'batch_id' => 'required|exists:lptm_batch,id',
                'day' => 'required|string',
                'lunch_menu' => 'required|string',
                'dinner_menu' => 'required|string',
                'img_menu' => 'required|image|mimes:jpg,jpeg,png|max:2048',
            ]);

            $menu = Menu::findOrFail($request->id);

            if ($request->hasFile('img_menu')) {
                if ($menu->img_menu && Storage::disk('public')->exists($menu->img_menu)) {
                    Storage::disk('public')->delete($menu->img_menu);
                }

                $menu->img_menu = $request->file('img_menu')->store('menu', 'public');
            }

            // $menu->batch_id = $request->batch_id;
            $menu->day = $request->day;
            $menu->lunch_menu = $request->lunch_menu;
            $menu->dinner_menu = $request->dinner_menu;

            $menu->save();

            return redirect()->back()->with('success', 'Menu berhasil diperbarui.');
        } catch (\Exception $e) {
            Log::error('Batch Menu Update Error: ' . $e->getMessage());

            dd($e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat memperbarui data.');
        }
    }

    public function destroy(Request $request, $id)
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

            if ($request->wantsJson()) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Menu berhasil dihapus',
                    'data' => null
                ], 200);
            }

            return redirect()->back()->with('success', 'data berhasil ditambah');
        } catch (\Exception $e) {
            Log::error('Menu Delete Error: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat menghapus menu',
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
}
