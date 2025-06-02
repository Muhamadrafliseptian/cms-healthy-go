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
            return view('index-dashboard');
        } catch (Exception $err) {
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
