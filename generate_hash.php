<?php
    $time = time();
    echo "Time: $time".PHP_EOL."Hash: ".sha1($argv[1].$time.'secreto').PHP_EOL;