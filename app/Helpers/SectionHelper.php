<?php

use App\Models\MasterSectionCategory;
use App\Models\SectionContent;

function getSectionBySlug(string $slug)
{
    $categories = MasterSectionCategory::whereIn('slug', [$slug])
        ->get()
        ->keyBy('slug');

    $sections = SectionContent::whereIn('section', [$slug])
        ->whereIn('menu_id', $categories->pluck('id'))
        ->get()
        ->keyBy('section');

    return $sections->get($slug);
}

function handleResponse($section, string $viewPath)
{
    if (request()->wantsJson()) {
        return response()->json([
            'status' => 'success',
            'message' => 'Data layanan berhasil diambil',
            'section' => $section,
        ], 200);
    }

    return view($viewPath, [
        'section' => $section,
    ]);
}
