<?php 
    include '../db/config.php';
    session_start();

    
    if(isset($_POST['createItem'])){
        # Create item
         if ($_POST['brand'] && $_POST['unit'] && $_POST['serialNumber'] && $_POST['purchaseDate'] && $_POST['specs'] && $_POST['price'] && $_POST['manufacturer']) {
           
             echo $brand = $_POST['brand'];
             echo $unit = $_POST['unit'];
             echo $serialNumber = $_POST['serialNumber'];
             echo $purchaseDate = $_POST['purchaseDate'];
             echo $specs = $_POST['specs'];
             echo $price = $_POST['price'];
             echo $manufacturer = $_POST['manufacturer'];
             echo $receiptId = $_POST['receiptId'];

             if(isset($_POST['bundle'])){
                $bundle = $_POST['bundle'];   
             } else {
                $bundle = 0;   
             }
             echo $bundle;
             $createItem = "INSERT INTO peripherals (brand, unit, serial_number, purchase_date, specs, price, manufacturer, receipt_id, set_id)
                 VALUES ('$brand', '$unit', '$serialNumber', '$purchaseDate', '$specs', '$price', '$manufacturer', '$receiptId', '$bundle')";
             if (mysqli_query($db, $createItem)) {
                 echo "Item created successfully ";
             } else {
                 echo "Item created unsuccessfully ";
             }

             # Logs
             $user = $_SESSION["username"];
             $description = "Created peripheral " . $unit . " with a serial number of " . $serialNumber . ".";
             $affected_user = "None";
             $date = date("Y-m-d h:i:sa");
             $logs = "INSERT into logs (`user`, `description`, `date`, `affected_user`) VALUES ('$user','$description','$date','$affected_user')";
             mysqli_query($db, $logs);
            
             header('location: ../index.php');
         } 
        
         else if ($_FILES['itemFile']) {
            // echo "2";
             $file_extension = pathinfo($_FILES['itemFile']['name'], PATHINFO_EXTENSION);
             if ($file_extension == 'csv') {
                 $file = fopen($_FILES['itemFile']['tmp_name'],"r"); 

                 # Get first column and check column format (firstname, lastname, set)
                 $columns = fgetcsv($file);
                 if ($columns[0] == 'item' && $columns[1] == 'unit' && $columns[2] == 'serial' && $columns[3] == 'date' && $columns[4] == 'receipt_id' && $columns[5] == 'price' && $columns[6] == 'manufacturer' && $columns[7] == 'additional_info' && $columns[8] == 'set') {
                     while ($newItem = fgetcsv($file)) {
                         # Get each column
                         $item = $newItem[0];
                         $unit = $newItem[1];
                         $serial = $newItem[2];
                         $date = date('Y-m-d', strtotime(str_replace('/', '-', $newItem[3])));;
                         $receipt_id = $newItem[4];
                         $price = $newItem[5];
                         $manufacturer = $newItem[6];
                         $specs = $newItem[7];
                         $set = $newItem[8];
                        
                         # Check if set exist in db
                         $check_set = "SELECT * FROM set_bundle WHERE set_name = '$set' ";
                         $check_set_result = mysqli_query($db, $check_set);

                         if (mysqli_num_rows($check_set_result)) {
                             # Get set ID
                             $existSetRow = mysqli_fetch_assoc($check_set_result);
                             $existSetid = $existSetRow['set_id'];

                             $create_item = "INSERT INTO peripherals (brand, unit, serial_number, specs, price, manufacturer, purchase_date, receipt_id, set_id)
                             VALUES ('$item', '$unit', '$serial', '$specs', '$price', '$manufacturer', '$date', '$receipt_id', '$existSetid')";
                             mysqli_query($db, $create_item);
                         } else {
                             $create_item = "INSERT INTO peripherals (brand, unit, serial_number, specs, price, manufacturer, purchase_date, receipt_id, set_id)
                             VALUES ('$item', '$unit', '$serial', '$specs', '$price', '$manufacturer', '$date', '$receipt_id', '0')";
                             mysqli_query($db, $create_item);
                         }
                         # Logs
                         $user = $_SESSION["username"];
                         $description = "Created peripheral " . $unit . " with a serial number of " . $serial . ".";
                         $affected_user = "None";
                         $date = date("Y-m-d h:i:sa");
                         $logs = "INSERT into logs (`user`, `description`, `date`, `affected_user`) VALUES ('$user','$description','$date','$affected_user')";
                         mysqli_query($db, $logs);
                     }
                     header('location: ../index.php');
                 } else {
                     # Invalid column format       
                     header('location: ../index.php');
                 }
             } else {
                 # If file is not csv
                 header('location: ../index.php');
             }
         }
    } else if(isset($_POST['createBundle'])){
        # Create set
        $bundle = $_POST['newBundle'];

        #Check set if exist
        $checkBundle = "SELECT * FROM set_bundle WHERE set_name = '$bundle' "; 
        $checkingBundle = mysqli_query($db, $checkBundle);

        if(mysqli_num_rows($checkingBundle)){
            header('location: ../index.php?set=' . $bundle . '');
        } else {
            $createBundle = "INSERT INTO set_bundle (set_name)
                VALUES ('$bundle')";
            mysqli_query($db, $createBundle);

            # Logs
            $user = $_SESSION["username"];
            $description = "Created Set:  " . $bundle . ".";
            $affected_user = "None";
            $date = date("Y-m-d h:i:sa");
            $logs = "INSERT into logs (`user`, `description`, `date`, `affected_user`) VALUES ('$user','$description','$date','$affected_user')";
            mysqli_query($db, $logs);

            header('location: ../sets.php');
        }
    } else if(isset($_POST['createEmployee'])){
        # Create employee
        if ($_POST['firstname'] && $_POST['lastname']) {
            $firstname = $_POST['firstname'];
            $lastname = $_POST['lastname'];
            $username = $_POST['username'];
            $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

            # Check if there is a Set chosen
            if(isset($_POST['bundle'])){
                $bundleId = $_POST['bundle'];
            } else {
                $bundleId = 0;
            }
            $createEmployee = "INSERT INTO employees (firstname, lastname, set_id, username)
                VALUES ('$firstname', '$lastname','$bundleId','$username')";
            mysqli_query($db, $createEmployee);
            $date = date("Y-m-d h:i:sa");
            $type = 2;
            $createEmployee = "INSERT INTO users (username, password, created_at, user_type)
                VALUES ('$username', '$password','$date','$type')";
            mysqli_query($db, $createEmployee);

            # Logs
            $name = $firstname." ".$lastname;
            $user = $_SESSION["username"];
            $description = "Created Employee:  " . $name . ".";
            $affected_user = $name;
            $date = date("Y-m-d h:i:sa");
            $logs = "INSERT into logs (`user`, `description`, `date`, `affected_user`) VALUES ('$user','$description','$date','$affected_user')";
            mysqli_query($db, $logs);
            echo "Employee: ".$employeeId = mysqli_insert_id($db);
            
            /*if(isset($_POST['bundle'])){
                echo "Bundle: " . $bundleId = $_POST['bundle'];
                $timecreated = time();
                
                $setBundle = "INSERT INTO bundle_assignments (bundle_id, employee_id, timecreated) VALUES ('$bundleId', '$employeeId', '$timecreated')";
                mysqli_query($db, $setBundle);
            }*/

            header('location: ../employee.php');

         } else if($_FILES['empFile']){
             $file_extension = pathinfo($_FILES['empFile']['name'], PATHINFO_EXTENSION);

             if ($file_extension == 'csv') {
                 $file = fopen($_FILES['empFile']['tmp_name'],"r"); 

                 # Get first column and check column format (firstname, lastname, set)
                 $columns = fgetcsv($file);
                
                 
                 if ($columns[0] == "firstname" && $columns[1] == "lastname" && $columns[2] == "set") {
                    
                     while ($newEmployee = fgetcsv($file)) {
                         # Get each column
                         $firstname = $newEmployee[0];
                         $lastname = $newEmployee[1];
                         $set = $newEmployee[2];
                        
                         # Check if set exist in db
                         $check_set = "SELECT * FROM set_bundle WHERE set_name = '$set' ";
                         $check_set_result = mysqli_query($db, $check_set);
                        
                         if (mysqli_num_rows($check_set_result)) {
                             # Get set ID
                             $existSetRow = mysqli_fetch_assoc($check_set_result);
                             $existSetid = $existSetRow['set_id'];
    
                             # Check set if assigned
                             $check_set_assigned = "SELECT * FROM employees WHERE set_id = '$existSetid' ";
                             $check_set_assigned_result = mysqli_query($db, $check_set_assigned);
    
                             if (mysqli_num_rows($check_set_assigned_result)) {
                                 # Create employee with no set
                                 $create_employee = "INSERT INTO employees (firstname, lastname, set_id)
                                 VALUES ('$firstname', '$lastname', '0')";
                                 mysqli_query($db, $create_employee);
    
                             } else {
                                 # Create employee with existing unassigned set
                                 $create_employee = "INSERT INTO employees (firstname, lastname, set_id)
                                 VALUES ('$firstname', '$lastname', '$existSetid')";
                                 mysqli_query($db, $create_employee);
                             }
                         } else {
                             # Create set
                             $create_set = "INSERT INTO set_bundle (set_name)
                             VALUES ('$set')";
                             mysqli_query($db, $create_set);

                             # Logs
                             $user = $_SESSION["username"];
                             $description = "Created Set:  " . $set . ".";
                             $affected_user = "None";
                             $date = date("Y-m-d h:i:sa");
                             $logs = "INSERT into logs (`user`, `description`, `date`, `affected_user`) VALUES ('$user','$description','$date','$affected_user')";
                             mysqli_query($db, $logs);
    
                             # Get new set
                             $get_set = "SELECT * FROM set_bundle WHERE set_name = '$set' ";
                             $get_set_result = mysqli_query($db, $get_set);
                             $getSetRow = mysqli_fetch_assoc($get_set_result);
                             $setid = $getSetRow['set_id'];
    
                             # Create employee with new set
                             $create_employee = "INSERT INTO employees (firstname, lastname, set_id)
                             VALUES ('$firstname', '$lastname', '$setid')";
                             mysqli_query($db, $create_employee);
                         }
                         # Logs
                         $name = $firstname." ".$lastname;
                         $user = $_SESSION["username"];
                         $description = "Created Employee:  " . $name . ".";
                         $affected_user = $name;
                         $date = date("Y-m-d h:i:sa");
                         $logs = "INSERT into logs (`user`, `description`, `date`, `affected_user`) VALUES ('$user','$description','$date','$affected_user')";
                         mysqli_query($db, $logs);
                     }
                     header('location: ../employee.php');
                 } else {
                     # Invalid column format
                     header('location: ../employee.php');
                 }
             } else {
                 # If file is not csv
                 header('location: ../employee.php');
             }
         } else {
             header('location: ../employee.php');
        }
        
    } else if(isset($_POST['addFile'])){
        $currentDirectory = getcwd();
        $uploadDirectory = "\../uploads/";

        $errors = []; // Store errors here

        $fileExtensionsAllowed = ['jpeg','jpg','png']; // These will be the only file extensions allowed 

        $fileName = $_FILES['the_file']['name'];
        $fileSize = $_FILES['the_file']['size'];
        $fileTmpName  = $_FILES['the_file']['tmp_name'];
        $fileType = $_FILES['the_file']['type'];
        $fileExtension = strtolower(end(explode('.',$fileName)));

        $uploadPath = $currentDirectory . $uploadDirectory . basename($fileName); 


        if (! in_array($fileExtension,$fileExtensionsAllowed)) {
            $errors[] = "This file extension is not allowed. Please upload a JPEG or PNG file";
        }

        if ($fileSize > 40000000) {
            $errors[] = "File exceeds maximum size (40MB)";
        }

        if (empty($errors)) {
            $didUpload = move_uploaded_file($fileTmpName, $uploadPath);

            if ($didUpload) {
                $insert = $db->query("INSERT into files (file_name, uploaded_on) VALUES ('".$fileName."', NOW())");
                # Logs
                $name = $firstname." ".$lastname;
                $user = $_SESSION["username"];
                $description = "Added a File:  " . $fileName . ".";
                $affected_user = 'None';
                $date = date("Y-m-d h:i:sa");
                $logs = "INSERT into logs (`user`, `description`, `date`, `affected_user`) VALUES ('$user','$description','$date','$affected_user')";
                mysqli_query($db, $logs);
                echo "The file " . basename($fileName) . " has been uploaded";
                header('location: ../files.php');
            } else {
                echo "An error occurred. Please contact the administrator.";
            }
        } else {
            foreach ($errors as $error) {
                echo $error . "These are the errors" . "\n";
            }
        }

    }
?>