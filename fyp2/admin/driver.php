<?php
    require 'config.php';
    $sql = "SELECT * FROM `driver`";
    $result = $conn->query($sql);
?>
<html>
    <head>
        <title></title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- CSS -->
        <link rel="stylesheet" href="css\style.css">
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
            <a href="vehicles.php?key="><i class="fa-solid fa-truck-front" style="background-color: transparent;"></i> Vehicles </a>
            <a href="parcel.php?key="><i class="fa-solid fa-box" style="background-color: transparent;"></i> Parcels</a>
            <a href="#" class="active"><i class="fa-solid fa-user" style="background-color: transparent;"></i> Driver</a>
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
        <!-- Column Space Start -->
        <div class="container">
            <div class="column">

            </div>

        
        <!-- Column Space End -->
        <!-- Table Start -->
        <div class="outline" style="transform:translate(0px,50px);">
            <div class="table-container" style="overflow-x: auto;">
            <div class="adjust">
                <div class="head" style="width: 100%">
                    <table id="myTable">
                        <thead>
                            <tr>
                                <th>Driver ID</th>
                                <th>Username</th>
                                <th>Email</th>
                                <th>Phone Number</th>
                                <th>Last Login</th>
                                <th>Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                            while($rows=$result->fetch_assoc())
                            {
                        ?>
                            <tr>
                                <td><?php echo $rows['DriverID']?></td>
                                <td><?php echo $rows['Username']?></td>
                                <td><?php echo $rows['Email']?></td>
                                <td><?php echo $rows['PhoneNo']?></td>
                                <td><?php echo $rows['LastLogin']?></td>
                                <td><button type="button" id="delete" ><a href="driverdelete.php?did=<?php echo $rows["DriverID"];?>"><i class='bx bx-trash' style="background-color: transparent;" ></i></a></button></td>
                            </tr>
                        <?php
                            }
                        ?>
                        </tbody>
                    </table>
                </div> <!-- Head-->
            </div> <!-- Table-Container -->
            </div>
        </div> <!-- Outline -->
    </div> <!-- Container -->
    <!-- Vehicles Table End -->

    <script>
        $(document).ready( function () {
            $('#myTable').DataTable();({
                pagingType: 'full_numbers',
        } );
    } );

    </script>

    
    <!-- Awesomefont -->
    <script src="https://kit.fontawesome.com/b2309d5c46.js" crossorigin="anonymous"></script>
    <script src="js\func.js"></script>
    
    </body>
</html>