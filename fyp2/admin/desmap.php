<?php
    require 'config.php';
    $did = $_GET["did"];
    //$sql = "SELECT * FROM `vehicle` WHERE `VehicleID` = '$mid'";
    $sql = "SELECT * FROM `driver` RIGHT JOIN `parcel` ON DriverID = AssignTo WHERE `ParcelID` = '$did';";
    $result = $conn->query($sql);
?>
<html>
    <head>
    <title></title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- CSS -->
        <link type="text/css" rel="stylesheet" href="css\style.css">
        <!-- Boxicon -->        
        <link href='https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css' rel='stylesheet'>
        <link href='https://fonts.googleapis.com/css?family=Montserrat' rel='stylesheet'>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    </head>
    <body>
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
            while($row=$result->fetch_assoc())
            {

                if($row["Username"]==""){
                    $output = "The parcel is not assigned to any driver yet";
                }else{
                    $output = "The parcel is assigned to ".$row["Username"];
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
        <div class="detailtab"> 
            <p><b> <?php echo $output?> and the parcel is currently <?php echo $soutput;?></b></p>
        </div>
        <!-- Map Section -->
        <div class="map" id="section-map">
            <div id="info"></div>
                <div id="map"></div>
            <script>
                
                var map;
                function initMap(){
                    
                    var mapStyles = [{
                        featureType: "all",
                        elementType: "labels",
                        stylers: [{
                            visibility: ""
                        }]
                    }];

                    var destination = {lat: <?php echo $row["latitude"]?> , lng: <?php echo $row["longitude"]?>};

                    //Center of the map
                    const options = {zoom: 15, center: destination, styles: mapStyles};

                    //Create map
                    map = new google.maps.Map(
                        document.getElementById('map'),options);

                    
                    var markerorigin = new google.maps.Marker({
                        position:destination,
                        map : map,
                        icon: 'img/homeicon.png',
                        animation: google.maps.Animation.BOUNCE
                    });

                    
                }
            </script>   
            <script src='//maps.googleapis.com/maps/api/js?key=AIzaSyDUBKQJzBXoAiqjw4d-6dthaLdzGZZAyng&callback=initMap' async defer></script>

        </div>
    </div>
    <?php
            }
    ?>
        
        <!-- Map Section End-->
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