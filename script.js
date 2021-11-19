/*  Table sorting function */

function sortTable(n) {
    var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
    table = document.getElementById("myTable");
    switching = true;
    dir = "asc";
    while (switching) {
        switching = false;
        rows = table.rows;
        /* Loop through all table rows (except the
        first, which contains table headers): */
        for (i = 1; i < (rows.length - 1); i++) {
            shouldSwitch = false;
            /* Get the two elements you want to compare,
            one from current row and one from the next: */
            x = rows[i].getElementsByTagName("TD")[n];
            y = rows[i + 1].getElementsByTagName("TD")[n];
            /* Check if the two rows should switch place,
            based on the direction, asc or desc: */
            if (dir == "asc") {
                if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
                    // If so, mark as a switch and break the loop:
                    shouldSwitch = true;
                    break;
                }
            } else if (dir == "desc") {
                if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
                    // If so, mark as a switch and break the loop:
                    shouldSwitch = true;
                    break;
                }
            }
        }
        if (shouldSwitch) {
            /* If a switch has been marked, make the switch
            and mark that a switch has been done: */
            rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
            switching = true;
            // Each time a switch is done, increase this count by 1:
            switchcount++;
        } else {
            /* If no switching has been done AND the direction is "asc",
            set the direction to "desc" and run the while loop again. */
            if (switchcount == 0 && dir == "asc") {
                dir = "desc";
                switching = true;
            }
        }
    }
}

function timeConverter(time) {
    let gmtTime = new Date(time).toUTCString();
    return gmtTime;
}

function timeToUnix(time) {
    let unixTime = new Date(time).getTime();
    return parseInt(unixTime);
}


function seedDatabase() {
    $(function () {

        $.ajax({
            url: "seed-database.php",
            type: 'GET',
        });
    })
}


function makeReservation(validUntil) {

    $("#reservation-button").on("click", function () {

        let formData = {
            fname: $("#fname").val(),
            lname: $("#lname").val(),
            route: $("#route").val(),
            price: $("#price").val(),
            travel_time: $("#travel-time").val(),
            provider_name: $("#company").val()
        }

        if (validUntil <= new Date().getTime()) {
            alert("Oops your offer is not valid anymore, please reload page and try again!")
        } else {
            $.ajax({
                url: "make-reservation.php",
                type: 'POST',
                data: formData,
            })
        }

    })
}

function submitButton() {
    seedDatabase();
    $('#request-flights-form').on("submit", function (e) {
        e.preventDefault();
        let formData = {
            from: $("#inputGroupSelect01").val(),
            to: $("#inputGroupSelect02").val(),
        };

        $.ajax({
            url: "search-flights.php",
            type: 'POST',
            data: formData,
        }).done(function (data) {
            let offerId = data.price_list_id + "-" + data.route_from + "-" + data.route_to;
            let offerIdSelector = `#${offerId}`;
            let validUntil = timeToUnix(data.valid_until);
            let timer = setInterval(function () {
                let seconds = new Date().getTime();
                let timeLeft = Math.floor((validUntil - seconds) / 1000);
                $("#timer").html('Offer ends in: ' + timeLeft + ' seconds.');
                if (timeLeft <= 0) {
                    clearInterval(timer);
                    $("#timer").html('Offer is EXPIRED!');
                    seedDatabase();
                }
            }, 1000);


            if ($('.offer-table').length == 0) {
                $(".main-content").append(`
                        <div class="container border mt-5 pt-5 pb-5 mb-5 offer-table">
                        <div class="container mt-5 mb-5">
                            <p id="timer"></p>
                        </div>
                        
                        
                             <table class="table table-striped table-hover table-sm" id="myTable">
                                <thead class="table-head" data="${offerId}">
                                    <tr>
                                    <th onclick="sortTable(0)" class="clickableTh">Company</th>
                                    <th onclick="sortTable(1)" class="clickableTh">Price</th>
                                    <th onclick="sortTable(2)" class="clickableTh">Route Length</th>
                                    <th>Departure</th>
                                    <th>Arrival</th>
                                    <th onclick="sortTable(5)" class="clickableTh">Travel Time</th>
                                    <th>Action</th>
                                    </tr>
                                </thead>
                             <tbody id="tableBody"></tbody>
                             </table>
                        <div class="modal fade" id="myModal">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title">Confirm your booking</h4>
                                        <button type="button" class="close"data-dismiss="modal">&times;</button>
                        </div>
                        <div class="modal-body">
                            <form action="#" id="make-reservation" method="POST">
                                <input type="text" class="container-fluid" id="fname" name="fname" 
                                placeholder="Name" required><br><br>
                                <input type="text" id="lname" name="lname" class="container-fluid" 
                                placeholder="Lastname" required><br><br>
                                <input type="hidden" id="route"  value="" >
                                <input type="hidden" id="price"  value="" >
                                <input type="hidden" id="travel-time"  value="" >
                                <input type="hidden" id="company"  value="" >

                            </form> 
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Dismiss</button>
                            <button type="button" class="btn btn-primary" id="reservation-button" data-dismiss="modal">
                            Confirm Reservation
                            </button>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        `);


                for (let i of data.data) {
                    let travelTime = timeToUnix(i.provider_flight_end) - timeToUnix(i.provider_flight_start);
                    let travelStart = timeConverter(i.provider_flight_start);
                    let travelEnd = timeConverter(i.provider_flight_end);
                    let flightId = i.flight_id;
                    $("#tableBody").append(`
                            <tr class="table-row" id="${i.flight_id}">
                            <td class="offer-company">${i.provider_company_name}</td>
                            <td class="price">${i.provider_price}</td>
                            <td class="route-length">${i.route_distance}</td>
                            <td class="route-start">${travelStart}</td>
                            <td class="route-end">${travelEnd}</td>
                            <td class="travel-time">${Math.floor(travelTime) / 1000} Seconds</td>
                            <td class="book-button">
                            <button type="button" class="btn btn-primary book-button" data-toggle="modal"
                                data-target="#myModal">Book Now
                            </button>
                            </td>
                            </tr>`);
                }

                $(".book-button").on("click", function () {
                    let flightId = $(this).parents('.table-row').attr("id");
                    for (i of data.data) {
                        if (i.flight_id == flightId) {
                            let travelTime = timeToUnix(i.provider_flight_end) - timeToUnix(i.provider_flight_start)
                            $("#route").val(i.from_name + "-" + i.to_name);
                            $("#price").val(i.provider_price);
                            $("#travel-time").val(travelTime);
                            $("#company").val(i.provider_company_name);

                        }
                    }
                })
                makeReservation(validUntil);
            } else {

                if ($(".table-head").attr("data") != offerId) {
                    $("#myTable").empty();
                    $("#myTable").append(`
                                <thead class="table-head" data="${offerId}">
                                    <tr>
                                    <th onclick="sortTable(0)" class="clickableTh">Company</th>
                                    <th onclick="sortTable(1)" class="clickableTh">Price</th>
                                    <th onclick="sortTable(2)" class="clickableTh">Route Length</th>
                                    <th>Departure</th>
                                    <th>Arrival</th>
                                    <th onclick="sortTable(5)" class="clickableTh">Travel Time</th>
                                    <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody id="tableBody"></tbody>
                                            `);


                    for (let i of data.data) {

                        let travelTime = timeToUnix(i.provider_flight_end) - timeToUnix(i.provider_flight_start);
                        let travelStart = timeConverter(i.provider_flight_start);
                        let travelEnd = timeConverter(i.provider_flight_end);
                        $("#tableBody").append(`
                                <tr class="table-row" id="${i.flight_id}">
                            <td class="offer-company">${i.provider_company_name}</td>
                            <td class="price">${i.provider_price}</td>
                            <td class="route-length">${i.route_distance}</td>
                            <td class="route-start">${travelStart}</td>
                            <td class="route-end">${travelEnd}</td>
                            <td class="travel-time">${Math.floor(travelTime) / 1000} Seconds</td>
                            <td class="book-button">
                            <button type="button" class="btn btn-primary book-button" data-toggle="modal"
                                data-target="#myModal">Book Now
                            </button>
                                    </td>
                                </tr>`);
                    }
                    $(".book-button").on("click", function () {
                        let flightId = $(this).parents('.table-row').attr("id");
                        for (i of data.data) {
                            if (i.flight_id == flightId) {
                                let travelTime = timeToUnix(i.provider_flight_end) - timeToUnix(i.provider_flight_start)
                                $("#route").val(i.from_name + "-" + i.to_name);
                                $("#price").val(i.provider_price);
                                $("#travel-time").val(travelTime);
                                $("#company").val(i.provider_company_name);

                            }
                        }
                    })
                }
            }
        }).fail(function () {
            alert('Sorry! No flights available for this route! Try again later.')
        })
    })
}

submitButton();
