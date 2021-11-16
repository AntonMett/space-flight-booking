<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SpaceScanner</title>
    <script src="https://code.jquery.com/jquery-3.6.0.js"
            integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk="
            crossorigin="anonymous">
    </script>
    <script
            src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.min.js"
            integrity="sha384-+YQ4JLhjyBLPDQt//I+STsc9iw4uQqACwlvpslubQzn4u2UU2UFM80nGisd026JF"
            crossorigin="anonymous">
    </script>
    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css"
          integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l"
          crossorigin="anonymous">
</head>
<body>
<header>
    <div class="container-fluid text-center " style="background-image:
     url('space.jpg');
     background-size: cover;
     background-position: bottom;
     min-height: 50vh;

"><h1>Welcome traveler!</h1>
        <h2>Let the journey begin!</h2>
    </div>
</header>
<main>
    <form action="search-flights.php" id="request-flights-form" method="POST">
        <div class="container" id="search">
            <div class="input-group">
                <select class="custom-select" id="inputGroupSelect01" name="from">
                    <option selected>From</option>
                    <option value="Mercury">Mercury</option>
                    <option value="Venus">Venus</option>
                    <option value="Earth">Earth</option>
                    <option value="Mars">Mars</option>
                    <option value="Jupiter">Jupiter</option>
                    <option value="Saturn">Saturn</option>
                    <option value="Uranus">Uranus</option>
                    <option value="Neptune">Neptune</option>
                </select>
                <select class="custom-select" id="inputGroupSelect02" name="to">
                    <option selected>To</option>
                    <option value="Mercury">Mercury</option>
                    <option value="Venus">Venus</option>
                    <option value="Earth">Earth</option>
                    <option value="Mars">Mars</option>
                    <option value="Jupiter">Jupiter</option>
                    <option value="Saturn">Saturn</option>
                    <option value="Uranus">Uranus</option>
                    <option value="Neptune">Neptune</option>
                </select>

                <button class="btn btn-primary ml-3" id="request-pricelist-btn">Search</button>
            </div>
        </div>
    </form>
</main>
<script type="text/javascript">
    $(function () {
        console.log("ready!");
        $.ajax({
            url: "seed-database.php",
            type: 'GET',
        }).done(function () {
            console.log('database seeded')
        });
        console.log('i am already here!');
        $('#request-flights-form').on("submit", function (e) {
            e.preventDefault();
            let formData = {
                from: $("#inputGroupSelect01").val(),
                to: $("#inputGroupSelect02").val(),
                date: $("#datepicker").val(),
            };

            $.ajax({
                url: "search-flights.php",
                type: 'POST',
                data: formData,
            }).done(function (data) {
                $("main").append(`<div class="container pt-3 border" id="flights-result">

        <table class="table table-striped table-hover table-sm" id="table">
            <thead>
            <tr>
                <th>Company</th>
                <th>Price</th>
                <th>Route Length</th>
                <th>Travel Time</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody id="tableBody">

            </tbody>
        </table>
        <div class="modal fade" id="myModal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Confirm your booking</h4>
                        <button type="button" class="close"
                                data-dismiss="modal">&times;
                        </button>
                    </div>
                    <div class="modal-body">
                        <div id="datepicker" class="container pt-3 d-flex justify-content-center"></div>
                        <input type="hidden" id="my_hidden_input">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger"
                                data-dismiss="modal">Dismiss
                        </button>
                        <button type="button" class="btn btn-primary" data-dismiss="modal"
                                id="savechangesbutton">Confirm Reservation
                        </button>
                    </div>

                </div>
            </div>
        </div>
    </div>`)
                for (let i of data) {
                    let travelTime = parseInt(i.provider_flight_end, 10) - parseInt(i.provider_flight_start, 10);
                    console.log(travelTime);
                    $("#tableBody").append(`<tr><td class="offer">${i.provider_company_name}</td>
                    <td class="price">${i.provider_price}</td>
                    <td class="route-length">${i.route_distance}</td>
                    <td class="travel-time">${travelTime} Seconds</td>
                    <td class="book-button">
                        <button onclick="resetCalendar(), selectDateIndex(this)" type="button" data-toggle="modal"
                                data-target="#myModal">Book Now
                        </button>
                    </td>
                </tr>`);
                }
            }).fail(function () {
                alert('Sorry! No flights awailable for this route!')
            })
        })
    });

</script>
</body>
</html>
<?php

include 'seed-database.php'

?>