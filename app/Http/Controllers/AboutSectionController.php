<?php

namespace App\Http\Controllers;

use App\Models\AboutImage;
use App\Models\MasterSectionCategory;
use App\Models\SectionContent;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AboutSectionController
{
    public function index(Request $request)
    {
        try {
            $categories = MasterSectionCategory::whereIn('slug', ['sabout'])
                ->get()
                ->keyBy('slug');

            $sections = SectionContent::whereIn('section', ['sabout'])
                ->whereIn('menu_id', $categories->pluck('id'))
                ->get()
                ->keyBy('section');
            $data = AboutImage::all();

            if ($request->wantsJson()) {
                return response()->json([
                    'status' => 'success',
                    'data' => [
                        'section' => $sections->get('sabout'),
                        'image' => $data
                    ]
                ], 200);
            }

            return view('pages.about-us.banner.index-banner', [
                'section' => $sections->get('sabout'),
                'data' => $data,
            ]);
        } catch (\Exception $e) {
            abort(500, 'Terjadi kesalahan saat memuat data.');
        }
    }

    public function storeSectionBanner(Request $request)
    {
        try {

            $category = MasterSectionCategory::where('slug', 'sabout')->first();

            $request->validate([
                'img' => 'required|image|mimes:jpg,jpeg,png|max:2048',
                'title' => 'required|string|max:255',
                'subtitle1' => 'required|string',
            ]);

            $imgPath = null;

            if ($request->hasFile('img')) {
                $imgPath = $request->file('img')->store('about', 'public');
            }

            SectionContent::create([
                'img' => $imgPath,
                'title' => $request->title,
                'subtitle1' => $request->subtitle1,
                'menu_id' => $category->id,
                'section' => 'sabout',
            ]);

            return redirect()->back()->with('success', 'Berhasil');
        } catch (\Exception $err) {
            return redirect()->back()->with('error', $err->getMessage());
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
                'img' => 'image|mimes:jpg,jpeg,png|max:2048',
                'title' => 'required|string|max:255',
                'subtitle1' => 'required|string',
            ]);

            if ($request->hasFile('img')) {
                if ($benefit->img && Storage::disk('public')->exists($benefit->img)) {
                    Storage::disk('public')->delete($benefit->img);
                }
                $benefit->img = $request->file('img')->store('about', 'public');
            }

            $benefit->title = $request->title;
            $benefit->subtitle1 = $request->subtitle1;

            $benefit->save();

            return redirect()->back()->with('success', 'Data berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function indexContentDescription(Request $request)
    {
        try {
            $categories = MasterSectionCategory::whereIn('slug', ['sabout1'])
                ->get()
                ->keyBy('slug');

            $sections = SectionContent::whereIn('section', ['sabout1'])
                ->whereIn('menu_id', $categories->pluck('id'))
                ->get()
                ->keyBy('section');

            if ($request->wantsJson()) {
                return response()->json([
                    'status' => 'success',
                    'data' => [
                        'section' => $sections->get('sabout1'),
                    ],
                ], 200);
            }

            return view('pages.about-us.description.index-description', [
                'section' => $sections->get('sabout1'),
            ]);
        } catch (\Exception $e) {
            abort(500, 'Terjadi kesalahan saat memuat data.');
        }
    }

    public function storeSectionDescription(Request $request)
    {
        try {

            $category = MasterSectionCategory::where('slug', 'sabout1')->first();

            $request->validate([
                'img' => 'required|image|mimes:jpg,jpeg,png|max:2048',
                'title' => 'required|string|max:255',
                'subtitle1' => 'required|string',
            ]);

            $imgPath = null;

            if ($request->hasFile('img')) {
                $imgPath = $request->file('img')->store('about', 'public');
            }

            SectionContent::create([
                'img' => $imgPath,
                'title' => $request->title,
                'subtitle1' => $request->subtitle1,
                'menu_id' => $category->id,
                'section' => 'sabout1',
            ]);

            return redirect()->back()->with('success', 'Berhasil');
        } catch (\Exception $err) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $err->getMessage());
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
                'subtitle1' => 'required|string',
            ]);

            if ($request->hasFile('img')) {
                if ($benefit->img && Storage::disk('public')->exists($benefit->img)) {
                    Storage::disk('public')->delete($benefit->img);
                }
                $benefit->img = $request->file('img')->store('about', 'public');
            }

            $benefit->title = $request->title;
            $benefit->subtitle1 = $request->subtitle1;

            $benefit->save();

            return redirect()->back()->with('success', 'Data berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function indexFooter(Request $request)
    {
        try {
            $categories = MasterSectionCategory::whereIn('slug', ['sabout1'])
                ->get()
                ->keyBy('slug');

            $sections = SectionContent::whereIn('section', ['sabout1'])
                ->whereIn('menu_id', $categories->pluck('id'))
                ->get()
                ->keyBy('section');

            if ($request->wantsJson()) {
                return response()->json([
                    'status' => 'success',
                    'data' => [
                        'section' => $sections->get('sabout1'),
                    ],
                ], 200);
            }

            return view('pages.about-us.description.index-description', [
                'section' => $sections->get('sabout1'),
            ]);
        } catch (\Exception $e) {
            abort(500, 'Terjadi kesalahan saat memuat data.');
        }
    }

    public function storeFooter(Request $request)
    {
        try {

            $category = MasterSectionCategory::where('slug', 'sabout1')->first();

            $request->validate([
                'img' => 'required|image|mimes:jpg,jpeg,png|max:2048',
                'title' => 'required|string|max:255',
                'subtitle1' => 'required|string',
            ]);

            $imgPath = null;

            if ($request->hasFile('img')) {
                $imgPath = $request->file('img')->store('about', 'public');
            }

            SectionContent::create([
                'img' => $imgPath,
                'title' => $request->title,
                'subtitle1' => $request->subtitle1,
                'menu_id' => $category->id,
                'section' => 'sabout1',
            ]);

            return redirect()->back()->with('success', 'Berhasil');
        } catch (\Exception $err) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $err->getMessage());
        }
    }

    public function updateFooter(Request $request, $id)
    {
        try {
            $benefit = SectionContent::find($id);

            if (!$benefit) {
                return redirect()->back()->with('error', 'Data tidak ditemukan.');
            }

            $request->validate([
                'img' => 'image|mimes:jpg,jpeg,png|max:2048',
                'title' => 'required|string|max:255',
                'subtitle1' => 'required|string',
            ]);

            if ($request->hasFile('img')) {
                if ($benefit->img && Storage::disk('public')->exists($benefit->img)) {
                    Storage::disk('public')->delete($benefit->img);
                }
                $benefit->img = $request->file('img')->store('about', 'public');
            }

            $benefit->title = $request->title;
            $benefit->subtitle1 = $request->subtitle1;

            $benefit->save();

            return redirect()->back()->with('success', 'Data berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function storeImage(Request $request)
    {
        try {
            $request->validate([
                'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);

            $path = $request->file('image')->store('about_images', 'public');

            $image = new AboutImage();
            $image->image = $path;
            $image->save();

            return redirect()->back()->with('success', 'Data berhasil diperbarui.');
        } catch (Exception $err) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $err->getMessage());
        }
    }

    public function updateImage(Request $request, $id)
    {
        try {
            $request->validate([
                'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);

            $image = AboutImage::findOrFail($id);

            // Hapus gambar lama jika ada
            if ($image->image && Storage::disk('public')->exists($image->image)) {
                Storage::disk('public')->delete($image->image);
            }

            $path = $request->file('image')->store('about_images', 'public');
            $image->image = $path;
            $image->save();

            return redirect()->back()->with('success', 'Data berhasil diperbarui.');
        } catch (Exception $err) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $err->getMessage());
        }
    }

    public function destroyImage($id)
    {
        try {
            $image = AboutImage::findOrFail($id);

            if ($image->image && Storage::disk('public')->exists($image->image)) {
                Storage::disk('public')->delete($image->image);
            }

            $image->delete();

            return redirect()->back()->with('success', 'Data berhasil diperbarui.');
        } catch (Exception $err) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $err->getMessage());
        }
    }
}
