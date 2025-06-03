<?php

namespace App\Http\Controllers;

use App\Http\Services\AnalyticsService as ServicesAnalyticsService;
use App\Models\Visitor;
use Exception;
use Illuminate\Http\Request;

class DashboardController
{
    public function index()
    {
        try {
            // $response = $analytics->getAllVisitors();

            // $rows = $response->getRows();

            // $pages = [];

            // foreach ($rows as $row) {
            //     $pagePath = $row->getDimensionValues()[0]->getValue(); // ambil pagePath
            //     $pageViews = (int) $row->getMetricValues()[0]->getValue(); // ambil views

            //     $pages[$pagePath] = $pageViews;
            // }

            return view('index-dashboard');

        } catch (\Exception $err) {
            dd($err->getMessage());
        }
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'ip_address' => 'required|ip',
            'user_agent' => 'nullable|string',
            'visited_at' => 'nullable|date',
        ]);

        $alreadyVisited = Visitor::where('ip_address', $validated['ip_address'])
            ->whereDate('visited_at', now()->toDateString())
            ->exists();

        if (! $alreadyVisited) {
            Visitor::create($validated + ['visited_at' => $validated['visited_at'] ?? now()]);
        }
    }
}
