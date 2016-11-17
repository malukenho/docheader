--TEST--
Check file that have correct regex header
--FILE--
<?php

require __DIR__ . '/init.php';

$command = new \DocHeader\Command\Checker(
    null,
    'Header with correct regex license %regexp:\d{2}\.\d{2}\.20\d{2}%'
);

$command->run(
    new Symfony\Component\Console\Input\StringInput('check tests/assets/CorrectRegexHeader.php'),
    new Symfony\Component\Console\Output\StreamOutput(fopen('php://stdout', 'w'))
);

?>
--EXPECTF--
Everything is OK!
