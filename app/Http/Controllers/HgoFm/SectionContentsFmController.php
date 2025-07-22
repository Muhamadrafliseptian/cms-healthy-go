<?php

namespace App\Http\Controllers\HgoFm;

use App\Models\FmProtein;
use App\Models\FmSolution;
use App\Models\FmTestimoni;
use App\Models\SectionContentsFm;
use App\Models\SectionsFm;
use Exception;
use Illuminate\Http\Request;

class SectionContentsFmController
{
    protected $sections = [
        'hero' => 1,
        'strategy' => 2,
        'food' => 3,
        'protein' => 4,
        'solution' => 5,
        'progress' => 6,
        'whatsinside' => 7,
        'socialProof' => 8,
        'testimoni' => 9,
        'faq' => 10,
        'delivery' => 11,
        'spirit' => 12,
    ];

    protected function renderSection(string $name, array $additionalData = [])
    {
        try {
            if (!isset($this->sections[$name])) {
                abort(404, 'Section not found.');
            }

            $sectionId = $this->sections[$name];
            $contents = SectionContentsFm::with('section')
                ->where('section_id', $sectionId)
                ->get();

            $section = $contents->pluck('value', 'key');
            $viewName = str_replace('_', '-', $name);

            return view("pages.hgo-for-men.$viewName.index", array_merge([
                'section' => $section
            ], $additionalData));
        } catch (Exception $err) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $err->getMessage());
        }
    }


    public function hero()
    {
        return $this->renderSection(__FUNCTION__);
    }
    public function strategy()
    {
        return $this->renderSection(__FUNCTION__);
    }
    public function spirit()
    {
        return $this->renderSection(__FUNCTION__);
    }
    public function food()
    {
        return $this->renderSection(__FUNCTION__);
    }
    public function protein()
    {
        $data = FmProtein::all();
        return $this->renderSection(__FUNCTION__, ['data' => $data]);
    }
    public function solution()
    {
        $data = FmSolution::all();

        return $this->renderSection(__FUNCTION__, ['data' => $data]);
    }
    public function progress()
    {
        return $this->renderSection(__FUNCTION__);
    }
    public function whatsinside()
    {
        return $this->renderSection(__FUNCTION__);
    }
    public function socialProof()
    {
        return $this->renderSection(__FUNCTION__);
    }
    public function testimoni()
    {
        $data = FmTestimoni::all();
        return $this->renderSection(__FUNCTION__, ['data' => $data]);
    }
    public function faq()
    {
        return $this->renderSection(__FUNCTION__);
    }
    public function delivery()
    {
        return $this->renderSection(__FUNCTION__);
    }

    public function indexHomeApi()
    {
        try {
            $data = SectionsFm::with('contents')
                ->where('menu_id', 11)
                ->get();

            return response()->json([
                'status' => "success",
                'data' => $data
            ]);
        } catch (\Exception $err) {
            return response()->json([
                'status' => 'error',
                'message' => $err->getMessage(),
            ], 500);
        }
    }

    public function proteinApi()
    {
        try {
            $data = FmProtein::all();

            return response()->json([
                'status' => "success",
                'data' => $data
            ]);
        } catch (\Exception $err) {
            return response()->json([
                'status' => 'error',
                'message' => $err->getMessage(),
            ], 500);
        }
    }

    public function solutionApi()
    {
        try {
            $data = FmSolution::all();

            return response()->json([
                'status' => "success",
                'data' => $data
            ]);
        } catch (\Exception $err) {
            return response()->json([
                'status' => 'error',
                'message' => $err->getMessage(),
            ], 500);
        }
    }

    public function testimoniApi()
    {
        try {
            $data = FmTestimoni::all();

            return response()->json([
                'status' => "success",
                'data' => $data
            ]);
        } catch (\Exception $err) {
            return response()->json([
                'status' => 'error',
                'message' => $err->getMessage(),
            ], 500);
        }
    }
}
