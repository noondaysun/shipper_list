<?php

declare(strict_types=1);

use Rector\Set\ValueObject\SetList;
use Rector\Config\RectorConfig;

return static function (RectorConfig $rectorConfig): void {
    // get parameters
    $rectorConfig->paths([
        __DIR__ . '/app',
    ]);
    $rectorConfig->skip([
        Rector\CodeQuality\Rector\Array_\CallableThisArrayToAnonymousFunctionRector::class,
    ]);

    // Define what rule sets will be applied
    $rectorConfig->import(SetList::CODE_QUALITY);
    $rectorConfig->import(SetList::CODING_STYLE);
    $rectorConfig->import(SetList::DEAD_CODE);
    $rectorConfig->import(SetList::NAMING);
    $rectorConfig->import(SetList::PHP_81);
};
