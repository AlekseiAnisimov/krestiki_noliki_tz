#!/usr/bin/php
<?php 

include 'autoloader.php';
//include 'library/Table.php';
//include 'library/Interactive.php';

$table = new Table();
$interactive = new Interactive($table);

$type =  $argv[1];
$stone_type = (isset($argv[2])) ? $argv[2] : null;

if (isset($type)) {
    $interactive->command($type,$stone_type);
}
?>