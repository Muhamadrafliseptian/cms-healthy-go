<?php

namespace App\Http\Controllers;

use App\Http\Services\AnalyticsService as ServicesAnalyticsService;
use App\Models\ImgPartnership;
use App\Models\Program;
use App\Models\Testimoni;
use App\Models\User;
use Exception;

class DashboardController
{
    //ServicesAnalyticsService $analytics
    // public function index(ServicesAnalyticsService $analytics)
    // {
    //     try {
    //         $response = $analytics->getAllVisitors();

    //         $rows = $response->getRows();

    //         $pages = [];

    //         foreach ($rows as $row) {
    //             $pagePath = $row->getDimensionValues()[0]->getValue(); // ambil pagePath
    //             $pageViews = (int) $row->getMetricValues()[0]->getValue(); // ambil views

    //             $pages[$pagePath] = $pageViews;
    //         }

    //         $total_partnership = ImgPartnership::count();
    //         $total_program = Program::count();
    //         $total_testimoni = Testimoni::count();

    //         return view('index-dashboard', ([
    //             "total_partnership" => $total_partnership,
    //             "total_program" => $total_program,
    //             "total_testimoni" => $total_testimoni,
    //             "pages" => $pages
    //         ]));
    //     } catch (\Exception $err) {
    //         dd($err->getMessage());
    //     }
    // }

    public function index()
    {
        try {
            $total_partnership = ImgPartnership::count();
            $total_program = Program::count();
            $total_testimoni = Testimoni::count();
            $total_admin = User::count();

            return view('index-dashboard', ([
                "total_partnership" => $total_partnership,
                "total_program" => $total_program,
                "total_testimoni" => $total_testimoni,
                "total_admin" => $total_admin,
            ]));
        } catch (\Exception $err) {
            dd($err->getMessage());
        }
    }
};
