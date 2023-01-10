<?php
    require 'config.php';
    require 'gps.php';

    $id = $_GET["id"];
    $pid = $_GET["pid"];
    $sql = "SELECT `ParcelID`, `latitude`, `longitude` FROM `parcel` WHERE `AssignTo` = '$id' AND `ParcelID` = '$pid'";
    $dresult = $conn->query($sql);
    while($d = $dresult->fetch_assoc()){
?>
<html>
    <head>
        <title></title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="css\style.css">
        <link href='https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css' rel='stylesheet'>
        <link href='https://fonts.googleapis.com/css?family=Montserrat' rel='stylesheet'>
    </head>
    <body>
        <!-- Nav Bar Start -->
        <div class="dashboard" id="resp-dashboard">
        
            <!--<div id="logo"><a>TrackNow</a></div>-->
            <div id="logo"><a><img src="img\drivericonwhite.png" alt="" style="width: 100px"></a></div>
            <a href="index.php" ><i class='bx bxs-home' style="background-color: transparent;"></i> Home</a>
            <a href="job.php" class="navactive"><i class="fa-solid fa-briefcase"></i> My Job</a>
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
        <div class="gmap">
            <div id="info"></div>
                <div id="map"></div>
                        <div id="latlng2"></div>
                            <div class="hide">lat:<span class="latitude"></span></div>
                            <div class="hide">lng:<span class="longitude"></span></div>
            <script>
                let originm;
                function load(){
                    var lat;
                    var lng;
                    //var originm;

                    $.getJSON('gps3.php',function(data){
                        
                            lat = $(".latitude").html(data.latitude);
                            var lat2 = JSON.parse(lat[0].innerHTML);
                            //console.log(lat2);

                            lng = $(".longitude").html(data.longitude);
                            var lng2 = JSON.parse(lng[0].innerHTML);
                            //console.log(lng2);

                            var origin1;
                            origin1 = {lat: lat2, lng: lng2};
                            originm = origin1
                            console.log(originm);
                        
                        });
                    
                        //initMap();
                }

                load()
                setInterval(function(){
                    load();
                },9000);
                
                $(document).ready(function(){
                    load();
                });

                var map;
                function initMap(){
                    
                    var mapStyles = [{
                        featureType: "all",
                        elementType: "labels",
                        stylers: [{
                            visibility: ""
                        }]
                    }];
                    
                    let origin
                    function testloop(){
                        origin =  originm;
                    }

                    testloop()
                    setInterval(function(){
                        testloop();
                    },1);

                    function test(){
                    console.log(origin);
                    console.log(originm);
                    }
                    
                    //Location of origin and destination
                    
                    const destination = <?php echo "{lat:" . $d["latitude"] . ", lng:" . $d["longitude"] . "}"?>;
                    console.log(destination);
                    
                    const options = {zoom: 20, center: origin, styles: mapStyles};
                    
                    //Create map
                    map = new google.maps.Map(
                        document.getElementById('map'),options);

                    //Create destination marker
                        var markerdestination = new google.maps.Marker({
                        position:destination, 
                        //map:map,
                        icon: 'img/homeicon.png',
                    });

                    markerdestination.setMap(map);
                    
                    function marker(){
                    var markerorigin = new google.maps.Marker({
                        position:origin, 
                        //map:map,
                        icon: 'img/deliveryicon.png',
                        animation: google.maps.Animation.BOUNCE
                        
                    });

                    markerorigin.setMap(map);
                    mo = markerorigin;
                }

                    function hide(){
                        mo.setMap(null);
                    }
                    
                    let directionsService = new google.maps.DirectionsService();
                    let directionsRenderer = new google.maps.DirectionsRenderer({
                        suppressMarkers: true,
                        preserveViewport: true,
                        polylineOptions: {
                            strokeColor: "#4682B4"
                        }
                    });
                    directionsRenderer.setMap(map); // Existing map object displays directions
                    
                    // Create route from existing points used for markers
                    function routelocation(){
                    const route = {
                        origin: origin,
                        destination: destination,
                        travelMode: 'DRIVING'
                    }

                    route1 = route
                }

                    function loadroute(){
                    directionsService.route(route1,
                        function(response, status) { // anonymous function to capture directions
                        if (status !== 'OK') {
                            window.alert('Directions request failed due to ' + status);
                            return;
                        } else {
                            directionsRenderer.setDirections(response); // Add route to the map
                            var directionsData = response.routes[0].legs[0]; // Get data about the mapped route
                            if (!directionsData) {
                            window.alert('Directions request failed');
                            return;
                            }
                            else {
                            //document.getElementById('info').innerHTML += " Your delivery partner is " + directionsData.distance.text + " away from your location, we estimate they will be arrive in " + directionsData.duration.text + ".";
                            }
                        }
                        });
                    }

                        setInterval(function(){
                            hide();
                            console.log('markerhided')
                        },10900);

                        marker();
                        setInterval(function(){
                            marker();
                            console.log('markeradded')
                        },11000);

                        routelocation();
                        loadroute();
                        setInterval(function(){
                            routelocation();
                            loadroute();
                            console.log('routeadded')
                        },11000);

                        /*setInterval(function(){
                            test();
                        },11500);*/
                        
                }
            </script>   
        </div>
        
        <!-- Map Section End-->

        <script src="js\func.js"></script>
        <script src="https://kit.fontawesome.com/b2309d5c46.js" crossorigin="anonymous"></script>
        <script src='//maps.googleapis.com/maps/api/js?key=AIzaSyDUBKQJzBXoAiqjw4d-6dthaLdzGZZAyng&callback=initMap' async defer></script>
    <?php
    }
    ?>
    </body>
    
</html>