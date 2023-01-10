<?php
    require 'config.php';

    $ID = $_GET["id"];

    if(ISSET($_GET["id"])){
        
        $sql = "DELETE FROM `parcel` WHERE `ParcelID`='$ID'";

        if($conn->query($sql)===TRUE){
            header("Location:parcel.php?key=");
        }else{
            echo "Delete fail" . $conn->error;
        }
    }
?>