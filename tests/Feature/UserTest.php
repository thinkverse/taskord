<?php

use App\Http\Livewire\User\Follow;
use App\Models\User;
use function Tests\actingAs;

it('has user done page', function ($url, $expected, $auth) {
    if ($auth) {
        actingAs(1)->get($url)->assertStatus($expected);
    } else {
        $this->get($url)->assertStatus($expected);
    }
})->with([
    ['/@test', 200, false],
    ['/@test', 200, true],
]);

it('has user pending page', function ($url, $expected, $auth) {
    if ($auth) {
        actingAs(1)->get($url)->assertStatus($expected);
    } else {
        $this->get($url)->assertStatus($expected);
    }
})->with([
    ['/@test/pending', 200, false],
    ['/@test/pending', 200, true],
]);

it('has user products page', function ($url, $expected, $auth) {
    if ($auth) {
        actingAs(1)->get($url)->assertStatus($expected);
    } else {
        $this->get($url)->assertStatus($expected);
    }
})->with([
    ['/@test/products', 200, false],
    ['/@test/products', 200, true],
]);

it('has user questions page', function ($url, $expected, $auth) {
    if ($auth) {
        actingAs(1)->get($url)->assertStatus($expected);
    } else {
        $this->get($url)->assertStatus($expected);
    }
})->with([
    ['/@test/questions', 200, false],
    ['/@test/questions', 200, true],
]);

it('has user answers page', function ($url, $expected, $auth) {
    if ($auth) {
        actingAs(1)->get($url)->assertStatus($expected);
    } else {
        $this->get($url)->assertStatus($expected);
    }
})->with([
    ['/@test/answers', 200, false],
    ['/@test/answers', 200, true],
]);

it('has user stats page', function ($url, $expected, $auth) {
    if ($auth) {
        actingAs(1)->get($url)->assertStatus($expected);
    } else {
        $this->get($url)->assertStatus($expected);
    }
})->with([
    ['/@test/stats', 200, false],
    ['/@test/stats', 200, true],
]);

it('has user popover', function ($url, $expected, $auth) {
    if ($auth) {
        actingAs(1)->get($url)->assertStatus($expected);
    } else {
        $this->get($url)->assertStatus($expected);
    }
})->with([
    ['/popover/user/1', 200, false],
    ['/popover/user/1', 200, true],
]);

it('can toggle follow on user', function ($sourceUser, $targetUser, $status) {
    $targetUser = User::find($targetUser);

    if ($status) {
        return actingAs($sourceUser)
            ->livewire(Follow::class, ['user' => $targetUser])
            ->call('toggleFollow')
            ->assertEmitted('toggleFollow');
    }

    return actingAs($sourceUser)
        ->livewire(Follow::class, ['user' => $targetUser])
        ->call('toggleFollow')
        ->assertNotEmitted('toggleFollow');
})->with([
    [1, 1, false], // Cannot follow staff -> staff
    [3, 1, false], // Cannot follow suspended -> staff
    [4, 2, false], // Cannot follow spammy -> staff
    [2, 1, false], // Can follow test -> staff
]);
