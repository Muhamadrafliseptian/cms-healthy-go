<?php

namespace App\Http\Controllers;

use App\Models\MasterSectionCategory;
use App\Models\SectionContent;
use App\Models\TNC;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class TnCController
{
    public function index(Request $request)
    {
        try {
            $data = TNC::all();
            if ($request->wantsJson()) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Data Terms and Conditions berhasil diambil',
                    'data' => $data
                ], 200);
            }

            return view('pages.tnc.index-tnc', compact('data'));
        } catch (\Exception $e) {
            Log::error('TnC Index Error: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat mengambil data Terms and Conditions',
                'data' => null
            ], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'title_tnc' => 'required|string',
                'subtitle_tnc' => 'required|string',
                'content_tnc' => 'required|string',
            ]);

            $tnc = TNC::create($request->only('title_tnc', 'subtitle_tnc', 'content_tnc'));

            if ($request->wantsJson()) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Terms and Conditions berhasil ditambahkan',
                    'data' => $tnc
                ], 201);
            }
            return redirect()->back()->with('success', 'Terms and Conditions berhasil ditambahkan');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function show($id)
    {
        try {
            $tnc = TNC::find($id);

            if (!$tnc) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Terms and Conditions tidak ditemukan',
                    'data' => null
                ], 404);
            }

            return response()->json([
                'status' => 'success',
                'message' => 'Detail Terms and Conditions berhasil diambil',
                'data' => $tnc
            ], 200);
        } catch (\Exception $e) {
            Log::error('TnC Show Error: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat mengambil detail Terms and Conditions',
                'data' => null
            ], 500);
        }
    }

    public function indexBanner(Request $request)
    {
        try {
            $category = MasterSectionCategory::where('slug', 'btnc')->first();
            $section = SectionContent::where('menu_id', $category->id)
                ->where('section', 'btnc')
                ->first();
            if ($request->wantsJson()) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Data FAQ berhasil diambil',
                    'section' => $section
                ], 200);
            }


            return view('pages.tnc.index-banner', compact('section'));
        } catch (\Exception $e) {
            Log::error('FAQ Index Error: ' . $e->getMessage());

            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat mengambil data FAQ',
                'data' => null
            ], 500);
        }
    }

    public function storeBannerTnc(Request $request)
    {
        try {
            $category = MasterSectionCategory::where('slug', 'btnc')->first();

            $request->validate([
                'img' => 'required|image|mimes:jpg,jpeg,png|max:2048',
                'title' => 'required|string|max:255',
                'subtitle1' => 'required|string',
                'subtitle2' => 'required|string',
                'subtitle3' => 'required|string',
            ]);

            $imgPath = null;

            if ($request->hasFile('img')) {
                $imgPath = $request->file('img')->store('tnc', 'public');
            }

            SectionContent::create([
                'img' => $imgPath,
                'title' => $request->title,
                'subtitle1' => $request->subtitle1,
                'subtitle2' => $request->subtitle2,
                'subtitle3' => $request->subtitle3,
                'menu_id' => $category->id,
                'section' => 'btnc',
            ]);

            return redirect()->back()->with('success', 'Berhasil');
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function updateBannerTnc(Request $request, $id)
    {
        try {
            $benefit = SectionContent::find($id);

            if (!$benefit) {
                return redirect()->back()->with('error', 'Data tidak ditemukan.');
            }

            $request->validate([
                'img' => 'required|image|mimes:jpg,jpeg,png|max:2048',
                'title' => 'required|string|max:255',
                'subtitle1' => 'required|string',
            ]);

            if ($request->hasFile('img')) {
                if ($benefit->img && Storage::disk('public')->exists($benefit->img)) {
                    Storage::disk('public')->delete($benefit->img);
                }
                $benefit->img = $request->file('img')->store('about', 'public');
            }

            $benefit->title = $request->title;
            $benefit->subtitle1 = $request->subtitle1;
            $benefit->subtitle2 = $request->subtitle2;
            $benefit->subtitle3 = $request->subtitle3;

            $benefit->save();

            return redirect()->back()->with('success', 'Data berhasil diperbarui.');
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $tnc = TNC::find($id);

            if (!$tnc) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Terms and Conditions tidak ditemukan',
                    'data' => null
                ], 404);
            }

            $request->validate([
                'title_tnc' => 'required|string',
                'subtitle_tnc' => 'required|string',
                'content_tnc' => 'required|string',
            ]);

            $tnc->update($request->only('title_tnc', 'subtitle_tnc', 'content_tnc'));

            if ($request->wantsJson()) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Terms and Conditions berhasil diperbarui',
                    'data' => $tnc
                ], 200);
            }
            return redirect()->back()->with('success', 'Terms and Conditions berhasil diperbarui');
        } catch (\Exception $e) {
            Log::error('TnC Update Error: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat memperbarui Terms and Conditions',
                'data' => null
            ], 500);
        }
    }

    public function destroy(Request $request, $id)
    {
        try {
            $tnc = TNC::find($id);

            if (!$tnc) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Terms and Conditions tidak ditemukan',
                    'data' => null
                ], 404);
            }

            $tnc->delete();

            if ($request->wantsJson()) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Terms and Conditions berhasil dihapus',
                    'data' => null
                ], 200);
            }

            return redirect()->back()->with('success', 'Terms and Conditions berhasil dihapus');
        } catch (\Exception $e) {
            Log::error('TnC Delete Error: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat menghapus Terms and Conditions',
                'data' => null
            ], 500);
        }
    }

    public function indexSkFm(Request $request)
    {
        try {
            $categoryIds = MasterSectionCategory::whereIn('slug', ['sk', 'sfm'])->pluck('id');

            $sections = SectionContent::whereIn('menu_id', $categoryIds)
                ->whereIn('section', ['sk', 'sfm'])
                ->get();

            $section = $sections->first();

            if ($request->wantsJson()) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Data SK dan FM berhasil diambil',
                    'sections' => $sections,
                    'section' => $section
                ], 200);
            }

            return view('pages.tnc.index-sk', compact('sections', 'section'));
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    public function storeSkFm(Request $request)
    {
        try {
            $category = MasterSectionCategory::where('slug', 'sk')->first();

            $request->validate([
                'title' => 'required|string|max:255',
                'subtitle1' => 'required|string',
                'subtitle2' => 'required|string',
                'subtitle3' => 'required|string',
                'subtitle4' => 'required|string',
            ]);

            SectionContent::create([
                'title' => $request->title,
                'subtitle1' => $request->subtitle1,
                'subtitle2' => $request->subtitle2,
                'subtitle3' => $request->subtitle3,
                'subtitle4' => $request->subtitle4,
                'menu_id' => $category->id,
                'section' => 'sk',
            ]);

            return redirect()->back()->with('success', 'Berhasil');
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function updateSkFm(Request $request, $id)
    {
        try {
            $benefit = SectionContent::find($id);

            if (!$benefit) {
                return redirect()->back()->with('error', 'Data tidak ditemukan.');
            }

            $request->validate([
                'title' => 'required|string|max:255',
                'subtitle1' => 'required|string',
                'subtitle2' => 'required|string',
                'subtitle3' => 'required|string',
                'subtitle4' => 'required|string',
            ]);

            $benefit->title = $request->title;
            $benefit->subtitle1 = $request->subtitle1;
            $benefit->subtitle2 = $request->subtitle2;
            $benefit->subtitle3 = $request->subtitle3;
            $benefit->subtitle4 = $request->subtitle4;

            $benefit->save();

            return redirect()->back()->with('success', 'Data berhasil diperbarui.');
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function indexGaransi(Request $request)
    {
        try {
            $categoryIds = MasterSectionCategory::whereIn('slug', ['sgaransi'])->pluck('id');

            $sections = SectionContent::whereIn('menu_id', $categoryIds)
                ->whereIn('section', ['sgaransi'])
                ->get();

            $section = $sections->first();

            return view('pages.tnc.index-garansi', compact('sections', 'section'));
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    public function storeGaransi(Request $request)
    {
        try {
            $category = MasterSectionCategory::where('slug', 'sgaransi')->first();

            $request->validate([
                'img' => 'required|image|mimes:jpg,jpeg,png|max:2048',
                'title' => 'required|string|max:255',
                'subtitle1' => 'required|string',
            ]);

            $imgPath = null;

            if ($request->hasFile('img')) {
                $imgPath = $request->file('img')->store('tnc', 'public');
            }

            SectionContent::create([
                'img' => $imgPath,
                'title' => $request->title,
                'subtitle1' => $request->subtitle1,
                'menu_id' => $category->id,
                'section' => 'sgaransi',
            ]);

            return redirect()->back()->with('success', 'Berhasil');
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function updateGaransi(Request $request, $id)
    {
        try {
            $benefit = SectionContent::find($id);

            if (!$benefit) {
                return redirect()->back()->with('error', 'Data tidak ditemukan.');
            }

            $request->validate([
                'img' => 'required|image|mimes:jpg,jpeg,png|max:2048',
                'title' => 'required|string|max:255',
                'subtitle1' => 'required|string',
            ]);

            if ($request->hasFile('img')) {
                if ($benefit->img && Storage::disk('public')->exists($benefit->img)) {
                    Storage::disk('public')->delete($benefit->img);
                }
                $benefit->img = $request->file('img')->store('tnc', 'public');
            }

            $benefit->title = $request->title;
            $benefit->subtitle1 = $request->subtitle1;

            $benefit->save();

            return redirect()->back()->with('success', 'Data berhasil diperbarui.');
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function indexReschedule(Request $request)
    {
        try {
            $categoryIds = MasterSectionCategory::whereIn('slug', ['sreschedule'])->pluck('id');

            $sections = SectionContent::whereIn('menu_id', $categoryIds)
                ->whereIn('section', ['sreschedule'])
                ->get();

            $section = $sections->first();

            return view('pages.tnc.index-reschedule', compact('sections', 'section'));
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    public function storeReschedule(Request $request)
    {
        try {
            $category = MasterSectionCategory::where('slug', 'sreschedule')->first();

            $request->validate([
                'img' => 'required|image|mimes:jpg,jpeg,png|max:2048',
                'title' => 'required|string|max:255',
                'subtitle1' => 'required|string',
            ]);

            $imgPath = null;

            if ($request->hasFile('img')) {
                $imgPath = $request->file('img')->store('tnc', 'public');
            }

            SectionContent::create([
                'img' => $imgPath,
                'title' => $request->title,
                'subtitle1' => $request->subtitle1,
                'menu_id' => $category->id,
                'section' => 'sreschedule',
            ]);

            return redirect()->back()->with('success', 'Berhasil');
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function updateReschedule(Request $request, $id)
    {
        try {
            $benefit = SectionContent::find($id);

            if (!$benefit) {
                return redirect()->back()->with('error', 'Data tidak ditemukan.');
            }

            $request->validate([
                'img' => 'required|image|mimes:jpg,jpeg,png|max:2048',
                'title' => 'required|string|max:255',
                'subtitle1' => 'required|string',
            ]);

            if ($request->hasFile('img')) {
                if ($benefit->img && Storage::disk('public')->exists($benefit->img)) {
                    Storage::disk('public')->delete($benefit->img);
                }
                $benefit->img = $request->file('img')->store('tnc', 'public');
            }

            $benefit->title = $request->title;
            $benefit->subtitle1 = $request->subtitle1;

            $benefit->save();

            return redirect()->back()->with('success', 'Data berhasil diperbarui.');
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function indexHte(Request $request)
    {
        try {
            $categoryIds = MasterSectionCategory::whereIn('slug', ['shte'])->pluck('id');

            $sections = SectionContent::whereIn('menu_id', $categoryIds)
                ->whereIn('section', ['shte'])
                ->get();

            $section = $sections->first();

            return view('pages.tnc.index-how-to-eat', compact('sections', 'section'));
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    public function storeHte(Request $request)
    {
        try {
            $category = MasterSectionCategory::where('slug', 'shte')->first();

            $request->validate([
                'img' => 'required|image|mimes:jpg,jpeg,png|max:2048',
                'title' => 'required|string|max:255',
                'subtitle1' => 'required|string',
            ]);

            $imgPath = null;

            if ($request->hasFile('img')) {
                $imgPath = $request->file('img')->store('tnc', 'public');
            }

            SectionContent::create([
                'img' => $imgPath,
                'title' => $request->title,
                'subtitle1' => $request->subtitle1,
                'menu_id' => $category->id,
                'section' => 'shte',
            ]);

            return redirect()->back()->with('success', 'Berhasil');
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function updateHte(Request $request, $id)
    {
        try {
            $benefit = SectionContent::find($id);

            if (!$benefit) {
                return redirect()->back()->with('error', 'Data tidak ditemukan.');
            }

            $request->validate([
                'img' => 'required|image|mimes:jpg,jpeg,png|max:2048',
                'title' => 'required|string|max:255',
                'subtitle1' => 'required|string',
            ]);

            if ($request->hasFile('img')) {
                if ($benefit->img && Storage::disk('public')->exists($benefit->img)) {
                    Storage::disk('public')->delete($benefit->img);
                }
                $benefit->img = $request->file('img')->store('tnc', 'public');
            }

            $benefit->title = $request->title;
            $benefit->subtitle1 = $request->subtitle1;

            $benefit->save();

            return redirect()->back()->with('success', 'Data berhasil diperbarui.');
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function mainTestimoni(Request $request)
    {
        try {
            $slugs = ['sk', 'sfm', 'sgaransi', 'sreschedule', 'shte', 'btnc', 'sjadwal'];

            $categoryIds = MasterSectionCategory::whereIn('slug', $slugs)->pluck('id');

            $sections = SectionContent::whereIn('menu_id', $categoryIds)->get();

            if ($request->wantsJson()) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Data Testimoni berhasil diambil',
                    'sections' => $sections
                ], 200);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat mengambil data testimoni',
                'data' => null
            ], 500);
        }
    }

    public function indexJadwal()
    {
        $category = MasterSectionCategory::where('slug', 'sjadwal')->first();

        $section = null;
        if ($category) {
            $section = SectionContent::where('section', 'sjadwal')
                ->where('menu_id', $category->id)
                ->first();
        }
        if (request()->wantsJson()) {
            return response()->json([
                "status" => "success",
                "section" => $section
            ]);
        }
        return view('pages.tnc.index-jadwal-pengiriman', compact('section'));
    }

    public function storeJadwal(Request $request)
    {
        try {
            $category = MasterSectionCategory::where('slug', 'sjadwal')->first();

            $request->validate([
                'subtitle1' => 'required|string',
                'subtitle2' => 'required|string',
                'subtitle3' => 'required|string',
                'subtitle4' => 'required|string',
                'subtitle5' => 'required|string',
            ]);

            SectionContent::create([
                'subtitle1' => $request->subtitle1,
                'subtitle2' => $request->subtitle2,
                'subtitle3' => $request->subtitle3,
                'subtitle4' => $request->subtitle4,
                'subtitle5' => $request->subtitle5,
                'menu_id' => $category->id,
                'section' => 'sjadwal',
            ]);

            return redirect()->back()->with('success', 'Berhasil');
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function updateJadwal(Request $request, $id)
    {
        try {
            $benefit = SectionContent::find($id);

            if (!$benefit) {
                return redirect()->back()->with('error', 'Data tidak ditemukan.');
            }

            $request->validate([
                'subtitle1' => 'required|string',
                'subtitle2' => 'required|string',
                'subtitle3' => 'required|string',
                'subtitle4' => 'required|string',
                'subtitle5' => 'required|string',
            ]);

            $benefit->subtitle1 = $request->subtitle1;
            $benefit->subtitle2 = $request->subtitle2;
            $benefit->subtitle3 = $request->subtitle3;
            $benefit->subtitle4 = $request->subtitle4;
            $benefit->subtitle5 = $request->subtitle5;

            $benefit->save();

            return redirect()->back()->with('success', 'Data berhasil diperbarui.');
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
