<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Promo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PromoController extends Controller
{
    public function index()
    {
        try {
            $data = Promo::all();
            return response()->json([
                'status' => 'success',
                'message' => 'Data promo berhasil diambil',
                'data' => $data
            ], 200);
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

            return response()->json([
                'status' => 'success',
                'message' => 'Promo berhasil ditambahkan',
                'data' => $promo
            ], 201);
        } catch (\Exception $e) {
            Log::error('Promo Store Error: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat menambahkan promo',
                'data' => null
            ], 500);
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

            return response()->json([
                'status' => 'success',
                'message' => 'Promo berhasil diperbarui',
                'data' => $promo
            ], 200);
        } catch (\Exception $e) {
            Log::error('Promo Update Error: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat memperbarui promo',
                'data' => null
            ], 500);
        }
    }

    public function destroy($id)
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

            return response()->json([
                'status' => 'success',
                'message' => 'Promo berhasil dihapus',
                'data' => null
            ], 200);
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
