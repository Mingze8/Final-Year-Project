<?php
    if(!ISSET($_SESSION["driver"]))
    {
        header("Location:login.php");
    }

?>
<html>
    <head>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    </head>
    <body onload = "getLocation();">
        <form action="gps.php" class="gps" method="POST">
            <input type="hidden" name="latitude" id="latitude">
            <input type="hidden" name="longitude" id="longitude">
            <input type="hidden" name="acc" id="acc">
            <input type="hidden" name="CurrentDriver" id="CurrentDriver" value="<?php echo $_SESSION["driver"]?>">
            <div id="autosave"></div>
            <!--<button type="submit" name="submit">Submit</button>-->
        </form>
        <script>
            function getLocation(){
                if(navigator.geolocation){

                    navigator.geolocation.watchPosition(showPosition, option);
                }
            }
            function showPosition(position){
                document.querySelector('.gps input[name = "latitude"]').value = position.coords.latitude
                document.querySelector('.gps input[name = "longitude"]').value = position.coords.longitude
                document.querySelector('.gps input[name = "acc"]').value = position.coords.accuracy;

            }

            function option(){
                enableHighAccuracy = true,
                timeout = 5000,
                maximumAge = 0
            }

            $(document).ready(function(){
                function autosave(){
                    var latitude = $('#latitude').val();
                    var longitude = $('#longitude').val();
                    var id = $('#CurrentDriver').val();
                    if(latitude != '' && longitude != '')
                    {
                        $.ajax({
                            url:"gps2.php",
                            method:"POST",
                            data:{lat:latitude, lng:longitude, id:id},
                            dataType:"text",
                            success:function(data)
                            {
                                if(data != '')
                                {
                                    $('#CurrentDriver').val(data);
                                }
                                /*$('#autosave').text("Post save as draft");
                                setInterval(function(){
                                    $('#autosave').text('');
                                }, 5000);*/
                                console.log('GPS Post Success');
                            }
                        });
                    }
                }
                setInterval(function(){
                    autosave();
                    }, 1000);
            })

        </script>
    </body>
</html>