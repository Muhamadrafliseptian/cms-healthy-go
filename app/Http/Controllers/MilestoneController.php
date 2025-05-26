<?php

namespace App\Http\Controllers;

use App\Models\MasterSectionCategory;
use App\Models\Milestone;
use App\Models\SectionContent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MilestoneController
{
    public function index(Request $request)
    {
        try {
            $data = Milestone::all();

            $category = MasterSectionCategory::where('slug', 'smilestones')->first();
            $section = SectionContent::where('menu_id', $category->id)
                ->where('section', 'smilestones')
                ->first();

            if ($request->wantsJson()) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Data layanan berhasil diambil',
                    'data' => $data,
                    'section' => $section,
                ], 200);
            }

            return view('pages.about-us.milestone.index-milestone', compact('data', 'section'));
        } catch (\Exception $e) {
            Log::error('Service Index Error: ' . $e->getMessage());
            if ($request->wantsJson()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Terjadi kesalahan saat mengambil data layanan',
                    'data' => null,
                    'section' => null
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

            return redirect()->back()->with('success', 'Data berhasil ditambah');
        } catch (\Exception $e) {
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

            $milestone->update($request->only('year', 'title_milestone', 'content_milestone'));

            if ($request->wantsJson()) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Layanan berhasil diperbarui',
                    'data' => $milestone
                ], 200);
            }

            return redirect()->back()->with('success', 'Data berhasil diubah');
        } catch (\Exception $e) {
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

            return redirect()->back()->with('success', 'Data berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function storeSection(Request $request)
    {
        try {
            $category = MasterSectionCategory::where('slug', 'smilestones')->first();

            SectionContent::create([
                'title' => $request->title,
                'subtitle1' => $request->subtitle1,
                'subtitle2' => $request->subtitle2,
                'subtitle3' => $request->subtitle3,
                'menu_id' => $category->id,
                'section' => 'smilestones',
            ]);

            return redirect()->back()->with('success', 'Data berhasil ditambah');
        } catch (\Exception $e) {
            Log::error('Service Store Error: ' . $e->getMessage());

            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function updateSection(Request $request, $id)
    {
        try {
            $benefit = SectionContent::find($id);

            $benefit->title = $request->title;
            $benefit->subtitle1 = $request->subtitle1;
            $benefit->subtitle2 = $request->subtitle2;
            $benefit->subtitle3 = $request->subtitle3;

            $benefit->save();

            return redirect()->back()->with('success', 'Data berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
