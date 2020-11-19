<?php
/**
 * Praktikum DBWT. Authoren:
 * Marco, Ermes Catulo, 3124518
 * Shafiq, Azam, 3241745
 */

$log = fopen('./accesslog.txt', 'a');

$line = date("d.m.y").', '.date("H:i:s").', '.$_SERVER['HTTP_USER_AGENT'].', '.$_SERVER['REMOTE_ADDR'].PHP_EOL;

fwrite($log, $line);

fclose($log);
?>