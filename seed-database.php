<?php

require("db.php");
$db = new DB();
try {
    $callFlightsApi = file_get_contents('https://cosmos-odyssey.azurewebsites.net/api/v1.0/TravelPrices');
    $flightsData = json_decode($callFlightsApi);
    $validUntil = strtotime($flightsData->validUntil);
    $db->insert('price_lists', 'price_list_id, valid_until', [$flightsData->id, $validUntil]);
} catch (Exception $e) {
    echo "ERROR!: " . $e->getMessage() . "\n";
}


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
              price_list_id,
              valid_until',
            [
                $route->id,
                $route->routeInfo->id,
                $route->routeInfo->from->id,
                $route->routeInfo->from->name,
                $route->routeInfo->to->id,
                $route->routeInfo->to->name,
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
