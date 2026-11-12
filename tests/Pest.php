<?php

declare(strict_types=1);

use JobAds\JobAd;
use Tests\TestCase;

pest()->extend(TestCase::class)->in('Feature');

/**
 * Build a valid JobAd for a test. Pass only the fields the test is about.
 *
 * @param  array<string, mixed>  $overrides
 */
function jobAd(array $overrides = []): JobAd
{
    return JobAd::fromArray([
        'id' => 1,
        'company' => 'Contoh Tech Sdn Bhd',
        'title' => 'Junior Laravel Developer',
        'seniority' => 'junior',
        'location' => 'Kuala Lumpur',
        'salary_min' => 3500,
        'salary_max' => 4500,
        'skills' => ['laravel', 'php'],
        ...$overrides,
    ]);
}
