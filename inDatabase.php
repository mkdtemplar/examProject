<?php
    print("<!DOCTYPE html>");
    print("<html>");
    print("<head>");
    print("<title>VLSM</title>");
    print(" <meta charset='UTF-8' />");
    print("<meta name='viewport' content='width=device-width, initial-scale=1.0' />");
    print("</head><body>");
    
    $subnets = [1, 2, 4, 8, 16, 32, 64, 128, 256];
    $hosts = [256, 128, 64, 32, 16, 8, 4, 2, 1];
    $submask = [24, 25, 26, 27, 28, 29, 30, 31, 32];
    $cidrLastOctet = [0, 128, 192, 224, 240, 248, 252, 254, 255];
    
        $first =$_POST["first"] ? : "";
        settype($first, "integer");
        
        $second = $_POST["second"] ? : "";
        settype($second, "integer");
   
        $third = $_POST["third"] ? : "";
        settype($third, "integer");
  
   
        $fourth = $_POST["fourth"] ? : "";
        settype($fourth, "integer");
        
        $cidr = $_POST["cid"] ? : "";
        settype($cidr,"integer");
        
    $keyIndex = array_search($cidr, haystack: $submask);
    $cidrLastO = $cidrLastOctet[$keyIndex];
    
    $cidrBinary = decbin($cidrLastO);
    $fourthBinary = decbin($fourth);
    
    settype($fourthBinary, "string");
    settype($cidrBinary, "string");
    
    
    
    $cidrArray = array();
    $fourthArray = array();
    
    for ($cidrIndex = 0; $cidrIndex < strlen($cidrBinary); $cidrIndex++)
    {
        $cidrArray[$cidrIndex] = $cidrBinary[$cidrIndex];
    }
    
    for ($fourthIndex = 0; $fourthIndex < strlen($fourthBinary); $fourthIndex++)
    {
        $fourthArray[$fourthIndex] = $fourthBinary[$fourthIndex];
    }
    
    $lengthFourthArray = count($fourthArray);
    $lengthCidrArray = count($cidrArray);
    
    if ($lengthCidrArray < 8)
    {
        while ($lengthCidrArray < 8)
        {
            array_unshift($cidrArray, '0');
            $lengthCidrArray++;
        }
    }
    
    if ($lengthFourthArray < 8)
    {
        while ($lengthFourthArray < 8)
        {
            array_unshift($fourthArray, '0');
            $lengthFourthArray++;
        }
    }
    
    $res = '';
    
    for ($i = 0; $i < 8; $i++)
    {
        if ($fourthArray[$i] == '0' && $cidrArray[$i] == '0')
        {
            $res .= '0';
        }
        elseif ($fourthArray[$i] == '0' && $cidrArray[$i] == '1')
        {
            $res .= '0';
        }
        elseif ($fourthArray[$i] == '1' && $cidrArray[$i] == '0')
        {
            $res .= '0';
        }
        elseif ($fourthArray[$i] == '1' && $cidrArray[$i] == '1')
        {
            $res .= '1';
        }
    }
    
    settype($res, "integer");
    
    bindec($res);
    
    $hostsPerLan = array();
    $lanHostArray = array();
    $i = 0;
    
    foreach ($_POST['lan'] as $lans)
    {
        $hostsPerLan[$i] = (int)$lans;
        if ($hostsPerLan[$i] <= 8)
        {
            $hostsPerLan[$i] += 2;
        }
        $i++;
    }
    
   
    
   
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
        $key = array_search($lanHostArray[$q], $hosts);
        $numberOfSubNets = $subnets[$key];
        $subMaskNo = $submask[$key];
        
        $networkID = $first . "." . $second . "." . $third . "." . $res;
        $rangeOfIp = $first . "." . $second . "." . $third . "." . $res + 1 . " - " . $first . "." . $second . "." . $third . "." . (($res + $lanHostArray[$q]) - 2);
        $query = "insert into vlsm (NetworkID, SubnetMask, NumberOfHostsPerSubnet, NumberOfSubnets, RangeOfUsableIPaddresses)
                  values ('$networkID', '$subMaskNo', '$lanHostArray[$q]', '$numberOfSubNets', '$rangeOfIp')";
    
        if (!(mysqli_query($database, $query))) {
            print("<p>Could not execute query!</p></body></html>");
            die(mysqli_error($database));
        }
        
    $res += $lanHostArray[$q];
    }
    
    mysqli_close($database);
    print ("<p>Results of calculations successfully stored in database</p>");
    print ("<a href='index.html'><button type='button'>CLICK TO RETURN TO MAIN PAGE</button></a>");
    print("</body></html>");