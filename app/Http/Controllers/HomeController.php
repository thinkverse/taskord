<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Question;
use App\Models\User;
use Carbon\Carbon;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $launched_today = Product::cacheFor(60 * 60)
            ->select('slug', 'name', 'avatar', 'description', 'launched', 'launched_at', 'user_id')
            ->where('launched', true)
            ->whereDate('launched_at', Carbon::today())
            ->orderBy('launched_at', 'DESC')
            ->take(6)
            ->get();
        $recent_questions = Question::cacheFor(60 * 60)
            ->select('id', 'title', 'body', 'created_at', 'user_id')
            ->orderBy('created_at', 'DESC')
            ->take(4)
            ->get();
        $recently_users = User::cacheFor(60 * 60)
            ->where([
                ['created_at', '>=', Carbon::now()->subdays(7)],
                ['isFlagged', false],
            ])
            ->orderBy('created_at', 'DESC');
        $recently_joined = $recently_users->take(5)
            ->get();
        $recently_joined_count = $recently_users->count('id');
        $products = Product::cacheFor(60 * 60)
            ->select('slug', 'name', 'avatar', 'launched', 'launched_at', 'user_id')
            ->where('launched', true)
            ->orderBy('created_at', 'DESC')
            ->take(5)
            ->get();
        $reputations = User::cacheFor(60 * 60)
            ->select('username', 'firstname', 'lastname', 'avatar', 'reputation')
            ->where('isFlagged', false)
            ->orderBy('reputation', 'DESC')
            ->take(10)
            ->get();

        return view('home/home', [
            'recent_questions' => $recent_questions,
            'launched_today' => $launched_today,
            'recently_joined' => $recently_joined,
            'recently_joined_count' => $recently_joined_count,
            'products' => $products,
            'reputations' => $reputations,
        ]);
    }
}
