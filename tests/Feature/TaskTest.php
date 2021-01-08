<?php

use function Tests\actingAs;
use function Tests\faker;
use function Pest\Livewire\livewire;
use App\Http\Livewire\CreateTask;

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

it('can create task as un-authed user', function () {
    livewire(CreateTask::class)
        ->set('task', 'Hello world from test!')
        ->call('submit')
        ->assertNotEmitted('taskAdded');
});

it('can create task as suspended/flagged user', function () {
    actingAs(3)
        ->livewire(CreateTask::class)
        ->set('task', 'Hello world from test!')
        ->call('submit')
        ->assertNotEmitted('taskAdded');
});

it('can create task as authed user', function ($task) {
    actingAs()
        ->livewire(CreateTask::class)
        ->set('task', $task)
        ->call('submit')
        ->assertEmitted('taskAdded');
})->with([
    ['Hello world from test!'],
    ['😊🤗💜✨👍'],
]);
