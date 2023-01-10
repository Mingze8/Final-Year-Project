<?php
require 'config.php';
$sqlload = "SELECT a.Latitude, a.Longtitude FROM `vehicle` AS a, `parcel` AS b WHERE a.CurrentDriver = b.AssignTo AND b.ParcelID =" . $_SESSION['tracknum'];
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

