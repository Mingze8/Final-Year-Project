<?php
    require 'config.php';
    $ve = $_GET["ve"];
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
    <!-- Nav Bar Start -->
    <div class="dashboard" id="resp-dashboard">
        
        <div id="logo"><a><img src="img\adminlogowhite.png" alt="" style="width: 100px"></a></div>
        <a href="index.php"><i class='bx bxs-home' style="background-color: transparent;"></i> Home</a>
        <a href="vehicles.php?key=" class="navactive"><i class="fa-solid fa-truck-front" style="background-color: transparent;"></i> Vehicles</a>
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
        if(ISSET($_POST["assignto"])){
            $did = $_POST["did"];

            $sql = "SELECT * FROM `vehicle` WHERE `Status` = '0' AND `VehicleID` = '$ve';";
            $result = $conn->query($sql);
            if($result->num_rows>0){
                $preupdate = "UPDATE `vehicle` SET `CurrentDriver`= NULL WHERE `CurrentDriver` = '$did'";
                if($conn->query($preupdate)===TRUE){
                    echo "";
                }else{
                    echo "error";
                }

                $update = "UPDATE `vehicle` SET `CurrentDriver`='$did' WHERE `VehicleID` = '$ve'";

                if($conn->query($update)===TRUE){
                    header("Location:vehicles.php?key=");
                }else{
                    header("Location:vassign.php?ve=".$ve."&error=Update Fail!");
                }
            }else{
                echo "<div class='msgalert'>This Vehicle is currently on use</div>";
            }
            
        }

        if(ISSET($_POST["unassign"])){
            $update2 = "UPDATE `vehicle` SET `CurrentDriver` = NULL WHERE `VehicleID` = '$ve'";

            if($conn->query($update2)===TRUE){
                header("Location:vehicles.php?key=");
            }else{
                header("Location:vassign.php?id=".$ve."&error=Update Fail!");
            }
        }
    ?>
    <?php
        $sql = "SELECT * FROM `driver` RIGHT JOIN `vehicle` ON DriverID = CurrentDriver WHERE `VehicleID` = '$ve'";
        $result = $conn->query($sql);
        while($row=$result->fetch_assoc())
        {
            $vt = $row["VehicleType"];

                    switch($row["VehicleType"]){
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
            
            $status = $row["Status"];

                switch($row["Status"]){
                    case "0":
                        $status = "Not Working";
                        break;
                    case "1":
                        $status = "Out For Delivery";
                        break;
                    case "2":
                        $status = "Lunch Break";
                        break;
                }

            $cd = $row["CurrentDriver"];

                switch($row["CurrentDriver"]){
                    case "" .$row["CurrentDriver"]."":
                        $cd = "" .$row["Username"]."";
                        break;
                }
                
    ?>
        <div class="a-container">
            <div class="a-header"><b>Vehicle Details</b></div>
            <hr style="margin: 10px">
            <div class="a-details">
                <p>Car Plate : <span><?php echo $row["CarPlate"];?></span></p>
                <table>
                    <tr>
                        <td>Car Type : <span><?php echo $vt;?></span></td>
                        <td>Current Driver : <span><?php echo $cd;?></span></td>
                    </tr>
                    <tr>
                        <td>Current Status : <span><?php echo  $status;?></span></td>
                        <td>Note for Status : <span><?php echo  $row["note"]?></span></td>
                    </tr>
                </table>
            </div>
            <hr style="margin: 10px">
            <div class="a-header2"><b>Assign to a Driver</b></div>
            <div class="d-container">
            <?php
                $assign = "SELECT * FROM `driver` LEFT JOIN `vehicle` ON DriverID = CurrentDriver AND DriverID > 1;";
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

                    switch($lr["Status"]){
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
            <form action="" method="POST">
                <input type="hidden" name="did" value="<?php echo $lr["DriverID"];?>">
                <input type="submit" name="assignto" class="a-collapsible <?php echo $state?>" value="<?php echo $lr["Username"]?>">
            </form>
            
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