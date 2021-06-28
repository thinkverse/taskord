<?php

use App\Http\Livewire\Home\Follow as HomeFollow;
use App\Http\Livewire\Notification\Follow as NotificationFollow;
use App\Http\Livewire\User\Follow as ProfileFollow;
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

it('can toggle follow user from profile page', function ($sourceUser, $targetUser, $status) {
    $targetUser = User::find($targetUser);

    if ($status) {
        return actingAs($sourceUser)
            ->livewire(ProfileFollow::class, ['user' => $targetUser])
            ->call('toggleFollow')
            ->assertEmitted('toggleFollow');
    }

    return actingAs($sourceUser)
        ->livewire(ProfileFollow::class, ['user' => $targetUser])
        ->call('toggleFollow')
        ->assertNotEmitted('toggleFollow');
})->with('follow-data');

it('can toggle follow user from notification page', function ($sourceUser, $targetUser, $status) {
    $targetUser = User::find($targetUser);

    if ($status) {
        return actingAs($sourceUser)
            ->livewire(NotificationFollow::class, ['user' => $targetUser])
            ->call('toggleFollow')
            ->assertEmitted('toggleFollow');
    }

    return actingAs($sourceUser)
        ->livewire(NotificationFollow::class, ['user' => $targetUser])
        ->call('toggleFollow')
        ->assertNotEmitted('toggleFollow');
})->with('follow-data');

it('can toggle follow user from home page', function ($sourceUser, $targetUser, $status) {
    $targetUser = User::find($targetUser);

    if ($status) {
        return actingAs($sourceUser)
            ->livewire(HomeFollow::class, [
                'user'     => $targetUser,
                'showText' => true,
            ])
            ->call('toggleFollow')
            ->assertEmitted('refreshSuggestions');
    }

    return actingAs($sourceUser)
        ->livewire(HomeFollow::class, [
            'user'     => $targetUser,
            'showText' => true,
        ])
        ->call('toggleFollow')
        ->assertNotEmitted('refreshSuggestions');
})->with('follow-data');
