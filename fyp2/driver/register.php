<?php
    require 'config.php';
    $sql = "SELECT * FROM  `driver`";
    $result = $conn->query($sql);
?>
<html>
    <head>
        <title></title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- CSS -->
        <link rel="stylesheet" href="css\style.css">
        <!-- Boxicon -->        
        <link href='https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css' rel='stylesheet'>
        <!-- font -->
        <link href='https://fonts.googleapis.com/css?family=Montserrat' rel='stylesheet'>
    </head>
    <body>
    <div class="login-container">
        <div>
            <?php
                if(ISSET($_POST["register"])){
                    
                    $name = $_POST["uname"];
                    $email = $_POST["email"];
                    $phone = $_POST["phone"];
                    $password = $_POST["password"];

                    $sql = "SELECT * FROM `driver` WHERE `Email`='$email'";

                    $result = $conn->query($sql);

                    if($result->num_rows>0){
                        echo "<span class='loginalert'><i class='fa-solid fa-circle-exclamation fa-lg'></i> Email Had Exist</span>";
                        }else{
                            $sql = "INSERT INTO `driver`(`Username`, `Email`, `PhoneNo`, `Password`)
                            VALUES ('$name','$email','$phone','$password')";

                            if($conn->query($sql)===TRUE){
                                echo "<span class='loginalert'><i class='fa-solid fa-circle-exclamation fa-lg'></i> Register Successful!</span>";
                                header("Location:login.php");
                            }else{
                                echo "<span class='loginalert'><i class='fa-solid fa-circle-exclamation fa-lg'></i> Register Error</span>".$conn->error;
                            }
                        }
                    }
                    
                
            ?>
        </div>
            <div class="register-panel">
                <div class="logo">
                   <img src="img\drivericon.png" alt="" class="logoicon">
                    <hr class="hrmobile"> <br>
                    <h4>Please fill all the blank</h4>
                    <div class="loginform">
                        <form action="register.php" method="POST">
                            <input type="text" placeholder="Username" name="uname" class="info" required>
                            <input type="email" placeholder="Email" name="email" class="info" required>
                            <input type="text" placeholder="Phone Number" name="phone" maxlength="11" class="info" required>
                            <input type="password" placeholder="Password" name="password" class="info" maxlength="15" required>
                            <input type="submit" name="register" value="Login" class="btn-login"><a href=""></a>
                        </form>
                    </div>
                    <div class="register-footer">
                        <a href="login.php"><p style="margin:0">Already got an account?</p></a>
                    </div>
                </div>
            </div>
        </div>
        <script src="https://kit.fontawesome.com/b2309d5c46.js" crossorigin="anonymous"></script>
    </body>
</html>