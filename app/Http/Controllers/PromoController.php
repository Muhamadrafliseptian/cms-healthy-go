<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\MasterSectionCategory;
use App\Models\Promo;
use App\Models\SectionContent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PromoController
{
    public function index(Request $request)
    {
        try {
            $data = Promo::all();
            $category = MasterSectionCategory::where('slug', 'spromo')->first();
            $section = SectionContent::where('menu_id', $category->id)
                ->where('section', 'spromo')
                ->first();
            if ($request->wantsJson()) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Data promo berhasil diambil',
                    'data' => $data,
                    'section' =>  $section
                ], 200);
            }

            return view('pages.product-service.promo.index-promo', compact('data', 'section'));
        } catch (\Exception $e) {
            Log::error('Promo Index Error: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat mengambil data promo',
                'data' => null
            ], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'title_promo' => 'nullable|string',
                'content_promo' => 'nullable|string',
            ]);

            $promo = Promo::create($request->only('title_promo', 'content_promo'));

            if ($request->wantsJson()) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Promo berhasil ditambahkan',
                    'data' => $promo
                ], 201);
            }

            return redirect()->back()->with('success', 'Data promo berhasil ditambah');
        } catch (\Exception $e) {
            Log::error('Promo Store Error: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat menambahkan promo',
                'data' => null
            ], 500);
        }
    }

    public function storeContentPromo(Request $request)
    {
        try {
            $category = MasterSectionCategory::where('slug', 'spromo')->first();

            SectionContent::create([
                'menu_id'    => $category->id,
                'section'    => 'spromo',
                'title'      => $request->title,
                'subtitle1'  => $request->subtitle1,
                'subtitle2'  => $request->subtitle2,
            ]);

            return back()->with('success', 'Data testimonial berhasil disimpan.');
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function updateContentPromo(Request $request, $id)
    {
        try {
            $content = SectionContent::findOrFail($id);

            $content->update([
                'title'     => $request->title,
                'subtitle1' => $request->subtitle1,
                'subtitle2' => $request->subtitle2,
            ]);

            return back()->with('success', 'Data testimonial berhasil diperbarui.');
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function show($id)
    {
        try {
            $promo = Promo::find($id);

            if (!$promo) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Promo tidak ditemukan',
                    'data' => null
                ], 404);
            }

            return response()->json([
                'status' => 'success',
                'message' => 'Detail promo berhasil diambil',
                'data' => $promo
            ], 200);
        } catch (\Exception $e) {
            Log::error('Promo Show Error: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat mengambil detail promo',
                'data' => null
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $promo = Promo::find($id);

            if (!$promo) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Promo tidak ditemukan',
                    'data' => null
                ], 404);
            }

            $promo->update($request->only('title_promo', 'content_promo'));

            if ($request->wantsJson()) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Promo berhasil diperbarui',
                    'data' => $promo
                ], 200);
            }

            return redirect()->back()->with('success', 'Data promo berhasil ditambah');
        } catch (\Exception $e) {
            Log::error('Promo Update Error: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat memperbarui promo',
                'data' => null
            ], 500);
        }
    }

    public function destroy(Request $request, $id)
    {
        try {
            $promo = Promo::find($id);

            if (!$promo) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Promo tidak ditemukan',
                    'data' => null
                ], 404);
            }

            $promo->delete();

            if ($request->wantsJson()) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Promo berhasil dihapus',
                    'data' => null
                ], 200);
            }

            return redirect()->back()->with('success', 'Data promo berhasil ditambah');
        } catch (\Exception $e) {
            Log::error('Promo Delete Error: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat menghapus promo',
                'data' => null
            ], 500);
        }
    }
}
