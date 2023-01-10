<?php
    require 'config.php';
    require 'gps.php';
    
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
        <link href='https://fonts.googleapis.com/css?family=Montserrat' rel='stylesheet'>
    </head>
    <body style="background-color:#555">
        <!-- Nav Bar Start -->
        <div class="dashboard" id="resp-dashboard">
        
            <div id="logo"><a><img src="img\drivericonwhite.png" alt="" style="width: 100px"></a></div>
            <a href="index.php"><i class='bx bxs-home' style="background-color: transparent;"></i> Home</a>
            <a href="" class="navactive"><i class="fa-solid fa-briefcase"></i> My Job</a>
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
        <!-- Collapsible -->
        <?php
            $totalassign = "SELECT COUNT(AssignTo) AS job FROM parcel WHERE `JobStatus` = '6' AND AssignTo =" . $_SESSION['driver'];
            $result = $conn->query($totalassign);
            $value = $result->fetch_assoc();
        ?>
       
        <div class="container">
            <div class="job-topbar">
                <p><?php echo "Total Assigned Jobs : " . $value['job'];?></p>
                <hr>
            </div>
        <?php
            /*sql = "SELECT * FROM `parcel` WHERE `AssignTo` = " . $_SESSION['driver'];
            $result = $conn->query($sql);*/

            $sql = "SELECT parcel.* , vehicle.latitude AS vla, vehicle.Longtitude AS vlo, vehicle.CurrentDriver FROM parcel LEFT JOIN vehicle 
            ON parcel.AssignTo = vehicle.CurrentDriver WHERE JobStatus = '6' AND CurrentDriver = " . $_SESSION['driver'];
            $result = $conn->query($sql);

            while($rows=$result->Fetch_assoc())
            {

            $output = $rows['JobType'];

                switch($rows["JobType"]){
                    case "1":
                        $output = "Standard Delivery";
                        break;
                    case "2":
                        $output = "Express Delivery";
                        break;
                    case "3":
                        $output = "International Delivery";
                        break;
                }

                $status = "Off";
                if($rows["DeliveryNow"] == "1"){
                    $status = "On";
                }elseif($rows["DeliveryNow"] == "0"){
                    $status = "Off";
                }
        ?>    
            <button type="button" class="collapsible <?php echo $status ?>"><?php echo $rows['TrackingNum'];?></button>
            <div class="content">
                <h3><?php echo $output;?></h3>
                <hr>
                <div class="flexcol">
                    <div class="leftcol">
                        <p>Sender Details</p>
                        <div class="jobcard">
                            <p class="detailp"><i class="fa-solid fa-user"></i> <span><?php echo $rows['SenderName'];?></span></p>
                            <p class="detailp"><i class="fa-solid fa-phone"></i> <span><?php echo $rows['SenderPhone'];?></span></p>
                            <p class="detailp"><i class="fa-solid fa-location-dot"></i> <span><?php echo $rows['SenderAddress'];?></span></p>
                        </div> 
                    </div>
                    <div class="rightcol">
                        <p>Receiver Details</p>
                            <div class="jobcard">
                                <p><i class="fa-solid fa-user"></i> <span><?php echo $rows['ReceiverName'];?></span></p>
                                <p><i class="fa-solid fa-phone"></i> <span><?php echo $rows['ReceiverPhone'];?></span></p>
                                <p><i class="fa-solid fa-location-dot"></i> <span><?php echo $rows['ReceiverAddress'];?></span></p>
                            </div>  
                        
                    </div>
                </div>
                <div class="introcol">
                    <p>Instruction</p>
                        <div class="jobcard">
                            <p class="con"><?php echo $rows['Instruction'];?></p>
                        </div>
                </div>    
                <div class="job-button">
                    <a href="map.php?id=<?php echo $_SESSION['driver'];?>&pid=<?php echo $rows["ParcelID"];?>"><button class="cstatus">View Map</button></a>

                    <a href="updatestatus.php?id=<?php echo $rows['ParcelID'];?>"><button class="cstatus">Change Status</button></a>
                    <a href="add.php?id=<?php echo $rows['ParcelID']?>"><button class="next">Delivery Now</button></a>
                </div>
            </div>
        <?php
            }
        ?>   
        </div>
        <!-- Collapsible End-->
        

        </div>
        <script src="js\func.js"></script>
        <!-- Awesomefont -->
        <script src="https://kit.fontawesome.com/b2309d5c46.js" crossorigin="anonymous"></script>
    </body>
</html>