<?php

namespace App\Http\Controllers;

use App\Models\Carousel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class CarouselController extends Controller
{
    public function index()
    {
        try {
            $data = Carousel::all();

            return response()->json([
                'status' => 'success',
                'message' => 'Data carousel berhasil diambil',
                'data' => $data
            ], 200);
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
                'name' => $request->name,
                'program_name' => $request->program_name,
                'content' => $request->content,
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Carousel berhasil ditambahkan',
                'data' => $carousel
            ], 201);
        } catch (\Exception $e) {
            Log::error('Carousel Store Error: ' . $e->getMessage());

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

            $carousel->name = $request->name;
            $carousel->program_name = $request->program_name;
            $carousel->content = $request->content;
            $carousel->save();

            return response()->json([
                'status' => 'success',
                'message' => 'Carousel berhasil diperbarui',
                'data' => $carousel
            ], 200);
        } catch (\Exception $e) {
            Log::error('Carousel Update Error: ' . $e->getMessage());

            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat memperbarui carousel',
                'data' => null
            ], 500);
        }
    }

    public function destroy($id)
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

            return response()->json([
                'status' => 'success',
                'message' => 'Carousel berhasil dihapus',
                'data' => null
            ], 200);
        } catch (\Exception $e) {
            Log::error('Carousel Delete Error: ' . $e->getMessage());

            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat menghapus carousel',
                'data' => null
            ], 500);
        }
    }
}
