<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;
use Rector\Set\ValueObject\SetList;
use Rector\ValueObject\PhpVersion;

return RectorConfig::configure()
    ->withPaths([
        __DIR__ . '/app',
        __DIR__ . '/bootstrap',
        __DIR__ . '/config',
        __DIR__ . '/resources',
        __DIR__ . '/routes',
        __DIR__ . '/tests',
    ])
    ->withPhpSets()
    ->withPhpVersion(PhpVersion::PHP_83)
    ->withCache()
    ->withSets([
        SetList::CODING_STYLE,
        SetList::CODE_QUALITY,
        SetList::DEAD_CODE,
        SetList::TYPE_DECLARATION,
        SetList::EARLY_RETURN,
        SetList::PRIVATIZATION,
        SetList::NAMING,
        SetList::STRICT_BOOLEANS,
        SetList::CARBON
    ])
    ->withPreparedSets(true)
    ->withSkip([
        __DIR__ . '/bootstrap/cache',
        __DIR__ . '/storage',
        __DIR__ . '/vendor',
        __DIR__ . '/node_modules',
        __DIR__ . '/database',
        __DIR__ . '/tests/Fixtures',
        '**/*.blade.php',
        '**/*.min.js',
        __DIR__ . '/.env',
        __DIR__ . '/.env*',
        __DIR__ . '/.git*',
    ]);
