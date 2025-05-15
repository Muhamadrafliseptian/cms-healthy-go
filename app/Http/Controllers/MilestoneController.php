<?php

namespace App\Http\Controllers;

use App\Models\Milestone;
use Illuminate\Http\Request;
use Log;

class MilestoneController
{
    public function index(Request $request)
    {
        try {
            $data = Milestone::all();
            if ($request->wantsJson()) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Data layanan berhasil diambil',
                    'data' => $data
                ], 200);
            }

            return view('pages.about-us.milestone.index-milestone', compact('data'));
        } catch (\Exception $e) {
            Log::error('Service Index Error: ' . $e->getMessage());
            if ($request->wantsJson()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Terjadi kesalahan saat mengambil data layanan',
                    'data' => null
                ], 500);
            }
            return redirect()->back()->with('error', 'Terjadi kesalahan saat mengambil data layanan');
        }
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'year' => 'nullable|string',
                'title_milestone' => 'nullable|string',
                'content_milestone' => 'nullable|string',
            ]);

            $milestone = Milestone::create($request->only('year', 'title_milestone', 'content_milestone'));

            if ($request->wantsJson()) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Milestone berhasil ditambahkan',
                    'data' => $milestone
                ], 201);
            }

            return redirect()->back()->with('success', 'Data berhasil ditambah');

        } catch (\Exception $e) {
            Log::error('Service Store Error: ' . $e->getMessage());

            if ($request->wantsJson()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Terjadi kesalahan saat menambahkan milestone',
                    'data' => null
                ], 500);
            }

            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function show(Request $request, $id)
    {
        try {
            $milestone = Milestone::find($id);

            if (!$milestone) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Milestone tidak ditemukan',
                    'data' => null
                ], 404);
            }

            if ($request->wantsJson()) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Detail Milestone berhasil diambil',
                    'data' => $milestone
                ], 200);
            }

            return view('pages.about-us.milestone.index-milestone', compact('service'));
        } catch (\Exception $e) {
            Log::error('Service Show Error: ' . $e->getMessage());
            if ($request->wantsJson()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Terjadi kesalahan saat mengambil detail layanan',
                    'data' => null
                ], 500);
            }

            return redirect()->back()->with('error', $e->getMessage());

        }
    }

    public function update(Request $request, $id)
    {
        try {
            $milestone = Milestone::find($id);

            if (!$milestone) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Layanan tidak ditemukan',
                    'data' => null
                ], 404);
            }

            $milestone->update($request->only('year','title_milestone', 'content_milestone'));

            if ($request->wantsJson()) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Layanan berhasil diperbarui',
                    'data' => $milestone
                ], 200);
            }

            return redirect()->back()->with('success', 'Data berhasil diubah');
        } catch (\Exception $e) {
            Log::error('Service Update Error: ' . $e->getMessage());
            if ($request->wantsJson()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Terjadi kesalahan saat memperbarui layanan',
                    'data' => null
                ], 500);
            }
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function destroy(Request $request, $id)
    {
        try {
            $milestone = Milestone::find($id);

            if (!$milestone) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Layanan tidak ditemukan',
                    'data' => null
                ], 404);
            }

            $milestone->delete();

            if ($request->wantsJson()) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Layanan berhasil dihapus',
                    'data' => null
                ], 200);
            }

            return redirect()->back()->with('success', 'Data berhasil dihapus');
        } catch (\Exception $e) {
            Log::error('Service Delete Error: ' . $e->getMessage());
            if ($request->wantsJson()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Terjadi kesalahan saat menghapus layanan',
                    'data' => null
                ], 500);
            }
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
