<?php

namespace App\Http\Controllers;

use App\Models\Program;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ProgramController
{
    public function index(Request $request)
    {
        try {
            $data = Program::all();
            if ($request->wantsJson()) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Data program berhasil diambil',
                    'data' => $data
                ], 200);
            }

            if ($request->is('dashboard/product-service/program*')) {
                return view('pages.product-service.program.index-program', compact('data'));
            } else {
                return view('pages.home.program.index-program', compact('data'));
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
                'program_title' => 'nullable|string',
                'program_subtitle' => 'nullable|string',
                'program_subtitle_2' => 'nullable|string',
                'content_program' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            ]);

            $imgPath = null;

            if ($request->hasFile('content_program')) {
                $imgPath = $request->file('content_program')->store('program', 'public');
            }

            $program = Program::create([
                'program_title' => $request->program_title,
                'program_subtitle' => $request->program_subtitle,
                'program_subtitle_2' => $request->program_subtitle_2,
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
            Log::error('Program Store Error: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat menambahkan program',
                'data' => null
            ], 500);
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
                'program_title' => 'nullable|string',
                'program_subtitle' => 'nullable|string',
                'program_subtitle_2' => 'nullable|string',
                'content_program' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
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
            Log::error('Program Update Error: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat memperbarui program',
                'data' => null
            ], 500);
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
            Log::error('Program Delete Error: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat menghapus program',
                'data' => null
            ], 500);
        }
    }

}
