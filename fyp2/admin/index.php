<?php
    require 'config.php';
    if(!ISSET($_SESSION["admin"]))
    {
        header("Location:login.php");
    }

    $sql = "SELECT * FROM `admin` WHERE `AdminID` = " . $_SESSION["admin"];
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
        <!--font-->
        <link href='https://fonts.googleapis.com/css?family=Montserrat' rel='stylesheet'>
    </head>
    <body style="background-color:#555">
        <!-- Nav Bar Start -->
        <div class="dashboard" id="resp-dashboard">
        
            <div id="logo"><a><img src="img\adminlogowhite.png" alt="" style="width: 100px"></a></div>
            <a href="#" class="active"><i class='bx bxs-home' style="background-color: transparent;"></i> Home</a>
            <a href="vehicles.php?key="><i class="fa-solid fa-truck-front" style="background-color: transparent;"></i> Vehicles</a>
            <a href="parcel.php?key="><i class="fa-solid fa-box" style="background-color: transparent;"></i> Parcels</a>
            <a href="driver.php"><i class="fa-solid fa-user" style="background-color: transparent;"></i> Driver</a>
            <a href="javascript:void(0);" class="icon" onclick="myFunction()">
                <i class="fa fa-bars" style="background-color: #333;"></i></a>
            
            <div class="split dropdown">
                <button class="dropbtn"><?php echo "Welcome Back, " . $_SESSION["name"]?>
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
            $totalshipping = "SELECT COUNT(JobStatus) AS job FROM parcel WHERE JobStatus = '3'";
            $resultshipping = $conn->query($totalshipping);
            $shipping = $resultshipping->fetch_assoc();

            $totaloft = "SELECT COUNT(JobStatus) AS oft FROM parcel WHERE JobStatus = '6'";
            $resultoft = $conn->query($totaloft);
            $delivery = $resultoft->fetch_assoc();

            $totalfail = "SELECT COUNT(JobStatus) AS fail FROM parcel WHERE JobStatus = '8'";
            $resultfail = $conn->query($totalfail);
            $fail = $resultfail->fetch_assoc();

            $totalprob = "SELECT COUNT(JobStatus) AS prob FROM parcel WHERE JobStatus = '13'";
            $resultprob = $conn->query($totalprob);
            $prob = $resultprob->fetch_assoc();

            $totalvehicle = "SELECT COUNT(VehicleID) AS vehicle FROM vehicle;";
            $resultvehicle = $conn->query($totalvehicle);
            $vehicle = $resultvehicle->fetch_assoc();

            $totaldriver = "SELECT COUNT(DriverID) AS driver FROM driver WHERE DriverID > 0";
            $resultdriver = $conn->query($totaldriver);
            $driver = $resultdriver->fetch_assoc();

            $totalparcel = "SELECT COUNT(ParcelID) AS parcel FROM parcel;";
            $resultparcel = $conn->query($totalparcel);
            $parcel = $resultparcel->fetch_assoc();

            $totalassign = "SELECT COUNT(CurrentDriver) AS assign FROM vehicle WHERE CurrentDriver = 0";
            $resultassign = $conn->query($totalassign);
            $assign = $resultassign->fetch_assoc();
        ?>
        <!-- Column Bar -->
        <div class="home-container">
            <div class="detailsec">
                <div class="home-banner"><h3>Job Status</h3></div>
                    <div class="home-column">
                        <div class="home-top">
                            <div class="col-item">
                                <i class="fa-solid fa-truck-fast fa-3x" style="color:#999"></i>
                                <p style="color:#5F9EA0">Parcel on Shipping</p>
                                <p><?php echo $shipping['job']?>
                                <a href="parcel.php?key=Shipping"><span class="fright">Details</span></a></p>
                            </div>
                        </div>
                        <div class="home-top">
                            <div class="col-item">
                                <i class="fa-solid fa-truck fa-3x" style="color:#999"></i>
                                <p style="color:#B8860B">Out For Delivery</p>
                                <p><?php echo $delivery['oft']?>
                                <a href="parcel.php?key=Out"><span class="fright">Details</span></a></p>
                            </div>
                        </div>
                        <div class="home-top">
                            <div class="col-item">
                                <i class="fa-solid fa-circle-xmark fa-3x" style="color:#999"></i>
                                <p style="color:#8FBC8F">Delivery Failed</p>
                                <p><?php echo $fail['fail']?>
                                <a href="parcel.php?key=Failed"><span class="fright">Details</span></a></p>
                            </div>    
                        </div>
                        <div class="home-top">
                            <div class="col-item">
                                <i class="fa-solid fa-triangle-exclamation fa-3x" style="color:#999"></i>
                                <p style="color:#FF8C00">Parcel Problem</p>
                                <p><?php echo $prob['prob']?>
                                <a href="parcel.php?key=Problem"><span class="fright">Details</span></a></p>
                            </div>    
                        </div>
                    </div>
            </div>
            <div class="home-status">
                <div class="home-banner"><h3>Overview</h3></div>
                <div class="home-column">
                        <div class="home-top">
                            <div class="col-item">
                            <i class="fa-solid fa-truck-front fa-3x" style="color:#999"></i>
                                <p style="color:#2E8B57">Total Vehicles</p>
                                <p><?php echo $vehicle['vehicle']?>
                                <a href="vehicles.php?key="><span class="fright">Details</span></a></p>
                            </div>
                        </div>
                        <div class="home-top">
                            <div class="col-item">
                            <i class="fa-solid fa-user fa-3x" style="color:#999"></i>
                                <p style="color:#808000">Total Driver</p>
                                <p><?php echo $driver['driver']?>
                                <a href="driver.php"><span class="fright">Details</span></a></p>
                            </div>
                        </div>
                        <div class="home-top">
                            <div class="col-item">
                            <i class="fa-solid fa-box fa-3x" style="color:#999"></i>
                                <p style="color:#BA55D3">Total Parcel</p>
                                <p><?php echo $parcel['parcel']?>
                                <a href="parcel.php?key="><span class="fright">Details</span></a></p>
                            </div>    
                        </div>
                        <div class="home-top">
                            <div class="col-item">
                            <i class="fa-solid fa-people-group fa-3x" style="color:#999"></i>
                                <p style="color:#20B2AA">Total Available Vehicle</p>
                                <p><?php echo $assign['assign']?>
                                <a href="vehicles.php?key=Assigned"><span class="fright">Details</span></a></p>
                            </div>    
                        </div>
                    </div>
            </div>
        </div>
        <!-- Column Bar End -->
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
        <!-- Awesomefont -->
        <script src="https://kit.fontawesome.com/b2309d5c46.js" crossorigin="anonymous"></script>
    </body>
</html>