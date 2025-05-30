<?php

namespace App\Http\Controllers;

use App\Models\Visitor;
use Exception;
use Illuminate\Http\Request;

class DashboardController
{
    public function index()
    {
        try {
            $dataVisitor = Visitor::all()->desc();
            $totalVisitor = Visitor::count();

            return view('index-dashboard', compact([
                "data-visitor" => $dataVisitor,
                "total-visitor" => $totalVisitor
            ]));
        } catch (Exception $err) {
        }
    }

    public function store(Request $request)
    {
        $alreadyVisited = Visitor::where('ip_address', $request->ip())
            ->whereDate('visited_at', now()->toDateString())
            ->exists();

        if (! $alreadyVisited) {
            Visitor::create([
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'visited_at' => now(),
            ]);
        }

        // return response()->json([
        //     'status' => 'success',
        //     'message' => 'Visitor counted',
        // ]);
    }

}
