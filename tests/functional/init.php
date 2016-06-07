<?php

require  __DIR__ . '/../../vendor/autoload.php';

/**
 * @param string $params
 */
$checkRunner = function ($params) {

    $basePath = realpath(__DIR__ . '/../../');

    system("php $basePath/bin/docheader check $params");
};
