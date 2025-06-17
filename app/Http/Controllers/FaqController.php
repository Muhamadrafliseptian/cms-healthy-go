<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use App\Models\MasterSectionCategory;
use App\Models\SectionContent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class FaqController
{
    public function index(Request $request)
    {
        try {
            $data = Faq::all();
            $category = MasterSectionCategory::where('slug', 'sfaq')->first();
            $section = SectionContent::where('menu_id', $category->id)
                ->where('section', 'sfaq')
                ->first();
            if ($request->wantsJson()) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Data FAQ berhasil diambil',
                    'data' => $data,
                    'section' => $section
                ], 200);
            }

            return view('pages.faq.index-faq', compact('data', 'section'));
        } catch (\Exception $e) {
            Log::error('FAQ Index Error: ' . $e->getMessage());

            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat mengambil data FAQ',
                'data' => null
            ], 500);
        }
    }

    public function indexBanner(Request $request)
    {
        try {
            $category = MasterSectionCategory::where('slug', 'bfaq')->first();
            $section = SectionContent::where('menu_id', $category->id)
                ->where('section', 'bfaq')
                ->first();
            if ($request->wantsJson()) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Data FAQ berhasil diambil',
                    'section' => $section
                ], 200);
            }


            return view('pages.faq.index-banner', compact('section'));
        } catch (\Exception $e) {
            Log::error('FAQ Index Error: ' . $e->getMessage());

            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat mengambil data FAQ',
                'data' => null
            ], 500);
        }
    }

    public function storeBannerFaq(Request $request)
    {
        try {
            $category = MasterSectionCategory::where('slug', 'bfaq')->first();

            $request->validate([
                'img' => 'required|image|mimes:jpg,jpeg,png|max:2048',
                'title' => 'required|string|max:255',
                // 'subtitle1' => 'required|string',
                'subtitle2' => 'required|string',
                'subtitle3' => 'required|string',
            ]);

            $imgPath = null;

            if ($request->hasFile('img')) {
                $imgPath = $request->file('img')->store('faq', 'public');
            }

            SectionContent::create([
                'img' => $imgPath,
                'title' => $request->title,
                // 'subtitle1' => $request->subtitle1,
                'subtitle2' => $request->subtitle2,
                'subtitle3' => $request->subtitle3,
                'menu_id' => $category->id,
                'section' => 'bfaq',
            ]);

            return redirect()->back()->with('success', 'Berhasil');
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function updateBannerFaq(Request $request, $id)
    {
        try {
            $benefit = SectionContent::find($id);

            if (!$benefit) {
                return redirect()->back()->with('error', 'Data tidak ditemukan.');
            }

            $request->validate([
                'img' => 'image|mimes:jpg,jpeg,png|max:2048',
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

    public function storeContentFaq(Request $request)
    {
        try {
            $category = MasterSectionCategory::where('slug', 'sfaq')->first();


            SectionContent::create([
                'menu_id'    => $category->id,
                'section'    => 'sfaq',
                'title'      => $request->title,
                'subtitle1'  => $request->subtitle1,
            ]);

            return back()->with('success', 'Data berhasil disimpan.');
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function updateContentFaq(Request $request, $id)
    {
        try {
            $content = SectionContent::findOrFail($id);
            $content->update([
                'title'     => $request->title,
                'subtitle1' => $request->subtitle1,
                'subtitle2' => $request->subtitle2,
            ]);

            return back()->with('success', 'Data berhasil diperbarui.');
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'ask_title' => 'required|string',
                'answer_content' => 'required|string',
            ]);

            $faq = Faq::create($request->only('ask_title', 'answer_content'));

            if ($request->wantsJson()) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'FAQ berhasil ditambahkan',
                    'data' => $faq
                ], 201);
            }

            return redirect()->back()->with('success', 'FAQ berhasil ditambahkan');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function show($id)
    {
        try {
            $faq = Faq::find($id);

            if (!$faq) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'FAQ tidak ditemukan',
                    'data' => null
                ], 404);
            }

            return response()->json([
                'status' => 'success',
                'message' => 'Detail FAQ berhasil diambil',
                'data' => $faq
            ], 200);
        } catch (\Exception $e) {
            Log::error('FAQ Show Error: ' . $e->getMessage());

            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat mengambil detail FAQ',
                'data' => null
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $faq = Faq::find($id);

            if (!$faq) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'FAQ tidak ditemukan',
                    'data' => null
                ], 404);
            }

            $faq->update($request->only('ask_title', 'answer_content'));

            if ($request->wantsJson()) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Data berhasil diperbarui',
                    'data' => $faq
                ], 200);
            }

            return redirect()->back()->with('success', 'Data berhasil diperbarui');
        } catch (\Exception $e) {
            Log::error('FAQ Update Error: ' . $e->getMessage());

            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat memperbarui FAQ',
                'data' => null
            ], 500);
        }
    }

    public function destroy(Request $request, $id)
    {
        try {
            $faq = Faq::find($id);

            if (!$faq) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'FAQ tidak ditemukan',
                    'data' => null
                ], 404);
            }

            $faq->delete();

            if ($request->wantsJson()) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'FAQ berhasil dihapus',
                    'data' => null
                ], 200);
            }

            return redirect()->back()->with('success', 'FAQ berhasil dihapus');
        } catch (\Exception $e) {
            Log::error('FAQ Delete Error: ' . $e->getMessage());

            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat menghapus FAQ',
                'data' => null
            ], 500);
        }
    }
}
