<?php
    require 'config.php';
    $ID = $_GET["id"];
?>  
<html>
    <head>
        <title></title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="css/styles.css">
        <link href='https://fonts.googleapis.com/css?family=Montserrat' rel='stylesheet'>
        <link href='https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css' rel='stylesheet'>

    </head>
    <body style="background-color:#555;">
    <?php
        if(ISSET($_POST["assign"])){
            $id = $_POST["id"];

            $sqlrun = "SELECT * FROM `parcel` WHERE `JobStatus` = '6' AND `ParcelID` = '$ID'";
            $resultrun = $conn->query($sqlrun);
            if($resultrun->num_rows>0){
                $update = "UPDATE `parcel` SET `AssignTo`='$id' WHERE `ParcelID` = '$ID'";
            
                if($conn->query($update)===TRUE){
                    header("Location:parcel.php?key=");
                }else{
                    header("Location:assign.php?id=".$ID."&error=Update Fail!");
                }
            }else{
                echo "<div class='msgalert'>This parcel cannot be assign to driver yet</div>";
            }
            
        }

        if(ISSET($_POST["unassign"])){
            $update2 = "UPDATE `parcel` SET `AssignTo` = NULL WHERE `ParcelID` = '$ID'";

            if($conn->query($update2)===TRUE){
                header("Location:parcel.php?key=");
            }else{
                header("Location:assign.php?id=".$ID."&error=Update Fail!");
            }
        }
    ?>
    <!-- Nav Bar Start -->
    <div class="dashboard" id="resp-dashboard">
        
        <div id="logo"><a><img src="img\adminlogowhite.png" alt="" style="width: 100px"></a></div>
        <a href="index.php"><i class='bx bxs-home' style="background-color: transparent;"></i> Home</a>
        <a href="vehicles.php?key="><i class="fa-solid fa-truck-front" style="background-color: transparent;"></i> Vehicles</a>
        <a href="parcel.php?key=" class="navactive"><i class="fa-solid fa-box" style="background-color: transparent;"></i> Parcels</a>
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
    <?php
        $sql = "SELECT * FROM `parcel` WHERE `ParcelID` = '$ID'";
        $result = $conn->query($sql);
        while($row=$result->fetch_assoc())
        {
            $output = $row['JobType'];

                            switch($row["JobType"]){
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

                        $soutput = $row['JobStatus'];

                                switch($row['JobStatus']){
                                    case "1":
                                        $soutput = "Pending Pickup";
                                        break;
                                    case "2":
                                        $soutput = "Parcel Picked Up";
                                        break;
                                    case "3":
                                        $soutput = "Shipping";
                                        break;
                                    case "4":
                                        $soutput = "Arrive Warehouse";
                                        break;
                                    case "5":
                                        $soutput = "In Progress";
                                        break;
                                    case "6":
                                        $soutput = "Out For Delivery";
                                        break;
                                    case "7":
                                        $soutput = "Completed";
                                        break;
                                    case "8":
                                        $soutput = "Delivery Failed";
                                        break;
                                    case "9":
                                        $soutput = "Returned to Hub";
                                        break;
                                    case "10":
                                        $soutput = "Delivery Rescheduled";
                                        break;
                                    case "11":
                                        $soutput = "Cancelled";
                                        break;
                                    case "12":
                                        $soutput = "Returned to Sender";
                                        break;
                                    case "13":
                                        $soutput = "Parcel Problem";
                                        break;
                                }
    ?>
    <!-- Nav Bar End-->
        <div class="a-container">
            <div class="a-header"><b>Parcel Details</b></div>
            <hr style="margin: 10px">
            <div class="a-details">
                <p>Tracking Number : <span><?php echo $row["TrackingNum"]?></span></p>
                <table>
                    <tr>
                        <td>Job Type: <span><?php echo $output?></span></td>
                        <td>Job Status: <span><?php echo $soutput?></span></td>
                    </tr>
                    <tr>
                        <td>Sender Name: <span><?php echo  $row["SenderName"]?></span></td>
                        <td>Receiver Name: <span><?php echo  $row["ReceiverName"]?></span></td>
                    </tr>
                    <tr>
                        <td>Sender Address: <span><?php echo  $row["SenderAddress"]?></span></td>
                        <td>Receiver Address: <span><?php echo  $row["ReceiverAddress"]?></span></td>
                    </tr>
                    <tr>
                        <td colspan="2" style="text-align:center">Parcel Instruction: </td>
                    </tr>
                    <tr>
                        <td colspan="2" style="text-align:center"><span><?php echo  $row["Instruction"]?></span></td>
                    </tr>
                </table>
            </div>
            <hr style="margin: 10px">
            <div class="a-header2"><b>Assign a Driver</b></div>
            <div class="d-container">
            <?php
                $assign = "SELECT * FROM `vehicle` RIGHT JOIN `driver` ON CurrentDriver = DriverID;";
                $rassign = $conn->query($assign);
                while($lr=$rassign->fetch_assoc())
                {

                    $sw = $lr['Status'];

                    switch($lr["Status"]){
                        case "0":
                            $sw = "Not Working";
                            break;
                        case "1":
                            $sw = "Out For Delivery";
                            break;
                        case "2":
                            $sw = "Lunch Break";
                            break;
                    }

                    $vt = $lr["VehicleType"];

                    switch($lr["VehicleType"]){
                        case "1":
                            $vt = "Car";
                            break;
                        case "2":
                            $vt = "Motorcycle";
                            break;
                        case "3":
                            $vt = "Van";
                            break;
                        case "4":
                            $vt = "Truck";
                            break;
                    }

                    $state = "off";

                    if($lr["Status"] == "1"){
                        $state = "working";
                    }elseif($lr["Status"] == "2"){
                        $state = "break";
                    }else{
                        $state = "off";
                    }
            ?>
            <button type="button" class="collapsible <?php echo $state?>"><?php echo $lr["Username"]?></button>
            <div class="content">
                <h3 style="text-align:center"><?php echo $sw?></h3>
                <hr>
                <div class="flexcol">
                    <div class="leftcol">
                        <p>Vehicle Type</p>
                        <div class="jobcard">
                            <p class="detailp"><span><?php echo $vt?></span></p>
                        </div> 
                    </div>
                    <div class="rightcol">
                        <p>Car Plate</p>
                            <div class="jobcard">
                                <p><span><?php echo $lr["CarPlate"]?></span></p>
                            </div>  
                        
                    </div>
                </div>
                <div class="introcol">
                    <p style="text-align:center">Notes</p>
                        <div class="jobcard">
                            <p class="con" style="text-align:center"><?php echo $lr["note"]?></p>
                        </div>
                </div>    
                <div class="job-button">
                    <form action="" method="POST">
                        <input type="hidden" name="id" value="<?php echo $lr["DriverID"]?>">
                        <input type="submit" class="map" name="assign" value="Assign To">
                    </form>
                </div>
            </div>
            <?php
                }
            ?>
            <div class="a-header3" style="text-align:center"> <b>OR</b> </div>
                <div class="job-button2">
                    <form action="" method="POST">
                    <input type="submit" class="map" name="unassign" value="Unassign a Driver">
                    </form>
                </div>
            </div>
        </div>

        <?php
        }
        ?>
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
        <script>
            var coll = document.getElementsByClassName("collapsible");
            var i;

            for(i = 0; i < coll.length; i++){
                coll[i].addEventListener("click",function(){
                    this.classList.toggle("active");
                    var content = this.nextElementSibling;
                    if(content.style.maxHeight){
                        content.style.maxHeight = null;
                    }else{
                        content.style.maxHeight = content.scrollHeight + "px";
                    }
                });
            }
        </script>
        <script src="https://kit.fontawesome.com/b2309d5c46.js" crossorigin="anonymous"></script>
    </body>
</html>