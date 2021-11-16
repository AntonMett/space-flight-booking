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

function searchFlight() {
    $(function () {

        $.ajax({
            url: "seed-database.php",
            type: 'GET',
        });
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
                let priceListId = data["price_list_id"]
                let priceListIdSelector = `#${priceListId}`;
                let validUntil = parseInt(data["valid_until"]);
                if ($(priceListIdSelector).length == 0) {

                    $(".main-content").append(
                        `<div class="container mt-5 mb-5">
                            <p id="timer"></p>
                        </div>

                        <div class="container border mt-5 pt-5 pb-5 mb-5" id="${priceListId}">
                             <table class="table table-striped table-hover table-sm" id="myTable">
                                <thead>
                                    <tr>
                                    <th onclick="sortTable(0)" class="clickableTh">Company</th>
                                    <th onclick="sortTable(1)" class="clickableTh">Price</th>
                                    <th onclick="sortTable(2)" class="clickableTh">Route Length</th>
                                    <th onclick="sortTable(3)" class="clickableTh">Travel Time</th>
                                    <th ">Action</th>
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
                            <div id="datepicker" class="container pt-3 d-flex justify-content-center"></div>
                            <input type="hidden" id="my_hidden_input">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Dismiss</button>
                            <button type="button" class="btn btn-primary" data-dismiss="modal" id="savechangesbutton">
                            Confirm Reservation
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>`)


                    setInterval(function () {
                        let seconds = Math.floor(new Date().getTime() / 1000);
                        let timeLeft = validUntil - seconds;
                        $("#timer").html('Offer ends in: ' + timeLeft + ' seconds.');
                        if (timeLeft <= 0) {
                            clearInterval(this);
                            $("#timer").html('Offer is EXPIRED!');
                        }
                    }, 1000);
                    for (let i of data["data"]) {
                        let travelTime = parseInt(i.provider_flight_end, 10) - parseInt(i.provider_flight_start, 10);
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
                }
            }).fail(function () {
                alert('Sorry! No flights available for this route! Try again later.')
            })
        })
    });
}

searchFlight();