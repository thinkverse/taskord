<?php

use App\Http\Livewire\CreateTask;
use function Pest\Livewire\livewire;
use function Tests\actingAs;

it('has task page', function ($url, $expected, $auth) {
    if ($auth) {
        actingAs(1)->get($url)->assertStatus($expected);
    } else {
        $this->get($url)->assertStatus($expected);
    }
})->with([
    ['/task/1', 200, false],
    ['/task/1', 200, true],
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
})->with([
    ['Hello world from test!', 2, true],
    ['😊🤗💜✨👍', 2, true],
    ['', 2, false],
    ['12', 2, false],
    ['Hello from suspended account!', 3, false],
    ['Hello from spammy account!', 4, false],
    ['Hello from un-verified account!', 5, false],
]);
