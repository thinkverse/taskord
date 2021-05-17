<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Milestone;
use App\Models\Product;
use App\Models\Question;
use App\Models\Task;
use App\Models\User;

class SitemapController extends Controller
{
    public function users()
    {
        $users = User::select('username', 'isFlagged')
            ->where('isFlagged', false)
            ->get();

        return view('seo.sitemap_users', [
            'users' => $users,
        ]);
    }

    public function products()
    {
        $products = Product::select('slug')
            ->get();

        return view('seo.sitemap_products', [
            'products' => $products,
        ]);
    }

    public function questions()
    {
        $questions = Question::select('id', 'hidden')
            ->whereHidden(false)
            ->get();

        return view('seo.sitemap_questions', [
            'questions' => $questions,
        ]);
    }

    public function tasks()
    {
        $tasks = Task::select('id', 'source', 'hidden')
            ->whereHidden(false)
            ->get();

        return view('seo.sitemap_tasks', [
            'tasks' => $tasks,
        ]);
    }

    public function comments()
    {
        $comments = Comment::select('id', 'hidden', 'task_id')
            ->whereHidden(false)
            ->get();

        return view('seo.sitemap_comments', [
            'comments' => $comments,
        ]);
    }

    public function milestones()
    {
        $milestones = Milestone::select('id', 'hidden')
            ->whereHidden(false)
            ->get();

        return view('seo.sitemap_milestones', [
            'milestones' => $milestones,
        ]);
    }
}
