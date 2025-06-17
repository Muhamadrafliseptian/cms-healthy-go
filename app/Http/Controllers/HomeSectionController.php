<?php

namespace App\Http\Controllers;

use App\Models\MasterSectionCategory;
use App\Models\SectionContent;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class HomeSectionController
{
    public function index(Request $request)
    {
        try {
            $categories = MasterSectionCategory::whereIn('slug', ['sbhome', 'shome1'])
                ->get()
                ->keyBy('slug');

            $sections = SectionContent::whereIn('section', ['sbhome', 'shome1'])
                ->whereIn('menu_id', $categories->pluck('id'))
                ->get()
                ->keyBy('section');

            if ($request->wantsJson()) {
                return response()->json([
                    'status' => 'success',
                    'data' => [
                        'sbhome' => $sections->get('sbhome'),
                        'shome1' => $sections->get('shome1'),
                    ]
                ], 200);
            }

            return view('pages.home.banner.index-banner', [
                'section' => $sections->get('sbhome'),
                'section2' => $sections->get('shome1'),
            ]);
        } catch (\Exception $e) {
            Log::error('HomeController@index error: ' . $e->getMessage());
            abort(500, 'Terjadi kesalahan saat memuat data.');
        }
    }

    public function storeSectionBanner(Request $request)
    {
        try {
            $category = MasterSectionCategory::where('slug', 'sbhome')->first();

            $request->validate([
                'img' => 'required|image|mimes:jpg,jpeg,png|max:2048',
                'img2' => 'required|image|mimes:jpg,jpeg,png|max:2048',
                'title' => 'required|string|max:255',
            ]);

            $imgPath = null;
            $img2Path = null;

            if ($request->hasFile('img')) {
                $imgPath = $request->file('img')->store('home', 'public');
            }

            if ($request->hasFile('img2')) {
                $img2Path = $request->file('img2')->store('home', 'public');
            }

            SectionContent::create([
                'img' => $imgPath,
                'img2' => $img2Path, // Pastikan kolom ini ada di database
                'title' => $request->title,
                'menu_id' => $category->id,
                'section' => 'sbhome',
            ]);

            return redirect()->back()->with('success', 'Berhasil');
        } catch (\Exception $err) {
            dd($err->getMessage());
        }
    }

    public function updateSectionBanner(Request $request, $id)
    {
        try {
            $benefit = SectionContent::find($id);

            if (!$benefit) {
                return redirect()->back()->with('error', 'Data tidak ditemukan.');
            }

            $request->validate([
                'img' => 'mimes:jpg,jpeg,png|max:2048',
                'img2' => 'mimes:jpg,jpeg,png|max:2048',
                'title' => 'required|string|max:255',
            ]);

            if ($request->hasFile('img')) {
                if ($benefit->img && Storage::disk('public')->exists($benefit->img)) {
                    Storage::disk('public')->delete($benefit->img);
                }
                $benefit->img = $request->file('img')->store('home', 'public');
            }

            if ($request->hasFile('img2')) {
                if ($benefit->img2 && Storage::disk('public')->exists($benefit->img2)) {
                    Storage::disk('public')->delete($benefit->img2);
                }
                $benefit->img2 = $request->file('img2')->store('home', 'public');
            }

            $benefit->title = $request->title;

            $benefit->save();

            return redirect()->back()->with('success', 'Data berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }


    public function storeSectionDescription(Request $request)
    {
        try {

            $category = MasterSectionCategory::where('slug', 'shome1')->first();

            $request->validate([
                'img' => 'image|mimes:jpg,jpeg,png|max:2048',
                'title' => 'required|string|max:255',
                'subtitle1' => 'required|string|max:255',
                'subtitle2' => 'required|string|max:255',
                'subtitle3' => 'required|string|max:255',
                'subtitle4' => 'required|string|max:255',
                'subtitle5' => 'required|string|max:255',
            ]);

            $imgPath = null;

            if ($request->hasFile('img')) {
                $imgPath = $request->file('img')->store('home', 'public');
            }

            SectionContent::create([
                'img' => $imgPath,
                'title' => $request->title,
                'subtitle1' => $request->subtitle1,
                'subtitle2' => $request->subtitle2,
                'subtitle3' => $request->subtitle3,
                'subtitle4' => $request->subtitle4,
                'subtitle5' => $request->subtitle5,
                'menu_id' => $category->id,
                'section' => 'shome1',
            ]);

            return redirect()->back()->with('success', 'Berhasil');
        } catch (\Exception $err) {
            dd($err->getMessage());
        }
    }

    public function updateSectionDescription(Request $request, $id)
    {
        try {
            $benefit = SectionContent::find($id);

            if (!$benefit) {
                return redirect()->back()->with('error', 'Data tidak ditemukan.');
            }

            $request->validate([
                'img' => 'image|mimes:jpg,jpeg,png|max:2048',
                'title' => 'required|string|max:255',
                'subtitle1' => 'required|string|max:255',
                'subtitle2' => 'required|string|max:255',
                'subtitle3' => 'required|string|max:255',
                'subtitle4' => 'required|string|max:255',
                'subtitle5' => 'required|string|max:255',
            ]);

            if ($request->hasFile('img')) {
                if ($benefit->img && Storage::disk('public')->exists($benefit->img)) {
                    Storage::disk('public')->delete($benefit->img);
                }
                $benefit->img = $request->file('img')->store('home', 'public');
            }

            $benefit->title = $request->title;
            $benefit->subtitle1 = $request->subtitle1;
            $benefit->subtitle2 = $request->subtitle2;
            $benefit->subtitle3 = $request->subtitle3;
            $benefit->subtitle4 = $request->subtitle4;
            $benefit->subtitle5 = $request->subtitle5;

            $benefit->save();

            return redirect()->back()->with('success', 'Data berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
