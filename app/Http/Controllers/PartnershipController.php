<?php

namespace App\Http\Controllers;

use App\Models\Partnership;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class PartnershipController 
{
    public function index(Request $request)
    {
        try {
            $data = Partnership::all();
            if($request->wantsJson()){
                return response()->json([
                    'status' => 'success',
                    'message' => 'Data partnership berhasil diambil',
                    'data' => $data
                ], 200);
            }

            return view('pages.home.partnership.index-partnership', compact('data'));
        } catch (\Exception $e) {
            Log::error('Partnership Index Error: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat mengambil data partnership',
                'data' => null
            ], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'title_partnership' => 'nullable|string',
                'program_partnership' => 'nullable|string',
                'content_program_partnership' => 'nullable|string',
                'img_partnership' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            ]);

            $imgPath = null;
            if ($request->hasFile('img_partnership')) {
                $imgPath = $request->file('img_partnership')->store('partnership', 'public');
            }

            $partnership = Partnership::create([
                'title_partnership' => $request->title_partnership,
                'program_partnership' => $request->program_partnership,
                'content_program_partnership' => $request->content_program_partnership,
                'img_partnership' => $imgPath,
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Partnership berhasil ditambahkan',
                'data' => $partnership
            ], 201);
        } catch (\Exception $e) {
            Log::error('Partnership Store Error: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat menyimpan partnership',
                'data' => null
            ], 500);
        }
    }

    public function show($id)
    {
        try {
            $partnership = Partnership::find($id);

            if (!$partnership) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Partnership tidak ditemukan',
                    'data' => null
                ], 404);
            }

            return response()->json([
                'status' => 'success',
                'message' => 'Detail partnership berhasil diambil',
                'data' => $partnership
            ], 200);
        } catch (\Exception $e) {
            Log::error('Partnership Show Error: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat mengambil detail partnership',
                'data' => null
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $partnership = Partnership::find($id);

            if (!$partnership) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Partnership tidak ditemukan',
                    'data' => null
                ], 404);
            }

            $request->validate([
                'title_partnership' => 'nullable|string',
                'program_partnership' => 'nullable|string',
                'content_program_partnership' => 'nullable|string',
                'img_partnership' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            ]);

            if ($request->hasFile('img_partnership')) {
                if ($partnership->img_partnership && Storage::disk('public')->exists($partnership->img_partnership)) {
                    Storage::disk('public')->delete($partnership->img_partnership);
                }

                $partnership->img_partnership = $request->file('img_partnership')->store('partnership', 'public');
            }

            $partnership->title_partnership = $request->title_partnership;
            $partnership->program_partnership = $request->program_partnership;
            $partnership->content_program_partnership = $request->content_program_partnership;
            $partnership->save();

            return response()->json([
                'status' => 'success',
                'message' => 'Partnership berhasil diperbarui',
                'data' => $partnership
            ], 200);
        } catch (\Exception $e) {
            Log::error('Partnership Update Error: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat memperbarui partnership',
                'data' => null
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $partnership = Partnership::find($id);

            if (!$partnership) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Partnership tidak ditemukan',
                    'data' => null
                ], 404);
            }

            if ($partnership->img_partnership && Storage::disk('public')->exists($partnership->img_partnership)) {
                Storage::disk('public')->delete($partnership->img_partnership);
            }

            $partnership->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Partnership berhasil dihapus',
                'data' => null
            ], 200);
        } catch (\Exception $e) {
            Log::error('Partnership Delete Error: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat menghapus partnership',
                'data' => null
            ], 500);
        }
    }
}
