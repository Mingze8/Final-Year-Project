<?php
    require 'config.php';

    $ID = $_GET["id"];
    if(ISSET($_GET["id"])){
        $presql = "UPDATE `parcel` SET `DeliveryNow`='0' WHERE `AssignTo` = " .$_SESSION["driver"];

        if($conn->query($presql)===TRUE){
            echo "";
        }else{
            echo "failed";
        }
    }

    if(ISSET($_GET["id"])){

        $sql = "UPDATE `parcel` SET `DeliveryNow`='1' WHERE `ParcelID` = '$ID'";

        if($conn->query($sql)===TRUE){
            header("Location:job.php");
        }else{
            echo "Failed to Add" . $conn->error;
        }
    }
?>