<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Testimoni;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TestimoniController extends Controller
{
    public function index()
    {
        try {
            $data = Testimoni::all();
            return response()->json([
                'status' => 'success',
                'message' => 'Data testimoni berhasil diambil',
                'data' => $data
            ], 200);
        } catch (\Exception $e) {
            Log::error('Testimoni Index Error: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat mengambil data testimoni',
                'data' => null
            ], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'nullable|string',
                'program_name' => 'nullable|string',
                'content' => 'nullable|string',
                'ava_testimoni' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            ]);

            $imgPath = null;

            if ($request->hasFile('ava_testimoni')) {
                $imgPath = $request->file('ava_testimoni')->store('testimoni', 'public');
            }

            $testimoni = Testimoni::create([
                'name' => $request->name,
                'program_name' => $request->program_name,
                'content' => $request->content,
                'ava_testimoni' => $imgPath,
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Testimoni berhasil ditambahkan',
                'data' => $testimoni
            ], 201);
        } catch (\Exception $e) {
            Log::error('Testimoni Store Error: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat menambahkan testimoni',
                'data' => null
            ], 500);
        }
    }

    public function show($id)
    {
        try {
            $testimoni = Testimoni::find($id);

            if (!$testimoni) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Testimoni tidak ditemukan',
                    'data' => null
                ], 404);
            }

            return response()->json([
                'status' => 'success',
                'message' => 'Detail testimoni berhasil diambil',
                'data' => $testimoni
            ], 200);
        } catch (\Exception $e) {
            Log::error('Testimoni Show Error: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat mengambil detail testimoni',
                'data' => null
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $testimoni = Testimoni::find($id);

            if (!$testimoni) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Testimoni tidak ditemukan',
                    'data' => null
                ], 404);
            }

            $request->validate([
                'name' => 'nullable|string',
                'program_name' => 'nullable|string',
                'content' => 'nullable|string',
                'ava_testimoni' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            ]);

            if ($request->hasFile('ava_testimoni')) {
                if ($testimoni->ava_testimoni && \Storage::disk('public')->exists($testimoni->ava_testimoni)) {
                    \Storage::disk('public')->delete($testimoni->ava_testimoni);
                }

                $testimoni->ava_testimoni = $request->file('ava_testimoni')->store('testimoni', 'public');
            }

            $testimoni->name = $request->name;
            $testimoni->program_name = $request->program_name;
            $testimoni->content = $request->content;
            $testimoni->save();

            return response()->json([
                'status' => 'success',
                'message' => 'Testimoni berhasil diperbarui',
                'data' => $testimoni
            ], 200);
        } catch (\Exception $e) {
            Log::error('Testimoni Update Error: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat memperbarui testimoni',
                'data' => null
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $testimoni = Testimoni::find($id);

            if (!$testimoni) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Testimoni tidak ditemukan',
                    'data' => null
                ], 404);
            }

            if ($testimoni->ava_testimoni && \Storage::disk('public')->exists($testimoni->ava_testimoni)) {
                \Storage::disk('public')->delete($testimoni->ava_testimoni);
            }

            $testimoni->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Testimoni berhasil dihapus',
                'data' => null
            ], 200);
        } catch (\Exception $e) {
            Log::error('Testimoni Delete Error: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat menghapus testimoni',
                'data' => null
            ], 500);
        }
    }
}
