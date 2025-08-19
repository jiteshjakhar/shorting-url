<?php

use App\Models\User;
use App\Models\Company;
use App\Models\ShortUrl;
use Illuminate\Support\Facades\URL;
use function Pest\Laravel\{actingAs, post};

it('creates a short url for an authenticated Admin and redirects with success', function () {
    // Arrange: company + admin
    $company = Company::create(['name' => 'TestCo']);
    $admin   = User::factory()->create([
        'role'       => 'Admin',
        'company_id' => $company->id,
    ]);

    $longUrl = 'https://example.com/some-very-long-url-path';

    // Act: act as admin, post from the create page
    actingAs($admin);
    $response = $this->from(route('short-urls.create'))
        ->post(route('short-urls.store'), [
            'long_url' => $longUrl,
        ]);

    // Assert: redirect back with success + DB row created
    $response->assertRedirect(route('short-urls.create'));
    $response->assertSessionHas('success');

    $this->assertDatabaseHas('short_urls', [
        'user_id'      => $admin->id,
        'company_id'   => $company->id,
        'original_url' => $longUrl,
    ]);
});

it('redirects back with validation error when long_url is missing', function () {
    $company = Company::create(['name' => 'TestCo']);
    $admin   = User::factory()->create([
        'role'       => 'Admin',
        'company_id' => $company->id,
    ]);

    actingAs($admin);
    $response = $this->from(route('short-urls.create'))
        ->post(route('short-urls.store'), []); // no long_url

    $response->assertRedirect(route('short-urls.create'));
    $response->assertSessionHasErrors(['long_url']);
});

it('redirects back with validation error when long_url is invalid', function () {
    $company = Company::create(['name' => 'TestCo']);
    $member  = User::factory()->create([
        'role'       => 'Member',
        'company_id' => $company->id,
    ]);

    actingAs($member);
    $response = $this->from(route('short-urls.create'))
        ->post(route('short-urls.store'), [
            'long_url' => 'not-a-valid-url',
        ]);

    $response->assertRedirect(route('short-urls.create'));
    $response->assertSessionHasErrors(['long_url']);
});
