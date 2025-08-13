<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Testing\Fluent\AssertableJson;

it('shortens a valid URL', function () {
    $longUrl = 'https://example.com/some-very-long-url-path';

    $response = $this->postJson('/shorten', [
        'long_url' => $longUrl
    ]);

    $response->assertStatus(200)
             ->assertJson(fn (AssertableJson $json) =>
                 $json->has('short_url')
                      ->whereType('short_url', 'string')
             );
});

it('throws validation error for missing URL', function () {
    $response = $this->postJson('/shorten', []);

    $response->assertStatus(404) // Laravel validation error
             ->assertJsonValidationErrors(['long_url']);
});

it('throws validation error for invalid URL', function () {
    $response = $this->postJson('/shorten', [
        'long_url' => 'not-a-valid-url'
    ]);

    $response->assertStatus(404)
             ->assertJsonValidationErrors(['long_url']);
});
