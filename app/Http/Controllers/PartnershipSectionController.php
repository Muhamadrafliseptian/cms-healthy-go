<?php

namespace App\Http\Controllers;

use App\Models\MasterSectionCategory;
use App\Models\SectionContent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PartnershipSectionController
{
    public function indexBanner()
    {
        try {
            $section = getSectionBySlug('bpartnership');
            return handleResponse($section, 'pages.partnership.banner.index-banner');
        } catch (\Exception $e) {
            abort(500, 'Terjadi kesalahan saat memuat data.');
        }
    }

    public function storeSectionBanner(Request $request)
    {
        try {

            $category = MasterSectionCategory::where('slug', 'bpartnership')->first();

            $request->validate([
                'img' => 'required|image|mimes:jpg,jpeg,png|max:2048',
                'title' => 'required|string|max:255',
            ]);

            $imgPath = null;

            if ($request->hasFile('img')) {
                $imgPath = $request->file('img')->store('partnership', 'public');
            }

            SectionContent::create([
                'img' => $imgPath,
                'title' => $request->title,
                'menu_id' => $category->id,
                'section' => 'bpartnership',
            ]);

            return redirect()->back()->with('success', 'Berhasil');
        } catch (\Exception $err) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $err->getMessage());
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
                'img' => 'required|image|mimes:jpg,jpeg,png|max:2048',
                'title' => 'required|string|max:255',
            ]);

            if ($request->hasFile('img')) {
                if ($benefit->img && Storage::disk('public')->exists($benefit->img)) {
                    Storage::disk('public')->delete($benefit->img);
                }
                $benefit->img = $request->file('img')->store('partnership', 'public');
            }

            $benefit->title = $request->title;

            $benefit->save();

            return redirect()->back()->with('success', 'Data berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function indexContentTag()
    {
        try {

            $section = getSectionBySlug('spartnership1');
            return handleResponse($section, 'pages.partnership.tag.index-tag');
        } catch (\Exception $e) {
            abort(500, 'Terjadi kesalahan saat memuat data.');
        }
    }

    public function storeSectionTag(Request $request)
    {
        try {

            $category = MasterSectionCategory::where('slug', 'spartnership1')->first();

            $request->validate([
                'title' => 'required|string|max:255',
                'subtitle1' => 'required|string|max:255',
            ]);
            SectionContent::create([
                'title' => $request->title,
                'subtitle1' => $request->subtitle1,
                'menu_id' => $category->id,
                'section' => 'spartnership1',
            ]);

            return redirect()->back()->with('success', 'Berhasil');
        } catch (\Exception $err) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $err->getMessage());
        }
    }

    public function updateSectionTag(Request $request, $id)
    {
        try {
            $benefit = SectionContent::find($id);

            if (!$benefit) {
                return redirect()->back()->with('error', 'Data tidak ditemukan.');
            }

            $request->validate([
                'title' => 'required|string|max:255',
                'subtitle1' => 'required|string|max:255',
            ]);

            $benefit->title = $request->title;
            $benefit->subtitle1 = $request->subtitle1;

            $benefit->save();

            return redirect()->back()->with('success', 'Data berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function indexContentCollaborate()
    {
        try {
            $section = getSectionBySlug('spartnership2');

            return handleResponse($section, 'pages.partnership.collaborate.index-collaborate');
        } catch (\Exception $e) {
            abort(500, 'Terjadi kesalahan saat memuat data.');
        }
    }

    public function storeSectionCollaborate(Request $request)
    {
        try {

            $category = MasterSectionCategory::where('slug', 'spartnership2')->first();

            $request->validate([
                'title' => 'required|string|max:255',
                'subtitle1' => 'required|string|max:255',
            ]);
            SectionContent::create([
                'title' => $request->title,
                'subtitle1' => $request->subtitle1,
                'menu_id' => $category->id,
                'section' => 'spartnership2',
            ]);

            return redirect()->back()->with('success', 'Berhasil');
        } catch (\Exception $err) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $err->getMessage());
        }
    }

    public function updateSectionCollaborate(Request $request, $id)
    {
        try {
            $benefit = SectionContent::find($id);

            if (!$benefit) {
                return redirect()->back()->with('error', 'Data tidak ditemukan.');
            }

            $request->validate([
                'title' => 'required|string|max:255',
                'subtitle1' => 'required|string|max:255',
            ]);

            $benefit->title = $request->title;
            $benefit->subtitle1 = $request->subtitle1;

            $benefit->save();

            return redirect()->back()->with('success', 'Data berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function indexContentHero()
    {
        try {

            $section = getSectionBySlug('spartnership3');

            return handleResponse($section, 'pages.partnership.working-together.index-working-together');
        } catch (\Exception $e) {
            abort(500, 'Terjadi kesalahan saat memuat data.');
        }
    }

    public function storeSectionHero(Request $request)
    {
        try {

            $category = MasterSectionCategory::where('slug', 'spartnership3')->first();

            $request->validate([
                'img' => 'required|image|mimes:jpg,jpeg,png|max:2048',
                'title' => 'required|string|max:255',
                'subtitle1' => 'required|string',
            ]);

            $imgPath = null;

            if ($request->hasFile('img')) {
                $imgPath = $request->file('img')->store('partnership', 'public');
            }

            SectionContent::create([
                'img' => $imgPath,
                'title' => $request->title,
                'subtitle1' => $request->subtitle1,
                'menu_id' => $category->id,
                'section' => 'spartnership3',
            ]);

            return redirect()->back()->with('success', 'Berhasil');
        } catch (\Exception $err) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $err->getMessage());
        }
    }

    public function updateSectionHero(Request $request, $id)
    {
        try {
            $benefit = SectionContent::find($id);

            if (!$benefit) {
                return redirect()->back()->with('error', 'Data tidak ditemukan.');
            }

            $request->validate([
                'img' => 'required|image|mimes:jpg,jpeg,png|max:2048',
                'title' => 'required|string|max:255',
                'subtitle1' => 'required|string',
            ]);

            if ($request->hasFile('img')) {
                if ($benefit->img && Storage::disk('public')->exists($benefit->img)) {
                    Storage::disk('public')->delete($benefit->img);
                }
                $benefit->img = $request->file('img')->store('partnership', 'public');
            }

            $benefit->title = $request->title;
            $benefit->subtitle1 = $request->subtitle1;

            $benefit->save();

            return redirect()->back()->with('success', 'Data berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function storeSectionPartnership(Request $request)
    {
        try {

            $category = MasterSectionCategory::where('slug', 'spartnership4')->first();

            $request->validate([
                'title' => 'required|string|max:255',
                'subtitle1' => 'required|string|max:255',
            ]);
            SectionContent::create([
                'title' => $request->title,
                'subtitle1' => $request->subtitle1,
                'subtitle2' => $request->subtitle2,
                'menu_id' => $category->id,
                'section' => 'spartnership4',
            ]);

            return redirect()->back()->with('success', 'Berhasil');
        } catch (\Exception $err) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $err->getMessage());
        }
    }

    public function updateSectionPartnership(Request $request, $id)
    {
        try {
            $benefit = SectionContent::find($id);

            if (!$benefit) {
                return redirect()->back()->with('error', 'Data tidak ditemukan.');
            }

            $request->validate([
                'title' => 'required|string|max:255',
                'subtitle1' => 'required|string|max:255',
            ]);

            $benefit->title = $request->title;
            $benefit->subtitle1 = $request->subtitle1;
            $benefit->subtitle2 = $request->subtitle2;

            $benefit->save();

            return redirect()->back()->with('success', 'Data berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
