<?php

declare(strict_types=1);

require __DIR__ . '/../../vendor/autoload.php';

$checkRunner = static function (string $params): void {
    $basePath = dirname(__DIR__, 2) . '/';

    system("php ".$basePath."/bin/docheader check $params");
};
