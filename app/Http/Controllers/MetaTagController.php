<?php

namespace App\Http\Controllers;

use App\Models\MasterMenu;
use App\Models\MasterMeta;
use Illuminate\Http\Request;

class MetaTagController
{
    public function index()
    {

        $data = MasterMenu::all();
        $datas = MasterMeta::all();

        if (request()->wantsJson()) {
            return response()->json([
                'data' => $datas,
                'status' => "success"
            ]);
        }

        return view('pages.meta-tags.index-meta-tags', (['data' => $data, 'datas' => $datas]));
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'menu_id' => 'required|exists:lptm_menu,id',
                'title' => 'required|string|max:255',
                'keywords' => 'required|string',
                'description' => 'required|string',
            ]);

            $existing = MasterMeta::where('menu_id', $request->menu_id)->first();

            if ($existing) {
                return redirect()->back()->with('error', 'Meta tag untuk menu ini sudah ada.');
            }

            MasterMeta::create([
                'menu_id' => $request->menu_id,
                'title' => $request->title,
                'keywords' => $request->keywords,
                'description' => $request->description,
            ]);

            return redirect()->back()->with('success', 'Meta tag berhasil disimpan.');
        } catch (\Exception $err) {
            return redirect()->back()->with('error', $err->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'title' => 'required|string|max:255',
                'keywords' => 'required|string',
                'description' => 'required|string',
            ]);

            $meta = MasterMeta::findOrFail($id);

            $meta->update([
                'title' => $request->title,
                'keywords' => $request->keywords,
                'description' => $request->description,
            ]);

            return redirect()->back()->with('success', 'Meta tag berhasil diperbarui.');
        } catch (\Exception $err) {
            return redirect()->back()->with('error', $err->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $meta = MasterMeta::findOrFail($id);
            $meta->delete();

            return redirect()->back()->with('success', 'Meta tag berhasil dihapus.');
        } catch (\Exception $err) {
            return redirect()->back()->with('error', $err->getMessage());
        }
    }
}
