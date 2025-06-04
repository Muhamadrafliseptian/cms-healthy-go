<?php

namespace App\Http\Controllers;

use App\Models\MasterSectionCategory;
use App\Models\SectionContent;
use App\Models\Testimoni;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class TestimoniController
{
    public function index(Request $request)
    {
        try {
            $data = Testimoni::all();
            $category = MasterSectionCategory::where('slug', 'stestimoni')->first();
            $section = SectionContent::where('menu_id', $category->id)
                ->where('section', 'stestimoni')
                ->first();
            if ($request->wantsJson()) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Data testimoni berhasil diambil',
                    'data' => $data,
                    'section' => $section
                ], 200);
            }

            return view('pages.home.testimoni.index-testimoni', compact('data', 'section'));
        } catch (\Exception $e) {
            Log::error('Testimoni Index Error: ' . $e->getMessage());
            if ($request->wantsJson()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Terjadi kesalahan saat mengambil data testimoni',
                    'data' => null
                ], 500);
            }
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function storeContentTestimoni(Request $request)
    {
        try {
            $category = MasterSectionCategory::where('slug', 'stestimoni')->first();

            $request->validate([
                "title" => "required|string",
                "subtitle1" => "required|string"
            ]);

            SectionContent::create([
                'menu_id'    => $category->id,
                'section'    => 'stestimoni',
                'title'      => $request->title,
                'subtitle1'  => $request->subtitle1,
            ]);

            return back()->with('success', 'Data testimonial berhasil disimpan.');
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function updateContentTestimoni(Request $request, $id)
    {
        try {
            $content = SectionContent::findOrFail($id);

            $request->validate([
                "title" => "required|string",
                "subtitle1" => "required|string"
            ]);

            $content->update([
                'title'     => $request->title,
                'subtitle1' => $request->subtitle1,
            ]);

            return back()->with('success', 'Data testimonial berhasil diperbarui.');
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }


    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|nullable|string',
                'program_name' => 'required|nullable|string',
                'content' => 'required|nullable|string',
                'ava_testimoni' => 'required|nullable|image|mimes:jpg,jpeg,png|max:2048',
            ]);

            $imgPath = null;

            if ($request->hasFile('ava_testimoni')) {
                $imgPath = $request->file('ava_testimoni')->store('testimoni', 'public');
            }

            $testimoni = Testimoni::create([
                'name' => $request->name,
                'program_name' => $request->program_name,
                'content' => $request->content,
                'ava_testimoni' => $imgPath,
            ]);

            return redirect()->back()->with('success', 'berhasil tambah testimoni');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function show($id) {}

    public function update(Request $request, $id)
    {
        try {
            $testimoni = Testimoni::find($id);

            if (!$testimoni) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Testimoni tidak ditemukan',
                    'data' => null
                ], 404);
            }

            $request->validate([
                'name' => 'required|nullable|string',
                'program_name' => 'required|nullable|string',
                'content' => 'required|nullable|string',
                'ava_testimoni' => 'required|nullable|image|mimes:jpg,jpeg,png|max:2048',
            ]);

            if ($request->hasFile('ava_testimoni')) {
                if ($testimoni->ava_testimoni && Storage::disk('public')->exists($testimoni->ava_testimoni)) {
                    Storage::disk('public')->delete($testimoni->ava_testimoni);
                }

                $testimoni->ava_testimoni = $request->file('ava_testimoni')->store('testimoni', 'public');
            }

            $testimoni->name = $request->name;
            $testimoni->program_name = $request->program_name;
            $testimoni->content = $request->content;
            $testimoni->save();

            return redirect()->back()->with('success', 'berhasil tambah diperbarui');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $testimoni = Testimoni::find($id);

            if (!$testimoni) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Testimoni tidak ditemukan',
                    'data' => null
                ], 404);
            }

            if ($testimoni->ava_testimoni && Storage::disk('public')->exists($testimoni->ava_testimoni)) {
                Storage::disk('public')->delete($testimoni->ava_testimoni);
            }

            $testimoni->delete();

            return redirect()->back()->with('success', 'berhasil hapus testimoni');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
