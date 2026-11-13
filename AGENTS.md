# AGENTS.md

Instructions for AI coding agents working in this repository. 

## What this is

`job-ads-cli`: a command-line app that lists, filters and summarises the job ads in
`data/job-ads.json`. Plain PHP 8.5 and Composer. No framework, no database.

## Commands

- Install: `composer install`
- Run: `php bin/jobs list`, `php bin/jobs filter --skill=laravel --min-salary=5000`, `php bin/jobs stats`
- Test: `composer test` (Pest 5)
- Lint: `composer lint` (Pint `--test`, then PHPStan level 5)
- Fix style: `composer fix`

CI (`.github/workflows/ci.yml`) runs Pint, PHPStan and Pest. A change is done when all three pass.

## Layout

- `bin/jobs`: entry script. Builds the objects and calls `Cli::run()`. Keep it tiny.
- `src/`: all classes, namespace `JobAds\`, autoloaded by PSR-4 (`JobAds\JobAdFilter` lives in
  `src/JobAdFilter.php`). One class or enum per file, file name = class name.
- `tests/Unit/`: one test file per class. `tests/Feature/`: runs `bin/jobs` as a real process.
- `tests/fixtures/`: small JSON files used by the repository tests.

## Conventions

- Every PHP file starts with `declare(strict_types=1);`.
- Type every parameter, return value and property. Use `list<JobAd>` docblocks for arrays.
- Value objects are `final readonly` classes. Fixed sets of values are backed enums (see `Seniority`).
- Bad user input throws `InvalidArgumentException` (exit code 2). A missing or broken data file
  throws `JobAds\InvalidJobAdsFile` (exit code 1). Only `Cli::run()` turns exceptions into exit codes.
- Compare with `===` and `!==`, never `==`.
- Test names describe behaviour, not methods: `it('keeps only the ads that ask for the skill')`.
- English everywhere: code, comments, commit messages, PR descriptions.

## Do not touch

- `vendor/`: installed by Composer, never committed, never edited.
- `composer.lock`: never edit by hand. It changes only through `composer require` or `composer update`.
- `data/job-ads.json` and `tests/fixtures/`: test data. The tests depend on the exact contents.
- `.github/workflows/ci.yml`: the cohort's CI template. Ask before changing it.

## How to help me

I am learning PHP (Phase 1 of the residency). Explain and point me to the line; do not write or edit
the code for me unless I ask for a specific change. Ask before running any command that deletes
files or rewrites Git history.