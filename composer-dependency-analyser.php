<?php

declare(strict_types=1);

use ShipMonk\ComposerDependencyAnalyser\Config\Configuration;

return (new Configuration())
    ->disableComposerAutoloadPathScan()
    ->setFileExtensions(['php'])
    ->addPathToScan(__DIR__ . '/src', isDev: false)
    ->addPathToScan(__DIR__ . '/tests', isDev: true)
    // Declared in src/test-functions.php, loaded via `require_once` in tests/bootstrap.php rather than
    // composer's "files" autoloader, so the analyser cannot resolve their declaration.
    ->ignoreUnknownFunctions([
        'Yiisoft\Html\IdGenerator\reset',
        'Yiisoft\Html\IdGenerator\enableSeed',
        'Yiisoft\Html\IdGenerator\disableSeed',
    ]);
