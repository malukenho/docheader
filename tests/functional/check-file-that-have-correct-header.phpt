--TEST--
Check file that have correct header
--FILE--
<?php

require __DIR__ . '/init.php';

$checkRunner('tests/assets/CorrectHeader.php');

?>
--EXPECTF--
Everything is OK!
