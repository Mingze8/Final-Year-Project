<?php
    require 'config.php';
    $sql = "SELECT * FROM `parcel` LEFT JOIN `driver` ON `AssignTo` = `DriverID`";
    $result = $conn->query($sql);

    $key = $_GET["key"];
?>
<html>
    <head>
        <title></title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- CSS -->
        <link rel="stylesheet" href="css\style.css">
        <!-- Boxicon -->        
        <link href='https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css' rel='stylesheet'>
        <!-- ajax JQuery -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <!-- DataTables-->
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
        <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
        <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    
        <!-- Google Geocoding API-->
        <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false&libraries=places&key=AIzaSyDUBKQJzBXoAiqjw4d-6dthaLdzGZZAyng"></script>
        
        <!-- font -->
        <link href='https://fonts.googleapis.com/css?family=Montserrat' rel='stylesheet'>

    </head>
    <body style="background-color:#555">
        <!-- Nav Bar Start -->
        <div class="dashboard" id="resp-dashboard">
        
            <div id="logo"><a><img src="img\adminlogowhite.png" alt="" style="width: 100px"></a></div>
            <a href="index.php"><i class='bx bxs-home' style="background-color: transparent;"></i> Home</a>
            <a href="vehicles.php?key="><i class="fa-solid fa-truck-front" style="background-color: transparent;"></i> Vehicles</a>
            <a href="#" class="active"><i class="fa-solid fa-box" style="background-color: transparent;"></i> Parcels</a>
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

        <!-- Add Parcel PHP Start-->
        <?php

            if(ISSET($_POST["add"])){

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

            //Insert
            $sql = "INSERT INTO `parcel`(`TrackingNum`, `JobType`, `SenderName`, `SenderPhone`, `SenderAddress`, `ReceiverName`, `ReceiverPhone`, `ReceiverAddress`, `Instruction`, `JobStatus`, `latitude`, `longitude`) 
            VALUES ('$track','$type','$sname','$sphone','$saddress','$rname','$rphone','$raddress','$instruction','$status','$lat','$lng')";

            if ($conn->query($sql)===TRUE){
                echo '<script>alert("Parcel had been done insert!")</script>';
            }else{
                echo '<script>alert("Parcel insert failed, Error:")</script>'. $conn->error;
            }

        }
        ?>
        <!-- Add Parcel PHP End -->

        <!-- Column Space Start -->
        <div class="container">
            <div class="column">

            </div>

        
        <!-- Column Space End -->

        <!-- Table Start -->
        <div class="outline">
            <div class="table-container" style="overflow-x: auto;">
                <div class="head" style=""><button class="btn-style-add" id="btn-click"><span id="btn-size"><i class="fa-solid fa-plus" style="background-color: transparent; color:white;"></i><a href="#" class="btn-add"> Add Parcel</a></span></button>
                    <table id="myTable">
                    <thead>
                        <tr>
                            <th>Parcel ID</th>
                            <th>Tracking Number</th>
                            <th>Job Type</th>
                            <th>Sender Name</th>
                            <th>Sender Phone No.</th>
                            <th>Sender Address</th>
                            <th>Receiver Name</th>
                            <th>Receiver Phone No.</th>
                            <th>Receiver Address</th>
                            <th>Parcel Instruction</th>
                            <th>Job Status</th>
                            <th>Assign To</th>
                            <th>Map</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    
                    <tbody>
                    <?php
                        while($rows=$result->fetch_assoc())
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

                        $soutput = $rows['JobStatus'];

                                switch($rows['JobStatus']){
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

                        $driver = $rows['AssignTo'];

                                switch($rows["AssignTo"]){
                                    case "" .$rows["DriverID"]. "":
                                        $driver = "" .$rows["Username"]. "";
                                        break;
                                }
                            
                            
                    ?>    
                        <tr>
                            <td><?php echo $rows['ParcelID'];?></td>
                            <td><?php echo $rows['TrackingNum'];?></td>
                            <td><?php echo $output;?></td>
                            <td><?php echo $rows['SenderName'];?></td>
                            <td><?php echo $rows['SenderPhone'];?></td>
                            <td><?php echo $rows['SenderAddress'];?></td>
                            <td><?php echo $rows['ReceiverName'];?></td>
                            <td><?php echo $rows['ReceiverPhone'];?></td>
                            <td><?php echo $rows['ReceiverAddress'];?></td>
                            <td><?php echo $rows['Instruction'];?></td>
                            <td><?php echo $soutput;?></td>
                            <td><?php echo $driver;?></td>
                            <td><button type="button" id="btn-map" ><a href="desmap.php?did=<?php echo $rows['ParcelID'];?>" style="color:black"><i class='bx bx-map' style="background-color: transparent;"></i></a></button></td>
                            <td>
                                <button type="button" id="assign"><a href="assign.php?id=<?php echo $rows['ParcelID'];?>"><i class="fa-solid fa-user-check" style="background-color: transparent;"></i></a></button>
                                <button type="button" id="edit"><a href="update.php?id=<?php echo $rows['ParcelID'];?>"><i class="fa-solid fa-pen-to-square" style="background-color: transparent;"></a></i></button>
                                <button type="button" id="delete" ><a href="delete.php?id=<?php echo $rows['ParcelID'];?>"><i class='bx bx-trash' style="background-color: transparent;" ></a></i></button>
                            </td>
                        </tr>
                    <?php
                         }
                        
                    ?>  
                    </tbody>
                        
                    </table>
                </div>
            </div>
        </div>
    </div>
    
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

    <!-- Add Parcel Modal Start-->
    <div id="PModalPop" class="modal" >
        <!-- Modal Content -->
        <div class="modal-content">
            <div class="modal-header">
                <span class="close">&times;</span>
                <h2><i class="fas fa-car" style="background-color: transparent;"></i> New Vehicle</h2>
            </div>
            <hr class="breakline">
            <div class="alert">
                <p><i class="fa-solid fa-triangle-exclamation" style="background-color: transparent; color: steelblue;"></i> Please fill out all the field marked with *</p>
            </div>
            <hr class="breakline">
            <div class="modal-body">
                <form action="parcel.php?key=" method="POST">
                    <div class="row">
                        <label for="" class="flabel">Tracking Number</label>
                        <input type="text" class="fans" name="track"><br>
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
                        <input type="text" class="fans" name="sname"><br>
                    </div>
                    <div class="row">
                        <label for="" class="flabel">Sender Phone No.</label>
                        <input type="text" class="fans" name="sphone"><br>
                    </div>
                    <div class="row">
                        <label for="" class="flabel">Sender Address</label>
                        <textarea class="fans" id="" cols="30" rows="10" name="saddress"></textarea>
                    </div>
                    <div class="row">
                        <label for="" class="flabel">Receiver Name</label>
                        <input type="text" class="fans" name="rname"><br>
                    </div>
                    <div class="row">
                        <label for="" class="flabel">Receiver Phone No.</label>
                        <input type="text" class="fans" name="rphone"><br>
                    </div>
                    <div class="row">
                        <label for="" class="flabel">Receiver Address</label>
                        <!--<textarea class="fans" id="" cols="30" rows="10" name="raddress" id="raddress"></textarea>-->
                        <input type="text" class="fans" name="raddress" id="raddress"><br>
                    </div>
                    <div class="row">
                        <label for="" class="flabel">Parcel Instruction</label>
                        <textarea class="fans" id="" cols="30" rows="10" name="instruction"></textarea>
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
                        <input type="submit" value="Add" class="btn-form" name="add">        
                    </div>

                </form>
            </div>
        </div>
    </div>
    <!-- Add Parcel Modal End -->

        <script>
            $(document).ready( function () {
                var table = $('#myTable').DataTable({
                    pagingType: 'full_numbers',
                    pageLength : 5,
                    lengthMenu: [[5, 10, 20],[5, 10, 20]],
                    "search":{
                        "search": "<?php echo $key?>"
                    }
            } );
        } );
    
        </script>

        <!-- Vehicles Table End -->
        <!-- Awesomefont -->
        <script src="https://kit.fontawesome.com/b2309d5c46.js" crossorigin="anonymous"></script>
        <script src="js\singlemodal.js"></script>

    </body>
</html>