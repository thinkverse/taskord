<?php

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

it('can create task as authed user', function ($task) {
    actingAs(2)
        ->livewire(CreateTask::class)
        ->set('task', $task)
        ->call('submit')
        ->assertEmitted('refreshTasks');
})->with([
    ['Hello world from test!'],
    ['😊🤗💜✨👍'],
]);

it('cannot create task - task validation', function ($task) {
    actingAs(2)
        ->livewire(CreateTask::class)
        ->set('task', $task)
        ->call('submit')
        ->assertHasErrors('task');
})->with([
    [''],
    ['1234'],
]);
