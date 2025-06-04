<?php

namespace App\Http\Controllers;

use App\Models\MasterSectionCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MasterSectionCategoryController
{
    public function index(Request $request)
    {
        try {
            $data = MasterSectionCategory::all();

            return view('pages.master.index-section-category', compact('data'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string',
                'slug' => 'required|string',
            ]);

            $faq = MasterSectionCategory::create($request->only('name', 'slug'));

            return redirect()->back()->with('success',  'berhasil ditambahkan');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $faq = MasterSectionCategory::find($id);

            if (!$faq) {
                return redirect()->back()->with('error', 'tidak ditemukan');
            }

            $faq->update($request->only('name', 'slug'));

            return redirect()->back()->with('success', 'FAQ berhasil diperbarui');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $faq = MasterSectionCategory::find($id);

            if (!$faq) {
                return redirect()->back()->with('error', 'tidak ditemukan');
            }

            $faq->delete();

            return redirect()->back()->with('success', 'berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
