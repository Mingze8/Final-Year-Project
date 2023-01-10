<?php
    require 'config.php';

    if(ISSET($_POST["lat"]) && ISSET($_POST["lng"]))
    {
        $latitude = mysqli_real_escape_string($conn, $_POST["lat"]);
        $longitude = mysqli_real_escape_string($conn, $_POST["lng"]);
        if($_POST["id"] != '')
        {
            $sql = "UPDATE `vehicle` SET `Latitude`='$latitude',`Longtitude`='$longitude' WHERE `CurrentDriver` = '" . $_POST["id"]."'";
            mysqli_query($conn, $sql);
        }
        else
        {
            $sql = "INSERT INTO `vehicle`(`Latitude`,`Longtitude`)VALUES('".$latitude."','".$longitude."')";
            mysqli_query($conn,$sql);
            echo mysqli_insert_id($conn);
        }
    }
?>
