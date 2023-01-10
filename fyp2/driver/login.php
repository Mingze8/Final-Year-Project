<?php
    require 'config.php';
    $sql = "SELECT * FROM `driver`";
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
                if(ISSET($_POST["login"])){

                    $email = $_POST["email"];
                    $password = $_POST["password"];

                    $sql = "SELECT * FROM `driver` WHERE `Email`='$email'";

                    $result = $conn->query($sql);

                    if($result->num_rows>0){
                        $row = $result->fetch_assoc();
                        if($row["Password"]==$password){
                            $_SESSION["driver"] = $row["DriverID"];
                            $_SESSION["username"] = $row["Username"];

                            $login = "UPDATE `driver` SET `LastLogin` = CURRENT_TIMESTAMP WHERE `DriverID` = " .$_SESSION["driver"];
                            if($conn->query($login)===TRUE){
                                echo "";
                            }else{
                                echo "Error" . $conn->error;
                            }

                            header("Location:index.php");
                        }else{
                            echo "<span class='loginalert'><i class='fa-solid fa-circle-exclamation fa-lg'></i> Wrong Password or Wrong Email</span>";
                        }
                    }else{
                        echo "<span class='loginalert'><i class='fa-solid fa-circle-exclamation fa-lg'></i> This email had not been register yet! </span>";
                    }
                }
                
            ?>    
        </div>
        <br><br>
            <div class="login-panel">
                <div class="logo">
                   <img src="img\drivericon.png" alt="" class="logoicon">
                    <hr class="hrmobile"> <br>
                    <h4>Welcome Back</h4>
                    <div class="loginform">
                        <form action="login.php" method="POST">
                            <input type="email" placeholder="Email" name="email" class="info" required>
                            <input type="password" placeholder="Password" name="password" class="info" maxlength="15" required>
                            <input type="submit" name="login" value="Login" class="btn-login"><a href=""></a>
                        </form>
                    </div>
                    <div class="login-footer">
                        <a href=""><p>Forgot your password?</p></a> 
                        
                        <a href="register.php"><p style="margin:0">Create an account</p></a>
                    </div>
                </div>
            </div>
        </div>
        <script src="https://kit.fontawesome.com/b2309d5c46.js" crossorigin="anonymous"></script>
    </body>
</html>