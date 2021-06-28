<?php

namespace App\Http\Livewire\Staff;

use App\Models\Answer;
use App\Models\Comment;
use App\Models\Milestone;
use App\Models\Product;
use App\Models\Question;
use App\Models\Task;
use App\Models\User;
use App\Models\Webhook;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Livewire\Component;
use Spatie\Activitylog\Models\Activity;

class Stats extends Component
{
    public $readyToLoad = false;

    public function loadStats()
    {
        $this->readyToLoad = true;
    }

    public function getStats()
    {
        $tasks = Task::count('id');
        $tasksDone = Task::whereDone(true)->count('id');
        $users = User::count('id');
        $usersActive = User::whereDate('last_active', '>', carbon()->subDays(30))->count('id');
        $products = Product::count('id');
        $productsLaunched = Product::whereLaunched(true)->count('id');
        $reputations = User::sum('reputation');
        $questions = Question::count('id');
        $questionsUnanswered = Question::doesntHave('answers')->count('id');
        $answers = Answer::count('id');
        $comments = Comment::count('id');
        $milestones = Milestone::count('id');
        $webhooks = Webhook::count('id');
        $notifications = DB::table('notifications')->count('id');
        $logs = Activity::count('id');
        $sessions = DB::table('sessions')->count();
        $interactions = DB::table('interactions')->count();
        $likes = DB::table('interactions')->whereRelation('like')->count();

        return [
            'tasks' => number_format($tasks),
            'tasks_done' => number_format($tasksDone),
            'tasks_pending' => number_format($tasks - $tasksDone),
            'users' => number_format($users),
            'users_active' => number_format($usersActive),
            'products' => number_format($products),
            'products_launched' => number_format($productsLaunched),
            'products_unlaunched' => number_format($products - $productsLaunched),
            'reputations' => number_format($reputations),
            'questions' => number_format($questions),
            'questions_answered' => number_format($questions - $questionsUnanswered),
            'questions_unanswered' => number_format($questionsUnanswered),
            'answers' => number_format($answers),
            'comments' => number_format($comments),
            'milestones' => number_format($milestones),
            'notifications' => number_format($notifications),
            'interactions' => number_format($interactions),
            'logs' => number_format($logs),
            'sessions' => number_format($sessions),
            'likes' => number_format($likes),
            'webhooks' => number_format($webhooks),
        ];
    }

    public function render(): View
    {
        return view('livewire.staff.stats', [
            'stats' => $this->readyToLoad ? $this->getStats() : [],
        ]);
    }
}
