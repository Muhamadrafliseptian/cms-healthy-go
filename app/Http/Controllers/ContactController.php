<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ContactController 
{
    public function index(Request $request)
    {
        try {
            $data = Contact::all();
            if($request->wantsJson()){
                return response()->json([
                    'status' => 'success',
                    'message' => 'Data contact berhasil diambil',
                    'data' => $data
                ], 200);
            }

            return view ('pages.contact.index-contact', compact('data'));
        } catch (\Exception $e) {
            Log::error('contact Index Error: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat mengambil data contact',
                'data' => null
            ], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'nullable|string',
                'icon' => 'nullable|string',
                'content' => 'nullable|string',
            ]);

            $contact = Contact::create($request->only('name', 'icon', 'content'));

            return response()->json([
                'status' => 'success',
                'message' => 'contact berhasil ditambahkan',
                'data' => $contact
            ], 201);
        } catch (\Exception $e) {
            Log::error('contact Store Error: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat menambahkan contact',
                'data' => null
            ], 500);
        }
    }

    public function show($id)
    {
        try {
            $contact = Contact::find($id);

            if (!$contact) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'contact tidak ditemukan',
                    'data' => null
                ], 404);
            }

            return response()->json([
                'status' => 'success',
                'message' => 'Detail contact berhasil diambil',
                'data' => $contact
            ], 200);
        } catch (\Exception $e) {
            Log::error('contact Show Error: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat mengambil detail contact',
                'data' => null
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $contact = Contact::find($id);

            if (!$contact) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'contact tidak ditemukan',
                    'data' => null
                ], 404);
            }

            $contact->update($request->only('name', 'icon', 'content'));

            return response()->json([
                'status' => 'success',
                'message' => 'contact berhasil diperbarui',
                'data' => $contact
            ], 200);
        } catch (\Exception $e) {
            Log::error('contact Update Error: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat memperbarui contact',
                'data' => null
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $contact = Contact::find($id);

            if (!$contact) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'contact tidak ditemukan',
                    'data' => null
                ], 404);
            }

            $contact->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'contact berhasil dihapus',
                'data' => null
            ], 200);
        } catch (\Exception $e) {
            Log::error('contact Delete Error: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat menghapus contact',
                'data' => null
            ], 500);
        }
    }
}
