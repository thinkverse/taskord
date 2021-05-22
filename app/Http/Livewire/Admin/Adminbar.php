<?php

namespace App\Http\Livewire\Admin;

use App\Jobs\Clean;
use App\Jobs\Deploy;
use Helper;
use Illuminate\Support\Facades\Queue;
use Livewire\Component;

class Adminbar extends Component
{
    public function clean()
    {
        Clean::dispatch();
        loggy(request(), 'Admin', auth()->user(), 'Cleaned the Application');

        return $this->dispatchBrowserEvent('toast', [
            'type' => 'success',
            'body' => 'Cleaning process has been initiated successfully',
        ]);
    }

    public function deploy()
    {
        if (auth()->id() === 1) {
            Deploy::dispatch(auth()->user(), request()->ip());
            Clean::dispatch();
            loggy(request(), 'Admin', auth()->user(), 'Deployed the Application');

            return Helper::toast($this, 'success', 'Deployment process has been initiated successfully 🚀');
        } else {
            return Helper::toast($this, 'error', 'Permission denied!');
        }
    }

    public function render()
    {
        $branch = git('rev-parse --abbrev-ref HEAD') ?: 'main';
        $commit = git('rev-parse --short HEAD') ?: '0000000';
        $jobs = Queue::size();

        return view('livewire.admin.adminbar', [
            'branchname' => $branch,
            'headHASH' => $commit,
            'jobs' => number_format($jobs),
        ]);
    }
}
