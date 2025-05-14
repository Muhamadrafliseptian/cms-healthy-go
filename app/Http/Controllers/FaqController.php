<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class FaqController 
{
    public function index()
    {
        try {
            $data = Faq::all();

            return response()->json([
                'status' => 'success',
                'message' => 'Data FAQ berhasil diambil',
                'data' => $data
            ], 200);
        } catch (\Exception $e) {
            Log::error('FAQ Index Error: ' . $e->getMessage());

            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat mengambil data FAQ',
                'data' => null
            ], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'ask_title' => 'nullable|string',
                'ask_content' => 'nullable|string',
            ]);

            $faq = Faq::create($request->only('ask_title', 'ask_content'));

            return response()->json([
                'status' => 'success',
                'message' => 'FAQ berhasil ditambahkan',
                'data' => $faq
            ], 201);
        } catch (\Exception $e) {
            Log::error('FAQ Store Error: ' . $e->getMessage());

            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat menambahkan FAQ',
                'data' => null
            ], 500);
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

            $faq->update($request->only('ask_title', 'ask_content'));

            return response()->json([
                'status' => 'success',
                'message' => 'FAQ berhasil diperbarui',
                'data' => $faq
            ], 200);
        } catch (\Exception $e) {
            Log::error('FAQ Update Error: ' . $e->getMessage());

            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat memperbarui FAQ',
                'data' => null
            ], 500);
        }
    }

    public function destroy($id)
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

            return response()->json([
                'status' => 'success',
                'message' => 'FAQ berhasil dihapus',
                'data' => null
            ], 200);
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
