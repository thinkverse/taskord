<?php

use App\Http\Livewire\Milestone\CreateMilestone;
use App\Models\Question;
use function Pest\Livewire\livewire;
use function Tests\actingAs;

it('has milestones page', function ($url, $expected, $auth) {
    if ($auth) {
        actingAs(1)->get($url)->assertStatus($expected);
    } else {
        $this->get($url)->assertStatus($expected);
    }
})->with([
    ['/milestones', 200, false],
    ['/milestones', 200, true],
]);

it('has new milestone page', function ($url, $expected, $auth) {
    if ($auth) {
        actingAs(1)->get($url)->assertStatus($expected);
    } else {
        $this->get($url)->assertStatus($expected);
    }
})->with([
    ['/milestones/new', 302, false],
    ['/milestones/new', 200, true],
]);

it('has single milestone page', function ($url, $expected, $auth) {
    if ($auth) {
        actingAs(1)->get($url)->assertStatus($expected);
    } else {
        $this->get($url)->assertStatus($expected);
    }
})->with([
    ['/milestones/1', 200, false],
    ['/milestones/1', 200, true],
]);

it('cannot create milestone as un-authed user', function () {
    livewire(CreateAnswer::class, ['question' => $question])
        ->set('answer', 'Hello world from test!')
        ->call('submit')
        ->assertNotEmitted('refreshAnswers');
});
