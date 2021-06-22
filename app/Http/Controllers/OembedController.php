<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Embed\Embed;

class OembedController extends Controller
{
    public function oembed(Request $request)
    {
        $url = $request->query('url');
        $embed = new Embed();
        $info = $embed->get($url);

        dd($info->icon);

        return $embed;
    }
}
