<?php

declare(strict_types=1);

use JobAds\InvalidJobAdsFile;
use JobAds\JobAdRepository;

it('loads every job ad in the file, in order', function () {
    $ads = (new JobAdRepository(__DIR__.'/../fixtures/two-ads.json'))->all();

    expect($ads)->toHaveCount(2)
        ->and($ads[0]->title)->toBe('Junior Laravel Developer')
        ->and($ads[1]->title)->toBe('Senior Laravel Engineer');
});

it('throws when the file does not exist', function () {
    $repository = new JobAdRepository(__DIR__.'/../fixtures/no-such-file.json');

    expect(fn () => $repository->all())->toThrow(InvalidJobAdsFile::class, 'Job ads file not found');
});

it('throws when the file is not valid JSON', function () {
    $repository = new JobAdRepository(__DIR__.'/../fixtures/not-json.json');

    expect(fn () => $repository->all())->toThrow(InvalidJobAdsFile::class, 'not valid JSON');
});

it('says which job ad is broken', function () {
    $repository = new JobAdRepository(__DIR__.'/../fixtures/second-ad-broken.json');

    expect(fn () => $repository->all())->toThrow(InvalidJobAdsFile::class, 'Job ad #2');
});