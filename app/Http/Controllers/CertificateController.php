<?php

namespace App\Http\Controllers;

use App\Models\Certificate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class CertificateController 
{
    public function index(Request $request )
    {
        try {
            $data = Certificate::all();

            if ($request->wantsJson()) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Data Certificate berhasil diambil',
                    'data' => $data
                ], 200);
            }

            return view('pages.home.certificate.index-certificate', compact('data'));
        } catch (\Exception $e) {
            Log::error('Certificate Index Error: ' . $e->getMessage());

            if ($request->wantsJson()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Terjadi kesalahan saat mengambil data Certificate',
                    'data' => null
                ], 500);
            }

            return redirect()->back()->with('error', 'Terjadi kesalahan saat mengambil data Certificate');
        }
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'img_certificate' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            ]);

            $imgPath = null;
            if ($request->hasFile('img_certificate')) {
                $imgPath = $request->file('img_certificate')->store('certificate', 'public');
            }

            $certificate = Certificate::create([
                'img_certificate' => $imgPath,
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Certificate berhasil ditambahkan',
                'data' => $certificate
            ], 201);
        } catch (\Exception $e) {
            Log::error('Certificate Store Error: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat menyimpan Certificate',
                'data' => null
            ], 500);
        }
    }

    public function show($id)
    {
        try {
            $certificate = Certificate::find($id);

            if (!$certificate) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Certificate tidak ditemukan',
                    'data' => null
                ], 404);
            }

            return response()->json([
                'status' => 'success',
                'message' => 'Detail Certificate berhasil diambil',
                'data' => $certificate
            ], 200);
        } catch (\Exception $e) {
            Log::error('Certificate Show Error: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat mengambil detail Certificate',
                'data' => null
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $certificate = Certificate::find($id);

            if (!$certificate) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Certificate tidak ditemukan',
                    'data' => null
                ], 404);
            }

            $request->validate([
                'img_certificate' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            ]);

            if ($request->hasFile('img_certificate')) {
                if ($certificate->img_certificate && Storage::disk('public')->exists($certificate->img_certificate)) {
                    Storage::disk('public')->delete($certificate->img_certificate);
                }

                $certificate->img_certificate = $request->file('img_certificate')->store('Certificate', 'public');
            }

            $certificate->save();

            return response()->json([
                'status' => 'success',
                'message' => 'Certificate berhasil diperbarui',
                'data' => $certificate
            ], 200);
        } catch (\Exception $e) {
            Log::error('Certificate Update Error: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat memperbarui Certificate',
                'data' => null
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $certificate = Certificate::find($id);

            if (!$certificate) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Certificate tidak ditemukan',
                    'data' => null
                ], 404);
            }

            if ($certificate->img_certificate && Storage::disk('public')->exists($certificate->img_certificate)) {
                Storage::disk('public')->delete($certificate->img_certificate);
            }

            $certificate->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Certificate berhasil dihapus',
                'data' => null
            ], 200);
        } catch (\Exception $e) {
            Log::error('Certificate Delete Error: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat menghapus Certificate',
                'data' => null
            ], 500);
        }
    }
}
