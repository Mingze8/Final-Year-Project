<?php
    require 'config.php';
?>
<html>
    <head></head>
    <body>
        <?php
        
        $checkup = "UPDATE `vehicle` SET `Status`='0', `note`='' WHERE `CurrentDriver` = " .$_SESSION["driver"]; 
        if($conn->query($checkup)===TRUE){
            echo "";
        }else{
            echo "Error" . $conn->error;
        }

        
        /*remove session
        session_unset();

        //destroy
        session_destroy();*/
        header("Location:login.php");

        ?>
    </body>
</html>