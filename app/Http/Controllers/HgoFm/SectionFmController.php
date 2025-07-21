<?php

namespace App\Http\Controllers\HgoFm;

use App\Models\SectionContentsFm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SectionFmController
{
    //
    public function store(Request $request, $sectionId)
    {

        try {
            $rules = [];

            if ($request->has('headline')) {
                $rules['headline'] = 'required|string';
            }

            if ($request->has('subheadline')) {
                $rules['subheadline'] = 'required|string';
            }

            if ($request->has('description')) {
                $rules['description'] = 'required|string';
            }

            if ($request->hasFile('img')) {
                $rules['img'] = 'required|image|mimes:jpeg,png,jpg,webp|max:5048';
            }

            $request->validate($rules);

            if ($request->hasFile('img')) {
                $existing = SectionContentsFm::where('section_id', $sectionId)
                    ->where('key', 'image')->first();

                if ($existing && Storage::disk('public')->exists($existing->value)) {
                    Storage::disk('public')->delete($existing->value);
                }

                $imagePath = $request->file('img')->store("banners/section_$sectionId", 'public');

                SectionContentsFm::updateOrCreate(
                    ['section_id' => $sectionId, 'key' => 'image'],
                    ['value' => $imagePath]
                );
            }

            if ($request->filled('headline')) {
                SectionContentsFm::updateOrCreate(
                    ['section_id' => $sectionId, 'key' => 'headline'],
                    ['value' => $request->headline]
                );
            }

            if ($request->filled('subheadline')) {
                SectionContentsFm::updateOrCreate(
                    ['section_id' => $sectionId, 'key' => 'subheadline'],
                    ['value' => $request->subheadline]
                );
            }

            if ($request->filled('description')) {
                SectionContentsFm::updateOrCreate(
                    ['section_id' => $sectionId, 'key' => 'description'],
                    ['value' => $request->description]
                );
            }

            return redirect()->back()->with('success', 'Data berhasil disimpan.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
