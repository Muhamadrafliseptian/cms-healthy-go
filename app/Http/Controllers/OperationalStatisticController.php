<?php

namespace App\Http\Controllers;

use App\Models\OperationalStatistic;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class OperationalStatisticController
{
    public function index(Request $request)
    {
        try {
            $data = OperationalStatistic::all();
            if ($request->wantsJson()) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Data Statistic berhasil diambil',
                    'data' => $data
                ], 200);
            }

            return view('pages.home.statistic.index-statistic', compact('data'));
        } catch (\Exception $e) {
            Log::error('Service Index Error: ' . $e->getMessage());
            if ($request->wantsJson()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Terjadi kesalahan saat mengambil data Statistic',
                    'data' => null
                ], 500);
            }
            return redirect()->back()->with('error', 'Terjadi kesalahan saat mengambil data Statistic');
        }
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'title_statistic' => 'nullable|string',
                'content_statistic' => 'nullable|string',
            ]);

            $service = OperationalStatistic::create($request->only('title_statistic', 'content_statistic'));

            if ($request->wantsJson()) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Statistic berhasil ditambahkan',
                    'data' => $service
                ], 201);
            }

            return redirect()->back()->with('success', 'Data berhasil ditambah');

        } catch (\Exception $e) {
            Log::error('Service Store Error: ' . $e->getMessage());

            if ($request->wantsJson()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Terjadi kesalahan saat menambahkan Statistic',
                    'data' => null
                ], 500);
            }

            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function show(Request $request, $id)
    {
        try {
            $service = OperationalStatistic::find($id);

            if (!$service) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Statistic tidak ditemukan',
                    'data' => null
                ], 404);
            }

            if ($request->wantsJson()) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Detail Statistic berhasil diambil',
                    'data' => $service
                ], 200);
            }

            return view('pages.home.Statistic.index-Statistic', compact('service'));
        } catch (\Exception $e) {
            Log::error('Service Show Error: ' . $e->getMessage());
            if ($request->wantsJson()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Terjadi kesalahan saat mengambil detail Statistic',
                    'data' => null
                ], 500);
            }

            return redirect()->back()->with('error', $e->getMessage());

        }
    }

    public function update(Request $request, $id)
    {
        try {
            $service = OperationalStatistic::find($id);

            if (!$service) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Statistic tidak ditemukan',
                    'data' => null
                ], 404);
            }

            $service->update($request->only('title_statistic', 'content_statistic'));

            if ($request->wantsJson()) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Statistic berhasil diperbarui',
                    'data' => $service
                ], 200);
            }

            return redirect()->back()->with('success', 'Data berhasil diubah');
        } catch (\Exception $e) {
            Log::error('Service Update Error: ' . $e->getMessage());
            if ($request->wantsJson()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Terjadi kesalahan saat memperbarui Statistic',
                    'data' => null
                ], 500);
            }
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function destroy(Request $request, $id)
    {
        try {
            $service = OperationalStatistic::find($id);

            if (!$service) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Statistic tidak ditemukan',
                    'data' => null
                ], 404);
            }

            $service->delete();

            if ($request->wantsJson()) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Statistic berhasil dihapus',
                    'data' => null
                ], 200);
            }

            return redirect()->back()->with('success', 'Data berhasil dihapus');
        } catch (\Exception $e) {
            Log::error('Service Delete Error: ' . $e->getMessage());
            if ($request->wantsJson()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Terjadi kesalahan saat menghapus Statistic',
                    'data' => null
                ], 500);
            }
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
