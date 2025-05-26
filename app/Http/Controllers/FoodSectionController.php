<?php

namespace App\Http\Controllers;

use App\Models\MasterSectionCategory;
use App\Models\SectionContent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FoodSectionController
{
    public function indexBanner()
    {
        try {

            $section = getSectionBySlug('sfood');
            return handleResponse($section, 'pages.food.banner.index-banner');
        } catch (\Exception $e) {
            abort(500, 'Terjadi kesalahan saat memuat data.');
        }
    }

    public function storeSectionBanner(Request $request)
    {
        try {

            $category = MasterSectionCategory::where('slug', 'sfood')->first();

            $request->validate([
                'img' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
                'title' => 'required|string|max:255',
            ]);

            $imgPath = null;

            if ($request->hasFile('img')) {
                $imgPath = $request->file('img')->store('food', 'public');
            }

            SectionContent::create([
                'img' => $imgPath,
                'title' => $request->title,
                'menu_id' => $category->id,
                'section' => 'sfood',
            ]);

            return redirect()->back()->with('success', 'Berhasil tambah benefit');
        } catch (\Exception $err) {
            dd($err->getMessage());
        }
    }

    public function updateSectionBanner(Request $request, $id)
    {
        try {
            $benefit = SectionContent::find($id);

            if (!$benefit) {
                return redirect()->back()->with('error', 'Data tidak ditemukan.');
            }

            $request->validate([
                'img' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
                'title' => 'required|string|max:255',
            ]);

            if ($request->hasFile('img')) {
                if ($benefit->img && Storage::disk('public')->exists($benefit->img)) {
                    Storage::disk('public')->delete($benefit->img);
                }
                $benefit->img = $request->file('img')->store('partnership', 'public');
            }

            $benefit->title = $request->title;

            $benefit->save();

            return redirect()->back()->with('success', 'Data berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
