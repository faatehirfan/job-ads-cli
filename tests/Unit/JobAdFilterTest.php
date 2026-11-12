<?php

declare(strict_types=1);

use JobAds\JobAdFilter;
use JobAds\Seniority;

it('keeps every ad when no option is given', function () {
    $ads = [jobAd(['id' => 1]), jobAd(['id' => 2])];

    expect((new JobAdFilter)->apply($ads))->toBe($ads);
});

it('keeps only the ads that ask for the skill', function () {
    $react = jobAd(['id' => 1, 'skills' => ['react']]);
    $laravel = jobAd(['id' => 2, 'skills' => ['laravel', 'php']]);

    $matches = (new JobAdFilter(skill: 'laravel'))->apply([$react, $laravel]);

    expect($matches)->toBe([$laravel]);
});

it('keeps an ad when its salary range reaches the minimum', function (int $salaryMax, bool $kept) {
    $ad = jobAd(['salary_min' => 3000, 'salary_max' => $salaryMax]);

    expect((new JobAdFilter(minSalary: 5000))->matches($ad))->toBe($kept);
})->with([
    'top of range below the minimum' => [4999, false],
    'top of range exactly the minimum' => [5000, true],
    'top of range above the minimum' => [5200, true],
]);

it('keeps only the ads at the given seniority', function () {
    $junior = jobAd(['id' => 1, 'seniority' => 'junior']);
    $senior = jobAd(['id' => 2, 'seniority' => 'senior']);

    expect((new JobAdFilter(seniority: Seniority::Senior))->apply([$junior, $senior]))->toBe([$senior]);
});

it('needs an ad to match every option given', function () {
    $cheapLaravel = jobAd(['id' => 1, 'skills' => ['laravel'], 'salary_max' => 4500]);
    $wellPaidReact = jobAd(['id' => 2, 'skills' => ['react'], 'salary_max' => 8000]);
    $wellPaidLaravel = jobAd(['id' => 3, 'skills' => ['laravel'], 'salary_max' => 8000]);

    $matches = (new JobAdFilter(skill: 'laravel', minSalary: 5000))
        ->apply([$cheapLaravel, $wellPaidReact, $wellPaidLaravel]);

    expect($matches)->toBe([$wellPaidLaravel]);
});