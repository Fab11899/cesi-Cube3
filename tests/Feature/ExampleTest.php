<?php

test('returns a successful response /', function () {
    $response = $this->get('/');

    $response->assertStatus(200);
});

test('returns a successful response /cart', function () {
    $response = $this->get('/cart');

    $response->assertStatus(200);
});

test('returns a successful response /product/1', function () {
    $response = $this->get('/product/1');

    $response->assertStatus(200);
});

test('returns a successful response /product/2', function () {
    $response = $this->get('/product/2');

    $response->assertStatus(200);
});

test('returns a successful response /product/3', function () {
    $response = $this->get('/product/3');

    $response->assertStatus(200);
});

test('returns a successful response /product/4', function () {
    $response = $this->get('/product/4');

    $response->assertStatus(200);
});

test('returns a successful response api/products', function () {
    $response = $this->get('api/products');

    $response->assertStatus(200);
});

test('returns a successful response api/cart', function () {
    $response = $this->get('api/cart');

    $response->assertStatus(200);
});
