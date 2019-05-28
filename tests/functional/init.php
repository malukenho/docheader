<?php

declare(strict_types=1);

require __DIR__ . '/../../vendor/autoload.php';

/**
 * @param string $params
 */
$checkRunner = static function ($params) : void {
    $basePath = realpath(__DIR__ . '/../../');

    system("php $basePath/bin/docheader check $params");
};
