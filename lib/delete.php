<?php 
    include '../db/config.php';
    session_start();
    
    if(isset($_GET['item'])){
         $item = $_GET['item'];

         # Logs
         $get_item = "SELECT * FROM peripherals WHERE component_id = '$item'";
         $result_set = mysqli_query($db, $get_item);

         if (mysqli_num_rows($result_set) > 0) {
            while ($peripheral = mysqli_fetch_assoc($result_set)) {
                $item_name = $peripheral['unit'];
                $item_serial = $peripheral['serial_number'];
            }
         } else {
            $item_name = 'NONE';
            $item_serial = 'NONE';
         }
         $user = $_SESSION["username"];
         $description = "Delete peripheral " . $item_name . " with a serial number of " . $item_serial . ".";
         $affected_user = "None";
         $date = date("Y-m-d h:i:sa");
         $logs = "INSERT into logs (`user`, `description`, `date`, `affected_user`) VALUES ('$user','$description','$date','$affected_user')";
        mysqli_query($db, $logs);

         # Delete Item
         $delete = "DELETE 
             FROM peripherals 
             WHERE component_id = '$item'";
         mysqli_query($db, $delete);

         header('location: ../index.php');
    } else if(isset($_GET['set'])){
        echo $bundleId = $_GET['set']; 

        # Check if set has assigned employee
        $checkAssigned = "";

        # Logs
        $get_set = "SELECT * FROM set_bundle WHERE set_id = '$bundleId'";
        $result_set = mysqli_query($db, $get_set);

         if (mysqli_num_rows($result_set) > 0) {
            while ($set = mysqli_fetch_assoc($result_set)) {
                $set_name = $set['set_name'];
            }
         } else {
            $set_name = 'NONE';
         }
         $user = $_SESSION["username"];
         $description = "Delete set " . $set_name . ".";
         $affected_user = "None";
         $date = date("Y-m-d h:i:sa");
         $logs = "INSERT into logs (`user`, `description`, `date`, `affected_user`) VALUES ('$user','$description','$date','$affected_user')";
         mysqli_query($db, $logs);

        # Delete Bundle
        $deleteBundle = "DELETE 
            FROM set_bundle 
            WHERE set_id = '$bundleId'";
        mysqli_query($db, $deleteBundle);

        header('location: ../index.php');
    } else if (isset($_GET['employee'])){
        $employeeId = $_GET['employee'];

        # Logs
        $get_set = "SELECT * FROM employees WHERE id = '$employeeId'";
        $result_set = mysqli_query($db, $get_set);

         if (mysqli_num_rows($result_set) > 0) {
            while ($employee = mysqli_fetch_assoc($result_set)) {
                $name = $employee['firstname']." ".$employee['lastname'];
            }
         } else {
            $name = 'NONE';
         }
         $user = $_SESSION["username"];
         $description = "Delete employee: " . $name . ".";
         $affected_user = $name;
         $date = date("Y-m-d h:i:sa");
         $logs = "INSERT into logs (`user`, `description`, `date`, `affected_user`) VALUES ('$user','$description','$date','$affected_user')";
         mysqli_query($db, $logs);

        $deleteEmployee = "DELETE 
            FROM employees 
            WHERE id = '$employeeId'";
        mysqli_query($db, $deleteEmployee);

        header('location: ../employee.php');
    }
?>