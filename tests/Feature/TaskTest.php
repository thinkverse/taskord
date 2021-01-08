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

it('can create task as un-authed user', function ($task) {
    livewire(CreateTask::class)
        ->set('task', $task)
        ->call('submit')
        ->assertNotEmitted('taskAdded');
})->with([
    ['Hello world from test!'],
    ['😊🤗💜✨👍'],
]);

it('can create task as authed user', function ($task) {
    actingAs(1)
        ->livewire(CreateTask::class)
        ->set('task', $task)
        ->call('submit')
        ->assertEmitted('taskAdded');
})->with([
    ['Hello world from test!'],
    ['😊🤗💜✨👍'],
]);
