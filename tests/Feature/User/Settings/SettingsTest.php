<?php

use App\Http\Livewire\User\Settings\Profile;
use App\Http\Livewire\User\Settings\Account;
use App\Models\User;
use function Pest\Livewire\livewire;
use function Tests\actingAs;

it('has settings/account page', function ($url, $expected, $auth) {
    if ($auth) {
        actingAs(1)->get($url)->assertStatus($expected);
    } else {
        $this->get($url)->assertStatus($expected);
    }
})->with([
    ['/settings/account', 302, false],
    ['/settings/account', 200, true],
]);

it('has settings/appearance page', function ($url, $expected, $auth) {
    if ($auth) {
        actingAs(1)->get($url)->assertStatus($expected);
    } else {
        $this->get($url)->assertStatus($expected);
    }
})->with([
    ['/settings/appearance', 302, false],
    ['/settings/appearance', 200, true],
]);

it('has settings/products page', function ($url, $expected, $auth) {
    if ($auth) {
        actingAs(1)->get($url)->assertStatus($expected);
    } else {
        $this->get($url)->assertStatus($expected);
    }
})->with([
    ['/settings/products', 302, false],
    ['/settings/products', 200, true],
]);

it('has settings/patron page', function ($url, $expected, $auth) {
    if ($auth) {
        actingAs(1)->get($url)->assertStatus($expected);
    } else {
        $this->get($url)->assertStatus($expected);
    }
})->with([
    ['/settings/patron', 302, false],
    ['/settings/patron', 200, true],
]);

it('has settings/password page', function ($url, $expected, $auth) {
    if ($auth) {
        actingAs(1)->get($url)->assertStatus($expected);
    } else {
        $this->get($url)->assertStatus($expected);
    }
})->with([
    ['/settings/password', 302, false],
    ['/settings/password', 200, true],
]);

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

it('has settings/api page', function ($url, $expected, $auth) {
    if ($auth) {
        actingAs(1)->get($url)->assertStatus($expected);
    } else {
        $this->get($url)->assertStatus($expected);
    }
})->with([
    ['/settings/api', 302, false],
    ['/settings/api', 200, true],
]);

it('has settings/sessions page', function ($url, $expected, $auth) {
    if ($auth) {
        actingAs(1)->get($url)->assertStatus($expected);
    } else {
        $this->get($url)->assertStatus($expected);
    }
})->with([
    ['/settings/sessions', 302, false],
    ['/settings/sessions', 200, true],
]);

it('has settings/logs page', function ($url, $expected, $auth) {
    if ($auth) {
        actingAs(1)->get($url)->assertStatus($expected);
    } else {
        $this->get($url)->assertStatus($expected);
    }
})->with([
    ['/settings/logs', 302, false],
    ['/settings/logs', 200, true],
]);

it('has settings/data page', function ($url, $expected, $auth) {
    if ($auth) {
        actingAs(1)->get($url)->assertStatus($expected);
    } else {
        $this->get($url)->assertStatus($expected);
    }
})->with([
    ['/settings/data', 302, false],
    ['/settings/data', 200, true],
]);

it('has settings/delete page', function ($url, $expected, $auth) {
    if ($auth) {
        actingAs(1)->get($url)->assertStatus($expected);
    } else {
        $this->get($url)->assertStatus($expected);
    }
})->with([
    ['/settings/delete', 302, false],
    ['/settings/delete', 200, true],
]);

test('can download user account data', function ($url, $expected, $auth) {
    if ($auth) {
        actingAs(1)->get($url)->assertStatus($expected);
    } else {
        $this->get($url)->assertStatus($expected);
    }
})->with([
    ['/settings/export/account', 302, false],
]);

test('can download user logs data', function ($url, $expected, $auth) {
    if ($auth) {
        actingAs(1)->get($url)->assertStatus($expected);
    } else {
        $this->get($url)->assertStatus($expected);
    }
})->with([
    ['/settings/export/logs', 302, false],
]);
