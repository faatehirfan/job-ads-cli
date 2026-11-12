<?php

declare(strict_types=1);

use JobAds\Seniority;

it('has a label for every level', function (Seniority $level, string $label) {
    expect($level->label())->toBe($label);
})->with([
    'junior' => [Seniority::Junior, 'Junior'],
    'mid' => [Seniority::Mid, 'Mid-level'],
    'senior' => [Seniority::Senior, 'Senior'],
]);

it('turns a JSON value into a case, or null when the value is unknown', function () {
    expect(Seniority::from('mid'))->toBe(Seniority::Mid)
        ->and(Seniority::tryFrom('intern'))->toBeNull();
});
