<?php

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