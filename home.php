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
            src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"
            integrity="sha512-T/tUfKSV1bihCnd+MxKD0Hm1uBBroVYBOYSk1knyvQ9VyZJpc/ALb4P0r6ubwVPSGB2GvjeoMAJJImBG12TiaQ=="
            crossorigin="anonymous" referrerpolicy="no-referrer">
    </script>
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css"
          integrity="sha512-mSYUmp1HYZDFaVKK//63EcZq4iFWFjxSL+Z3T/aCt4IO9Cejm03q3NKKYN6pFQzY0SBOr8h+eCIAZHPXcpZaNw=="
          crossorigin="anonymous" referrerpolicy="no-referrer"/>
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
    <form action="seed-database.php" method="POST">
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
                <select class="custom-select" id="inputGroupSelect01" name="to">
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

                <input placeholder="Flight Date" type="date" id="datepicker" name="date">
                <button class="btn btn-primary ml-3">Search</button>
            </div>
        </div>
    </form>
</main>
</body>
</html>