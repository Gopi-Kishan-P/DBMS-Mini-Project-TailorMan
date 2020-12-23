<?php
include "config.php";
$Message = "";
if ($conn == true) {
   if ($_SERVER["REQUEST_METHOD"] == "POST") {
      if (array_key_exists("log-phno", $_POST)) {
         $log_phno = mysqli_real_escape_string($conn, $_POST["log-phno"]);
         $log_passwd = mysqli_real_escape_string($conn, $_POST["log-passwd"]);
         login($conn, $log_phno, $log_passwd);
      } else if (array_key_exists("reg-username-inp", $_POST)) {
         $num = 1;
         $username = mysqli_real_escape_string($conn, $_POST["reg-username-inp"]);
         $phno = mysqli_real_escape_string($conn, $_POST["reg-phno"]);
         $sql = "Select * from Customer where Cust_Phno = $phno";
         $result = mysqli_query($conn, $sql);
         if (empty($result)) $num = 0;
         else    $num = mysqli_num_rows($result);
         if ($num == 0) {
            $password = mysqli_real_escape_string($conn, $_POST["reg-passwd"]);
            $hashedpwd = password_hash($password, PASSWORD_DEFAULT);
            $sql = "INSERT INTO `customer` (`Cust_Name`, `Cust_Phno`, `Cust_Password`) VALUES ('$username', '$phno', '$hashedpwd')";

            mysqli_query($conn, $sql);

            login($conn, $phno, $password);
         } else {
            $Message = "User already exits, Please try login";
         }
      }
   }
}
function login($conn, $phno, $passwd)
{
   global $Message;
   $sql = "Select * from Customer where Cust_Phno = $phno";
   $result = mysqli_query($conn, $sql);
   $num = mysqli_num_rows($result);
   if ($num == 1) {
      while ($row = mysqli_fetch_assoc($result)) {
         if (password_verify($passwd, $row['Cust_Password'])) {
            session_start();
            $_SESSION['Logged In'] = true;
            $_SESSION['User Name'] = $row['Cust_Name'];
            // $username = $row['Cust_Name'];
            // $Message = "Logged in Successfully";
         } else $Message = "Password Incorrect, Try Again";
      }
   } else $Message = "Invalid Phone and Password, <br>Register if you are a new Customer";
}
?>

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
   <!-- <link rel="stylesheet" href="Styles/login.css"> -->
   <link rel="stylesheet" href="Styles/log-reg.css">

   <!-- font -->
   <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap" rel="stylesheet">


</head>

<body >
   <div class="container-fluid h-100 d-flex flex-column">

      <!-- navigation bar -->
      <nav class="navbar navbar-expand-lg navbar-light cc-navbar p-0">
         <div class="container-fluid">
            <a class="navbar-brand cc-nav-logo" href="index.php">TailorMan</a>
            <button class="navbar-toggler p-0" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
               <span class="cc-menu">
                  <img src="images/menu.svg" alt="" width="30px" id="menu" onclick="change()">
               </span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
               <ul class="navbar-nav ml-auto text-right p-0 font-weigth-bolder">
                  <li class="nav-item">
                     <a class="nav-link" aria-current="page" href="index.php">Home</a>
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
                           <a class="nav-link active" href="login.php">' . $_SESSION['User Name'] . '</a>
                           </li>';
                  else
                     echo '<li class="nav-item">
                           <a class="nav-link active" href="login.php">Login</a>
                           </li>';
                  ?>
            </div>
         </div>
      </nav>

      <!-- Login / Register -->
      
         <?php
         session_start();
         if (isset($_SESSION["Logged In"]) && $_SESSION["Logged In"] == true){
            echo '<div class="col flex-grow-1 p-2 justify-content-center align-items-center my-3"><h2>Logged in as '. $_SESSION['User Name']. "</h2>";
            echo '<div><button type="button" id="return-to-home" class="my-1 btn btn-primary rounded-pill p-1 cc-rth" onclick="redirect()">Return to Home Page</button></div>
            <div><a href="/logout.php"><button type="button" class="my-1 btn btn-primary-outline rounded-pill p-1 cc-logout">Logout</button></a>
            </div>';
         }
         else
            echo '<div class="row flex-grow-1 p-2 justify-content-center align-items-center">
         <div class="col-lg-4 col-md-6 col-sm-8 col-sm-10 cc-lc-form my-3 cc-lc-main">
            <div class="cc-lc-head d-flex rounded-pill my-5">
               <div class="flex-grow-1 text-center rounded-pill cc-lc">
                  <h4 class="m-0 p-1 rounded-pill cc-lc-active" id="loginHead" onclick="loginClicked()">Login</h4>
               </div>
               <div class="flex-grow-1 text-center rounded-pill cc-lc">
                  <h4 class="m-0 p-1 rounded-pill" id="createHead" onclick="registerClicked()">Register</h4>
               </div>
            </div>
            <form action="/login.php" method="POST" class="my-5 cc-login-form" id="log-form">
               <!-- Login Contents -->
               <div class="cc-login-contents">
                  <div class="cc-phno my-4 d-flex">
                     <label for="phno" class="mr-3">
                        <img src="images/phone.svg" width="18px" alt="">
                     </label>
                     <input type="tel" maxlength="15" name="log-phno" id="log-phno" class="text-center flex-grow-1 rounded-pill px-2 fw-bold cc-lc-inp" placeholder="Phone Number" required>
                  </div>
                  <div class="cc-passwd my-4 d-flex">
                     <label for="phno" class="form-label mr-3">
                        <img src="images/key.svg" width="18px" alt="">
                     </label>
                     <input type="password" name="log-passwd" maxlength="20" id="log-passwd" class="text-center flex-grow-1 rounded-pill fw-bold px-2 cc-lc-inp" placeholder="Password" required>
                  </div>
               </div>

               <div class="d-flex flex-column mt-4 cc-sub-res">
                  <button type="submit" id="lof-btn" class="my-1 btn btn-primary rounded-pill p-1 cc-submit m-auto" onclick="login">Login</button>
                  <button type="reset" class="my-1 btn btn-primary-outline rounded-pill p-1 cc-reset m-auto">Reset</button>
               </div>
            </form>

            <!-- Register Contents -->
            <form action="/login.php" method="POST" class="my-5 cc-register-form d-none" id="reg-form">
               <div class="cc-register-contents">
                  <div id="username" class="cc-name my-4 d-flex">
                     <label for="username-inp" class="mr-3">
                        <img src="images/user.svg" width="18px" alt="">
                     </label>
                     <input type="tel" name="reg-username-inp" id="reg-username-inp" class="text-center flex-grow-1 rounded-pill px-2 fw-bold cc-lc-inp" placeholder="Name">
                  </div>
                  <div class="cc-phno my-4 d-flex">
                     <label for="phno" class="mr-3">
                        <img src="images/phone.svg" width="18px" alt="">
                     </label>
                     <input type="tel" name="reg-phno" id="reg-phno" class="text-center flex-grow-1 rounded-pill px-2 fw-bold cc-lc-inp" placeholder="Phone Number" required>
                  </div>
                  <div class="cc-passwd my-4 d-flex">
                     <label for="phno" class="form-label mr-3">
                        <img src="images/key.svg" width="18px" alt="">
                     </label>
                     <input type="password" name="reg-passwd" id="reg-passwd" class="text-center flex-grow-1 rounded-pill fw-bold px-2 cc-lc-inp" placeholder="Password" required>
                  </div>
                  <div class="d-flex flex-column mt-4 cc-sub-res">
                     <button type="submit" id="reg-btn" class="my-1 btn btn-primary rounded-pill p-1 cc-submit m-auto" onclick="login">Register</button>
                     <button type="reset" class="my-1 btn btn-primary-outline rounded-pill p-1 cc-reset m-auto">Reset</button>
                  </div>
               </div>
            </form>';
            ?>
            <?php
            if (!empty($Message))
               echo '<div id="lr-status" class="bg-warning px-3 py-1 text-center rounded-pill">' . $Message . '</div>';
            ?>
            <div class="container-fluid">
               <div class="row">
                  <div class="col-lg bg-success">Lorem ipsum dolor sit amet consectetur adipisicing elit. Eveniet veritatis, repellendus in, impedit sed iste a at soluta, excepturi molestias fuga. Enim veniam nisi expedita dolorum ratione exercitationem consectetur assumenda.</div>
                  <div class="col-lg bg-danger flex-grow-1">Lorem ipsum dolor sit amet consectetur adipisicing elit. Placeat suscipit dolor ab quasi consequatur itaque quis enim totam, incidunt voluptatibus tempore accusamus eligendi obcaecati velit neque exercitationem repellendus voluptate et.</div>
               </div>
            </div>
         </div>
      </div>
   </div>
   <!-- bootstrap js bundle -->
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-popRpmFF9JQgExhfw5tZT4I9/CI5e2QcuUZPOVXb1m7qUmeR2b50u+YFEYe1wgzy" crossorigin="anonymous"></script>

   

   <script src="Script/log_reg.js"></script>
   <script src="Script/nav.js"></script>

</body>

</html>