<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Question;
use App\Models\User;
use App\Models\Task;

class SitemapController extends Controller
{
    public function users()
    {
        $users = User::all('username');

        return view('seo.sitemap_users', [
            'users' => $users,
        ]);
    }

    public function products()
    {
        $products = Product::all('slug');

        return view('seo.sitemap_products', [
            'products' => $products,
        ]);
    }

    public function questions()
    {
        $questions = Question::all('id');

        return view('seo.sitemap_questions', [
            'questions' => $questions,
        ]);
    }
    
    public function tasks()
    {
        $tasks = Task::all('id');

        return view('seo.sitemap_tasks', [
            'tasks' => $tasks,
        ]);
    }
}
