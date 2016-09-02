--TEST--
Check against multiple files
--FILE--
<?php

require __DIR__ . '/init.php';

$checkRunner('tests/assets/CorrectHeader.php tests/assets/MissingHeader.php ');

?>
--EXPECTF--
-> MissingHeader.php

%ASomething goes wrong!
