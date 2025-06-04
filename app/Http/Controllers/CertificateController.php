<?php

namespace App\Http\Controllers;

use App\Models\Certificate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class CertificateController
{
    public function index(Request $request)
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
                'img_certificate' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
            ], [
                'img_certificate.required' => 'Gambar wajib diunggah.',
                'img_certificate.image' => 'File harus berupa gambar.',
                'img_certificate.mimes' => 'Format gambar harus jpg, jpeg, png, atau webp.',
                'img_certificate.max' => 'Ukuran gambar maksimal 2MB.',
            ]);

            $imgPath = null;
            if ($request->hasFile('img_certificate')) {
                $imgPath = $request->file('img_certificate')->store('certificate', 'public');
            }

            $certificate = Certificate::create([
                'img_certificate' => $imgPath,
            ]);

            return redirect()->back()->with('success', 'Data berhasil ditambah');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function show($id) {}

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
                'img_certificate' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
            ], [
                'img_certificate.required' => 'Gambar wajib diunggah.',
                'img_certificate.image' => 'File harus berupa gambar.',
                'img_certificate.mimes' => 'Format gambar harus jpg, jpeg, png, atau webp.',
                'img_certificate.max' => 'Ukuran gambar maksimal 2MB.',
            ]);

            if ($request->hasFile('img_certificate')) {
                if ($certificate->img_certificate && Storage::disk('public')->exists($certificate->img_certificate)) {
                    Storage::disk('public')->delete($certificate->img_certificate);
                }

                $certificate->img_certificate = $request->file('img_certificate')->store('certificate', 'public');
            }

            $certificate->save();

            return redirect()->back()->with('success', 'Data berhasil diperbarui');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $certificate = Certificate::find($id);

            if ($certificate->img_certificate && Storage::disk('public')->exists($certificate->img_certificate)) {
                Storage::disk('public')->delete($certificate->img_certificate);
            }

            $certificate->delete();

            return redirect()->back()->with('success', 'Data berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
