<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MasterSectionCategory;
use App\Models\SectionContent;
use Illuminate\Support\Facades\Storage;

class ProductSectionController
{
    public function indexBanner(Request $request)
    {
        try {
            $categories = MasterSectionCategory::whereIn('slug', ['sproduct'])
                ->get()
                ->keyBy('slug');

            $sections = SectionContent::whereIn('section', ['sproduct'])
                ->whereIn('menu_id', $categories->pluck('id'))
                ->get()
                ->keyBy('section');

            if ($request->wantsJson()) {
                return response()->json([
                    'status' => 'success',
                    'section' => $sections
                ]);
            }

            return view('pages.product-service.banner.index-banner', [
                'section' => $sections->get('sproduct'),
            ]);
        } catch (\Exception $e) {
            abort(500, 'Terjadi kesalahan saat memuat data.');
        }
    }

    public function storeSectionBanner(Request $request)
    {
        try {

            $category = MasterSectionCategory::where('slug', 'sproduct')->first();

            $request->validate([
                'img' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
                'title' => 'required|string|max:255',
            ]);

            $imgPath = null;

            if ($request->hasFile('img')) {
                $imgPath = $request->file('img')->store('partnership', 'public');
            }

            SectionContent::create([
                'img' => $imgPath,
                'title' => $request->title,
                'menu_id' => $category->id,
                'section' => 'sproduct',
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

    public function indexContentTag(Request $request)
    {
        try {
            $categories = MasterSectionCategory::whereIn('slug', ['sproduc1'])
                ->get()
                ->keyBy('slug');

            $sections = SectionContent::whereIn('section', ['sproduc1'])
                ->whereIn('menu_id', $categories->pluck('id'))
                ->get()
                ->keyBy('section');

            if ($request->wantsJson()) {
                return response()->json([
                    'status' => 'success',
                    'section' => $sections
                ]);
            }

            return view('pages.product-service.tag.index-tag', [
                'section' => $sections->get('sproduc1'),
            ]);
        } catch (\Exception $e) {
            abort(500, 'Terjadi kesalahan saat memuat data.');
        }
    }

    public function storeSectionContentTag(Request $request)
    {
        try {

            $category = MasterSectionCategory::where('slug', 'sproduc1')->first();

            $request->validate([
                'title' => 'required|string',
            ]);
            SectionContent::create([
                'title' => $request->title,
                'menu_id' => $category->id,
                'section' => 'sproduc1',
            ]);

            return redirect()->back()->with('success', 'Berhasil tambah benefit');
        } catch (\Exception $err) {
            dd($err->getMessage());
        }
    }

    public function updateSectionContentTag(Request $request, $id)
    {
        try {
            $benefit = SectionContent::find($id);

            if (!$benefit) {
                return redirect()->back()->with('error', 'Data tidak ditemukan.');
            }

            $request->validate([
                'title' => 'required|string',
            ]);

            $benefit->title = $request->title;
            $benefit->subtitle1 = $request->subtitle1;

            $benefit->save();

            return redirect()->back()->with('success', 'Data berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function indexContentSolution(Request $request)
    {
        try {
            $categories = MasterSectionCategory::whereIn('slug', ['sproduct2'])
                ->get()
                ->keyBy('slug');

            $sections = SectionContent::whereIn('section', ['sproduct2'])
                ->whereIn('menu_id', $categories->pluck('id'))
                ->get()
                ->keyBy('section');

                if($request->wantsJson()) {
                    return response()->json([
                        'status' => 'success',
                        'section' => $sections
                    ]);
                }

            return view('pages.product-service.solution.index-solution', [
                'section' => $sections->get('sproduct2'),
            ]);
        } catch (\Exception $e) {
            abort(500, 'Terjadi kesalahan saat memuat data.');
        }
    }

    public function storeSectionContentSolution(Request $request)
    {
        try {

            $category = MasterSectionCategory::where('slug', 'sproduct2')->first();

            $request->validate([
                'title' => 'required|string|max:255',
                'subtitle1' => 'required|string|max:255',
            ]);
            SectionContent::create([
                'title' => $request->title,
                'subtitle1' => $request->subtitle1,
                'menu_id' => $category->id,
                'section' => 'sproduct2',
            ]);

            return redirect()->back()->with('success', 'Berhasil tambah benefit');
        } catch (\Exception $err) {
            dd($err->getMessage());
        }
    }

    public function updateSectionContentSolution(Request $request, $id)
    {
        try {
            $benefit = SectionContent::find($id);

            if (!$benefit) {
                return redirect()->back()->with('error', 'Data tidak ditemukan.');
            }

            $request->validate([
                'title' => 'required|string|max:255',
                'subtitle1' => 'required|string|max:255',
            ]);

            $benefit->title = $request->title;
            $benefit->subtitle1 = $request->subtitle1;

            $benefit->save();

            return redirect()->back()->with('success', 'Data berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
