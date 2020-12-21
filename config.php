<?php

    define('DB_SERVER', 'localhost');
    define('DB_USERNAME', 'root');
    define('DB_PASSWORD', 'root');
    // define('DB_Name', 'tailorman');
    
    $conn = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD);
    if($conn == false){
        echo "Coudnt Connect";
    }else{
        echo "<br>Connection Established<br>";
    
        $sql = "Create database if not exis Tailorman;";
        if(mysqli_query($conn, $sql)){
            echo "<br>Successful database creation<br>";
        }
        $sql = "Use Tailorman;";
        if(mysqli_query($conn, $sql))
            echo "<br>Successful database use<br>";
        $sql = "Use Tailorman;";

        $sql = "CREATE TABLE IF NOT EXISTS `tailorman`.`customer` (`Cust_ID` INT(3) NOT NULL AUTO_INCREMENT UNIQUE, `Cust_Name` VARCHAR(30) NOT NULL , `Cust_Phno` VARCHAR(15) NOT NULL UNIQUE, `Cust_Password` VARCHAR(255) NOT NULL , PRIMARY KEY (`Cust_ID`, `Cust_Phno`))";

        if(mysqli_query($conn, $sql))
            echo "<br>Successful TABLE <br>";
    }
?>