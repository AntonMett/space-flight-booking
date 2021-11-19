<?php
require 'db.php';
$db = new DB();

$fname = htmlspecialchars($_POST["fname"]);
$lname = htmlspecialchars($_POST["lname"]);
$route = htmlspecialchars($_POST["route"]);
$price = htmlspecialchars($_POST["price"]);
$travelTime = htmlspecialchars($_POST["travel_time"]);
$company = htmlspecialchars($_POST["provider_name"]);

try {
    $db->insert('reservations', 'first_name, last_name, route, provider, total_price, total_travel_time',
        [$fname, $lname, $route, $company, $price, $travelTime]);
} catch (PDOException $exception) {
    "ERROR!: " . $exception->getMessage() . "\n";
}


