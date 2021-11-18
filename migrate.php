<?php

/* ------------- Run this file to migrate tables to fresh db ---------- */

require 'db.php';
$db = new DB();

try {
    $db->createTable(
        "price_lists",
        "price_list_id VARCHAR(200) NOT NULL PRIMARY KEY,
          valid_until VARCHAR(40) NOT NULL,
          reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
  ");

    $db->createTable(
        "routes",
        "route_id VARCHAR(200) PRIMARY KEY,
          route_info_id VARCHAR(200),
          from_id VARCHAR(200),
          from_name VARCHAR(40),
          to_id VARCHAR(200),
          to_name VARCHAR(40),
          route_distance INT,
          price_list_id VARCHAR(200),   
          valid_until VARCHAR(40) NOT NULL,
          FOREIGN KEY (price_list_id) REFERENCES price_lists(price_list_id) ON DELETE CASCADE
          ");

    $db->createTable(
        "providers",
        "flight_id VARCHAR(200) PRIMARY KEY,
          company_id VARCHAR(200),
          provider_company_name VARCHAR(100),
          provider_price FLOAT,
          provider_flight_start VARCHAR(40) NOT NULL,
          provider_flight_end VARCHAR(40) NOT NULL,
          route_id VARCHAR(200),
          FOREIGN KEY (route_id) REFERENCES routes(route_id) ON DELETE CASCADE
          ");


    $db->createTable(
        "reservations",
        "reservation_id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        first_name VARCHAR(100),
        last_name VARCHAR(100),
        total_price FLOAT,
        total_travel_time INT,
        reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        ");

    $db->createTable(
        "reservation_routes",
        "flight_from VARCHAR(40),
        flight_to VARCHAR(40),
        provider VARCHAR(100),
        reservation_id INT UNSIGNED,
        FOREIGN KEY (reservation_id) REFERENCES reservations (reservation_id) ON DELETE CASCADE
        ");

    echo "MIGRATION DONE!";
} catch (Exception $exception) {
    echo "ERROR WHILE MIGRATING: " . $exception->getMessage(), "\n";
}
