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

        if(request()->wantsJson()){
            return response()->json([
                'data' => $datas,
                'status' => "success"
            ]);
        }

        return view('pages.meta-tags.index-meta-tags', (['data' => $data, 'datas' => $datas]));
    }

    public function store(Request $request)
    {
        $request->validate([
            'menu_id' => 'required|exists:lptm_menu,id',
            'title' => 'nullable|string|max:255',
            'keywords' => 'nullable|string',
            'description' => 'nullable|string',
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
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'nullable|string|max:255',
            'keywords' => 'nullable|string',
            'description' => 'nullable|string',
        ]);

        $meta = MasterMeta::findOrFail($id);

        $meta->update([
            'title' => $request->title,
            'keywords' => $request->keywords,
            'description' => $request->description,
        ]);

        return redirect()->back()->with('success', 'Meta tag berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $meta = MasterMeta::findOrFail($id);
        $meta->delete();

        return redirect()->back()->with('success', 'Meta tag berhasil dihapus.');
    }
}
