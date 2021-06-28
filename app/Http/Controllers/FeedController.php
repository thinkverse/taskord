<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\User;

class FeedController extends Controller
{
    public function user($username, $page = 1)
    {
        $user = User::whereUsername($username)
            ->firstOrFail();
        $tasks = $user->tasks()
            ->latest()
            ->offset($page - 1)
            ->limit(50)
            ->get();

        $content = view('feed.user', [
            'user'  => $user,
            'tasks' => $tasks,
        ]);

        return response($content, 200)
            ->header('Content-Type', 'text/xml');
    }

    public function product($slug, $page = 1)
    {
        $product = Product::whereSlug($slug)
            ->firstOrFail();
        $tasks = $product->tasks()
            ->latest()
            ->offset($page - 1)
            ->limit(50)
            ->get();

        $content = view('feed.product', [
            'product' => $product,
            'tasks'   => $tasks,
        ]);

        return response($content, 200)
            ->header('Content-Type', 'text/xml');
    }
}
