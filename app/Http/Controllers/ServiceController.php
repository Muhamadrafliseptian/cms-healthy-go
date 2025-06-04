<?php

namespace App\Http\Controllers;

use App\Models\MasterSectionCategory;
use App\Models\SectionContent;
use App\Models\Service;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class ServiceController
{
    public function index(Request $request)
    {
        try {
            $data = Service::all();
            $category = MasterSectionCategory::where('slug', 'ssservice')->first();
            $section = SectionContent::where('menu_id', $category->id)
                ->where('section', 'ssservice')
                ->first();

            if ($request->wantsJson()) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Data layanan berhasil diambil',
                    'data' => $data,
                    'section' => $section
                ], 200);
            }

            return view('pages.home.layanan.index-layanan',  [
                'data' => $data,
                'section' => $section,
            ]);
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
                'title_service' => 'required|string',
                'content_service' => 'required|string',
            ]);

            $service = Service::create($request->only('title_service', 'content_service'));

            return redirect()->back()->with('success', 'Data berhasil ditambah');
        } catch (\Exception $e) {
            Log::error('Service Store Error: ' . $e->getMessage());

            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function storeSectionService(Request $request)
    {
        try {
            $category = MasterSectionCategory::where('slug', 'ssservice')->first();

            SectionContent::create([
                'title' => $request->title,
                'subtitle1' => $request->subtitle1,
                'subtitle2' => $request->subtitle2,
                'subtitle3' => $request->subtitle3,
                'subtitle4' => $request->subtitle4,
                'menu_id' => $category->id,
                'section' => 'ssservice',
            ]);

            return redirect()->back()->with('success', 'Data berhasil ditambah');
        } catch (\Exception $e) {
            Log::error('Service Store Error: ' . $e->getMessage());

            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function updateSectionService(Request $request, $id)
    {
        try {
            $benefit = SectionContent::find($id);

            $benefit->title = $request->title;
            $benefit->subtitle1 = $request->subtitle1;
            $benefit->subtitle2 = $request->subtitle2;
            $benefit->subtitle3 = $request->subtitle3;
            $benefit->subtitle4 = $request->subtitle4;

            $benefit->save();

            return redirect()->back()->with('success', 'Data berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function show(Request $request, $id)
    {
        try {
            $service = Service::find($id);

            return view('pages.home.layanan.index-layanan', compact('service'));
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
            $service = Service::find($id);

            if (!$service) {
            }

            $service->update($request->only('title_service', 'content_service'));

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
            $service = Service::find($id);

            if (!$service) {
            }

            $service->delete();

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
