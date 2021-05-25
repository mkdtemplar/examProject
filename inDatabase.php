<?php
    print("<!DOCTYPE html>");
    print("<html>");
    print("<head>");
    print("<title>VLSM</title>");
    print(" <meta charset='UTF-8' />");
    print("<meta name='viewport' content='width=device-width, initial-scale=1.0' />");
    print("</head><body>");
    
    
        $first =$_POST["first"] ? : "";
        settype($first, "integer");
        
        $second = $_POST["second"] ? : "";
        settype($second, "integer");
   
        $third = $_POST["third"] ? : "";
        settype($third, "integer");
  
   
        $fourth = $_POST["fourth"] ? : "";
        settype($fourth, "integer");
        
    print ($first. "<br>");
    $subnets = [1, 2, 4, 8, 16, 32, 64, 128, 256];
    $hosts = [256, 128, 64, 32, 16, 8, 4, 2, 1];
    $submask = [24, 25, 26, 27, 28, 29, 30, 31, 32];
    
    $hostsPerLan = array();
    $lanHostArray = array();
    $i = 0;
    
    print_r($_POST);
    foreach ($_POST['lan'] as $lans) {
        print ($lans . "<br>");
        
        $hostsPerLan[$i] = (int)$lans;
        if ($hostsPerLan[$i] <= 8)
        {
            $hostsPerLan[$i] += 2;
        }
        $i++;
    }
    
    print ("<br><p>HOSTS PER LAN</p>");
    
   
    for ($j = 0; $j < count($hostsPerLan) ; $j++)
    {
        for ($index = 0; $index < count($hosts); $index++)
        {
            if (($hostsPerLan[$j] <= $hosts[$index]) && ($hostsPerLan[$j] >= $hosts[$index + 1]))
            {
                $lanHostArray[$j] = $hosts[$index];
            }
        }
    }
    rsort($lanHostArray);
    foreach ($lanHostArray as $lanHosts)
    {
        print ($lanHosts. "<br>");
    }
    
    print (count($lanHostArray). "<br>");
    
    $db_host = 'localhost';
    $db_username = 'root';
    $db_password = 'i36297815M@';
    $db_name = 'examproject';
    
    if (!($database = mysqli_connect("localhost:3306", "root", "i36297815M@"))) {
        die("<p>Could not connect to database </p></body></html>");
    }
    
    if (!mysqli_select_db($database, "$db_name")) {
        die("<p>Could not open products database </p></body></html>");
    }
    $length = count($lanHostArray);
    for ($q = 0; $q < $length; $q++)
    {
        $key = array_search($lanHostArray[$q], $lanHostArray);
        $numberOfSubNets = $subnets[$key];
        $subMaskNo = $submask[$key];
        
        $networkID = $first . "." . $second . "." . $third . "." . $fourth;
        $rangeOfIp = $first . "." . $second . "." . $third . "." . $fourth + 1 . " - " . $first . "." . $second . "." . $third . "." . (($fourth + $lanHostArray[$q]) - 2);
        $query = "insert into vlsm (NetworkID, SubnetMask, NumberOfHostsPerSubnet, NumberOfSubnets, RangeOfUsableIPaddresses)
                  values ('$networkID', '$subMaskNo', '$lanHostArray[$q]', '$numberOfSubNets', '$rangeOfIp')";
    
        if (!(mysqli_query($database, $query))) {
            print("<p>Could not execute query!</p></body></html>");
            die(mysqli_error($database));
        }
    $fourth += $lanHostArray[$q];
    }
    
    mysqli_close($database);
    
    print("</body></html>");