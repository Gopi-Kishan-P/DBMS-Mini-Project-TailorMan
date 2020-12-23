<?php

    error_reporting(1);
    define('DB_SERVER', 'localhost');
    define('DB_USERNAME', 'root');
    define('DB_PASSWORD', 'root');
    // define('DB_Name', 'tailorman');
    
    $conn = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD);
    if($conn == false){
        echo "Coudnt Connect";
    }else{    
        $sql = "Create database if not exis Tailorman;";
        mysqli_query($conn, $sql);
        $sql = "Use Tailorman;";
        mysqli_query($conn, $sql);

        // CUSTOMER Table
        $sql = "CREATE TABLE IF NOT EXISTS `tailorman`.`customer` (`Cust_ID` INT(3) NOT NULL AUTO_INCREMENT UNIQUE, `Cust_Name` VARCHAR(30) NOT NULL , `Cust_Phno` VARCHAR(15) NOT NULL UNIQUE, `Cust_Password` VARCHAR(255) NOT NULL , PRIMARY KEY (`Cust_ID`, `Cust_Phno`))";
        mysqli_query($conn, $sql);
        
        // Measurement Table
        $sql = "CREATE TABLE IF NOT EXISTS `tailorman`.`measurements` ( `Cust_ID` INT(3) NOT NULL, Foreign Key (Cust_Id) References `customer`(Cust_ID), `Shirt Length` FLOAT, `Collar` FLOAT, `Shoulder` FLOAT, `Chest` FLOAT, `Sleeves` FLOAT, `Waist` FLOAT, `Pant Length` FLOAT, `Hip` FLOAT, `Fork Round` FLOAT, `Thigh` FLOAT, `Knee` FLOAT, `Bottom` FLOAT )";
        mysqli_query($conn, $sql);
        
        
    }
?>