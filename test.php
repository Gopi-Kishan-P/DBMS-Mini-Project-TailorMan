<?php
    session_start();
    echo $_SESSION['Logged In'];
    echo "<br>";
    echo $_SESSION['User Name'];
    echo "<br>";
    echo isset($_SESSION["Logged In"]);
    if (isset($_SESSION["Logged In"]) && $_SESSION["Logged In"] == true)
    echo "TRUE";
    else echo "FALSE";
    
?>