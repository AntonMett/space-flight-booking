<?php
require 'db.php';
$db = new DB();

try {
    $callFlightsApi = file_get_contents('https://cosmos-odyssey.azurewebsites.net/api/v1.0/TravelPrices');
    $flightsData = json_decode($callFlightsApi);
    $validUntil = strtotime($flightsData->validUntil);
} catch (Exception $exception) {
    echo "ERROR!: " . $exception->getMessage() . "\n";
}

$from = $_POST["from"];
$to = $_POST["to"];

$sql = "SELECT 
       price_lists.valid_until,
       routes.from_name,
       routes.to_name,
       providers.provider_company_name,
       providers.provider_price,
       providers.provider_flight_start,
       providers.provider_flight_end,
       routes.route_distance
       FROM routes
       INNER JOIN price_lists ON price_lists.valid_until='$validUntil' AND 
                                 price_lists.price_list_id = routes.price_list_id AND
                                 routes.from_name='$from' AND
                                 routes.to_name='$to'
       INNER JOIN providers ON providers.route_id = routes.route_id  ";

$results = $db->conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);

if ($results) {
    header('Content-Type: application/json');
    $json_string = json_encode($results);
    echo $json_string;
}



