<?php 
    include '../db/config.php';
    
    if(isset($_GET['item'])){
         $item = $_GET['item'];

         $delete = "DELETE 
             FROM peripherals 
             WHERE component_id = '$item'";
         mysqli_query($db, $delete);

         header('location: ../index.php');
    } else if(isset($_GET['set'])){
        echo $bundleId = $_GET['set']; 

        # Check if set has assigned employee
        $checkAssigned = "";

        # Delete Bundle
        $deleteBundle = "DELETE 
            FROM set_bundle 
            WHERE set_id = '$bundleId'";
        mysqli_query($db, $deleteBundle);

        header('location: ../index.php');
    } else if (isset($_GET['employee'])){
        $employeeId = $_GET['employee'];

        $deleteEmployee = "DELETE 
            FROM employees 
            WHERE id = '$employeeId'";
        mysqli_query($db, $deleteEmployee);

        header('location: ../employee.php');
    }
?>