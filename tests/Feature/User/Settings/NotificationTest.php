<?php

use App\Http\Livewire\User\Settings\Notifications;
use App\Models\User;
use function Tests\actingAs;

it('has settings/notifications page', function ($url, $expected, $auth) {
    if ($auth) {
        actingAs(1)->get($url)->assertStatus($expected);
    } else {
        $this->get($url)->assertStatus($expected);
    }
})->with([
    ['/settings/notifications', 302, false],
    ['/settings/notifications', 200, true],
]);

it('can edit notification (notificationsEmail) settings', function ($status) {
    $newUser = User::factory()->create();

    if ($status) {
        return actingAs($newUser->id)
            ->livewire(Notifications::class, ['user' => $newUser])
            ->call('notificationsEmail')
            ->assertEmitted('toggledNotificationsEmail');
    }

    return actingAs(1)
        ->livewire(Notifications::class, ['user' => $newUser])
        ->call('notificationsEmail')
        ->assertNotEmitted('toggledNotificationsEmail');
})->with([
    [true],
    [false],
]);

it('can edit notification (notificationsWeb) settings', function ($status) {
    $newUser = User::factory()->create();

    if ($status) {
        return actingAs($newUser->id)
            ->livewire(Notifications::class, ['user' => $newUser])
            ->call('notificationsWeb')
            ->assertEmitted('toggledNotificationsWeb');
    }

    return actingAs(1)
        ->livewire(Notifications::class, ['user' => $newUser])
        ->call('notificationsWeb')
        ->assertNotEmitted('toggledNotificationsWeb');
})->with([
    [true],
    [false],
]);