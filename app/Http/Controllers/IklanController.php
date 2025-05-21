<?php

namespace App\Http\Controllers;

use App\Models\ImgTestimoniIklan;
use App\Models\MasterSectionCategory;
use App\Models\MealBenefits;
use App\Models\MealPains;
use App\Models\SectionContent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class IklanController
{
    public function indexBanner()
    {
        $category = MasterSectionCategory::where('slug', 'isbanner')->first();
        $section = SectionContent::where('menu_id', $category->id)
            ->where('section', 'isbanner')
            ->first();
        return view('pages.iklan.banner.index-banner', compact('section'));
    }

    public function storeBanner(Request $request)
    {
        try {

            $category = MasterSectionCategory::where('slug', 'isbanner')->first();

            $request->validate([
                'img' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
                'title' => 'required|string|max:255',
                'subtitle1' => 'nullable|string|max:255',
                'subtitle2' => 'nullable|string|max:255',
                'subtitle3' => 'nullable|string|max:255',
                'subtitle4' => 'nullable|string|max:255',
                'subtitle5' => 'nullable|string|max:255',
            ]);

            $imgPath = null;
            $imgPath2 = null;

            if ($request->hasFile('img')) {
                $imgPath = $request->file('img')->store('iklan', 'public');
            }

            SectionContent::create([
                'img' => $imgPath,
                'title' => $request->title,
                'subtitle1' => $request->subtitle1,
                'subtitle2' => $request->subtitle2,
                'subtitle3' => $request->subtitle3,
                'subtitle4' => $request->subtitle4,
                'subtitle5' => $request->subtitle5,
                'menu_id' => $category->id,
                'section' => 'isbanner',
            ]);

            return redirect()->back()->with('success', 'Berhasil tambah benefit');
        } catch (\Exception $err) {
            dd($err->getMessage());
        }
    }

    public function updateBanner(Request $request, $id)
    {
        try {
            $benefit = SectionContent::find($id);

            if (!$benefit) {
                return redirect()->back()->with('error', 'Data tidak ditemukan.');
            }

            $request->validate([
                'img' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
                'title' => 'required|string|max:255',
                'subtitle1' => 'nullable|string|max:255',
                'subtitle2' => 'nullable|string|max:255',
                'subtitle3' => 'nullable|string|max:255',
                'subtitle4' => 'nullable|string|max:255',
                'subtitle5' => 'nullable|string|max:255',
            ]);

            if ($request->hasFile('img')) {
                if ($benefit->img && Storage::disk('public')->exists($benefit->img)) {
                    Storage::disk('public')->delete($benefit->img);
                }
                $benefit->img = $request->file('img')->store('iklan', 'public');
            }

            $benefit->title = $request->title;
            $benefit->subtitle1 = $request->subtitle1;
            $benefit->subtitle2 = $request->subtitle2;
            $benefit->subtitle3 = $request->subtitle3;
            $benefit->subtitle4 = $request->subtitle4;
            $benefit->subtitle5 = $request->subtitle5;

            $benefit->save();

            return redirect()->back()->with('success', 'Data berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function indexAchievement()
    {
        $category = MasterSectionCategory::where('slug', 'isachievement')->first();
        $section = SectionContent::where('menu_id', $category->id)
            ->where('section', 'isachievement')
            ->first();
        return view('pages.iklan.achievement.index-achievement', compact('section'));
    }

    public function storeAchievement(Request $request)
    {
        try {
            $category = MasterSectionCategory::where('slug', 'isachievement')->first();

            $imgPath = null;

            if ($request->hasFile('img')) {
                $imgPath = $request->file('img')->store('iklan', 'public');
            }

            SectionContent::create([
                'menu_id'    => $category->id,
                'section'    => 'isachievement',
                'title'      => $request->title,
                'img'        => $imgPath,
            ]);

            return back()->with('success', 'Data testimonial berhasil disimpan.');
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function updateAchievement(Request $request, $id)
    {
        try {
            $testimoni = SectionContent::find($id);

            if ($request->hasFile('img')) {
                if ($testimoni->img && Storage::disk('public')->exists($testimoni->img)) {
                    Storage::disk('public')->delete($testimoni->img);
                }

                $testimoni->img = $request->file('img')->store('iklan', 'public');
            }

            $testimoni->title = $request->title;
            $testimoni->save();

            return back()->with('success', 'Data testimonial berhasil disimpan.');
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function indexBenefit(Request $request)
    {
        $data = MealBenefits::all();

        return view('pages.iklan.benefits.index-benefits', compact('data'));
    }

    public function storeBenefit(Request $request)
    {
        try {
            $request->validate([
                'content' => 'nullable|string',
                'img_mealb' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            ]);

            $imgPath = null;

            if ($request->hasFile('img_mealb')) {
                $imgPath = $request->file('img_mealb')->store('testimoni', 'public');
            }

            $benefit = MealBenefits::create([
                'content' => $request->content,
                'img_mealb' => $imgPath,
            ]);

            return redirect()->back()->with('success', 'berhasil tambah benefit');
        } catch (\Exception $e) {
        }
    }

    public function updateBenefit(Request $request, $id)
    {
        try {
            $benefit = MealBenefits::find($id);

            if (!$benefit) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Testimoni tidak ditemukan',
                    'data' => null
                ], 404);
            }

            $request->validate([
                'content' => 'nullable|string',
                'img_mealb' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            ]);

            if ($request->hasFile('img_mealb')) {
                if ($benefit->img_mealb && Storage::disk('public')->exists($benefit->img_mealb)) {
                    Storage::disk('public')->delete($benefit->img_mealb);
                }

                $benefit->img_mealb = $request->file('img_mealb')->store('testimoni', 'public');
            }

            $benefit->content = $request->content;
            $benefit->save();

            return redirect()->back()->with('success', 'berhasil tambah diperbarui');
        } catch (\Exception $e) {
        }
    }

    public function destroyBenefit($id)
    {
        try {
            $benefit = MealBenefits::find($id);

            if (!$benefit) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Testimoni tidak ditemukan',
                    'data' => null
                ], 404);
            }

            if ($benefit->img_mealb && Storage::disk('public')->exists($benefit->img_mealb)) {
                Storage::disk('public')->delete($benefit->img_mealb);
            }

            $benefit->delete();

            return redirect()->back()->with('success', 'berhasil hapus testimoni');
        } catch (\Exception $e) {
            Log::error('Testimoni Delete Error: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat menghapus testimoni',
                'data' => null
            ], 500);
        }
    }

    public function indexGaleri(Request $request)
    {
        $data = ImgTestimoniIklan::all();

        if ($request->wantsJson()) {
        }

        return view('pages.iklan.galeri.index-gallery', compact('data'));
    }

    public function storeGaleri(Request $request)
    {
        $request->validate([
            'img_testimoni' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $imgPath = null;

        if ($request->hasFile('img_testimoni')) {
            $imgPath = $request->file('img_testimoni')->store('testimoni', 'public');
        }

        $benefit = ImgTestimoniIklan::create([
            'img_testimoni' => $imgPath,
        ]);

        return redirect()->back()->with('success', 'berhasil tambah benefit');
    }

    public function updateGaleri(Request $request, $id)
    {
        try {
            $benefit = ImgTestimoniIklan::find($id);

            if (!$benefit) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Testimoni tidak ditemukan',
                    'data' => null
                ], 404);
            }

            $request->validate([
                'img_testimoni' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            ]);

            if ($request->hasFile('img_testimoni')) {
                if ($benefit->img_testimoni && Storage::disk('public')->exists($benefit->img_testimoni)) {
                    Storage::disk('public')->delete($benefit->img_testimoni);
                }

                $benefit->img_testimoni = $request->file('img_testimoni')->store('testimoni', 'public');
            }

            $benefit->save();

            return redirect()->back()->with('success', 'berhasil tambah diperbarui');
        } catch (\Exception $e) {
        }
    }

    public function destroyGaleri($id)
    {
        try {
            $benefit = ImgTestimoniIklan::find($id);

            if (!$benefit) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Testimoni tidak ditemukan',
                    'data' => null
                ], 404);
            }

            if ($benefit->img_testimoni && Storage::disk('public')->exists($benefit->img_testimoni)) {
                Storage::disk('public')->delete($benefit->img_testimoni);
            }

            $benefit->delete();

            return redirect()->back()->with('success', 'berhasil hapus testimoni');
        } catch (\Exception $e) {
            Log::error('Testimoni Delete Error: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat menghapus testimoni',
                'data' => null
            ], 500);
        }
    }

    public function indexPains(Request $request)
    {
        $data = MealPains::all();
        if ($request->wantsJson()) {
        }
        return view('pages.iklan.pains.index-pains', compact('data'));
    }
    public function storePains(Request $request)
    {
        try {
            $request->validate([
                'content' => 'nullable|string',
            ]);

            $benefit = MealPains::create([
                'content' => $request->content,
            ]);

            return redirect()->back()->with('success', 'berhasil tambah benefit');
        } catch (\Exception $e) {
        }
    }

    public function updatePains(Request $request, $id)
    {
        try {
            $benefit = MealPains::find($id);

            if (!$benefit) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Testimoni tidak ditemukan',
                    'data' => null
                ], 404);
            }

            $request->validate([
                'content' => 'nullable|string',
            ]);

            $benefit->content = $request->content;
            $benefit->save();

            return redirect()->back()->with('success', 'berhasil tambah diperbarui');
        } catch (\Exception $e) {
        }
    }

    public function destroyPains($id)
    {
        try {
            $benefit = MealPains::find($id);

            if (!$benefit) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Testimoni tidak ditemukan',
                    'data' => null
                ], 404);
            }

            $benefit->delete();

            return redirect()->back()->with('success', 'berhasil hapus testimoni');
        } catch (\Exception $e) {
            Log::error('Testimoni Delete Error: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat menghapus testimoni',
                'data' => null
            ], 500);
        }
    }

    public function indexGoals()
    {
        $category = MasterSectionCategory::where('slug', 'isigoals')->first();
        $section = SectionContent::where('menu_id', $category->id)
            ->where('section', 'isigoals')
            ->first();
        return view('pages.iklan.goals.index-goals', compact('section'));
    }

    public function storeGoals(Request $request)
    {
        try {

            $category = MasterSectionCategory::where('slug', 'isigoals')->first();

            $request->validate([
                'img' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
                'title' => 'required|string|max:255',
                'subtitle1' => 'nullable|string|max:255',
                'subtitle2' => 'nullable|string|max:255',
                'subtitle3' => 'nullable|string|max:255',
                'subtitle4' => 'nullable|string|max:255',
                'subtitle5' => 'nullable|string|max:255',
            ]);

            $imgPath = null;

            if ($request->hasFile('img')) {
                $imgPath = $request->file('img')->store('iklan', 'public');
            }

            SectionContent::create([
                'img' => $imgPath,
                'title' => $request->title,
                'subtitle1' => $request->subtitle1,
                'subtitle2' => $request->subtitle2,
                'subtitle3' => $request->subtitle3,
                'subtitle4' => $request->subtitle4,
                'subtitle5' => $request->subtitle5,
                'menu_id' => $category->id,
                'section' => 'isigoals',
            ]);

            return redirect()->back()->with('success', 'Berhasil tambah benefit');
        } catch (\Exception $err) {
            dd($err->getMessage());
        }
    }

    public function updateGoals(Request $request, $id)
    {
        try {
            $benefit = SectionContent::find($id);

            if (!$benefit) {
                return redirect()->back()->with('error', 'Data tidak ditemukan.');
            }

            $request->validate([
                'img' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
                'title' => 'required|string|max:255',
                'subtitle1' => 'nullable|string|max:255',
                'subtitle2' => 'nullable|string|max:255',
                'subtitle3' => 'nullable|string|max:255',
                'subtitle4' => 'nullable|string|max:255',
                'subtitle5' => 'nullable|string|max:255',
            ]);

            if ($request->hasFile('img')) {
                if ($benefit->img && Storage::disk('public')->exists($benefit->img)) {
                    Storage::disk('public')->delete($benefit->img);
                }
                $benefit->img = $request->file('img')->store('iklan', 'public');
            }

            $benefit->title = $request->title;
            $benefit->subtitle1 = $request->subtitle1;
            $benefit->subtitle2 = $request->subtitle2;
            $benefit->subtitle3 = $request->subtitle3;
            $benefit->subtitle4 = $request->subtitle4;
            $benefit->subtitle5 = $request->subtitle5;

            $benefit->save();

            return redirect()->back()->with('success', 'Data berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function indexPromo()
    {
        $category = MasterSectionCategory::where('slug', 'ispromo')->first();
        $section = SectionContent::where('menu_id', $category->id)
            ->where('section', 'ispromo')
            ->first();

        return view('pages.iklan.promo.index-promo', compact('section'));
    }

    public function storePromo(Request $request)
    {
        try {
            $category = MasterSectionCategory::where('slug', 'ispromo')->first();

            $request->validate([
                'img' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
                'img2' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
                'title' => 'required|string|max:255',
                'subtitle1' => 'nullable|string|max:255',
            ]);

            $imgPath = null;
            $imgPath2 = null;

            if ($request->hasFile('img')) {
                $imgPath = $request->file('img')->store('iklan', 'public');
            }

            if ($request->hasFile('img2')) {
                $imgPath2 = $request->file('img2')->store('iklan', 'public');
            }

            SectionContent::create([
                'img' => $imgPath,
                'img2' => $imgPath2,
                'title' => $request->title,
                'subtitle1' => $request->subtitle1,
                'menu_id' => $category->id,
                'section' => 'ispromo',
            ]);

            return redirect()->back()->with('success', 'Berhasil tambah benefit');
        } catch (\Exception $err) {
            dd($err->getMessage());
        }
    }

    public function updatePromo(Request $request, $id)
    {
        try {
            $benefit = SectionContent::find($id);

            if (!$benefit) {
                return redirect()->back()->with('error', 'Data tidak ditemukan.');
            }

            $request->validate([
                'img' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
                'img2' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
                'title' => 'required|string|max:255',
                'subtitle1' => 'nullable|string|max:255',
            ]);

            if ($request->hasFile('img')) {
                if ($benefit->img && Storage::disk('public')->exists($benefit->img)) {
                    Storage::disk('public')->delete($benefit->img);
                }
                $benefit->img = $request->file('img')->store('iklan', 'public');
            }

            if ($request->hasFile('img2')) {
                if ($benefit->img2 && Storage::disk('public')->exists($benefit->img2)) {
                    Storage::disk('public')->delete($benefit->img2);
                }
                $benefit->img2 = $request->file('img2')->store('iklan', 'public');
            }

            $benefit->title = $request->title;
            $benefit->subtitle1 = $request->subtitle1;

            $benefit->save();

            return redirect()->back()->with('success', 'Data berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
