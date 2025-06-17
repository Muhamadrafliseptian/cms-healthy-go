<?php

namespace App\Http\Controllers;

use App\Models\MasterSectionCategory;
use App\Models\Program;
use App\Models\SectionContent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ProgramController
{
    public function index(Request $request)
    {
        try {
            $data = Program::all();
            $category = MasterSectionCategory::where('slug', 'sprogram')->first();
            $section = SectionContent::where('menu_id', $category->id)
                ->where('section', 'sprogram')
                ->first();
            if ($request->wantsJson()) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Data program berhasil diambil',
                    'data' => $data,
                    'section' => $section
                ], 200);
            }

            if ($request->is('dashboard/product-service/program*')) {
                return view('pages.product-service.program.index-program', compact('data', 'section'));
            } else {
                return view('pages.home.program.index-program', compact('data', 'section'));
            }
        } catch (\Exception $e) {
            Log::error('Program Index Error: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat mengambil data program',
                'data' => null
            ], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'program_title' => 'required|nullable|string',
                'program_subtitle' => 'required|nullable|string',
                'program_subtitle_2' => 'required|nullable|string',
                'content_program_2' => 'required|nullable|string',
                'content_program' => 'required|nullable|image|mimes:jpg,jpeg,png|max:2048',
            ]);

            $imgPath = null;

            if ($request->hasFile('content_program')) {
                $imgPath = $request->file('content_program')->store('program', 'public');
            }

            $program = Program::create([
                'program_title' => $request->program_title,
                'program_subtitle' => $request->program_subtitle,
                'program_subtitle_2' => $request->program_subtitle_2,
                'content_program_2' => $request->content_program_2,
                'content_program' => $imgPath
            ]);

            if ($request->wantsJson()) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Program berhasil ditambahkan',
                    'data' => $program
                ], 201);
            }

            return redirect()->back()->with('success', 'Data berhasil ditambah');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function storeContentProgram(Request $request)
    {
        try {
            $category = MasterSectionCategory::where('slug', 'sprogram')->first();

            $request->validate([
                'title' => 'required|nullable|string',
                'subtitle1' => 'required|nullable|string',
                'subtitle2' => 'required|nullable|string',
            ]);

            SectionContent::create([
                'menu_id'    => $category->id,
                'section'    => 'sprogram',
                'title'      => $request->title,
                'subtitle1'  => $request->subtitle1,
                'subtitle2'  => $request->subtitle2,
            ]);

            return back()->with('success', 'Data berhasil disimpan.');
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function updateContentProgram(Request $request, $id)
    {
        try {
            $content = SectionContent::findOrFail($id);

            $request->validate([
                'title' => 'required|nullable|string',
                'subtitle1' => 'required|nullable|string',
                'subtitle2' => 'required|nullable|string',
            ]);

            $content->update([
                'title'     => $request->title,
                'subtitle1' => $request->subtitle1,
                'subtitle2' => $request->subtitle2,
            ]);

            return back()->with('success', 'Data berhasil diperbarui.');
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function show($id)
    {
        try {
            $program = Program::find($id);

            if (!$program) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Program tidak ditemukan',
                    'data' => null
                ], 404);
            }

            return response()->json([
                'status' => 'success',
                'message' => 'Detail program berhasil diambil',
                'data' => $program
            ], 200);
        } catch (\Exception $e) {
            Log::error('Program Show Error: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat mengambil detail program',
                'data' => null
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $program = Program::find($id);

            if (!$program) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Program tidak ditemukan',
                    'data' => null
                ], 404);
            }

            $request->validate([
                'program_title' => 'required|nullable|string',
                'program_subtitle' => 'required|nullable|string',
                'program_subtitle_2' => 'required|nullable|string',
                'program_content_2' => 'required|nullable|string',

                'content_program' => 'required|image|mimes:jpg,jpeg,png|max:2048',
            ]);

            if ($request->hasFile('content_program')) {
                if ($program->content_program && Storage::disk('public')->exists($program->content_program)) {
                    Storage::disk('public')->delete($program->content_program);
                }

                $program->content_program = $request->file('content_program')->store('program', 'public');
            }

            $program->program_title = $request->program_title;
            $program->program_subtitle = $request->program_subtitle;
            $program->program_subtitle_2 = $request->program_subtitle_2;
            $program->content_program_2 = $request->content_program_2;

            $program->save();

            if ($request->wantsJson()) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Program berhasil diperbarui',
                    'data' => $program
                ], 200);
            }

            return redirect()->back()->with('success', 'Program berhasil diperbarui');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }


    public function destroy(Request $request, $id)
    {
        try {
            $program = Program::find($id);

            if (!$program) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Program tidak ditemukan',
                    'data' => null
                ], 404);
            }

            if ($program->content_program && Storage::disk('public')->exists($program->content_program)) {
                Storage::disk('public')->delete($program->content_program);
            }

            $program->delete();

            if ($request->wantsJson()) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Program berhasil dihapus',
                    'data' => null
                ], 200);
            }

            return redirect()->back()->with('success', 'data berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
