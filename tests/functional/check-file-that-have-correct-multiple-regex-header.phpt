--TEST--
Check file that have correct multiple regex header
--FILE--
<?php

require __DIR__ . '/init.php';

$docheader = __DIR__ . '/.docheader-check-file-that-have-correct-multiple-regex-header';

$command = new \DocHeader\Command\Checker(null );

$command->run(
    new Symfony\Component\Console\Input\StringInput('check tests/assets/CorrectMultipleRegexHeader.php --docheader ' . $docheader),
    new Symfony\Component\Console\Output\StreamOutput(fopen('php://stdout', 'bw'))
);

?>
--EXPECTF--
Everything is OK!
