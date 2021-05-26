<?php

namespace App\Http\Livewire\Staff;

use Livewire\Component;
use Livewire\WithPagination;

class Deployments extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $readyToLoad = false;

    public function loadUsers()
    {
        $this->readyToLoad = true;
    }

    public function getDeployments()
    {
        return true;
    }

    public function render()
    {
        return view('livewire.staff.deployments', [
            'deployments' => $this->readyToLoad ? $this->getDeployments() : [],
        ]);
    }
}
