<?php

namespace App\Http\Livewire\Staff;

use App\Jobs\Clean;
use App\Jobs\Deploy;
use Illuminate\Support\Facades\Queue;
use Livewire\Component;
use Jean85\PrettyVersions;

class Staffbar extends Component
{
    public function clean()
    {
        Clean::dispatch();
        loggy(request(), 'Staff', auth()->user(), 'Cleaned the Application');

        return toast($this, 'success', 'Cleaning process has been initiated successfully');
    }

    public function deploy()
    {
        if (auth()->id() === 1) {
            Deploy::dispatch(auth()->user(), request()->ip());
            Clean::dispatch();
            loggy(request(), 'Staff', auth()->user(), 'Deployed the Application');

            return toast($this, 'success', 'Deployment process has been initiated successfully 🚀');
        }

        return toast($this, 'error', 'Permission denied!');
    }

    public function render()
    {
        $branch = git('rev-parse --abbrev-ref HEAD') ?: 'main';
        $commit = git('rev-parse --short HEAD') ?: '0000000';
        $jobs = Queue::size();
        $version = PrettyVersions::getVersion('laravel/framework');

        return view('livewire.staff.staffbar', [
            'branchname' => $branch,
            'headHASH' => $commit,
            'laravel_version' => $version->getShortVersion(),
            'laravel_ref' => $version->getShortReference(),
            'jobs' => number_format($jobs),
        ]);
    }
}
