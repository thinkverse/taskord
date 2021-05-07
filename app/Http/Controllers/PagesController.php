<?php

namespace App\Http\Controllers;

use App\Models\Deal;

class PagesController extends Controller
{
    public function deals()
    {
        $deals = Deal::latest()
            ->get();

        return view('pages.deals', [
            'deals' => $deals,
        ]);
    }

    public function about()
    {
        $deals = Deal::latest()
            ->get();

        return view('pages.about', [
            'deals' => $deals,
        ]);
    }
}
