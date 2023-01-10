<?php
require 'config.php';
$sqlload = "SELECT `Latitude`, `Longtitude` FROM `vehicle` WHERE `CurrentDriver` =" . $_SESSION['driver'];
        $result = $conn->query($sqlload);
        while($row = $result->fetch_assoc()){
            //echo "{lat:" . $row['Latitude'] . ", lng:" . $row['Longtitude'] . "}" ;
            //echo "{lat:" . $row['Latitude'] . ", lng:" . $row['Longtitude'] . "}";
            //echo $row['Latitude'];
            //$lat = $row['Latitude'];
            //$lng = $row['Longtitude'];
            //$test = $row['Latitude'];
            echo json_encode(Array(
                'latitude' => "" . $row['Latitude'],
                'longitude' => "" . $row['Longtitude']
            ));
        }
?>

