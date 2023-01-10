<?php
    require 'config.php';
    $ID = $_GET["id"];
?>
<html>
    <head>
        <title></title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- CSS -->
        <link rel="stylesheet" href="css\style.css">
        <!-- Boxicon -->
        <link href='https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css' rel='stylesheet'>
    </head>
    <body>
    <?php
        if(ISSET($_POST["update"])){
            $status = $_POST["status"];
            $note = $_POST["note"];

            $sql = "UPDATE `vehicle` SET `Status`='$status', `note`='$note' WHERE `CurrentDriver` = '$ID'"; 
            
            if($conn->query($sql)===TRUE){
                header("location:index.php");
            }else{
                header("location:status.php?id=".$ID."&error=Update Fail!");
            }
        }

    ?>
    <div class="update-container">
        <div class="updateform">
            <div class="header">
                <h2>Update Status</h2>
            </div>
            <hr>
            <form action="status.php?id=<?php echo $ID;?>" method="POST">
                <div class="row">
                    <label for="" class="flabel">Change Status to</label>
                    <select name="status" id="" class="fans">
                        <option value="0">Not Working</option>
                        <option value="1">Out For Delivery</option>
                        <option value="2">Lunch Break</option>
                    </select>
                    <label for="" class="flabel topspace">Notes</label>
                    <input type="text" class="fans" name="note">
                    <div class="form-footer">
                        <input type="submit" value="Update" class="btn-update" name="update">
                    </div>
                </div>
            </form>
        </div>
    </div>
    <script src="js\func.js"></script>
        <!-- Awesomefont -->
        <script src="https://kit.fontawesome.com/b2309d5c46.js" crossorigin="anonymous"></script>
    </body>
</html>