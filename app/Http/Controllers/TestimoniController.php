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
                'name' => 'nullable|string',
                'program_name' => 'nullable|string',
                'content' => 'nullable|string',
                'ava_testimoni' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
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

            if ($request->wantsJson()) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Testimoni berhasil ditambahkan',
                    'data' => $testimoni
                ], 201);
            }

            return redirect()->back()->with('success', 'berhasil tambah testimoni');
        } catch (\Exception $e) {
            Log::error('Testimoni Store Error: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat menambahkan testimoni',
                'data' => null
            ], 500);
        }
    }

    public function show($id)
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

            return response()->json([
                'status' => 'success',
                'message' => 'Detail testimoni berhasil diambil',
                'data' => $testimoni
            ], 200);
        } catch (\Exception $e) {
            Log::error('Testimoni Show Error: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat mengambil detail testimoni',
                'data' => null
            ], 500);
        }
    }

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
                'name' => 'nullable|string',
                'program_name' => 'nullable|string',
                'content' => 'nullable|string',
                'ava_testimoni' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
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

            if ($request->wantsJson()) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Testimoni berhasil diperbarui',
                    'data' => $testimoni
                ], 200);
            }
            return redirect()->back()->with('success', 'berhasil tambah diperbarui');
        } catch (\Exception $e) {
            Log::error('Testimoni Update Error: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat memperbarui testimoni',
                'data' => null
            ], 500);
        }
    }

    public function destroy(Request $request, $id)
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

            if ($request->wantsJson()) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Testimoni berhasil dihapus',
                    'data' => null
                ], 200);
            }

            return redirect()->back()->with('success', 'berhasil hapus testimoni');
        } catch (\Exception $e) {
            Log::error('Testimoni Delete Error: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat menghapus testimoni',
                'data' => null
            ], 500);
        }
    }
}
