--TEST--
Check file that not have header
--FILE--
<?php

require __DIR__ . '/init.php';

$checkRunner('tests/assets/MissingHeader.php');

?>
--EXPECTF--

-> MissingHeader.php

%ASomething goes wrong!
