<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Place Order</title>

    <!-- favicon -->
    <link rel="shortcut icon" href="images/logo.svg" type="image/x-icon">

    <!-- bootstrap css -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-CuOF+2SnTUfTwSZjCXf01h7uYhfOBuxIhGKPbfEJ3+FqH/s6cIFN9bGr1HmAg4fQ" crossorigin="anonymous">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="Styles/navbar.css">
    <link rel="stylesheet" href="Styles/place_order.css">

    <!-- font -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap" rel="stylesheet">

</head>

<body>
    <div class="container-fluid h-100 d-flex flex-column">

        <!-- navigation bar -->
        <nav class="navbar navbar-expand-lg navbar-light cc-navbar p-0">
            <div class="container-fluid pl-2">
                <a class="navbar-brand cc-nav-logo" href="/">TailorMan</a>
                <button class="navbar-toggler p-0" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="cc-menu">
                        <img src="images/menu.svg" alt="" width="30px" id="menu" onclick="change()">
                    </span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ml-auto text-right p-0 font-weigth-bolder">
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="/">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="place_order.php">Place Order</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="track_order.php">Track Order</a>
                        </li>
                        <?php
                        session_start();
                        if (isset($_SESSION["Logged In"]) && $_SESSION["Logged In"] == true)
                            echo '<li class="nav-item">
                     <a class="nav-link" href="login.php">' . $_SESSION['User Name'] . '</a>
                     </li>';
                        else
                            echo '<li class="nav-item">
                     <a class="nav-link" href="login.php">Login</a>
                     </li>';
                        ?>
                </div>
            </div>
        </nav>
        <?php
        if (!(isset($_SESSION["Logged In"]) && $_SESSION["Logged In"] == true)) {
            echo '
            <div class=" container-flex col flex-grow-1 p-2 justify-content-center align-items-center mt-3">
                <h3 class="fw-normal">You have not Logged-in. Please Login to Place your Order</h3>
                
                <div><a href="/login.php"><button type="button" class="my-1 btn btn-primary rounded-pill px-3 py-1">Login</button></a>
                </div>
            </div>            
            ';
        }
        ?>



        <!-- bootstrap js bundle -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-popRpmFF9JQgExhfw5tZT4I9/CI5e2QcuUZPOVXb1m7qUmeR2b50u+YFEYe1wgzy" crossorigin="anonymous"></script>
        <script src="Script/nav.js"></script>
</body>

</html>