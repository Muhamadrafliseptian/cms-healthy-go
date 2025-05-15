<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\TNC;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TnCController 
{
    public function index(Request $request)
    {
        try {
            $data = TNC::all();
            if($request->wantsJson()){
                return response()->json([
                    'status' => 'success',
                    'message' => 'Data Terms and Conditions berhasil diambil',
                    'data' => $data
                ], 200);
            }

            return view ('pages.tnc.index-tnc', compact('data'));
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
                'title_tnc' => 'nullable|string',
                'subtitle_tnc' => 'nullable|string',
                'content_tnc' => 'nullable|string',
            ]);

            $tnc = TNC::create($request->only('title_tnc', 'subtitle_tnc', 'content_tnc'));

            return response()->json([
                'status' => 'success',
                'message' => 'Terms and Conditions berhasil ditambahkan',
                'data' => $tnc
            ], 201);
        } catch (\Exception $e) {
            Log::error('TnC Store Error: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat menambahkan Terms and Conditions',
                'data' => null
            ], 500);
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
                'title_tnc' => 'nullable|string',
                'subtitle_tnc' => 'nullable|string',
                'content_tnc' => 'nullable|string',
            ]);

            $tnc->update($request->only('title_tnc', 'subtitle_tnc', 'content_tnc'));

            return response()->json([
                'status' => 'success',
                'message' => 'Terms and Conditions berhasil diperbarui',
                'data' => $tnc
            ], 200);
        } catch (\Exception $e) {
            Log::error('TnC Update Error: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat memperbarui Terms and Conditions',
                'data' => null
            ], 500);
        }
    }

    public function destroy($id)
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

            return response()->json([
                'status' => 'success',
                'message' => 'Terms and Conditions berhasil dihapus',
                'data' => null
            ], 200);
        } catch (\Exception $e) {
            Log::error('TnC Delete Error: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat menghapus Terms and Conditions',
                'data' => null
            ], 500);
        }
    }
}
