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

it('can edit notification (notificationsEmail) settings', function () {
    $newUser = User::factory()->create();

    return actingAs($newUser->id)
        ->livewire(Notifications::class, ['user' => $newUser])
        ->call('notificationsEmail')
        ->assertEmitted('toggledNotificationsEmail');
});

it('can edit notification (notificationsWeb) settings', function () {
    $newUser = User::factory()->create();

    return actingAs($newUser->id)
        ->livewire(Notifications::class, ['user' => $newUser])
        ->call('notificationsWeb')
        ->assertEmitted('toggledNotificationsWeb');
});
