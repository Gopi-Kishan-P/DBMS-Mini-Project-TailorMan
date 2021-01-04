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
        $sql = "Create database if not exists Tailorman;";
        mysqli_query($conn, $sql);
        $sql = "Use Tailorman;";
        mysqli_query($conn, $sql);

        // CUSTOMER Table
        $sql = "CREATE TABLE IF NOT EXISTS `tailorman`.`customer` (`Cust_ID` INT AUTO_INCREMENT PRIMARY KEY, `Cust_Name` VARCHAR(30) NOT NULL , `Cust_Phno` VARCHAR(15) NOT NULL UNIQUE, `Cust_Password` VARCHAR(255) NOT NULL)";
        mysqli_query($conn, $sql);
        
        // Measurement Table
        $sql = "CREATE TABLE IF NOT EXISTS `tailorman`.`Measurement` ( `Cust_ID` INT NOT NULL, Foreign Key (Cust_Id) References `customer`(Cust_ID), `Shirt Length` FLOAT, `Collar` FLOAT, `Shoulder` FLOAT, `Chest` FLOAT, `Sleeves` FLOAT, `Waist` FLOAT, `Pant Length` FLOAT, `Hip` FLOAT, `Fork Round` FLOAT, `Thigh` FLOAT, `Knee` FLOAT, `Bottom` FLOAT )";
        mysqli_query($conn, $sql);
        
        // Order Table
        $sql = "CREATE TABLE IF NOT EXISTS `tailorman`.`Order` ( `Order_Id` INT PRIMARY KEY AUTO_INCREMENT, `Cust_ID` INT NOT NULL, Foreign Key (Cust_Id) References `customer`(Cust_ID), Order_Date DATE, Delivery_Date DATE)";
        mysqli_query($conn, $sql);
        
        // Department Table
        $sql = "CREATE TABLE IF NOT EXISTS `tailorman`.`Department` (`Dept_ID` INT PRIMARY KEY AUTO_INCREMENT, `Dept_Name` VARCHAR(20), `Dept_Location` VARCHAR(10) )";
        mysqli_query($conn, $sql);

        // Employee Table 
        $sql = "CREATE TABLE IF NOT EXISTS `tailorman`.`Employee` ( `Emp_Id` INT PRIMARY KEY AUTO_INCREMENT, `Dept_ID` INT, `Emp_Name` VARCHAR(25), `Emp_Phno` VARCHAR(15), `Emp_Address` VARCHAR(50), `Emp_Salary` DOUBLE, FOREIGN KEY References Department(Dept_Id))";
        mysqli_query($conn, $sql);
        
        // Order_Status Table
        $sql = "CREATE TABLE IF NOT EXISTS `tailorman`.`Order_Status` (`Order_Id` INT, `Progress_Percent` INT, `Cut_Emp_ID` INT, `Cut_Status` INT, `Stitch_Emp_ID` INT, `Stitch_Status` INT, `Button_Iron_Emp_Id` INT, `Button_Iron_Status` INT, `Delivery_Status` INT, FOREIGN KEY (Cut_Emp_ID) REFERENCES Employee(Emp_Id), FOREIGN KEY (Stitch_Emp_ID) REFERENCES Employee(Emp_Id), FOREIGN KEY (Button_Iron_Emp_ID) REFERENCES Employee(Emp_Id), FOREIGN KEY (Order_ID) REFERENCES `tailorman`.Order(Order_Id))";
        mysqli_query($conn, $sql);

        // Payment Table
        $sql = "CREATE TABLE IF NOT EXISTS `tailorman`.`Payment` (`Pay_Id` INT PRIMARY KEY AUTO_INCREMENT, `Cust_Id` INT, `Order_Id` INT, `Pay_Date` DATE, `Pay_Amt` DOUBLE, `Pay_Status` varchar(10), FOREIGN KEY(Cust_ID) REFERENCES Customer(Cust_Id), FOREIGN KEY(Order_Id) REFERENCES `tailorman`.Order(Order_ID))";
        mysqli_query($conn, $sql);
    }
?>