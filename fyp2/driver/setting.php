<?php
    require 'config.php';

    if(!ISSET($_SESSION["driver"]))
    {
        header("Location:login.php");
    }
    
?>  
<html>
    <head>
        <title></title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- CSS -->
        <link rel="stylesheet" href="css\style.css">
        <!-- Boxicon -->        
        <link href='https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css' rel='stylesheet'>
        <!--font-->
        <link href='https://fonts.googleapis.com/css?family=Montserrat' rel='stylesheet'>
    </head>
    <body style="background-color:#555">
        <!-- Nav Bar Start -->
        <div class="dashboard" id="resp-dashboard">
        
            <!--<div id="logo"><a>TrackNow</a></div>-->
            <div id="logo"><a><img src="img\drivericonwhite.png" alt="" style="width: 100px"></a></div>
            <a href="index.php" class="navactive"><i class='bx bxs-home' style="background-color: transparent;"></i> Home</a>
            <a href="job.php"><i class="fa-solid fa-briefcase"></i> My Job</a>
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
            $sql = "SELECT * FROM `driver` WHERE `DriverID` = " . $_SESSION["driver"];
            $result = $conn->query($sql);
            $row = $result->fetch_assoc();

            if(ISSET($_POST["update"])){
            
                if($_POST["user"] == null){
                    $name = $row['Username'];
                }
                else{
                    $name = $_POST["user"];
                }

                if($_POST["email"] == null){
                    $email = $row['Email'];
                }
                else{
                    $email = $_POST["email"];
                }

                if($_POST["phone"] == null){
                    $phone = $row["PhoneNo"];
                }
                else{
                    $phone = $_POST["phone"];
                }
                
                if($_POST["oldpass"] == $row["Password"]){
                    $pass = $_POST["newpass"];
                }
                else{
                    $pass = $row["Password"];
                }

                $sql2 = "UPDATE `driver` SET `Username`='$name', `Email`='$email', `PhoneNo`='$phone', `Password`='$pass' WHERE `DriverID` =" .$_SESSION["driver"];
                
                if($conn->query($sql2)===TRUE){
                    unset($_SESSION["driver"]);
                    unset($_SESSION["username"]);
                    header("Location:login.php");
                }else{
                    header("Location:setting.php&Update Fail!");
                }
            }
        ?>
        <!-- Main Body -->
        <div class="setting-container">
            <div class="s-header">Account Setting</div>
            <hr style="margin:20px">
            <div class="message">* Leave blank if no changes required</div>
            <div class="s-form">
                <form action="" method="POST">
                    <div class="form-ques">
                        <label for="">Current Acount Username <span style="color:#777"> [ <?php echo $row["Username"]?> ] </span></label>
                        <input type="text" placeholder="Please enter your new username" name="user" id="user">
                    </div>
                    <div class="form-ques">
                        <label for="">Current Email <span style="color:#777">[ <?php echo $row["Email"]?> ]</span></label>
                        <input type="text" placeholder="Please enter your new email" name="email" id="email">
                    </div>
                    <div class="form-ques">
                        <label for="">Current Phone Number <span style="color:#777">[ <?php echo $row["PhoneNo"]?> ]</span></label>
                        <input type="text" placeholder="Please enter your new phone number" name="phone" id="phone">
                    </div>
                    <div class="form-ques">
                        <label for="">Current Password</label>
                        <input type="password" placeholder="Please enter your current password" name="oldpass" id="oldpass">
                    </div>
                    <div class="form-ques">
                        <label for="">New Password</label>
                        <input type="password" placeholder="Please enter your new password" name="newpass" id="newpass">
                    </div>
                    <div class="form-footer">
                    <input type="submit" value="Update" class="btn-update" name="update">
                    </div>
                </form>
            </div>
        </div>
        <script>
            function myFunction() {
                var x = document.getElementById("resp-dashboard");
                if (x.className === "dashboard") {
                    x.className += " responsive";
                } else {
                    x.className = "dashboard";
                }
            }
        </script>

        <script src="js\func.js"></script>
        <!-- Awesomefont -->
        <script src="https://kit.fontawesome.com/b2309d5c46.js" crossorigin="anonymous"></script>
    </body>
</html>