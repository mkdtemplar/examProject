<!DOCTYPE html>
<html>
<head>
    <meta charset = "utf-8">
    <meta http-equiv = "refresh" content = "120"/>
    <title>Search results</title>
    <style>
        div {
            margin-top: 10px;
            margin-bottom: 10px;
        }
        label, datalist, list, option {
            width: 8em;
            float: left;
        }
        table {
            background-color: lightblue;
            border-collapse: collapse;
            border: 1px solid gray;
            text-align: center;
        }
        
        th, td {
            padding: 5px;
            border: 1px solid gray;
            text-align: center;
        }
        
        tr:nth-child(even) {
            background-color: lightcoral;
            text-align: center;
        }
        
        tr:first-child {
            background-color: lightgreen;
            text-align: center;
        }
        h1 {
            font-weight: bold;
            color: blue;
            text-align: center;
            text-shadow: 5px 5px 10px red;
            text-align: center;
        }
    </style>
</head>
<body>

<?php
    
    $db_host = 'localhost';
    $db_username = 'root';
    $db_password = 'i36297815M@';
    $db_name = 'examproject';
    
    $query = "SELECT * FROM vlsm";
    if (!($database = mysqli_connect("localhost:3306", "root", "i36297815M@"))) {
        die("<p>Could not connect to database </p></body></html>");
    }
    
    if (!mysqli_select_db($database, "$db_name")) {
        die("<p>Could not open products database </p></body></html>");
    }
    
    if (!($result = mysqli_query($database, $query))) {
        print ("<p>Could not execute query!</p></body></html>");
        die(mysqli_error($database));
    }
    ?>
<h1>Database content</h1>
<table>
    <caption>Information stored in database table  VLSM</caption>
    <tr>
        <th>id</th>
        <th>Network ID</th>
        <th>CIDR</th>
        <th>Subnet Mask</th>
        <th>Number Of Hosts Per Subnet</th>
        <th>Number Of Subnets</th>
        <th>Range Of Usable IP addresses</th>
        <th>Broadcast ID</th>
    </tr>
    <?php
        for ($i = 0; $row = mysqli_fetch_row($result); $i++)
        {
            print ("<tr>");
            foreach ($row as $key => $value)
                print ("<td>$value</td>");
            print ("</tr>");
        }
        
        mysqli_close($database);
    ?>
</table>
</body>
</html>
<?php
    print ("<br><br>");
    print ("<a href='index.html'><button type='button'>CLICK TO RETURN TO MAIN PAGE</button></a>");
    ?>

