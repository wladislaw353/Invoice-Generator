<?php

$db_host     = 'dr319515.mysql.tools';
$db_name     = 'dr319515_invoicetest';
$db_login    = 'dr319515_invoicetest';
$db_password = 'h&MB;62tv2';

try {
    $db = new PDO ("mysql:host=$db_host;dbname=$db_name;charset=utf8mb4", $db_login, $db_password);
} catch (PDOException $e) {
    exit ("Error!: " . $e->getMessage());
}