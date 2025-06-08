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
