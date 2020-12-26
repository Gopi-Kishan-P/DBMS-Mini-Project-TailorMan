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
            // Inserting into CUSTOMER Table
            $sql = "INSERT INTO `customer` (`Cust_Name`, `Cust_Phno`, `Cust_Password`) VALUES ('$username', '$phno', '$hashedpwd')";
            mysqli_query($conn, $sql);

            login($conn, $phno, $password);
            // Inserting into MEASUREMENT Table
            if ($_SESSION['Logged In']) {
               $Cust_Id = $_SESSION['Cust_Id'];
               $sql = "INSERT INTO `Measurement` (`Cust_ID`) VALUES ($Cust_Id)";
               mysqli_query($conn, $sql);
            }
         } else {
            $Message = "User already exits, Please try login";
         }
      }
      session_start();
      $Cust_ID = $_SESSION['Cust_Id'];
      updateMeasurement($conn, $Cust_ID, "shirt-length", "Shirt Length");
      updateMeasurement($conn, $Cust_ID, "collar", "Collar");
      updateMeasurement($conn, $Cust_ID, "shoulder", "Shoulder");
      updateMeasurement($conn, $Cust_ID, "chest", "Chest");
      updateMeasurement($conn, $Cust_ID, "sleeves", "Sleeves");
      updateMeasurement($conn, $Cust_ID, "waist", "Waist");
      updateMeasurement($conn, $Cust_ID, "pant-length", "Pant Length");
      updateMeasurement($conn, $Cust_ID, "hip", "Hip");
      updateMeasurement($conn, $Cust_ID, "fork-round", "Fork Round");
      updateMeasurement($conn, $Cust_ID, "thigh", "Thigh");
      updateMeasurement($conn, $Cust_ID, "knee", "Knee");
      updateMeasurement($conn, $Cust_ID, "bottom", "Bottom");
   }
}

function updateMeasurement($conn, $Cust_ID, $meas_key, $meas_Name)
{
   if (array_key_exists($meas_key, $_POST)) {
      if (strlen($_POST[$meas_key]) == 0)
         $meas_value = "NULL";
      else
         $meas_value = $_POST[$meas_key];
      // echo " * ".$meas_value. " * ";
      // echo $Cust_ID;
      // echo "<br>"; 
      $sql = "UPDATE `Measurement` set `$meas_Name` = $meas_value where `Cust_ID` = $Cust_ID";
      mysqli_query($conn, $sql);
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
            $_SESSION['Cust_Id'] = $row['Cust_ID'];
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
   <link rel="stylesheet" href="Styles/log_reg.css">

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
                  <!-- <li class="nav-item">
                     <a class="nav-link" href="#">Catalog</a>
                  </li> -->
                  <li class="nav-item">
                     <a class="nav-link" href="place_order.php">Place Order</a>
                  </li>
                  <li class="nav-item">
                     <a class="nav-link" href="track_order.php">Track Order</a>
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


      <?php
      session_start();

      function displayMeasVal($conn, $column,  $Cust_ID)
      {
         $sql = "Select `$column` from Measurement where Cust_Id = $Cust_ID";
         while ($row = mysqli_fetch_assoc(mysqli_query($conn, $sql))) {
            return $row[$column];
         }
      }

      if (isset($_SESSION["Logged In"]) && $_SESSION["Logged In"] == true) {
         
         $shirt_length_val = displayMeasVal($conn, "Shirt Length", $Cust_ID);
         $collar_val = displayMeasVal($conn, "Collar", $Cust_ID);
         $pant_length_val = displayMeasVal($conn, "Pant Length", $Cust_ID);

         echo '<div class=" container-flex col flex-grow-1 p-2 justify-content-center align-items-center mt-3"><h3 class = "fw-normal">Logged in as <span class = "fw-bolder" >' . $_SESSION['User Name'] . "</span></h3>";
         echo '<div class="mt-4"><button type="button" id="return-to-home" class="my-1 btn btn-primary rounded-pill p-1 cc-rth" onclick="redirect()">Return to Home Page</button></div>
            <div><a href="/logout.php"><button type="button" class="my-1 btn btn-primary-outline rounded-pill p-1 cc-logout">Logout</button></a>
            </div>';

         echo '
            
            <div class="container-fluid flex-grow-1 my-4">
               <hr>
               <h2 class="text-center ">Measurement</h2>
               <form action="/login.php" method="POST">
                  <div class="row">
                     <div class="col-lg">
                        <!-- <h5 class="text-center">Upper Body</h5> -->
                        <div class="p-1 d-flex justify-content-evenly align-items-end">
                           <label for="shirt-length" class="text-right cc-mes-label">Shirt Length :</label>
                           <div class="cc-w-50 text-left">
                              <input type="number" name="shirt-length" id="shirt-length" class="text-center ml-3 cc-mes-inp" min="0"
                                 max="99" step="0.1" value='.displayMeasVal($conn, "Shirt Length", $Cust_ID).'>
                           </div>
                        </div>
                        <div class="p-1 d-flex justify-content-evenly align-items-end">
                           <label for="shirt-length" class="text-right cc-mes-label">Collar :</label>
                           <div class="cc-w-50 text-left">
                              <input type="number" name="collar" id="collar" class="text-center ml-3 cc-mes-inp" min="0" max="99"
                                 step="0.1" value='.displayMeasVal($conn, "Collar", $Cust_ID).'>
                           </div>
                        </div>
                        <div class="p-1 d-flex justify-content-evenly align-items-end">
                           <label for="shirt-length" class="text-right cc-mes-label">Shoulder :</label>
                           <div class="cc-w-50 text-left">
                              <input type="number" name="shoulder" id="shoulder" class="text-center ml-3 cc-mes-inp" min="0" max="99"
                                 step="0.1" value='.displayMeasVal($conn, "Shoulder", $Cust_ID).'>
                           </div>
                        </div>
                        <div class="p-1 d-flex justify-content-evenly align-items-end">
                           <label for="shirt-length" class="text-right cc-mes-label">Chest :</label>
                           <div class="cc-w-50 text-left">
                              <input type="number" name="chest" id="chest" class="text-center ml-3 cc-mes-inp" min="0" max="99"
                                 step="0.1" value='.displayMeasVal($conn, "Chest", $Cust_ID).'>
                           </div>
                        </div>
                        <div class="p-1 d-flex justify-content-evenly align-items-end">
                           <label for="shirt-length" class="text-right cc-mes-label">Sleeves :</label>
                           <div class="cc-w-50 text-left">
                              <input type="number" name="sleeves" id="sleeves" class="text-center ml-3 cc-mes-inp" min="0" max="99"
                                 step="0.1" value='.displayMeasVal($conn, "Sleeves", $Cust_ID).'>
                           </div>
                        </div>
                        <div class="p-1 d-flex justify-content-evenly align-items-end">
                           <label for="shirt-length" class="text-right cc-mes-label">Waist :</label>
                           <div class="cc-w-50 text-left">
                              <input type="number" name="waist" id="waist" class="text-center ml-3 cc-mes-inp" min="0" max="99"
                                 step="0.1" value='.displayMeasVal($conn, "Waist", $Cust_ID).'>
                           </div>
                        </div>
                     </div>
                     <div class="col-lg flex-grow-1">
                        <!-- <h5 class="text-left">Lower Body</h5> -->
                        <div class="p-1 d-flex justify-content-evenly align-items-end">
                           <label for="shirt-length" class="text-right cc-mes-label">Pant Length :</label>
                           <div class="cc-w-50 text-left">
                              <input type="number" name="pant-length" id="pant-length" class="text-center ml-3 cc-mes-inp" min="0"
                                 max="99" step="0.1" value='.displayMeasVal($conn, "Pant Length", $Cust_ID).'>
                           </div>
                        </div>
                        <div class="p-1 d-flex justify-content-evenly align-items-end">
                           <label for="shirt-length" class="text-right cc-mes-label">Hip :</label>
                           <div class="cc-w-50 text-left">
                              <input type="number" name="hip" id="hip" class="text-center ml-3 cc-mes-inp" min="0" max="99"
                                 step="0.1" value='.displayMeasVal($conn, "Hip", $Cust_ID).'>
                           </div>
                        </div>
                        <div class="p-1 d-flex justify-content-evenly align-items-end">
                           <label for="shirt-length" class="text-right cc-mes-label">Fork Round :</label>
                           <div class="cc-w-50 text-left">
                              <input type="number" name="fork-round" id="fork-round" class="text-center ml-3 cc-mes-inp" min="0"
                                 max="99" step="0.1" value='.displayMeasVal($conn, "Fork Round", $Cust_ID).'>
                           </div>
                        </div>
                        <div class="p-1 d-flex justify-content-evenly align-items-end">
                           <label for="shirt-length" class="text-right cc-mes-label">Thigh :</label>
                           <div class="cc-w-50 text-left">
                              <input type="number" name="thigh" id="thigh" class="text-center ml-3 cc-mes-inp" min="0" max="99"
                                 step="0.1" value='.displayMeasVal($conn, "Thigh", $Cust_ID).'>
                           </div>
                        </div>
                        <div class="p-1 d-flex justify-content-evenly align-items-end">
                           <label for="shirt-length" class="text-right cc-mes-label">Knee :</label>
                           <div class="cc-w-50 text-left">
                              <input type="number" name="knee" id="knee" class="text-center ml-3 cc-mes-inp" min="0" max="99"
                                 step="0.1" value='.displayMeasVal($conn, "Knee", $Cust_ID).'>
                           </div>
                        </div>
                        <div class="p-1 d-flex justify-content-evenly align-items-end">
                           <label for="shirt-length" class="text-right cc-mes-label">Bottom :</label>
                           <div class="cc-w-50 text-left">
                              <input type="number" name="bottom" id="bottom" class="text-center ml-3 cc-mes-inp" min="0" max="99"
                                 step="0.1" value='.displayMeasVal($conn, "Bottom", $Cust_ID).'>
                           </div>
                        </div>
                     </div>
                  </div>
         
                  <div class="row">
                     <button type="submit" id="lof-btn"
                        class="mt-3 btn btn-primary rounded-pill p-1 cc-mes-save m-auto">Save</button>
         
                  </div>
               </form>
            </div>';
      } else
         echo ' 
      <!-- Login / Register -->

            <div class="row flex-grow-1 p-2 justify-content-center align-items-center">
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
   </div>


   <!-- bootstrap js bundle -->
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-popRpmFF9JQgExhfw5tZT4I9/CI5e2QcuUZPOVXb1m7qUmeR2b50u+YFEYe1wgzy" crossorigin="anonymous"></script>



   <script src="Script/log_reg.js"></script>
   <script src="Script/nav.js"></script>

</body>

</html>