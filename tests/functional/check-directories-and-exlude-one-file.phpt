--TEST--
Check directory and ignore one file
--FILE--
<?php

require __DIR__ . '/init.php';

$docheader = __DIR__ . '/.docheader-check-directories-and-exclude-one-file';

$command = new \DocHeader\Command\Checker(null);

$command->run(
    new Symfony\Component\Console\Input\StringInput('check tests/assets/ --exclude CorrectHeader.php --docheader ' . $docheader),
    new Symfony\Component\Console\Output\StreamOutput(fopen('php://stdout', 'w'))
);

?>
--EXPECTF--
-> CorrectRegexHeader.php
-> MissingHeader.php

    Something went wrong!
