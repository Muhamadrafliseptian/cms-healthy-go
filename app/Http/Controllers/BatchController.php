<?php

namespace App\Http\Controllers;

use App\Models\MasterBatch;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Http;

class BatchController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $data = MasterBatch::orderBy('start_date', 'desc')->get();
            return view('pages.food.master-batch.index-master-batch', compact('data'));
        } catch (\Exception $err) {
            return back()->with('error', 'Gagal mengambil data batch.');
        }
    }

    public function syncBatch(Request $request)
    {
        try {
            $url = 'https://api.dapursehatindonesia.com/api/getlistbatch';
            $response = Http::withToken('Bearer 4|0pLuWSOnwJjX2MLS2xauoeidaIKleub4g4GsgZsz20df10e5')->post($url);
            $batchs = json_decode($response->getBody()->getContents(), true);

            foreach ($batchs['data'] as $batch) {
                $cek = MasterBatch::where('code', $batch['name'])->first();
                if ($cek == null) {
                    $save = new MasterBatch();
                    $save->name = $batch['alias'];
                    $save->code = $batch['name'];
                    $save->start_date = $batch['start'];
                    $save->end_date = $batch['end'];
                    $save->saveOrFail();
                }
            }

            return response()->json([
                'status' => 'success',
                'message' => 'Batch berhasil disinkronkan.',
            ], 200);
        } catch (Exception $e) {
            // return $this->errorHandler($e);

            dd($e->getMessage());
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.food.master-batch.create-master-batch');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'start_date' => 'required|date|after_or_equal:today|before_or_equal:' . now()->addDays(14)->toDateString(),
        ]);

        $startDate = Carbon::parse($request->start_date);
        $endDate = $startDate->copy()->addDays(6);

        $isOverlap = MasterBatch::where(function ($query) use ($startDate, $endDate) {
            $query->whereBetween('start_date', [$startDate, $endDate])
                ->orWhereBetween('end_date', [$startDate, $endDate])
                ->orWhere(function ($q) use ($startDate, $endDate) {
                    $q->where('start_date', '<=', $startDate)
                        ->where('end_date', '>=', $endDate);
                });
        })->exists();

        if ($isOverlap) {
            return back()->with('error', 'Tanggal yang dipilih sudah digunakan oleh batch lain.');
        }

        try {
            $batch = new MasterBatch();
            $batch->name = $request->name;
            $batch->start_date = $startDate;
            $batch->end_date = $endDate;
            $batch->save();

            return redirect()->route('batch.index')->with('success', 'Batch berhasil ditambahkan.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menyimpan batch.');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $batch = MasterBatch::findOrFail($id);
        return view('pages.food.master-batch.edit-master-batch', compact('batch'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'start_date' => 'required|date|after_or_equal:today|before_or_equal:' . now()->addDays(14)->toDateString(),
        ]);

        $startDate = Carbon::parse($request->start_date);
        $endDate = $startDate->copy()->addDays(6);

        $isOverlap = MasterBatch::where('id', '!=', $id)
            ->where(function ($query) use ($startDate, $endDate) {
                $query->whereBetween('start_date', [$startDate, $endDate])
                    ->orWhereBetween('end_date', [$startDate, $endDate])
                    ->orWhere(function ($q) use ($startDate, $endDate) {
                        $q->where('start_date', '<=', $startDate)
                            ->where('end_date', '>=', $endDate);
                    });
            })->exists();

        if ($isOverlap) {
            return back()->with('error', 'Tanggal yang dipilih sudah digunakan oleh batch lain.');
        }

        try {
            $batch = MasterBatch::findOrFail($id);
            $batch->name = $request->name;
            $batch->start_date = $startDate;
            $batch->end_date = $endDate;
            $batch->save();

            return redirect()->route('batch.index')->with('success', 'Batch berhasil diperbarui.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal memperbarui batch.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $batch = MasterBatch::findOrFail($id);
            $batch->delete();
            return redirect()->route('batch.index')->with('success', 'Batch berhasil dihapus.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menghapus batch.');
        }
    }
}
