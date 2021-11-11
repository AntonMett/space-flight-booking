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
    <div class="container text-center"><h1>Welcome traveler!</h1>
        <h2>Let the journey begin!</h2>
    </div>
</header>
<main>
    <form action="seed-database.php" id="request-flights-form" method="POST">
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
    <div class="offer-list container">
        <ul class="list-group">
            <div class="row container">
                <li class="list-group-item col-sm-8">Cras justo odio</li><button class="btn btn-primary">HELLO</button>
            </div>

            <li class="list-group-item">Dapibus ac facilisis in</li>
            <li class="list-group-item">Morbi leo risus</li>
            <li class="list-group-item">Porta ac consectetur ac</li>
            <li class="list-group-item">Vestibulum at eros</li>
        </ul>
    </div>
</main>
<!--<script type="text/javascript">-->
<!--    $('#request-flights-form').submit(function (e) {-->
<!--        e.preventDefault();-->
<!--        let formData = {-->
<!--            from: $("#inputGroupSelect01").val(),-->
<!--            to: $("#inputGroupSelect02").val(),-->
<!--            date: $("#datepicker").val(),-->
<!--        };-->
<!---->
<!--        $.ajax({-->
<!--            url: "seed-database.php",-->
<!--            type: 'POST',-->
<!--            data: formData,-->
<!--        })-->
<!--    })-->
<!--</script>-->
</body>
</html>
