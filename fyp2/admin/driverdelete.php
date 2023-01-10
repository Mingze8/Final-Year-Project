<?php
    require 'config.php';

    $DID = $_GET["did"];

    if(ISSET($_GET["did"])){
        
        $sql = "DELETE FROM `driver` WHERE `DriverID`='$DID'";

        if($conn->query($sql)===TRUE){
            header("Location:driver.php");
        }else{
            echo "Delete fail" . $conn->error;
        }
    }
?>