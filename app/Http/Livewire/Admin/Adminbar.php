<?php

namespace App\Http\Livewire\Admin;

use App\Jobs\Clean;
use App\Jobs\Deploy;
use App\Models\Answer;
use App\Models\Comment;
use App\Models\Product;
use App\Models\Question;
use App\Models\Task;
use App\Models\User;
use App\Models\Webhook;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Queue;
use Livewire\Component;
use Spatie\Activitylog\Models\Activity;

class Adminbar extends Component
{
    protected $listeners = [
        'refreshStats' => 'render',
    ];

    public function refreshStats()
    {
        loggy(request()->ip(), 'Admin', auth()->user(), 'Refreshed Adminbar Status');

        $this->emitSelf('refreshStats');
    }

    public function clean()
    {
        Clean::dispatch()->delay(now()->addSeconds(10));
        loggy(request()->ip(), 'Admin', auth()->user(), 'Cleaned the Application');

        return $this->alert('success', 'Cleaning process has been initiated successfully 🧼');
    }
    
    public function deploy()
    {
        if (auth()->id() === 1) {
            Deploy::dispatch();
            loggy(request()->ip(), 'Admin', auth()->user(), 'Deployed the Application');
    
            return $this->alert('success', 'Deployment process has been initiated successfully 🚀');
        } else {
            return $this->alert('error', 'Permission denied!');
        }
    }

    public function render()
    {
        $branch = git('rev-parse --abbrev-ref HEAD') ?: 'main';
        $commit = git('rev-parse --short HEAD') ?: '0000000';

        // DB Details
        $tasks = Task::count('id');
        $users = User::count('id');
        $products = Product::count('id');
        $reputations = User::sum('reputation');
        $questions = Question::count('id');
        $answers = Answer::count('id');
        $comments = Comment::count('id');
        $webhooks = Webhook::count('id');
        $notifications = DB::table('notifications')->count('id');
        $logs = Activity::count('id');
        $interactions = DB::table('interactions')->count();
        $praises = DB::table('interactions')->whereRelation('like')->count();
        $jobs = Queue::size();
        $cache = Cache::getStore()->getMemcached()->getAllKeys() ?: [];

        return view('livewire.admin.adminbar', [
            'branchname' => $branch,
            'headHASH' => $commit,
            'tasks' => number_format($tasks),
            'users' => number_format($users),
            'products' => number_format($products),
            'reputations' => number_format($reputations),
            'questions' => number_format($questions),
            'answers' => number_format($answers),
            'comments' => number_format($comments),
            'notifications' => number_format($notifications),
            'interactions' => number_format($interactions),
            'logs' => number_format($logs),
            'praises' => number_format($praises),
            'jobs' => number_format($jobs),
            'cache' => number_format(count($cache)),
            'webhooks' => number_format($webhooks),
        ]);
    }
}
