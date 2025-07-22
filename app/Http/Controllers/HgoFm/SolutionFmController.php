<?php

namespace App\Http\Controllers\HgoFm;

use App\Models\FmSolution;
use Exception;
use Illuminate\Http\Request;

class SolutionFmController
{
    public function store(Request $request)
    {
        try {
            $request->validate([
                'title' => 'required|nullable|string',
                'content' => 'required|nullable|string',
            ]);

            FmSolution::create([
                'title' => $request->title,
                'content' => $request->content,
            ]);

            return redirect()->back()->with('success', 'Data berhasil ditambah');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $data = FmSolution::find($id);
            $request->validate([
                'title' => 'required|nullable|string',
                'content' => 'required|nullable|string',
            ]);
            $data->title = $request->title;
            $data->content = $request->content;
            $data->save();

            return redirect()->back()->with('success', 'Data berhasil ditambah');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $data = FmSolution::find($id);
            $data->delete();
            return redirect()->back()->with('success', 'data berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
