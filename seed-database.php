<?php

require 'db.php';
$db = new DB();


$url = "https://cosmos-odyssey.azurewebsites.net/api/v1.0/TravelPrices";

$ch = curl_init();
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_URL, $url);
$response = curl_exec($ch);

$flightsData = json_decode($response);
$validUntil = $flightsData->validUntil;


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
                $flightStart = $provider->flightStart;
                $flightEnd = $provider->flightEnd;
                $db->insert(
                    "providers",
                    "flight_id,
                    company_id,
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

    /* --- Check how many pricelists are in DB, if more thant 15 then delete oldest list.
    Adding TRIGGER to DB doesnt work because we are not allowed to do same table updates where trigger is registered.
    General error: 1442 Can't update table 'price_lists' in stored function/trigger because it is already used by
    statement which invoked this stored function/trigger --------- */


    $sql = "SELECT * FROM price_lists";
    $result = $db->conn->query($sql)->fetchAll();
    if (count($result) >= 16) {
        $sql = "DELETE FROM price_lists WHERE reg_date IS NOT NULL order by reg_date asc LIMIT 1";
        $db->conn->query($sql)->execute();
    }
}


die();


