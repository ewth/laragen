<?php

$tableName = $argv[1] ?? '';
if (empty($tableName)) {
    throw new \Exception('A table name must be specified.');
}
include('Laragen.php');
$laragen = new Ewth\Laragen($tableName);
$laragen->generate();
