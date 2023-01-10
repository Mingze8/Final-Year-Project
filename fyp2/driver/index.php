<?php
    require 'config.php';
    require 'gps.php';
    $did = $_SESSION["driver"];

    if(!ISSET($_SESSION["driver"])){
        header("Location:login.php");
    }

    if(ISSET($_POST["update"])){
        $status = $_POST["status"];
        $note = $_POST["note"];

        $sqlcheck = "SELECT * FROM `vehicle` WHERE `CurrentDriver` =" .$_SESSION["driver"];
        $checkresult = $conn->query($sqlcheck);
        if($checkresult->num_rows>0){
            $sql = "UPDATE `vehicle` SET `Status`='$status', `note`='$note' WHERE `CurrentDriver` =" .$_SESSION["driver"]; 
        
            if($conn->query($sql)===TRUE){
                header("location:index.php");
            }else{
                header("location:status.php?id=".$ID."&error=Update Fail!");
            }
        }else{
            echo "You cannot start work now!";
        }
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
    <body>
        <!-- Nav Bar Start -->
        <div class="dashboard" id="resp-dashboard">
        
            <!--<div id="logo"><a>TrackNow</a></div>-->
            <div id="logo"><a><img src="img\drivericonwhite.png" alt="" style="width: 100px"></a></div>
            <a href="" class="navactive"><i class='bx bxs-home' style="background-color: transparent;"></i> Home</a>
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
        <!-- Column Bar -->
        <?php
        $sqlmsg = "SELECT COUNT(AssignTo) AS did FROM `parcel` WHERE `JobStatus` = '6' AND `AssignTo` =".$_SESSION["driver"];
        $result = $conn->query($sqlmsg);
        $value = $result->fetch_assoc();
        if($result->num_rows>0){
            $alert = "<i class='fa-solid fa-bell'></i> You have ".$value['did']." parcel assign to you for delivery";
        }
        
        ?>
        <?php
            //$sql = "SELECT `Status`, `CarPlate` FROM `vehicle` WHERE `CurrentDriver` = " . $_SESSION["driver"];
            $sql = "SELECT * FROM vehicle right join driver ON CurrentDriver = DriverID AND DriverID = '$did' limit 1";
            $result = $conn->query($sql);

            while($rows=$result->fetch_assoc())
            {   

                $statusp = $rows['Status'];

                switch($rows['Status']){
                    
                    case "":
                        $statusp = "Unassigned Vehicle";
                        break;
                    case "0":
                        $statusp = "Not Working";
                        break;
                    case "1":
                        $statusp = "Out For Delivery";
                        break;
                    case "2":
                        $statusp = "Lunch Break";
                        break;
                }

                $carplate = $rows["CarPlate"];

                switch($rows["CarPlate"]){
                    case "":
                        $carplate = "Unassigned Vehicle";
                        break;
                }

            
                $totalava = "SELECT COUNT(AssignTo) AS did FROM `parcel` WHERE `AssignTo` is null";
                $resultava = $conn->query($totalava);
                $ava = $resultava->fetch_assoc();

                $totald = "SELECT COUNT(AssignTo) AS d FROM `parcel` WHERE `AssignTo` =" .$_SESSION["driver"];
                $resultd = $conn->query($totald);
                $d = $resultd->fetch_assoc();

                $totalc = "SELECT COUNT(AssignTo) AS c FROM `parcel` WHERE `JobStatus` = '7' AND `AssignTo` =" .$_SESSION["driver"];
                $resultc = $conn->query($totalc);
                $c = $resultc->fetch_assoc();
        ?>
        <div class="container-home">
            <div class="alert">
                <?php echo $alert?>
            </div>  

            <div class="detailbar">
                <div class="statusbar">
                    <h3>Current Status</h3>
                    <input type="text" id="status" readonly value="<?php echo $statusp?>" style="pointer-events:none">
                    <button class="edit" id="myBtn"><i class="fa-solid fa-pen"></i></button>
                </div>
                <div class="vehiclebar">
                    <h3>Your Vehicle</h3>
                    <input type="text" id="vehicle" readonly value="<?php echo $carplate?>" style="pointer-events:none">
                </div>
            </div>

            <div class="statistic">
                <div class="torder">
                    <div class="stext">
                        <i class='bx bx-bar-chart-alt-2 icon-large bx-lg' style="color:#999"></i>    
                        <div class="value">
                            <h3>Total Parcel Available</h3>
                            <p><?php echo $ava["did"]?></p>
                        </div>
                    </div>      
                </div>
                <div class="rorder">
                    <div class="stext">
                        <i class='bx bx-line-chart bx-lg' style="color:#999"></i>
                        <div class="value">
                            <h3>Total Parcel On Hold</h3>
                            <p><?php echo $d["d"]?></p>
                        </div>
                    </div>
                </div>
                <div class="corder">
                    <div class="stext">
                        <i class='bx bxs-pie-chart-alt-2 bx-lg' style="color:#999"></i>
                        <div class="value">
                            <h3>Total Parcel Completed</h3>
                            <p><?php echo $c["c"]?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
            }
        ?>
        <!-- The Modal -->
        <div id="myModal" class="modal">

        <!-- Modal content -->
        <div class="modal-content">
            <div class="modal-header">
            <span class="close">&times;</span>
            <h2>Change Status</h2>
            <hr style="margin:20 0 0 0">
            </div>
            <div class="modal-body">
                <form action="" method="POST">
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

        </div>
        <script>
        // Get the modal
        var modal = document.getElementById("myModal");

        // Get the button that opens the modal
        var btn = document.getElementById("myBtn");

        // Get the <span> element that closes the modal
        var span = document.getElementsByClassName("close")[0];

        // When the user clicks the button, open the modal 
        btn.onclick = function() {
        modal.style.display = "block";
        }

        // When the user clicks on <span> (x), close the modal
        span.onclick = function() {
        modal.style.display = "none";
        }

        // When the user clicks anywhere outside of the modal, close it
        window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
        }
        </script>
        <!-- Column Bar End -->
        <script src="js\func.js"></script>
        <!-- Awesomefont -->
        <script src="https://kit.fontawesome.com/b2309d5c46.js" crossorigin="anonymous"></script>
    </body>
</html>