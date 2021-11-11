<?php

require 'db.php';
$db=new DB();

try {
    $callFlightsApi = file_get_contents('https://cosmos-odyssey.azurewebsites.net/api/v1.0/TravelPrices');
    $flightsData = json_decode($callFlightsApi);
    $validUntil = strtotime($flightsData->validUntil);
} catch (Exception $exception) {
    echo "ERROR!: " . $exception->getMessage() . "\n";
}

/* ----------- CHECK IF valid price list is present in database, IF not then seed new data-------*/

$sql = "SELECT * FROM price_lists WHERE valid_until='$validUntil'";
$result = $db->conn->query($sql)->fetchAll();
if (count($result) == 0) {
    $db->insert('price_lists', 'price_list_id, valid_until', [$flightsData->id, $validUntil]);
    if (!empty($flightsData->legs)) {
        foreach ($flightsData->legs as $route) {
            $db->insert(
                'routes',
                'route_id,
                route_info_id,
                from_id,
                from_name,
                to_id,
                to_name,
                route_distance,
                price_list_id,
                valid_until',
                [
                    $route->id,
                    $route->routeInfo->id,
                    $route->routeInfo->from->id,
                    $route->routeInfo->from->name,
                    $route->routeInfo->to->id,
                    $route->routeInfo->to->name,
                    $route->routeInfo->distance,
                    $flightsData->id,
                    $validUntil
                ]);
            foreach ($route->providers as $provider) {
                $flightStart = strtotime($provider->flightStart);
                $flightEnd = strtotime($provider->flightEnd);
                $db->insert(
                    "providers",
                    "provider_id,
                    provider_company_id,
                    provider_company_name,
                    provider_price,
                    provider_flight_start,
                    provider_flight_end,
                    route_id",
                    [
                        $provider->id,
                        $provider->company->id,
                        $provider->company->name,
                        $provider->price,
                        $flightStart,
                        $flightEnd,
                        $route->id
                    ]
                );
            }

        }

    }
}
require 'search-flights.php';
