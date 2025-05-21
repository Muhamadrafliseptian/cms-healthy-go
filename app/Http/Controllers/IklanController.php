<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class IklanController
{
    public function indexAchievement()
    {
        return view('pages.iklan.banner.index-achievement');
    }
    public function indexBanner()
    {
        return view('pages.iklan.banner.index-banner');
    }
    public function indexBenefit()
    {
        return view('pages.iklan.banner.index-benefits');
    }
    public function indexGaleri()
    {
        return view('pages.iklan.banner.index-gallery');
    }
    public function indexGoals()
    {
        return view('pages.iklan.banner.index-goals');
    }
    public function indexPains()
    {
        return view('pages.iklan.banner.index-pains');
    }
    public function indexPromo()
    {
        return view('pages.iklan.banner.index-banner');
    }
}
