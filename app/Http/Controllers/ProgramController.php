<?php

namespace App\Http\Controllers;

use App\Models\Program;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ProgramController 
{
    public function index(Request $request)
    {
        try {
            $data = Program::all();
            if($request->wantsJson()){
                return response()->json([
                    'status' => 'success',
                    'message' => 'Data program berhasil diambil',
                    'data' => $data
                ], 200);
            }

            return view('pages.home.program.index-program', compact('data'));
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
                'content_program' => 'nullable|string',
            ]);

            $program = Program::create($request->only(
                'program_title',
                'program_subtitle',
                'program_subtitle_2',
                'content_program'
            ));

            return response()->json([
                'status' => 'success',
                'message' => 'Program berhasil ditambahkan',
                'data' => $program
            ], 201);
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

            $program->update($request->only(
                'program_title',
                'program_subtitle',
                'program_subtitle_2',
                'content_program'
            ));

            return response()->json([
                'status' => 'success',
                'message' => 'Program berhasil diperbarui',
                'data' => $program
            ], 200);
        } catch (\Exception $e) {
            Log::error('Program Update Error: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat memperbarui program',
                'data' => null
            ], 500);
        }
    }

    public function destroy($id)
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

            $program->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Program berhasil dihapus',
                'data' => null
            ], 200);
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
