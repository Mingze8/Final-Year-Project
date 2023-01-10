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
        <link href='https://fonts.googleapis.com/css?family=Montserrat' rel='stylesheet'>
    </head>
    <body style="background:#555">
    <!-- Nav Bar Start -->
    <div class="dashboard" id="resp-dashboard">
        
        <div id="logo"><a><img src="img\drivericonwhite.png" alt="" style="width: 100px"></a></div>
        <a href="index.php"><i class='bx bxs-home' style="background-color: transparent;"></i> Home</a>
        <a href="job.php" class="navactive"><i class="fa-solid fa-briefcase"></i> My Job</a>
        <a href="javascript:void(0);" class="icon" onclick="myFunction()">
            <i class="fa fa-bars" style="background-color: #333;"></i></a>
        <div class="split dropdown">
            <button class="dropbtn"><?php echo "Welcome Back, " . $_SESSION["username"] ?>
                <i class="fa fa-caret-down" style="background-color: #333;"></i>
            </button>
            <div class="dropdown-content">
                <a href="setting.php">Settings</a>
                <a href="logout.php">Log Out</a>
            </div>
        </div>


    </div>
    <!-- Nav Bar End-->
    <?php
        if(ISSET($_POST["update"])){
            $status = $_POST["status"];

            //update
            $sql = "UPDATE `parcel` SET `JobStatus`='$status', `DeliveryNow`='0' WHERE `ParcelID` = '$ID'";
            
            if($conn->query($sql)===TRUE){
                header("location:job.php");
            }else{
                header("location:updatestatus.php?id=".$ID."&error=Update Fail!");
            }
        }
    ?>
    <div class="update-container">
        <div class="updateform">
            <div class="header">
                <h2>Update Status</h2>
            </div>
            <hr>
            <form action="updatestatus.php?id=<?php echo $ID;?>" method="POST">
                <div class="s-row">
                    <label for="" class="flabel">Change Status to</label>
                    <select name="status" id="" class="fans">
                        <option value="6">Out For Delivery</option>
                        <option value="7">Completed</option>
                        <option value="8">Delivery Failed</option>
                        <option value="9">Returned to Hub</option>
                        <option value="10">Delivery Rescheduled</option>
                        <option value="13">Parcel Problem</option>
                    </select>
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