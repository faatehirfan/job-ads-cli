<?php

declare(strict_types=1);

/**
 * Run bin/jobs the way you would in a terminal.
 *
 * @return array{int, string} the exit code, and everything it printed
 */
function jobs(string $arguments): array
{
    $command = escapeshellarg(PHP_BINARY).' '.escapeshellarg(dirname(__DIR__, 2).'/bin/jobs').' '.$arguments.' 2>&1';
    exec($command, $lines, $exitCode);

    return [$exitCode, implode(PHP_EOL, $lines)];
}

it('exits with 0 after listing the ads', function () {
    [$exitCode, $output] = jobs('list');

    expect($exitCode)->toBe(0)
        ->and($output)->toContain('Junior Laravel Developer');
});

it('exits with 0 after filtering by skill and minimum salary', function () {
    [$exitCode, $output] = jobs('filter --skill=laravel --min-salary=5000');

    expect($exitCode)->toBe(0)
        ->and($output)->toContain('Senior Laravel Engineer')
        ->and($output)->not->toContain('Junior PHP Developer');
});

it('exits with 2 and shows the usage for an unknown command', function () {
    [$exitCode, $output] = jobs('lsit');

    expect($exitCode)->toBe(2)
        ->and($output)->toContain('Unknown command "lsit"')
        ->and($output)->toContain('Usage: php bin/jobs');
});

it('exits with 2 when the minimum salary is not a whole number', function (string $value) {
    [$exitCode, $output] = jobs('filter --min-salary='.$value);

    expect($exitCode)->toBe(2)
        ->and($output)->toContain('--min-salary must be a whole number');
})->with(['five', '5k', '-100', '4500.50']);
