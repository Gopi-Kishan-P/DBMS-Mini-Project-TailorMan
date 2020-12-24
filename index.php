<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>TailorMan</title>

   <!-- favicon -->
   <link rel="shortcut icon" href="images/logo.svg" type="image/x-icon">

   <!-- bootstrap css -->
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-CuOF+2SnTUfTwSZjCXf01h7uYhfOBuxIhGKPbfEJ3+FqH/s6cIFN9bGr1HmAg4fQ" crossorigin="anonymous">

   <!-- Custom CSS -->
   <link rel="stylesheet" href="Styles/navbar.css">
   <link rel="stylesheet" href="Styles/home.css">

   <!-- font -->
   <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap" rel="stylesheet">


</head>

<body>
   <div class="container-fluid h-100 d-flex flex-column">
      <div class="cc-white-bg"></div>
      <!-- navigation bar -->
      <nav class="navbar navbar-expand-lg navbar-light cc-navbar p-0">
         <div class="container-fluid">
            <a class="navbar-brand cc-nav-logo" href="/">TailorMan</a>
            <button class="navbar-toggler p-0" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
               <span class="cc-menu">
                  <img src="images/menu.svg" alt="" width="30px" id="menu" onclick="change()">
               </span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
               <ul class="navbar-nav ml-auto text-right p-0 font-weigth-bolder">
                  <li class="nav-item">
                     <a class="nav-link active" aria-current="page" href="/">Home</a>
                  </li>
                  <!-- <li class="nav-item">
                     <a class="nav-link" href="#">Catalog</a>
                  </li> -->
                  <li class="nav-item">
                     <a class="nav-link" href="#">Place Order</a>
                  </li>
                  <li class="nav-item">
                     <a class="nav-link" href="#">Track Order</a>
                  </li>

                  <?php
                  session_start();
                  if (isset($_SESSION["Logged In"]) && $_SESSION["Logged In"] == true)
                     echo '<li class="nav-item">
                           <a class="nav-link" href="login.php">'.$_SESSION['User Name'].'</a>
                           </li>';
                  else
                     echo '<li class="nav-item">
                           <a class="nav-link" href="login.php">Login</a>
                           </li>';
                  ?>
            </div>
         </div>
      </nav>

      <!-- Main Container -->
      <div class="row flex-grow-1">
         <div class="col-lg cc-illus d-flex justify-content-center align-items-center">
            <img src="images/logo.svg" alt="Logo" class="img-fluid cc-ill-img m-4">
         </div>
         <div class="col-lg d-flex justify-content-center align-items-center flex-column">
            <div class="cc-contents">
               <h1 class="cc-main-head">Tailor <br> Management</h1>
               <p class="cc-main-p">One Stop Solution To PLACE and TRACK Your ORDER</p>
               <div class="cc-buttons">
                  <button class="btn btn-primary cc-place-order-btn">Place Order</button>
                  <br>
                  <button class="btn btn-primary-outline cc-track-order-btn ">Track Order</button>
               </div>
            </div>
         </div>
      </div>
   </div>

   <!-- bootstrap js bundle -->
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-popRpmFF9JQgExhfw5tZT4I9/CI5e2QcuUZPOVXb1m7qUmeR2b50u+YFEYe1wgzy" crossorigin="anonymous"></script>

   <script src="Script/nav.js"></script>
</body>

</html>