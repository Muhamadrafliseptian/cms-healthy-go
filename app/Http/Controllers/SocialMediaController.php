<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\SocialMedia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SocialMediaController
{
    public function index(Request $request)
    {
        try {
            $data = SocialMedia::all();
            if($request->wantsJson()){
                return response()->json([
                    'status' => 'success',
                    'message' => 'Data socialmedia berhasil diambil',
                    'data' => $data
                ], 200);
            }

            return view('pages.social-media.index-social-media', compact('data'));
        } catch (\Exception $e) {
            Log::error('socialmedia Index Error: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat mengambil data socialmedia',
                'data' => null
            ], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string',
                'icon' => 'required|string',
                'content' => 'required|string',
            ]);

            $sosmed = SocialMedia::create($request->only('name', 'icon', 'content'));

            if($request->wantsJson()){
                return response()->json([
                    'status' => 'success',
                    'message' => 'Social Media berhasil ditambahkan',
                    'data' => $sosmed
                ], 201);
            }
            return redirect()->back()->with('success', 'Social Media berhasil ditambahkan');
        } catch (\Exception $e) {
            Log::error('socialmedia Store Error: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat menambahkan socialmedia',
                'data' => null
            ], 500);
        }
    }

    public function show($id)
    {
        try {
            $sosmed = SocialMedia::find($id);

            if (!$sosmed) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'socialmedia tidak ditemukan',
                    'data' => null
                ], 404);
            }

            return response()->json([
                'status' => 'success',
                'message' => 'Detail socialmedia berhasil diambil',
                'data' => $sosmed
            ], 200);
        } catch (\Exception $e) {
            Log::error('socialmedia Show Error: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat mengambil detail socialmedia',
                'data' => null
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $sosmed = SocialMedia::find($id);

            if (!$sosmed) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'socialmedia tidak ditemukan',
                    'data' => null
                ], 404);
            }

            $sosmed->update($request->only('name', 'icon', 'content'));

            if($request->wantsJson()){
                return response()->json([
                    'status' => 'success',
                    'message' => 'socialmedia berhasil diperbarui',
                    'data' => $sosmed
                ], 200);
            }
            return redirect()->back()->with('success', 'socialmedia berhasil diperbarui');
        } catch (\Exception $e) {
            Log::error('socialmedia Update Error: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat memperbarui socialmedia',
                'data' => null
            ], 500);
        }
    }

    public function destroy(Request $request, $id)
    {
        try {
            $sosmed = SocialMedia::find($id);

            if (!$sosmed) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'socialmedia tidak ditemukan',
                    'data' => null
                ], 404);
            }

            $sosmed->delete();

            if($request->wantsJson()){
                return response()->json([
                    'status' => 'success',
                    'message' => 'socialmedia berhasil dihapus',
                    'data' => null
                ], 200);
            }
            return redirect()->back()->with('success', 'socialmedia berhasil dihapus');
        } catch (\Exception $e) {
            Log::error('socialmedia Delete Error: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat menghapus socialmedia',
                'data' => null
            ], 500);
        }
    }
}
