<?php

use Illuminate\Support\Str;
use App\Http\Livewire\Products\CreateProduct;
use function Pest\Livewire\livewire;
use function Tests\actingAs;

it('has products page', function ($url, $expected, $auth) {
    if ($auth) {
        actingAs(1)->get($url)->assertStatus($expected);
    } else {
        $this->get($url)->assertStatus($expected);
    }
})->with([
    ['/products', 200, false],
    ['/products', 200, true],
]);

it('has launched products page', function ($url, $expected, $auth) {
    if ($auth) {
        actingAs(1)->get($url)->assertStatus($expected);
    } else {
        $this->get($url)->assertStatus($expected);
    }
})->with([
    ['/products/launched', 200, false],
    ['/products/launched', 200, true],
]);

it('has new products page', function ($url, $expected, $auth) {
    if ($auth) {
        actingAs(1)->get($url)->assertStatus($expected);
    } else {
        $this->get($url)->assertStatus($expected);
    }
})->with([
    ['/products/new', 302, false],
    ['/products/new', 200, true],
]);

it('has product done page', function ($url, $expected, $auth) {
    if ($auth) {
        actingAs(1)->get($url)->assertStatus($expected);
    } else {
        $this->get($url)->assertStatus($expected);
    }
})->with([
    ['/product/taskord', 200, false],
    ['/product/taskord', 200, true],
]);

it('has product pending page', function ($url, $expected, $auth) {
    if ($auth) {
        actingAs(1)->get($url)->assertStatus($expected);
    } else {
        $this->get($url)->assertStatus($expected);
    }
})->with([
    ['/product/taskord/pending', 200, false],
    ['/product/taskord/pending', 200, true],
]);

it('has product updates page', function ($url, $expected, $auth) {
    if ($auth) {
        actingAs(1)->get($url)->assertStatus($expected);
    } else {
        $this->get($url)->assertStatus($expected);
    }
})->with([
    ['/product/taskord/updates', 200, false],
    ['/product/taskord/updates', 200, true],
]);

it('has product popover', function ($url, $expected, $auth) {
    if ($auth) {
        actingAs(1)->get($url)->assertStatus($expected);
    } else {
        $this->get($url)->assertStatus($expected);
    }
})->with([
    ['/popover/product/1', 200, false],
    ['/popover/product/1', 200, true],
]);

it('cannot create product as un-authed user', function () {
    livewire(CreateProduct::class)
        ->set('name', 'Test Product')
        ->set('slug', Str::random(8))
        ->call('submit')
        ->assertNotEmitted('refreshProducts');
});
