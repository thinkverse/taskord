<?php

namespace App\Http\Livewire\Staff;

use App\Jobs\Clean;
use App\Jobs\Deploy;
use App\Jobs\Report;
use Illuminate\Support\Facades\Queue;
use Illuminate\View\View;
use Jean85\PrettyVersions;
use Livewire\Component;

class Staffbar extends Component
{
    public $title;
    public $description;

    public function report()
    {
        $this->validate([
            'title'       => ['required', 'min:3', 'max:10000'],
            'description' => ['max:10000'],
        ]);

        Report::dispatch($this->title, $this->description);
        $this->reset();
        loggy(request(), 'Staff', auth()->user(), 'Reported an issue to GitLab');

        return toast($this, 'success', 'A new issue has been submitted to GitLab successfully');
    }

    public function clean()
    {
        Clean::dispatch();
        loggy(request(), 'Staff', auth()->user(), 'Cleaned the Application');

        return toast($this, 'success', 'Cleaning process has been initiated successfully');
    }

    public function deploy()
    {
        Deploy::dispatch();
        loggy(request(), 'Staff', auth()->user(), 'Deployed the Application');

        return toast($this, 'success', 'Deployment process has been initiated successfully');
    }

    public function render(): View
    {
        $branchName = git('rev-parse --abbrev-ref HEAD') ?: 'main';
        $headRef = git('rev-parse --short HEAD') ?: '0000000';
        $jobs = Queue::size();
        $version = PrettyVersions::getVersion('laravel/framework');

        return view('livewire.staff.staffbar', [
            'branch_name'     => $branchName,
            'head_ref'        => $headRef,
            'laravel_version' => $version->getShortVersion(),
            'laravel_ref'     => $version->getShortReference(),
            'jobs'            => number_format($jobs),
        ]);
    }
}
