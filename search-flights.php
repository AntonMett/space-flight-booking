<?php
echo '<pre>';
$from = $_POST["from"];
$to = $_POST["to"];

$sql = "SELECT 
       routes.from_name,
       routes.to_name,
       providers.provider_company_name,
       providers.provider_price,
       providers.provider_flight_start,
       providers.provider_flight_end
       FROM routes
       INNER JOIN price_lists ON price_lists.valid_until='$validUntil' AND 
                                 price_lists.price_list_id = routes.price_list_id AND
                                 routes.from_name='$from' AND
                                 routes.to_name='$to'
       INNER JOIN providers ON providers.route_id = routes.route_id  
";

$results = $db->conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);
var_dump($results);

