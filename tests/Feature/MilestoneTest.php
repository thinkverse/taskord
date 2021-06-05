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
    livewire(CreateMilestone::class)
        ->set('name', 'Hello world from test!')
        ->set('description', 'Hello world from test!')
        ->call('submit')
        ->assertNotEmitted('refreshMilestones');
});

it('can create milestone as authed user', function ($question, $user, $status) {
    if ($status) {
        return actingAs($user)
            ->livewire(CreateMilestone::class)
            ->set('name', $question)
            ->set('description', $question)
            ->call('submit')
            ->assertEmitted('refreshMilestones');
    }

    return actingAs($user)
        ->livewire(CreateMilestone::class)
        ->set('name', $question)
        ->set('description', $question)
        ->call('submit')
        ->assertNotEmitted('refreshMilestones');
})->with([
    ['Hello world from test!', 2, true],
    ['😊🤗💜✨👍', 2, true],
    ['', 2, false],
    ['12', 2, false],
    ['Hello from suspended account!', 3, false],
    ['Hello from spammy account!', 4, false],
    ['Hello from un-verified account!', 5, false],
]);
