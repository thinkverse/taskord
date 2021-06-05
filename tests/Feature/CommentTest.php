<?php

use App\Models\Task;
use App\Http\Livewire\Comment\CreateComment;
use function Pest\Livewire\livewire;
use function Tests\actingAs;

it('has comment page', function ($url, $expected, $auth) {
    if ($auth) {
        actingAs(1)->get($url)->assertStatus($expected);
    } else {
        $this->get($url)->assertStatus($expected);
    }
})->with([
    ['/task/1/1', 200, false],
    ['/task/1/1', 200, true],
]);

it('cannot create comment as un-authed user', function () {
    $task = Task::factory()->create();

    livewire(CreateComment::class, ['task' => $task])
        ->set('comment', 'Hello world from test!')
        ->call('submit')
        ->assertNotEmitted('refreshTasks');
});
