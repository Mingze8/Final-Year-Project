<?php
    require 'config.php';
    $sql = "SELECT * FROM `admin`";
    $result = $conn->query($sql);

    if(ISSET($_SESSION["admin"])){
        header("Location:index.php");
    }
?>
<html>
    <head>
        <title>Sign Up Now</title>
        <link href="css\style2.css" rel="stylesheet">
    </head>
    <body>
        <?php
            if(ISSET($_POST["signup"])){
                
                $name = $_POST["name"];
                $email = $_POST["email"];
                $password = $_POST["password"];
                //check email first
                $sql = "SELECT * FROM `admin` WHERE `AdminEmail` = '$email'";
                $result = $conn->query($sql);
                if($result->num_rows>0){
                    echo "Email Had Exist";
                }else{
                //Insert
                $sql = "INSERT INTO `admin`(`AdminName`, `AdminEmail`, `AdminPassword`) 
                VALUES ('$name','$email','$password')";

                if ($conn->query($sql)===TRUE){
                    echo 'Sign Up Successful!';
                }else{
                    echo 'Sign Up Error'.$conn->error;
                }
            }
        }

        if(ISSET($_POST["signin"])){
            //check value
            $loginemail = $_POST["loginemail"];
            $loginpassword = $_POST["loginpassword"];

            $sql = "SELECT * FROM `admin` WHERE `AdminEmail`='$loginemail'";

            $result = $conn->query($sql);

            if($result->num_rows>0){
            $row = $result->fetch_assoc();
            echo $row['$result'];
            if($row["AdminPassword"]==$loginpassword){
                $_SESSION["admin"] = $row["Admin_ID"];
                $_SESSION["name"] = $row["AdminName"];
                header("Location:index.php");
            }else{
                header("Location:login.php?error=Wrong Email or Wrong Password");
            }
            }else{
            echo "This email had not been register yet!";
            }
        }
        ?>
        
        <div class="container" id="container">
            <div class="form-container sign-up-container">
                <form action="login.php" method="POST" style="margin-top:20px">
                    <h1>Create Account</h1>
                    <br>
                    <!--<div class="social-container">
                        <a href="#" class="social"><i class="fa-brands fa-facebook-square"></i></a>
                        <a href="#" class="social"><i class="fa-brands fa-google"></i></a>
                    </div>-->
                    <span>Please fill all the blank</span><br>
                    <input type="text" placeholder="Username" name="name" required>
                    <input type="email" placeholder="Email" name="email" required>
                    <input type="password" placeholder="Password" name="password" maxlength="15" required>
                    <input type="submit" id="btn-sign" name="signup"><a href="" id="li">Sign Up</a></input>
                </form>
            </div>
            <div class="form-container sign-in-container">
                <form action="login.php" style="margin-top:20px" method="POST">
                    <h1>Sign in</h1><br>
                    <!--<div class="social-container">
                        <a href="#" class="social"><i class="fa-brands fa-facebook-square"></i></a>
                        <a href="#" class="social"><i class="fa-brands fa-google"></i></a>
                    </div>-->
                    <span>Welcome Back</span><br>
                    <input type="email" placeholder="Email" name="loginemail" required>
                    <input type="password" placeholder="Password" name="loginpassword" required>
                    <!--<a href="#">Forgot your password?</a>-->
                    <input type="submit" id="btn-sign" name="signin"><a href="" id="li">Sign In</a></input>
                </form>
            </div>
            <div class="overlay-container">
                <div class="overlay">
                    <div class="overlay-panel overlay-left">
                        <h1>Already have an account?</h1>
                        <p>Login now and experience with us!</p>
                        <button class="ghost" id="signIn">Sign In</button>
                    </div>
                    <div class="overlay-panel overlay-right">
                        <h1>Don't have an account?</h1>
                        <p>Sign Up for free now!</p>
                        <button class="ghost" id="signUp">Sign Up</button>
                    </div>
                </div>
            </div>
        </div>

            <script src="js\login.js"></script>
            <script src="https://kit.fontawesome.com/50e5f661a7.js" crossorigin="anonymous"></script>
    </body>
</html>