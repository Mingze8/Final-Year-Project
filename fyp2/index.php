<?php
    require 'config.php';
?>
<html>
    <head>
        <title></title>
        <link rel="stylesheet" href="style.css">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <link href='https://fonts.googleapis.com/css?family=Montserrat' rel='stylesheet'>
        <script src="https://kit.fontawesome.com/b2309d5c46.js" crossorigin="anonymous"></script>

    </head>
    <body onload="load();" >
        <div class="container">
            <img src="tracklogo.png" class="logo" alt="">
            <div class="word"><h1>Start tracking your parcel now</h1></div>
            <div class="arrow"><a href="#section-test"><i class="fa-solid fa-chevron-down fa-3x fa-bounce"></i></a></div>
            <div class="btn-ex">
                <a href="admin\login.php"><button class="left">Admin Page</button></a>
                <a href="driver\login.php"><button class="right">Driver Page</button></a>
            </div>
        </div>
        

        <?php
            if(ISSET($_POST["submit"])){

                $track = $_POST["track"];

                $sql = "SELECT * FROM `parcel` WHERE `TrackingNum` = '$track'";

                $result = $conn->query($sql);

                if($result->num_rows>0){
                    $num = $result->fetch_assoc();
                    if($num["TrackingNum"]==$track){
                        $_SESSION["tracknum"] = $num["ParcelID"];
                        $_SESSION["driver"] = $num["AssignTo"];
                        $post = "block";
                        //header("Location:index.php#");
                    }
                }else{
                        $post = "hide";
                        echo "<span class='loginalert'><i class='fa-solid fa-circle-exclamation fa-lg'></i> This Tracking Number is not available </span>";
                    }
            }
        ?>
        <!-- Tracking Number -->
        <div class="main" id="section-test">
            <div class="input">
                <form action="" method="POST">
                    <input type="text" class="trackingnumber" name="track" id="" required>
                    <label for="">Please insert your tracking number</label>
                    <input type="submit" class="btn" value="Track Now" name="submit">
                </form>
            </div>
        </div>
        <!-- Tracking Number End-->

        <!-- Status Section-->
        <div class="hide" style="display:<?php echo $post?>">
        <div class="status" id="status-section">
            <div class="statusheader">
            <div class="detailsection">
                <h2>Delivery Details</h2>
                <!--<p>Tracking Number : <span><b>12345</b></span></p>
                <p>Current Status : <span><b>Out for Delivery</b></span></p>-->
            </div>
            <hr style="margin:-10px 20px ;">
            <?php
                //$detailsql = "SELECT * FROM `parcel` WHERE `ParcelID` = " .$_SESSION["tracknum"];
                $detailsql = "SELECT a.Username, a.PhoneNo, b.TrackingNum, b.JobType, b.ReceiverName, b.SenderAddress, b.ReceiverAddress FROM `driver` AS a, `parcel` AS b WHERE a.DriverID = b.AssignTo AND b.ParcelID =" . $_SESSION["tracknum"];
                $dresult = $conn->query($detailsql);

                while($d = $dresult->fetch_assoc())
                {
                    $type = $d['JobType'];

                            switch($d["JobType"]){
                                case "1":
                                    $type = "Standard Delivery";
                                    break;
                                case "2":
                                    $type = "Express Delivery";
                                    break;
                                case "3":
                                    $type = "International Delivery";
                                    break;
                                }
            ?>
            <div class="details">
                
                <p>Tracking Number: <span><?php echo $d["TrackingNum"]?></span></p>
                <br>
                <table>
                    <tr>
                        <td>Delivery Type: <span><?php echo $type;?></span></td>
                        <td>Receiver Name: <span><?php echo $d["ReceiverName"];?></span></td>
                    </tr>
                    <tr>
                        <td>Delivery by: <span><?php echo $d["Username"]?></span></td>
                        <td>Contact Number: <span><?php echo $d["PhoneNo"]?></span></td>
                    </tr>
                    <tr>
                        <td>Delivery From: <span><?php echo $d["SenderAddress"]?></span></td>
                        <td>Delivery To: <span><?php echo $d["ReceiverAddress"]?></span></td>
                    </tr>
                </table>
                </div>
                <br>
                <?php
                }
                ?>
                <?php
                    $pro = "SELECT `JobStatus` FROM `parcel` WHERE `ParcelID` =" . $_SESSION["tracknum"];
                    $proresult = $conn->query($pro);
                    while($pr = $proresult->fetch_Assoc())
                    {   
                        $x = $pr["JobStatus"];
                        if($x == "1"){
                            $ac1 = "active";
                        }
                        elseif($x == "3"){
                            $ac1 = "active";
                            $ac2 = "active";
                        }
                        elseif($x == "6"){
                            $ac1 = "active";
                            $ac2 = "active";
                            $ac3 = "active";
                        }
                        elseif($x == "7"){
                            $ac1 = "active";
                            $ac2 = "active";
                            $ac3 = "active";
                            $ac4 = "active";
                        }

                        $soutput = $pr['JobStatus'];

                                switch($pr['JobStatus']){
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
                                        $soutput = "Delivered";
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
                <div class="statussection">
                    <h2>Current Status</h2>
                        <hr style="margin: 10px 0 0 0">
                    <div class="progressbarsection">
                        <ul class="progressbar">
                            <li class="<?php echo $ac1?>">Order Placed</li>
                            <li class="<?php echo $ac2?>">Item Shipped</li>
                            <li class="<?php echo $ac3?>">Out For Delivery</li>
                            <li class="<?php echo $ac4?>">Delivered</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div id="msg" class="msgbar"></div>
                <script>
                    document.getElementById("msg").innerHTML = "Your parcel is currently <?php echo $soutput ?>";
                </script>
            <?php
                    }

                    $count = "SELECT COUNT(AssignTo) AS assign FROM parcel WHERE `AssignTo` = '10'";
                    $cresult = $conn->query($count);
                    $countr = $cresult->fetch_assoc();

                    if($num["JobStatus"]!='6'){
                        $post2 = "hide";
                        echo "<div class='msgbar2'>Map Not Available Now<div>";
                    }elseif($num["DeliveryNow"]!="1"){
                        $post2 = "hide";
                        echo "<div class='msgbar2'><br> Your Delivery Partner is currently having ". $countr['assign'] ." parcel to be deliver during this trip</div>";
                        echo "<div class='msgbar2'>Map Will Be Available Soon<div>";
                    }else{
                        $post2 = "block";
                    }
            ?>
            <?php
                $state = "SELECT * FROM `vehicle` WHERE `CurrentDriver` = " .$_SESSION["driver"];
                $cstate = $conn->query($state);
                $crstate = $cstate->fetch_assoc();

                if($crstate["Status"] == '2'){
                    $post2 = "hide";
                    echo "<div style='color:red'><br>You Delivery Partner Is Currently Go For A Lunch Break For " .$crstate['note']."</div>";
                }
            ?>
        </div>
        
        <!-- Status Section End -->
        <?php
            $google = "SELECT `latitude` AS lat, `longitude` AS lng FROM `parcel` WHERE `ParcelID` = " . $_SESSION["tracknum"];
            $gresult = $conn->query($google);
            while($g = $gresult->fetch_Assoc()){
        ?>
        <!-- Map Section -->
        <div class="hide" style="display:<?php echo $post2?>">
        <div class="map" id="section-map">
            <div id="info"></div>
                <div id="map"></div>
                    <div class="text hide">lat:<span class="latitude"></span></div>
                    <div class="text hide">lng:<span class="longitude"></span></div>
            <script>
                let originm;
                function load(){
                    var lat;
                    var lng;
                    $.getJSON('gps.php',function(data){
                        
                        lat = $(".latitude").html(data.latitude);
                        var lat2 = JSON.parse(lat[0].innerHTML);

                        lng = $(".longitude").html(data.longitude);
                        var lng2 = JSON.parse(lng[0].innerHTML);

                        var origin1;
                        origin1 = {lat : lat2, lng : lng2};
                        originm = origin1
                        console.log(originm);
                    });
                }

                load();
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
                            visibility: "off"
                        }]
                    }];

                    var origin
                    function testloop(){
                        origin = originm;
                    }

                    testloop();
                    setInterval(function(){
                        testloop();
                    },1);

                    function test(){
                        console.log(origin);
                        console.log(originm);
                    }

                    test()
                    setInterval(function(){
                        test();
                    },3000);

                    //Center of the map
                    const destination = <?php echo "{lat: " . $g["lat"] . ", lng: " . $g["lng"] . "}"?>;
                    console.log(destination);

                    const options = {zoom: 20, center: origin, styles: mapStyles};

                    //Create map
                    map = new google.maps.Map(
                        document.getElementById('map'),options);
                    
                    //create destination marker

                    var markerdestination = new google.maps.Marker({
                        position:destination,
                        icon: 'homeicon.png',
                    });

                    markerdestination.setMap(map);

                    function marker(){
                        var markerorigin = new google.maps.Marker({
                            position:origin,
                            icon: 'deliveryicon.png',
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
                            document.getElementById('info').innerHTML += " Your delivery partner is " + directionsData.distance.text + " away from your location, we estimate they will be arrive in " + directionsData.duration.text + ".";
                            }
                        }
                        });
                }

                function deleteletter(){
                    document.getElementById('info').innerHTML = "";
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

            setInterval(function(){
                deleteletter();
                console.log('deleted')
            },10999);
        }   
            </script>   
        </div>
    </div>
    </div>
        
        <!-- Map Section End-->
        <!-- Footer -->
        <div class="footer">
            <h3>Cloud Based Live Courier & Delivery Tracking System @ Ming Ze </h3>
        </div>

        

        <script src='//maps.googleapis.com/maps/api/js?key=AIzaSyDUBKQJzBXoAiqjw4d-6dthaLdzGZZAyng&callback=initMap' async defer></script>
            <!--AIzaSyDUBKQJzBXoAiqjw4d-6dthaLdzGZZAyng-->

        <?php
            }
        ?>
    </body>
</html>