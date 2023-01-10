<?php
    require 'config.php';
    $mid = $_GET["mid"];
    //$sql = "SELECT * FROM `vehicle` WHERE `VehicleID` = '$mid'";
    $sql = "SELECT * FROM `driver` LEFT JOIN `vehicle` ON DriverID = CurrentDriver WHERE `VehicleID` = '$mid'";
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
            <a href="vehicles.php?key=" class="active"><i class="fa-solid fa-truck-front" style="background-color: transparent;"></i> Vehicles</a>
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
            while($row=$result->fetch_Assoc()){

                $cd = $row["CurrentDriver"];

                switch($row["CurrentDriver"]){
                    case "" .$row["CurrentDriver"]."":
                        $cd = "" .$row["Username"]."";
                        break;
                }
        ?>
        <div class="detailtab"> 
             <p><B>Driver Name : <span><?php echo $cd;?></span> | Car Plate : <span><?php echo $row["CarPlate"]?></span></b></p>
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

                    var origin = {lat: <?php echo $row["Latitude"]?> , lng: <?php echo $row["Longtitude"]?>};

                    //Center of the map
                    const options = {zoom: 15, center: origin, styles: mapStyles};

                    //Create map
                    map = new google.maps.Map(
                        document.getElementById('map'),options);

                    
                    var markerorigin = new google.maps.Marker({
                        position:origin,
                        map : map,
                        icon: 'img/deliveryicon.png',
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