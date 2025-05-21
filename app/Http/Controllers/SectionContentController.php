<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SectionContentController
{
    public function index(){
        try {
            return view('pages.master.index-section-content');
        } catch (\Exception $err) {
            dd($err);
        }
    }
}
