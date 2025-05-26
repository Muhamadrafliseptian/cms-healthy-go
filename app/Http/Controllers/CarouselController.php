<?php

namespace App\Http\Controllers;

use App\Models\Carousel;
use App\Models\MasterSectionCategory;
use App\Models\SectionContent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class CarouselController
{
    public function index(Request $request)
    {
        try {
            $data = Carousel::all();
            $categories = MasterSectionCategory::whereIn('slug', ['scarousel'])
                ->get()
                ->keyBy('slug');

            $sections = SectionContent::whereIn('section', ['scarousel'])
                ->whereIn('menu_id', $categories->pluck('id'))
                ->get()
                ->keyBy('section');
            if ($request->wantsJson()) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Data carousel berhasil diambil',
                    'data' => $data,
                    'section' => $sections
                ], 200);
            }

            return view('pages.food.carousel.index-carousel', [
                'section' => $sections->get('scarousel'),
                'data' => $data
            ]);
        } catch (\Exception $e) {
            Log::error('Carousel Index Error: ' . $e->getMessage());

            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat mengambil data carousel',
                'data' => null
            ], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'img_carousel' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            ]);

            $imgPath = null;

            if ($request->hasFile('img_carousel')) {
                $imgPath = $request->file('img_carousel')->store('carousel', 'public');
            }

            $carousel = Carousel::create([
                'img_carousel' => $imgPath,
            ]);

            if ($request->wantsJson()) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Carousel berhasil ditambahkan',
                    'data' => $carousel
                ], 201);
            }

            return redirect()->back()->with('success', 'Data berhasil ditambah');
        } catch (\Exception $e) {
            Log::error('Carousel Store Error: ' . $e->getMessage());

            dd($e->getMessage());

            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat menyimpan carousel',
                'data' => null
            ], 500);
        }
    }

    public function show($id)
    {
        try {
            $carousel = Carousel::find($id);

            if (!$carousel) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Carousel tidak ditemukan',
                    'data' => null
                ], 404);
            }

            return response()->json([
                'status' => 'success',
                'message' => 'Detail carousel berhasil diambil',
                'data' => $carousel
            ], 200);
        } catch (\Exception $e) {
            Log::error('Carousel Show Error: ' . $e->getMessage());

            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat mengambil detail carousel',
                'data' => null
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $carousel = Carousel::find($id);

            if (!$carousel) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Carousel tidak ditemukan',
                    'data' => null
                ], 404);
            }

            $request->validate([
                'img_carousel' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            ]);

            if ($request->hasFile('img_carousel')) {
                if ($carousel->img_carousel && Storage::disk('public')->exists($carousel->img_carousel)) {
                    Storage::disk('public')->delete($carousel->img_carousel);
                }

                $carousel->img_carousel = $request->file('img_carousel')->store('carousel', 'public');
            }

            $carousel->save();

            if ($request->wantsJson()) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Carousel berhasil diperbarui',
                    'data' => $carousel
                ], 200);
            }

            return redirect()->back()->with('success', 'Data berhasil ditambah');
        } catch (\Exception $e) {
            Log::error('Carousel Update Error: ' . $e->getMessage());

            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat memperbarui carousel',
                'data' => null
            ], 500);
        }
    }

    public function destroy(Request $request, $id)
    {
        try {
            $carousel = Carousel::find($id);

            if (!$carousel) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Carousel tidak ditemukan',
                    'data' => null
                ], 404);
            }

            if ($carousel->img_carousel && Storage::disk('public')->exists($carousel->img_carousel)) {
                Storage::disk('public')->delete($carousel->img_carousel);
            }

            $carousel->delete();

            if ($request->wantsJson()) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Carousel berhasil dihapus',
                    'data' => null
                ], 200);
            }

            return redirect()->back()->with('success', 'Data berhasil dihapus');
        } catch (\Exception $e) {
            Log::error('Carousel Delete Error: ' . $e->getMessage());

            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat menghapus carousel',
                'data' => null
            ], 500);
        }
    }

    public function storeSectionCarousel(Request $request)
    {
        try {

            $category = MasterSectionCategory::where('slug', 'scarousel')->first();

            $request->validate([
                'title' => 'required|string|max:255',
            ]);

            SectionContent::create([
                'title' => $request->title,
                'section' => 'scarousel',
                'menu_id' => $category->id,
            ]);

            return redirect()->back()->with('success', 'Berhasil');
        } catch (\Exception $err) {
            dd($err->getMessage());
        }
    }

    public function updateSectionCarousel(Request $request, $id)
    {
        try {
            $benefit = SectionContent::find($id);

            if (!$benefit) {
                return redirect()->back()->with('error', 'Data tidak ditemukan.');
            }

            $request->validate([
                'title' => 'required|string|max:255',
            ]);

            $benefit->title = $request->title;

            $benefit->save();

            return redirect()->back()->with('success', 'Data berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
