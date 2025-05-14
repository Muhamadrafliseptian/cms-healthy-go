<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Meal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MealController 
{
    public function index()
    {
        try {
            $data = Meal::all();

            return response()->json([
                'status' => 'success',
                'message' => 'Data meal berhasil diambil',
                'data' => $data
            ], 200);
        } catch (\Exception $e) {
            Log::error('Meal Index Error: ' . $e->getMessage());

            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat mengambil data meal',
                'data' => null
            ], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'meal_title' => 'nullable|string',
                'meal_content' => 'nullable|string',
            ]);

            $meal = Meal::create($request->only('meal_title', 'meal_content'));

            return response()->json([
                'status' => 'success',
                'message' => 'Meal berhasil ditambahkan',
                'data' => $meal
            ], 201);
        } catch (\Exception $e) {
            Log::error('Meal Store Error: ' . $e->getMessage());

            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat menyimpan meal',
                'data' => null
            ], 500);
        }
    }

    public function show($id)
    {
        try {
            $meal = Meal::find($id);

            if (!$meal) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Meal tidak ditemukan',
                    'data' => null
                ], 404);
            }

            return response()->json([
                'status' => 'success',
                'message' => 'Detail meal berhasil diambil',
                'data' => $meal
            ], 200);
        } catch (\Exception $e) {
            Log::error('Meal Show Error: ' . $e->getMessage());

            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat mengambil detail meal',
                'data' => null
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $meal = Meal::find($id);

            if (!$meal) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Meal tidak ditemukan',
                    'data' => null
                ], 404);
            }

            $meal->update($request->only('meal_title', 'meal_content'));

            return response()->json([
                'status' => 'success',
                'message' => 'Meal berhasil diperbarui',
                'data' => $meal
            ], 200);
        } catch (\Exception $e) {
            Log::error('Meal Update Error: ' . $e->getMessage());

            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat memperbarui meal',
                'data' => null
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $meal = Meal::find($id);

            if (!$meal) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Meal tidak ditemukan',
                    'data' => null
                ], 404);
            }

            $meal->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Meal berhasil dihapus',
                'data' => null
            ], 200);
        } catch (\Exception $e) {
            Log::error('Meal Delete Error: ' . $e->getMessage());

            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat menghapus meal',
                'data' => null
            ], 500);
        }
    }
}
