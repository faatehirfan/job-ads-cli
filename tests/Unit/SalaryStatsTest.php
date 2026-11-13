<?php

declare(strict_types=1);

use JobAds\SalaryStats;

it('summarises the salaries of a list of ads', function () {
    $stats = SalaryStats::fromAds([
        jobAd(['salary_min' => 3000, 'salary_max' => 4000]),
        jobAd(['salary_min' => 5000, 'salary_max' => 7000]),
        jobAd(['salary_min' => 9000, 'salary_max' => 11000]),
    ]);

    expect($stats->count)->toBe(3)
        ->and($stats->lowest)->toBe(3000)
        ->and($stats->highest)->toBe(11000)
        ->and($stats->averageMidpoint)->toBe(6500);
});

it('refuses to summarise zero ads', function () {
    expect(fn () => SalaryStats::fromAds([]))
        ->toThrow(InvalidArgumentException::class, 'zero job ads');
});
