<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ServiceController extends Controller
{
    public function index()
    {
        try {
            $data = Service::all();
            return response()->json([
                'status' => 'success',
                'message' => 'Data layanan berhasil diambil',
                'data' => $data
            ], 200);
        } catch (\Exception $e) {
            Log::error('Service Index Error: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat mengambil data layanan',
                'data' => null
            ], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'title_service' => 'nullable|string',
                'content_service' => 'nullable|string',
            ]);

            $service = Service::create($request->only('title_service', 'content_service'));

            return response()->json([
                'status' => 'success',
                'message' => 'Layanan berhasil ditambahkan',
                'data' => $service
            ], 201);
        } catch (\Exception $e) {
            Log::error('Service Store Error: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat menambahkan layanan',
                'data' => null
            ], 500);
        }
    }

    public function show($id)
    {
        try {
            $service = Service::find($id);

            if (!$service) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Layanan tidak ditemukan',
                    'data' => null
                ], 404);
            }

            return response()->json([
                'status' => 'success',
                'message' => 'Detail layanan berhasil diambil',
                'data' => $service
            ], 200);
        } catch (\Exception $e) {
            Log::error('Service Show Error: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat mengambil detail layanan',
                'data' => null
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $service = Service::find($id);

            if (!$service) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Layanan tidak ditemukan',
                    'data' => null
                ], 404);
            }

            $service->update($request->only('title_service', 'content_service'));

            return response()->json([
                'status' => 'success',
                'message' => 'Layanan berhasil diperbarui',
                'data' => $service
            ], 200);
        } catch (\Exception $e) {
            Log::error('Service Update Error: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat memperbarui layanan',
                'data' => null
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $service = Service::find($id);

            if (!$service) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Layanan tidak ditemukan',
                    'data' => null
                ], 404);
            }

            $service->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Layanan berhasil dihapus',
                'data' => null
            ], 200);
        } catch (\Exception $e) {
            Log::error('Service Delete Error: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat menghapus layanan',
                'data' => null
            ], 500);
        }
    }
}
