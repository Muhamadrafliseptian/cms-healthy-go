<?php

namespace App\Http\Controllers;

use App\Models\MasterSectionCategory;
use App\Models\OperationalStatistic;
use App\Models\SectionContent;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class OperationalStatisticController
{
    public function index(Request $request)
    {
        try {
            $data = OperationalStatistic::all();
            $category = MasterSectionCategory::where('slug', 'sstatistic')->first();
            $section = SectionContent::where('menu_id', $category->id)
                ->where('section', 'sstatistic')
                ->first();

            if ($request->wantsJson()) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Data Statistic berhasil diambil',
                    'data' => $data
                ], 200);
            }

            return view('pages.home.statistic.index-statistic', compact('data', 'section'));
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

    public function storeContentStats(Request $request)
    {
        try {

            $category = MasterSectionCategory::where('slug', 'sstatistic')->first();

            $request->validate([
                'img' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
                'title' => 'required|string|max:255',
                'subtitle1' => 'nullable|string|max:255',
            ]);

            $imgPath = null;

            if ($request->hasFile('img')) {
                $imgPath = $request->file('img')->store('stats', 'public');
            }

            SectionContent::create([
                'img' => $imgPath,
                'title' => $request->title,
                'subtitle1' => $request->subtitle1,
                'menu_id' => $category->id,
                'section' => 'sstatistic',
            ]);

            return redirect()->back()->with('success', 'Berhasil tambah');
        } catch (\Exception $err) {
            dd($err->getMessage());
        }
    }

    public function updateContentStats(Request $request, $id)
    {
        try {
            $benefit = SectionContent::find($id);

            if (!$benefit) {
                return redirect()->back()->with('error', 'Data tidak ditemukan.');
            }

            $request->validate([
                'img' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
                'title' => 'required|string|max:255',
                'subtitle1' => 'nullable|string|max:255',
            ]);

            if ($request->hasFile('img')) {
                if ($benefit->img && Storage::disk('public')->exists($benefit->img)) {
                    Storage::disk('public')->delete($benefit->img);
                }
                $benefit->img = $request->file('img')->store('iklan', 'public');
            }

            $benefit->title = $request->title;
            $benefit->subtitle1 = $request->subtitle1;

            $benefit->save();

            return redirect()->back()->with('success', 'Data berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
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
