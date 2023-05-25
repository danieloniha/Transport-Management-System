<?php 
    include('config/db_connect.php');

    $reg_no = $first_name = $last_name = $phone_no = $mode = $address = $dob = $state = $lga = $middle_name = $gender = $nok_firstname = $nok_lastname = $nok_middlename = $nok_phoneno = $nok_address = $nok_relationship = $plate_no = $vehicle_name = $vehicle_colour = $image = '';
    $errors = array('reg_no' => '', 'first_name'=> '', 'last_name' => '', 'phone_no' => '', 'mode' => '', 'address' => '', 'dob' => '', 'middle_name' => '', 'gender' => '', 'nok_firstname' => '', 'nok_middlename' => '', 'nok_lastname' => '', 'nok_relationship' => '', 'nok_phoneno' => '', 'nok_address' => '', 'plate_no' => '', 'vehicle_name' => '', 'vehicle_colour' => '' , 'image' => '');

    if(isset($_POST['submit'])){
        
        print_r($_POST);

        if(empty($_POST['reg_no'])){
            $errors['reg_no'] = 'A reg no is required <br />';
        }else{
            $reg_no = $_POST['reg_no'];
        }

        if(empty($_POST['first_name'])){
            $errors['first_name'] = 'Your first name is required <br />';
        }else{
            $first_name = $_POST['first_name'];
        }

        if(empty($_POST['last_name'])){
            $errors['last_name'] = 'Your last name is required <br />';
        }else{
            $last_name = $_POST['last_name'];
        }

        if(empty($_POST['phone_no'])){
            $errors['phone_no'] = 'A phone number is required <br />';
        }else{
            $phone_no = $_POST['phone_no'];
            if(!preg_match('/^[0-9]{11}+$/', $phone_no)) {
                $errors['phone_no'] = "Invalid Phone Number";
            }
            // if(!filter_var($phone_no, FILTER_SANITIZE_NUMBER_INT));{
            //     $errors['phone_no'] = "Invalid Phone Number";
            // }       
        }

        if(empty($_POST['plate_no'])){
            $errors['plate_no'] = 'A plate number is required <br />';
        }else{
            $plate_no = $_POST['plate_no'];
            if(strlen($plate_no) != 11){
                $errors['plate_no'] = "Invalid Plate Number";
            }
        }

        $image = $_FILES['image'];

        $fileName = $_FILES['image']['name'];
        $fileSize = $_FILES['image']['size'];
        $tmpName = $_FILES['image']['tmp_name'];
        $fileError = $_FILES['image']['error'];
        $fileType = $_FILES['image']['type'];

        $fileExt = explode('.', $fileName);
        $fileActualExt = strtolower(end($fileExt));

        $allowed = array('jpg', 'jpeg', 'png');

        if(in_array($fileActualExt, $allowed)){
            if($fileError === 0){
                if($fileSize < 1000000){
                    $fileNameNew = uniqid('', true).".".$fileActualExt;
                    $fileDestination = 'uploads/' .$fileNameNew;
                    move_uploaded_file($tmpName, $fileDestination);
                    // header('Location: form.php');
                } else {
                    $errors['image'] = "Your file is too large";
                }
            } else {
                $errors['image'] = "There was an error uploading your file";
            }
        } else {
            $errors['image'] = "You cannot upload files of this type";
        }

        // if($_FILES['image']['error'] === 4){
        //     $errors['image'] = 'Image Does Not Exist <br />';
        // } else {
        //     $fileName = $_FILES['image']['name'];
        //     $fileSize = $_FILES['image']['size'];
        //     $tmpName = $_FILES['image']['tmp_name'];

        //     $validImageExtension = ['jpg', 'jpeg', 'png'];
        //     $imageExtension = explode('.', $fileName);
        //     $imageExtension = strtolower(end($imageExtension)){
        //         if(!in_array($imageExtension, $validImageExtension)){
        //             $errors['image'] = "Invalid Image Extension";
        //         } else if($fileSize > 1000000){
        //             $errors['image'] = "Image Size Is Too Large";
        //         } else {
        //             $newImageName = uniqid();
        //             $newImageName .= '.' . $imageExtension;

        //             move_uploaded_file($tmpName, '')
        //         }
        //     }
        // }

        $mode = $_POST['mode'];

        if(empty($_POST['address'])){
            $errors['address'] = 'An address is required <br />';
        }else{
            $address = $_POST['address'];
        }

        if(array_filter($errors)){
            // echo 'errors in the form';
        }else{
    
            $status = 'active';
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

            $previous_reg_query = "SELECT * FROM REGISTRATION WHERE reg_no = '$reg_no' ";
            $result = mysqli_query($conn, $previous_reg_query);
            $reg_checker = mysqli_fetch_all($result, MYSQLI_ASSOC);

            
            if(mysqli_query($conn, $previous_reg_query)){
                // success
                if($reg_checker != null){
                    $errors['reg_no'] = 'This registration number has been taken';  
                } else {
                    // create sql
                    $sql1 = "INSERT INTO registration(reg_no, first_name, last_name, phone_no, mode, address, middle_name, dob, state, lga, gender, status, nok_firstname, nok_middlename, nok_lastname, nok_relationship, nok_phoneno, nok_address) VALUES('$reg_no', '$first_name','$last_name', '$phone_no', '$mode', '$address', '$middle_name', '$dob', '$state', '$lga', '$gender', '$status', '$nok_firstname', '$nok_middlename', '$nok_lastname', '$nok_relationship', '$nok_phoneno', '$nok_address')";
                    //die($sql1);
                    
                    if(mysqli_query($conn, $sql1)){
                        // success
                        $sql2 = "INSERT INTO vehicle(plate_no, vehicle_name, vehicle_colour, reg_no) VALUES('$plate_no', '$vehicle_name', '$vehicle_colour', '$reg_no')";
                        // save to db & check
                        if(mysqli_query($conn, $sql2)){
                            // success
                            // header('Location: index.php');
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
            } else {
                // error
                echo 'query error: ' . mysqli_error($conn);
            }
    
            // // create sql
            // $sql = "INSERT INTO registration(reg_no, first_name, last_name, phone_no, mode, address, middle_name, dob, state, lga) VALUES('$reg_no', '$first_name','$last_name', '$phone_no', '$mode', $address, $middle_name, $dob, $state, $lga)";
    
            // // save to db & check
            // if(mysqli_query($conn, $sql)){
            //     // success
            //     header('Location: index.php');
            // } else {
            //     // error
            //     echo 'query error: ' . mysqli_error($conn);
            // }
            mysqli_free_result($result);
            mysqli_close($conn);
        }
        
    }   
    

?>

<!DOCTYPE html>
<html lang="en">
    <?php include('templates/header.php') ?>
    <link rel="stylesheet" href="css/regstyle.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
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
            <h3 class="i-name">Add User</h3>

            <!-- Personal -->
            <h4 class="name">Personal</h4>
            <!-- <div class="title">Registration</div> -->
            <form action="form.php" method="POST" enctype="multipart/form-data">
            <div class="upload">
                <img src="Images/630729-200.png" width="100" height="100" alt="">
                <div class="">
                    <input type="file" name="image" id="image" accept=".jpg, .jpeg, .png" value="">
                    <i class="fa fa-solid fa-camera" style="color: #ffffff;"></i>
                </div>
            </div>
                <div class="user-details">
                    
                    <div class="input-box">
                        <span class="details">Registration No</span>
                        <input type="number" name="reg_no" placeholder="Registration number" value="<?php echo htmlspecialchars($reg_no) ?>" >
                        <div class="red-text"><?php echo $errors['reg_no']; ?></div>
                    </div>
                    <div class="input-box">
                        <span class="details">First Name</span>
                        <input type="text" name="first_name" placeholder="First name" value="<?php echo htmlspecialchars($first_name) ?>" >
                    </div>
                    <div class="input-box">
                        <span class="details">Middle Name</span>
                        <input type="text" name="middle_name" placeholder="Middle Name" value="<?php echo htmlspecialchars($middle_name) ?>" >
                    </div>
                    <div class="input-box">
                        <span class="details">Surname</span>
                        <input type="text" name="last_name" placeholder="Surname" value="<?php echo htmlspecialchars($last_name) ?>" >
                    </div>
                    <div>
                        <p class="rad">Gender</p>
                        <input type="radio" name="gender" value="Male">
                        <label for="male" class="rad-space">Male</label>
                        <input type="radio" name="gender" value="Female">
                        <label for="female">Female</label>
                    </div>
                    <div class="input-box">
                        <span class="details">Phone Number</span>
                        <input type="text" name="phone_no" placeholder="000-000-0000" value="<?php echo htmlspecialchars($phone_no) ?>" >
                        <div class="red-text"><?php echo $errors['phone_no']; ?></div>
                    </div>
                    <div class="input-box">
                        <span class="details">Mode</span>
                        <select name="mode" id="mode">
                            <option disabled>--Select--</option>
                            <option value="Shuttle" <?php if($mode == 'Shuttle'){echo 'selected';} ?>>Shuttle</option>
                            <option value="Cab" <?php if($mode == 'Cab'){echo 'selected';} ?>>Cab</option>
                        </select>
                    </div>
                    <div class="input-box">
                        <span class="details">Address</span>
                        <input type="text" name="address" placeholder="Enter your address" value="<?php echo htmlspecialchars($address) ?>">
                    </div>
                    <div class="input-box">
                        <span class="details">Date of Birth</span>
                        <input type="date" name="dob" placeholder="DD/MM/YYYY" value="<?php echo htmlspecialchars($dob) ?>" >
                    </div>
                    <div class="input-box">
                        <span class="details">State</span>
                        <input type="text" name="state" placeholder="State" value="<?php echo htmlspecialchars($state) ?>" >
                    </div>
                    <div class="input-box">
                        <span class="details">LGA</span>
                        <input type="text" name="lga" placeholder="LGA" value="<?php echo htmlspecialchars($lga) ?>" >
                    </div>
                    <div class="input-box">
                        <input type="hidden" name="" placeholder="" value="" >
                    </div>

                    <!-- Next Of Kin -->
                    <h4 class="name">Next of Kin</h4>
                    <div class="input-box">
                        <input type="hidden" name="" placeholder="" value="" >
                    </div>
                    <div class="input-box">
                        <span class="details">First Name</span>
                        <input type="text" name="nok_firstname" placeholder="First Name" value="<?php echo htmlspecialchars($nok_firstname) ?>" >
                    </div>
                    <div class="input-box">
                        <span class="details">Middle Name</span>
                        <input type="text" name="nok_middlename" placeholder="Middle name" value="<?php echo htmlspecialchars($nok_middlename) ?>" >
                    </div>
                    <div class="input-box">
                        <span class="details">Last Name</span>
                        <input type="text" name="nok_lastname" placeholder="Last Name" value="<?php echo htmlspecialchars($nok_lastname) ?>" >
                    </div>
                    <div class="input-box">
                        <span class="details">Relationship</span>
                        <input type="text" name="nok_relationship" placeholder="Relationship" value="<?php echo htmlspecialchars($nok_relationship) ?>" >
                    </div>
                    <div class="input-box">
                        <span class="details">Phone Number</span>
                        <input type="text" name="nok_phoneno" placeholder="000-000-0000" value="<?php echo htmlspecialchars($nok_phoneno) ?>" >
                    </div>
                    <div class="input-box">
                        <!-- <span class="details">Date of Birth</span> -->
                        <input type="hidden" name="nok_dob" placeholder="DD/MM/YYYY" value="<?php echo htmlspecialchars($nok_dob) ?>" >
                    </div>
                    <div class="long-input-box">
                        <span class="details">Address</span>
                        <input type="text" name="nok_address" placeholder="Enter your address" value="<?php echo htmlspecialchars($nok_address) ?>">
                    </div>

                    <!-- Vehicle Details -->
                    <h4 class="name">Vehicle</h4>
                    <div class="input-box">
                        <input type="hidden" name="" placeholder="" value="" >
                    </div>
                    <div class="input-box">
                        <span class="details">Vehicle Name</span>
                        <input type="text" name="vehicle_name" placeholder="Vehicle Name" value="<?php echo htmlspecialchars($vehicle_name) ?>" >
                    </div>
                    <div class="input-box">
                        <span class="details">Vehicle Colour</span>
                        <input type="text" name="vehicle_colour" placeholder="Vehicle Colour" value="<?php echo htmlspecialchars($vehicle_colour) ?>" >
                    </div>
                    <div class="input-box">
                        <span class="details">Plate Number</span>
                        <input type="text" name="plate_no" placeholder="Plate Number" value="<?php echo htmlspecialchars($plate_no) ?>" >
                        <div class="red-text"><?php echo $errors['plate_no']; ?></div>
                    </div>
                    <div class="input-box">
                        <span class="details">Driver's License</span>
                        <input type="text" name="" placeholder="Driver's License" value="" >
                    </div>
                    <div class="input-box">
                        <span class="details">Route</span>
                        <input type="text" name="" placeholder="Route" value="" >
                    </div>
                    <div class="input-box">
                        <input type="hidden" name="" placeholder="Route" value="" >
                    </div>
                    <h4 class="name">Clearance</h4>
                    <div class="input-box">
                        <input type="hidden" name="" placeholder="Route" value="" >
                    </div>
                    <div class="input-box">
                        <span class="details">University Clearance</span>
                        <input type="text" name="" placeholder="University Clearance" value="" >
                    </div>
                    <div class="input-box">
                        <span class="details">Date of Clearance</span>
                        <input type="date" name="" placeholder="DD/MM/YYYY" value="" >
                    </div>

                </div>
                <div class="button" id="submit">
                    <input type="submit" name="submit" value="Submit">
                </div>
            </form>
        </div>
    </section>
</body>
</html>
