<?php

namespace App\Http\Controllers;

use App\Models\ImgPartnership;
use App\Models\MasterSectionCategory;
use App\Models\Partnership;
use App\Models\SectionContent;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class PartnershipController
{
    public function index(Request $request)
    {
        try {

            $data = Partnership::all();
            $category = MasterSectionCategory::where('slug', 'spartnership4')->first();
            $section = SectionContent::where('menu_id', $category->id)
                ->where('section', 'spartnership4')
                ->first();
            if ($request->wantsJson()) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Data partnership berhasil diambil',
                    'data' => $data,
                    'section' => $section
                ], 200);
            }

            return view('pages.partnership.main-partnership.index-partnership', compact('data', 'section'));
        } catch (\Exception $e) {
            Log::error('Partnership Index Error: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat mengambil data partnership',
                'data' => null
            ], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'title_partnership' => 'nullable|string',
                'program_partnership' => 'nullable|string',
                'content_program_partnership' => 'nullable|string',
                'btn_color' => 'nullable|string',
                'img_partnership' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            ]);

            $imgPath = null;
            if ($request->hasFile('img_partnership')) {
                $imgPath = $request->file('img_partnership')->store('partnership', 'public');
            }

            $partnership = Partnership::create([
                'title_partnership' => $request->title_partnership,
                'program_partnership' => $request->program_partnership,
                'content_program_partnership' => $request->content_program_partnership,
                'img_partnership' => $imgPath,
            ]);

            return redirect()->back()->with('success', 'data berhasil ditambah');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function show($id)
    {
        try {
            $partnership = Partnership::find($id);

            if (!$partnership) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Partnership tidak ditemukan',
                    'data' => null
                ], 404);
            }

            return response()->json([
                'status' => 'success',
                'message' => 'Detail partnership berhasil diambil',
                'data' => $partnership
            ], 200);
        } catch (\Exception $e) {
            Log::error('Partnership Show Error: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat mengambil detail partnership',
                'data' => null
            ], 500);
        }
    }

    public function test(Request $request, $id){
        dd("ada");
    }

    public function update(Request $request, $id)
    {
        try {
            $partnership = Partnership::find($id);

            if (!$partnership) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Partnership tidak ditemukan',
                    'data' => null
                ], 404);
            }

            $request->validate([
                'title_partnership' => 'nullable|string',
                'btn_color' => 'nullable|string',
                'program_partnership' => 'nullable|string',
                'content_program_partnership' => 'nullable|string',
                'img_partnership' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            ]);

            if ($request->hasFile('img_partnership')) {
                if ($partnership->img_partnership && Storage::disk('public')->exists($partnership->img_partnership)) {
                    Storage::disk('public')->delete($partnership->img_partnership);
                }

                $partnership->img_partnership = $request->file('img_partnership')->store('partnership', 'public');
            }

            $partnership->title_partnership = $request->title_partnership;
            $partnership->program_partnership = $request->program_partnership;
            $partnership->content_program_partnership = $request->content_program_partnership;
            $partnership->btn_color = $request->btn_color;
            $partnership->save();

            return redirect()->back()->with('success', 'data berhasil diperbarui');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $partnership = Partnership::find($id);

            if (!$partnership) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Partnership tidak ditemukan',
                    'data' => null
                ], 404);
            }

            if ($partnership->img_partnership && Storage::disk('public')->exists($partnership->img_partnership)) {
                Storage::disk('public')->delete($partnership->img_partnership);
            }

            $partnership->delete();

            return redirect()->back()->with('success', 'data berhasil diperbarui');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function indexHomePartnership(Request $request)
    {
        try {
            $data = ImgPartnership::all();

            if ($request->wantsJson()) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Data partnership berhasil diambil',
                    'data' => $data
                ], 200);
            }

            if ($request->is('dashboard/home/partnership-home*')) {
                return view('pages.home.partnership.index-partnership', compact('data'));
            } elseif ($request->is('dashboard/about-us/partnership*')) {
                return view('pages.about-us.partnership.index-partnership', compact('data'));
            } else {
                return view('pages.home.partnership.index-partnership', compact('data'));
            }
        } catch (Exception $err) {
        }
    }

    public function storeHomePartnership(Request $request)
    {
        $request->validate([
            'img_partnership' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $imgPath = null;
        if ($request->hasFile('img_partnership')) {
            $imgPath = $request->file('img_partnership')->store('home_partnership', 'public');
        }

        $partnership = ImgPartnership::create([
            'img_partnership' => $imgPath,
        ]);

        return redirect()->back()->with('success', 'data image berhasil ditambah');
    }

    public function updateHomePartnership(Request $request, $id)
    {
        try {
            $partnership = ImgPartnership::find($id);

            if (!$partnership) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Partnership tidak ditemukan',
                    'data' => null
                ], 404);
            }

            $request->validate([
                'img_partnership' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            ]);

            if ($request->hasFile('img_partnership')) {
                if ($partnership->img_partnership && Storage::disk('public')->exists($partnership->img_partnership)) {
                    Storage::disk('public')->delete($partnership->img_partnership);
                }

                $partnership->img_partnership = $request->file('img_partnership')->store('partnership', 'public');
            }

            $partnership->save();

            return redirect()->back()->with('success', 'data berhasil diperbarui');
        } catch (\Exception $e) {
            Log::error('Partnership Update Error: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat memperbarui partnership',
                'data' => null
            ], 500);
        }
    }

    public function destroyHomePartnership($id)
    {
        try {
            $partnership = ImgPartnership::find($id);

            if (!$partnership) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Partnership tidak ditemukan',
                    'data' => null
                ], 404);
            }

            if ($partnership->img_partnership && Storage::disk('public')->exists($partnership->img_partnership)) {
                Storage::disk('public')->delete($partnership->img_partnership);
            }

            $partnership->delete();

            return redirect()->back()->with('success', 'data berhasil dihapus');
        } catch (\Exception $e) {
            Log::error('Partnership Delete Error: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat menghapus partnership',
                'data' => null
            ], 500);
        }
    }
}
