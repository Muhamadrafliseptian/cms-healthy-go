<?php

namespace App\Http\Controllers\HgoFm;

use App\Models\SectionContentsFm;
use Exception;
use Illuminate\Http\Request;

class SectionContentsFmController
{
    //
    public function hero()
    {
        try {
            $contents = SectionContentsFm::with('section')->where('section_id', 1)->get();
            $section = $contents->pluck('value', 'key');
            return view('pages.hgo-for-men.hero.index', compact('section'));
        } catch (Exception $err) {
            dd($err->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $err->getMessage());
        }
    }
    public function strategy()
    {
        try {
            $contents = SectionContentsFm::with('section')->where('section_id', 2)->get();
            $section = $contents->pluck('value', 'key');
            return view('pages.hgo-for-men.strategy.index', compact('section'));
        } catch (Exception $err) {
            dd($err->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $err->getMessage());
        }
    }
    public function food()
    {
        try {
            $contents = SectionContentsFm::with('section')->where('section_id', 3)->get();
            $section = $contents->pluck('value', 'key');
            return view('pages.hgo-for-men.food.index', compact('section'));
        } catch (Exception $err) {
            dd($err->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $err->getMessage());
        }
    }
    public function protein()
    {
        try {
            $contents = SectionContentsFm::with('section')->where('section_id', 4)->get();
            $section = $contents->pluck('value', 'key');
            return view('pages.hgo-for-men.protein.index', compact('section'));
        } catch (Exception $err) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $err->getMessage());
        }
    }
    public function solution()
    {
        try {
            $contents = SectionContentsFm::with('section')->where('section_id', 5)->get();
            $section = $contents->pluck('value', 'key');
            return view('pages.hgo-for-men.solution.index', compact('section'));
        } catch (Exception $err) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $err->getMessage());
        }
    }
    public function progress()
    {
        try {
            $contents = SectionContentsFm::with('section')->where('section_id', 6)->get();
            $section = $contents->pluck('value', 'key');
            return view('pages.hgo-for-men.progress.index', compact('section'));
        } catch (Exception $err) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $err->getMessage());
        }
    }
    public function whatsinside()
    {
        try {
            $contents = SectionContentsFm::with('section')->where('section_id', 7)->get();
            $section = $contents->pluck('value', 'key');
            return view('pages.hgo-for-men.whats-inside.index', compact('section'));
        } catch (Exception $err) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $err->getMessage());
        }
    }
    public function socialProof()
    {
        try {
            $contents = SectionContentsFm::with('section')->where('section_id', 8)->get();
            $section = $contents->pluck('value', 'key');
            return view('pages.hgo-for-men.social-proof.index', compact('section'));
        } catch (Exception $err) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $err->getMessage());
        }
    }
    public function testimoni()
    {
        try {
            $contents = SectionContentsFm::with('section')->where('section_id', 9)->get();
            $section = $contents->pluck('value', 'key');
            return view('pages.hgo-for-men.testimoni.index', compact('section'));
        } catch (Exception $err) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $err->getMessage());
        }
    }
    public function faq()
    {
        try {
            $contents = SectionContentsFm::with('section')->where('section_id', 10)->get();
            $section = $contents->pluck('value', 'key');
            return view('pages.hgo-for-men.faq.index', compact('section'));
        } catch (Exception $err) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $err->getMessage());
        }
    }
    public function delivery()
    {
        try {
            $contents = SectionContentsFm::with('section')->where('section_id', 11)->get();
            $section = $contents->pluck('value', 'key');
            return view('pages.hgo-for-men.delivery.index', compact('section'));
        } catch (Exception $err) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $err->getMessage());
        }
    }
}
