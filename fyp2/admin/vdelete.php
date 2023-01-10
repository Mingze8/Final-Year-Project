<?php
    require 'config.php';

    $VID = $_GET["vid"];

    if(ISSET($_GET["vid"])){
        
        $sql = "DELETE FROM `vehicle` WHERE `VehicleID`='$VID'";

        if($conn->query($sql)===TRUE){
            header("Location:vehicles.php");
        }else{
            echo "Delete fail" . $conn->error;
        }
    }
?>