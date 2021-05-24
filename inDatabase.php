<?php
    
    print("<!DOCTYPE html>");
    print("<html>");
    print("<head>");
    print("<title>VLSM</title>");
    print(" <meta charset='UTF-8' />");
    print("<meta name='viewport' content='width=device-width, initial-scale=1.0' />");
    print("</head><body>");
    
    
    
    /*
    $data = json_decode($_POST['data'], true);
    count($_POST['data']);
    count($_POST['data'][5]);
    */
    print_r($_POST);
    foreach ($_POST['lan'] as $lans) {
        print ($_POST. "<br>");
    }
    
    /*
    
    $db_host = 'localhost';
    $db_username = 'root';
    $db_password = 'i36297815M@';
    $db_name = 'examproject';
    $pArrayData = array($arrayData);
    
    
    $json_ques = json_encode($data);
    
    $query = "insert into vlsm (NetworkID, SubnetMask, NumberOfHostsPerSubnet, NumberOfSubnets, RangeOfUsableIPaddresses) values ('$json_ques')";
    
    
    if (!($database = mysqli_connect("localhost:3306", "root", "i36297815M@"))) {
        die("<p>Could not connect to database </p></body></html>");
    }
    
    if (!mysqli_select_db($database, "$db_name")) {
        die("<p>Could not open products database </p></body></html>");
    }
    
    // query products database
    if (!($result = mysqli_query($database, $query))) {
        print("<p>Could not execute query!</p></body></html>");
        die(mysqli_error($database));
    }
    mysqli_close($database);
    */
    print("</body></html>");