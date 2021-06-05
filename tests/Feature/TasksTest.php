<?php

use App\Http\Livewire\Tasks\CreateTask;
use function Pest\Livewire\livewire;
use function Tests\actingAs;

it('has tasks page', function ($url, $expected, $auth) {
    if ($auth) {
        actingAs(1)->get($url)->assertStatus($expected);
    } else {
        $this->get($url)->assertStatus($expected);
    }
})->with([
    ['/tasks', 302, false],
    ['/tasks', 200, true],
]);

it('cannot create task as un-authed user', function () {
    livewire(CreateTask::class)
        ->set('task', 'Hello world from test!')
        ->call('submit')
        ->assertNotEmitted('refreshTasks');
});

it('can create task as authed user', function ($task, $user, $status) {
    if ($status) {
        return actingAs($user)
            ->livewire(CreateTask::class)
            ->set('task', $task)
            ->call('submit')
            ->assertEmitted('refreshTasks');
    }

    return actingAs($user)
        ->livewire(CreateTask::class)
        ->set('task', $task)
        ->call('submit')
        ->assertNotEmitted('refreshTasks');
})->with('model-content');
