<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SearchController extends Controller
{
    public $layout = 'layouts.app';

    public function search(Request $request, $term="")
    {
        $user = auth()->user();
        return view('search/results',["term" => $term, "user" => $user] );
    }
}
