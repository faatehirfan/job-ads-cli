# job-ads-cli

A small command-line app that lists, filters and summarises job ads. Plain PHP 8.5 and Composer, no
framework. Built in Week 2 of the Laravel Developer Residency.

The ads in `data/job-ads.json` are fictional: made-up companies, made-up numbers. Salaries are in
ringgit per month.

## Requirements

- PHP 8.5 and Composer 2 (Laravel Herd ships both)

## Install

```bash
composer install
```

## Use

```bash
php bin/jobs list                                    # every ad
php bin/jobs filter --skill=laravel --min-salary=5000
php bin/jobs stats                                   # salary range and averages
php bin/jobs help
```

`--min-salary` keeps an ad when the top of its salary range is at least that amount.

Exit codes: `0` success, `1` the data file is missing or broken, `2` the command was typed wrong.

## Develop

```bash
composer test    # Pest
composer lint    # Pint (style) and PHPStan (level 5)
composer fix     # let Pint fix the style
```

CI runs the same checks on every push to `main` and on every pull request.