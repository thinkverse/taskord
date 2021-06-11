<?php

use App\Http\Livewire\User\Settings\Integrations;
use App\Models\User;
use App\Models\Webhook;
use function Tests\actingAs;

it('has settings/integrations page', function ($url, $expected, $auth) {
    if ($auth) {
        actingAs(1)->get($url)->assertStatus($expected);
    } else {
        $this->get($url)->assertStatus($expected);
    }
})->with([
    ['/settings/integrations', 302, false],
    ['/settings/integrations', 200, true],
]);

it('can create new webhook', function ($status) {
    $newUser = User::factory()->create();

    if ($status) {
        return actingAs($newUser->id)
            ->livewire(Integrations::class, ['user' => $newUser])
            ->set('name', 'Test webhook')
            ->call('submit')
            ->assertEmitted('webhookCreated');
    }

    return actingAs(1)
        ->livewire(Integrations::class, ['user' => $newUser])
        ->set('name', 'Test webhook')
        ->call('submit')
        ->assertNotEmitted('webhookCreated');
})->with([
    [true],
    [false],
]);

it('can delete a webhook', function ($status) {
    $newUser = User::factory()->create();
    $newWebhook = Webhook::factory()->create();

    if ($status) {
        return actingAs($newUser->id)
            ->livewire(Integrations::class, ['user' => $newUser])
            ->set('name', 'Test webhook')
            ->call('submit')
            ->assertEmitted('webhookCreated');
    }

    return actingAs(1)
        ->livewire(Integrations::class, ['user' => $newUser])
        ->set('name', 'Test webhook')
        ->call('submit')
        ->assertNotEmitted('webhookCreated');
})->with([
    [true],
    [false],
]);
