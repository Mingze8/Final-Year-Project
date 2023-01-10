<?php
    require 'config.php';

    $ID = $_GET["id"];
?>
<html>
    <head>
        <title></title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="css/style.css">
        <link href='https://fonts.googleapis.com/css?family=Montserrat' rel='stylesheet'>
        <link href='https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css' rel='stylesheet'>
        <!-- ajax JQuery -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <!-- Google Geocoding API-->
        <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false&libraries=places&key=AIzaSyDUBKQJzBXoAiqjw4d-6dthaLdzGZZAyng"></script>
    </head>
    <body style="background-color:#555">
        <!-- Nav Bar Start -->
        <div class="dashboard" id="resp-dashboard">
        
            <div id="logo"><a><img src="img\adminlogowhite.png" alt="" style="width: 100px"></a></div>
            <a href="index.php"><i class='bx bxs-home' style="background-color: transparent;"></i> Home</a>
            <a href="vehicles.php?key="><i class="fa-solid fa-truck-front" style="background-color: transparent;"></i> Vehicles</a>
            <a href="parcel.php?key=" class="active"><i class="fa-solid fa-box" style="background-color: transparent;"></i> Parcels</a>
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
            if(ISSET($_POST["update"])){

                $track = $_POST["track"];
                $type = $_POST["type"];
                $sname = $_POST["sname"];
                $sphone = $_POST["sphone"];
                $saddress = $_POST["saddress"];
                $rname = $_POST["rname"];
                $raddress = $_POST["raddress"];
                $rphone = $_POST["rphone"];
                $instruction = $_POST["instruction"];
                $status = $_POST["status"];
                $lat = $_POST["lat"];
                $lng = $_POST["lng"];

                //Update
                $sql = "UPDATE `parcel` SET `TrackingNum`='$track',`JobType`='$type',`SenderName`='$sname',`SenderPhone`='$sphone',`SenderAddress`='$saddress',`ReceiverName`='$rname',`ReceiverPhone`='$rphone',`ReceiverAddress`='$raddress',`Instruction`='$instruction',`JobStatus`='$status',`latitude`='$lat', `longitude`='$lng' WHERE `ParcelID` = '$ID'";
                
                if($conn->query($sql)===TRUE){
                    header("Location:parcel.php?key=");
                }else{
                    header("Location:update.php?id=".$ID."&error=Update Fail!");
                }
            }
            $sql = "SELECT * FROM `parcel` WHERE `ParcelID` = '$ID'";
            $result = $conn->query($sql);
            $row = $result->fetch_assoc();
        ?>
    <!-- Geocoding Section -->
        <script>
            $(document).ready(function(){
                var autocomplete;
                var id="raddress";

                autocomplete = new google.maps.places.Autocomplete((document.getElementById(id)),{
                    types:[/*'establishment', 'geocode'*/],
                })

                google.maps.event.addListener(autocomplete, 'place_changed', function(){
                    var place = autocomplete.getPlace();
                    jQuery("#lat").val(place.geometry.location.lat());
                    jQuery("#long").val(place.geometry.location.lng());
                })
            })
        </script>
    <!-- Geocoding Section End -->
        <div class="up-modal-content">
            <div class="modal-header">
                <h2><i class="fa-solid fa-box"></i>  Edit Parcel Information</h2>
            </div>
            <hr class="breakline">
            <div class="alert">
                <p><i class="fa-solid fa-triangle-exclamation" style="background-color: transparent; color: steelblue;"></i> Please enter the value required * </p>
            </div>
            <hr class="breakline">
            <div class="modal-body">
                <form action="update.php?id=<?php echo $ID; ?>" method="POST">
                    <div class="row">
                        <label for="" class="flabel">Tracking Number</label>
                        <input type="text" class="fans" name="track" value="<?php echo $row["TrackingNum"]?>"><br>
                    </div>
                    <div class="row">
                        <label for="" class="flabel">Job Type</label>
                        <select name="type" id="" class="fans">
                            <option value="1">Standard Delivery</option>
                            <option value="2">Express Delivery</option>
                            <option value="3">International Delivery</option>
                        </select>
                    </div>
                    <div class="row">
                        <label for="" class="flabel">Sender Name</label>
                        <input type="text" class="fans" name="sname" value="<?php echo $row["SenderName"]?>"><br>
                    </div>
                        <div class="row">
                        <label for="" class="flabel">Sender Phone No.</label>
                        <input type="text" class="fans" name="sphone" value="<?php echo $row["SenderPhone"]?>"><br>
                    </div>
                        <div class="row">
                            <label for="" class="flabel">Sender Address</label>
                            <textarea class="fans" id="" cols="30" rows="10" name="saddress"><?php echo $row["SenderAddress"]?></textarea>
                    </div>
                    <div class="row">
                        <label for="" class="flabel">Receiver Name</label>
                        <input type="text" class="fans" name="rname" value="<?php echo $row["ReceiverName"]?>"><br>
                    </div>
                    <div class="row">
                        <label for="" class="flabel">Receiver Phone No.</label>
                        <input type="text" class="fans" name="rphone" value="<?php echo $row["ReceiverPhone"]?>"><br>
                    </div>
                    <div class="row">
                        <label for="" class="flabel">Receiver Address</label>
                        <input type="text" class="fans" name="raddress" id="raddress" required><br>                    
                    </div>
                    <div class="row">
                        <label for="" class="flabel">Parcel Instruction</label>
                        <textarea class="fans" id="" cols="30" rows="10" name="instruction"><?php echo $row["Instruction"]?></textarea>
                    </div>
                    <div class="row">
                        <label for="" class="flabel">Job Status</label>
                        <select name="status" id="" class="fans">
                            <option value="1">Pending Pickup</option>
                            <option value="2">Parcel Picked Up</option>
                            <option value="3">Shipping</option>
                            <option value="4">Arrive Warehouse</option>
                            <option value="5">In Progress</option>
                            <option value="6">Out For Delivery</option>
                            <option value="7">Completed</option>
                            <option value="8">Delivery Failed</option>
                            <option value="9">Returned to Hub</option>
                            <option value="10">Delivery Rescheduled</option>
                            <option value="11">Cancelled</option>
                            <option value="12">Returned to Sender</option>
                            <option value="13">Parcel Problem</option>
                        </select>
                    </div>
                    <input type="hidden" id="lat" name="lat"/>
                    <input type="hidden" id="long" name="lng"/>
                    <hr class="breakline">
                    <div class="footer">
                        <input type="submit" value="Update" class="up-btn-form" name="update">        
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
        <script src="https://kit.fontawesome.com/b2309d5c46.js" crossorigin="anonymous"></script>

    </body>
</html>