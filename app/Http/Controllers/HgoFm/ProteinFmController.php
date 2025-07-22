<?php

namespace App\Http\Controllers\HgoFm;

use App\Models\FmProtein;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProteinFmController
{
    //
    public function store(Request $request)
    {
        try {
            $request->validate([
                'title' => 'required|nullable|string',
                'content' => 'required|nullable|string',
                'image' => 'image|mimes:jpg,jpeg,png|max:2048',
            ]);

            $imgPath = null;

            if ($request->hasFile('image')) {
                $imgPath = $request->file('image')->store('fmprotein', 'public');
            }

            FmProtein::create([
                'title' => $request->title,
                'content' => $request->content,
                'image' => $imgPath,
            ]);

            return redirect()->back()->with('success', 'Data berhasil ditambah');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $data = FmProtein::find($id);
            $request->validate([
                'title' => 'required|nullable|string',
                'content' => 'required|nullable|string',
                'image' => 'image|mimes:jpg,jpeg,png|max:2048',
            ]);
            if ($request->hasFile('image')) {
                if ($data->image && Storage::disk('public')->exists($data->image)) {
                    Storage::disk('public')->delete($data->image);
                }

                $data->image = $request->file('image')->store('fmprotein', 'public');
            }
            $data->title = $request->title;
            $data->content = $request->content;
            $data->save();

            return redirect()->back()->with('success', 'Data berhasil ditambah');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $data = FmProtein::find($id);
            if ($data->image && Storage::disk('public')->exists($data->image)) {
                Storage::disk('public')->delete($data->image);
            }
            $data->delete();
            return redirect()->back()->with('success', 'data berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
