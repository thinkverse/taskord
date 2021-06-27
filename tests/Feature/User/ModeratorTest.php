<?php

use App\Http\Livewire\User\Moderator;
use App\Models\User;
use function Tests\actingAs;

it('can edit (enrollBeta) settings', function ($status) {
    $newUser = User::factory()->create();

    if ($status) {
        return actingAs(1)
            ->livewire(Moderator::class, ['user' => $newUser])
            ->call('enrollBeta')
            ->assertEmitted('modSettingsUpdated');
    }

    return actingAs($newUser->id)
        ->livewire(Moderator::class, ['user' => $newUser])
        ->call('enrollBeta')
        ->assertNotEmitted('modSettingsUpdated');
})->with([
    [true],
    [false],
]);
