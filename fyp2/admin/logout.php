<?php
    require 'config.php';
?>
<html>
    <head></head>
    <body>
        <?php
        //remove session
        unset($_SESSION["admin"]);
        unset($_SESSION["name"]);

        //destroy
        //session_destroy();
        header("Location:login.php");

        ?>
    </body>
</html>