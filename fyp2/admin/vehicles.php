<?php
    require 'config.php';
    $sql = "SELECT vehicle.*, driver.DriverID AS DID, driver.Username AS name FROM vehicle LEFT JOIN driver ON vehicle.CurrentDriver = driver.DriverID;";
    $result = $conn->query($sql);
    
    $key = $_GET["key"];
?>
<html>
    <head>
        <title></title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- CSS -->
        <link type="text/css" rel="stylesheet" href="css\style.css">
        <!-- Boxicon -->        
        <link href='https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css' rel='stylesheet'>
        <!-- DataTables-->
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
        <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
        <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
        <link href='https://fonts.googleapis.com/css?family=Montserrat' rel='stylesheet'>
    </head>
    <body style="background-color:#555">
        <!-- Nav Bar Start -->
        <div class="dashboard" id="resp-dashboard">
        
            <div id="logo"><a><img src="img\adminlogowhite.png" alt="" style="width: 100px"></a></div>
            <a href="index.php"><i class='bx bxs-home' style="background-color: transparent;"></i> Home</a>
            <a href="#" class="active"><i class="fa-solid fa-truck-front" style="background-color: transparent;"></i> Vehicles</a>
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

        <!-- Add Vehicle PHP Start -->
        <?php
            if(ISSET($_POST["add"])){

            $carplate = $_POST["carplate"];
            $type = $_POST["type"];

            //Insert
            $sql = "INSERT INTO `vehicle`(`CarPlate`,`VehicleType`)
            VALUE ('$carplate','$type')";

            if($conn->query($sql)===TRUE){
                echo '<script>alert("Vehicles had been done insert!")</script>';
            }else{
                echo '<script>alert("Vehicle insert failed, Error:")</script>'.$conn->error;
            }
            }
        ?>
        <!-- Add Vehicle PHP End -->    

        <!-- Column Space Start -->
        <div class="container">
            <div class="column">

            </div>

        
        <!-- Column Space End -->

        <!-- Vehicles Table Start -->
        <div class="outline">
            <div class="table-container" style="overflow-x: auto;">
                <div class="head" style="width: 100%">
                    <button class="btn-style-add"><span id="btn-size"><i class="fa-solid fa-plus" style="background-color: transparent; color:white;"></i><a href="#" class="btn-add" id="btn-add"> Add Vehicle</a></span></button>
                    <table id="myTable">
                        <thead>
                            <tr>
                                <th>Vehicle ID</th>
                                <th>Driver Username</th>
                                <th>Car Plate</th>
                                <th>Vehicle Type</th>
                                <th>Status</th>
                                <th>Notes for status</th>
                                <th>Last Location</th>
                                <th>Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                            while($rows=$result->fetch_assoc())
                            {
                                $output = $rows['CurrentDriver'];

                                switch($rows["CurrentDriver"]){
                                    case "".$rows["DID"]."":
                                        $output = "".$rows["name"]."";
                                        break;
                                }

                                $sw = $rows['Status'];

                                switch($rows["Status"]){
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

                                $vt = $rows["VehicleType"];

                                switch($rows["VehicleType"]){
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
                        ?>
                            <tr>
                                <td><?php echo $rows['VehicleID'];?></td>
                                <td><?php echo $output;?></td>
                                <td><?php echo $rows['CarPlate'];?></td>
                                <td><?php echo $vt;?></td>
                                <td><?php echo $sw;?></td>
                                <td><?php echo $rows['note']?></td>
                                <td><button type="button" id="btn-map" ><a href="map.php?mid=<?php echo $rows['VehicleID']?>" style="color:black"><i class='bx bx-map' style="background-color: transparent;"></i></button></a></td>
                                <td>
                                <button type="button" id="edit"><a href="assignv.php?ve=<?php echo $rows['VehicleID'];?>"><i class="fa-solid fa-pen-to-square" style="background-color: transparent;"></i></a></button>
                                <button type="button" id="delete"><a href="vdelete.php?vid=<?php echo $rows['VehicleID']?>"><i class='bx bx-trash' style="background-color: transparent;" ></i></a></button>
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
    <!-- Table End -->

     <!-- Add Vehicle Modal Start-->
     <div id="VModalPop" class="modal">
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
                <form action="vehicles.php?key=" method="POST">
                    <div class="row">
                        <label for="" class="flabel">Car Plate</label>
                        <input type="text" class="fans" name="carplate" required><br>
                    </div>
                    <div class="row">
                        <label for="" class="flabel">Vehicle Type</label>
                        <select name="type" id="" class="fans">
                            <option value="1">Car</option>
                            <option value="2">Motorcycle</option>
                            <option value="3">Van</option>
                            <option value="4">Truck</option>
                        </select>
                        <br>
                    </div>
                    <hr class="breakline">
                    <div class="footer">
                        <input type="submit" value="Add" class="btn-form" name="add">        
                    </div>

                </form>
            </div>
        </div>
    </div>
    <!-- Add Vehicle Modal End -->

    <?php
            
            $sql = "SELECT * FROM `group`";
            //$result2 = $conn->query($sql);

            //while($rows=$result2->fetch_assoc()){
             //   echo $rows['GroupLeaderID'] . "<br>";

            $result2 = mysqli_query($conn,$sql);
            
    ?>

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
        <script src="js\func.js"></script>


    </body>
</html>