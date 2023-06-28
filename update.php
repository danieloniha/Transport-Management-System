<?php 
    session_start();
    include('config/db_connect.php');

    if(isset($_GET['id'])){
        $id = $_GET['id'];
        

    $sql = "SELECT * FROM registration WHERE id = '$id' LIMIT 1";
    $result = mysqli_query($conn, $sql);
    $registration = mysqli_fetch_assoc($result);

    $reg_no = $registration['reg_no'];
    $sql2 = "SELECT * FROM vehicle WHERE reg_no = '$reg_no'";
    $result2 = mysqli_query($conn, $sql2);
    $registration2 = mysqli_fetch_assoc($result2);

    if($registration == null){
        echo 'Incorrect id';
    }

    mysqli_free_result($result);
    mysqli_close($conn);
    }
    
?>

<?php 
    if(isset($_POST['save'])){

        if(isset($_GET['id_new'])){
            $idnew = $_GET['id_new'];
        }

            $reg_no = mysqli_real_escape_string($conn, $_POST['reg_no']);
            $first_name = mysqli_real_escape_string($conn, $_POST['first_name']);
            $middle_name = mysqli_real_escape_string($conn, $_POST['middle_name']);
            $last_name = mysqli_real_escape_string($conn, $_POST['last_name']);
            $gender = mysqli_real_escape_string($conn, $_POST['gender']);
            $phone_no = mysqli_real_escape_string($conn, $_POST['phone_no']);
            $mode = mysqli_real_escape_string($conn, $_POST['mode']);
            $dob = mysqli_real_escape_string($conn, $_POST['dob']);
            $address = mysqli_real_escape_string($conn, $_POST['address']);
            $state = mysqli_real_escape_string($conn, $_POST['state']);
            $lga = mysqli_real_escape_string($conn, $_POST['lga']);
            $nok_firstname = mysqli_real_escape_string($conn, $_POST['nok_firstname']);
            $nok_middlename = mysqli_real_escape_string($conn, $_POST['nok_middlename']);
            $nok_lastname = mysqli_real_escape_string($conn, $_POST['nok_lastname']);
            $nok_phoneno = mysqli_real_escape_string($conn, $_POST['nok_phoneno']);
            $nok_relationship = mysqli_real_escape_string($conn, $_POST['nok_relationship']);
            $nok_address = mysqli_real_escape_string($conn, $_POST['nok_address']);
            //$nok_dob = mysqli_real_escape_string($conn, $_POST['nok_dob']);
            $plate_no = mysqli_real_escape_string($conn, $_POST['plate_no']);
            $vehicle_name = mysqli_real_escape_string($conn, $_POST['vehicle_name']);
            $vehicle_colour = mysqli_real_escape_string($conn, $_POST['vehicle_colour']);

        $sql = "UPDATE registration SET first_name = '$first_name', middle_name = '$middle_name', last_name = '$last_name', gender = '$gender', reg_no = '$reg_no', phone_no = '$phone_no', mode = '$mode', address = '$address', dob = '$dob', state = '$state', lga = '$lga', nok_firstname = '$nok_firstname', nok_middlename = '$nok_middlename', nok_lastname = '$nok_lastname', nok_phoneno = '$nok_phoneno', nok_relationship = '$nok_relationship', nok_address = '$nok_address' WHERE id = '$idnew' ";

        $result = mysqli_query($conn, $sql);

        if(mysqli_query($conn, $sql)){
            // success
            $sql2 = "UPDATE vehicle SET vehicle_name = '$vehicle_name', vehicle_colour = '$vehicle_colour', plate_no = '$plate_no' WHERE reg_no = '$reg_no' ";

            if(mysqli_query($conn, $sql2)){

            } else {
                // error
                echo 'query error: ' . mysqli_error($conn);
            }
            header('Location: index.php');
        } else {
            // error
            echo 'query error: ' . mysqli_error($conn);
        }
    }

    if(isset($_POST['cancel'])){
        header('Location: index.php');
    }

?>

<!DOCTYPE html>
<html lang="en">
    <?php include('templates/header.php') ?>
    <link rel="stylesheet" href="css/regstyle.css">
<!-- <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration</title>
    <link rel="stylesheet" href="regstyle.css">
</head> -->
<body>
<?php include('templates/nav.php') ?>
    <!-- <section id='menu'>
        <div class="logo">
            <img src="/Images/University-of-Lagos-courses.jpg" alt=""> 
            <h2>University Of Lagos</h2>
        </div>
        <div class="items">
            <li><i class="fa fa-pie-chart" aria-hidden="true"></i><a href="#">Dashboard</a></li>
            <li><i class="fa fa-user" aria-hidden="true"></i><a href="#">Manage Profile</a></li>
            <li><i class="fa fa-pie-chart" aria-hidden="true"></i><a href="#">Status</a></li>
            <li><i class="fa fa-cog" aria-hidden="true"></i><a href="#">Settings</a></li>
        </div>
    </section> -->
    <section id="form">
        <div class="container">
            <h3 class="i-name">Dashboard</h3>
            <!-- <div class="title">Registration</div> -->
            <form action="update.php?id_new=<?php echo $id; ?>" method="POST" enctype="multipart/form-data">
            <div class="upload">
                <img src="Images/630729-200.png" width="100" height="100" alt="" id="profileDisplay" onchange="displayImage(this)">
                
                    <input type="file" name="image" id="image"  accept=".jpg, .jpeg, .png" value=""  onclick="triggerClick()" >
                    <i class="fa fa-solid fa-camera" style="color: #ffffff;"></i>
                
            </div>
                <div class="user-details">
                    <!-- <div class="input-box">
                        <span class="details">Date</span>
                        <input type="text" placeholder="DD/MM/YYYY" value="" >
                    </div> -->
                    <div class="input-box">
                        <span class="details">Registration No</span>
                        <input type="text" name="reg_no" placeholder="Registration number" value="<?php echo htmlspecialchars($registration['reg_no']) ?>" >
                        <!-- <div class="red-text"><?php echo $errors['reg_no']; ?></div> -->
                    </div>
                    <div class="input-box">
                        <span class="details">First Name</span>
                        <input type="text" name="first_name" placeholder="First name" value="<?php echo htmlspecialchars($registration['first_name']) ?>" >
                    </div>
                    <div class="input-box">
                        <span class="details">Middle Name</span>
                        <input type="text" name="middle_name" placeholder="Middle name" value="<?php echo htmlspecialchars($registration['middle_name']) ?>" >
                    </div>
                    <div class="input-box">
                        <span class="details">Surname</span>
                        <input type="text" name="last_name" placeholder="Surname" value="<?php echo htmlspecialchars($registration['last_name']) ?>" >
                    </div>
                    <div>
                        <p class="rad">Gender</p>
                        <input type="radio" <?php if($registration['gender'] == 'male'){echo 'checked';} ?> name="gender" value="">
                        <label for="male" class="rad-space">Male</label>
                        <input type="radio" <?php if($registration['gender'] == 'female'){echo 'checked';} ?> name="gender" value="">
                        <label for="female">Female</label>
                    </div>
                    <div class="input-box">
                        <span class="details">Phone Number</span>
                        <input type="number" name="phone_no" placeholder="000-000-0000" value="<?php echo htmlspecialchars($registration['phone_no']) ?>" >
                    </div>
                    <div class="input-box">
                        <span class="details">Email</span>
                        <input type="email" name="email" placeholder="" value="<?php echo htmlspecialchars($registration['email']) ?>" >
                    </div>
                    <div class="input-box">
                        <span class="details">Mode</span>
                        <select name="mode" id="mode">
                            <option >--Select--</option>
                            <option value="Shuttle" <?php if($registration['mode'] == 'Shuttle'){echo 'selected';} ?>>Shuttle</option>
                            <option value="Cab" <?php if($registration['mode'] == 'Cab'){echo 'selected';} ?>>Cab</option>
                        </select>
                    </div>
                    <div class="input-box">
                        <span class="details">Address</span>
                        <input type="text" name="Address" placeholder="Address" value="<?php echo htmlspecialchars($registration['address']) ?>" >
                    </div>
                    <div class="input-box">
                        <span class="details">Date of Birth</span>
                        <input type="date" name="dob" placeholder="DD/MM/YYYY" value="<?php echo htmlspecialchars($registration['dob']) ?>" >
                    </div>
                    <div class="input-box">
                        <span class="details">State</span>
                        <input type="text" name="state" placeholder="State" value="<?php echo htmlspecialchars($registration['state']) ?>" >
                    </div>
                    <div class="input-box">
                        <span class="details">LGA</span>
                        <input type="text" name="lga" placeholder="LGA" value="<?php echo htmlspecialchars($registration['lga']) ?>" >
                    </div>
                    <!-- <div class="input-box">
                        <input type="hidden" name="" placeholder="" value="" >
                    </div> -->
                    
                    <!-- Next of Kin -->
                    <h4 class="name">Next of Kin</h4>
                    <div class="input-box">
                        <input type="hidden" name="" placeholder="" value="" >
                    </div>
                    <div class="input-box">
                        <span class="details">First Name</span>
                        <input type="text" name="nok_firstname" placeholder="First Name" value="<?php echo htmlspecialchars($registration['nok_firstname']) ?>" >
                    </div>
                    <div class="input-box">
                        <span class="details">Middle Name</span>
                        <input type="text" name="nok_middlename" placeholder="Middle name" value="<?php echo htmlspecialchars($registration['nok_middlename']) ?>" >
                    </div>
                    <div class="input-box">
                        <span class="details">Surname</span>
                        <input type="text" name="nok_lastname" placeholder="Surname" value="<?php echo htmlspecialchars($registration['nok_lastname']) ?>" >
                    </div>
                    <div class="input-box">
                        <span class="details">Relationship</span>
                        <input type="text" name="nok_relationship" placeholder="Relationship" value="<?php echo htmlspecialchars($registration['nok_relationship']) ?>" >
                    </div>
                    <div class="input-box">
                        <span class="details">Phone Number</span>
                        <input type="number" name="nok_phoneno" placeholder="000-000-0000" value="<?php echo htmlspecialchars($registration['nok_phoneno']) ?>" >
                    </div>
                    <div class="input-box">
                        <!-- <span class="details">Date of Birth</span> -->
                        <input type="hidden" name="nok_dob" placeholder="DD/MM/YYYY" value="<?php echo htmlspecialchars($registration['nok_dob']) ?>" >
                    </div>
                    <div class="long-input-box">
                        <span class="details">Address</span>
                        <input type="text" name="nok_address" placeholder="Enter your address" value="<?php echo htmlspecialchars($registration['nok_address']) ?>">
                    </div>

                    <!-- Vehicle Details -->
                    <h4 class="name">Vehicle</h4>
                    <div class="input-box">
                        <input type="hidden" name="" placeholder="" value="" >
                    </div>
                    <div class="input-box">
                        <span class="details">Vehicle Name</span>
                        <input type="text" name="vehicle_name" placeholder="Vehicle Name" value="<?php echo htmlspecialchars($registration2['vehicle_name']) ?>" >
                    </div>
                    <div class="input-box">
                        <span class="details">Vehicle Colour</span>
                        <input type="text" name="vehicle_colour" placeholder="Vehicle Colour" value="<?php echo htmlspecialchars($registration2['vehicle_colour']) ?>" >
                    </div>
                    <div class="input-box">
                        <span class="details">Plate Number</span>
                        <input type="text" name="plate_no" placeholder="Plate Number" value="<?php echo htmlspecialchars($registration2['plate_no']) ?>" >
                    </div>
                    <div class="input-box">
                        <span class="details">Driver's License</span>
                        <input type="text" name="" placeholder="Driver's License" value="" >
                    </div>
                    <div class="input-box">
                        <!-- <span class="details">Route</span> -->
                        <input type="hidden" name="" placeholder="Route" value="" >
                    </div>
                    <!-- <div class="input-box">
                        <span class="details">University Clearance</span>
                        <input type="text" name="" placeholder="University Clearance" value="" >
                    </div>
                    <div class="input-box">
                        <span class="details">Date of Clearance</span>
                        <input type="date" name="" placeholder="DD/MM/YYYY" value="" >
                    </div> -->
                </div>
                <div class="button" id="submit">
                    <input type="submit" name="save" value="Save">
                </div>
                <div class="button2" id="cancel">
                    <input type="submit" name="cancel" value="Cancel">
                </div>
            </form>
        </div>
    </section>
</body>
</html>