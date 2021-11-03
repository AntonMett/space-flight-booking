<?php

require("db.php");
$db = new DB();
$db->createTable("price_list", "id VARCHAR(255) PRIMARY KEY, valid_until DATETIME");

$callFlightsApi = file_get_contents('https://cosmos-odyssey.azurewebsites.net/api/v1.0/TravelPrices');
$flightsData = json_decode($callFlightsApi);

$dateTime = new DateTime($flightsData->validUntil);
$validUntil = $dateTime->format("Y-m-d H:m:s");

$db->insert('price_list', 'id, valid_until', [$flightsData->id, $validUntil]);
echo "<pre>";
var_dump($validUntil);
var_dump($flightsData->validUntil);

//$from = $_POST['from'];
//$to = $_POST['to'];
//$date = $_POST['date'];
//
//$matchList = array();
//$flightRoute = "";
//
//foreach ($flightsData->legs as $route) {
//    if ($route->routeInfo->from->name == $from and $route->routeInfo->to->name == $to) {
//        echo "Route match!" . "<br>";
//        $flightRoute = $route;
//        echo "<pre>";
//        var_dump($flightRoute);
//        if (isset($date)) {
//            foreach ($route->providers as $provider) {
//                $date1 = new DateTime($provider->flightStart);
//                $flightDate = $date1->format("Y-m-d");
//                if ($flightDate == $date) {
//                    echo "Date match!" . "$flightDate" . "<br>";
//                    echo "<pre>";
//                    array_push($matchList, $provider);
//                }
//            }
//        }
//
//    }
//}
//return $matchList;
?>