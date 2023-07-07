<?php 
    session_start();
    include('config/db_connect.php');
    $phone = $_SESSION['phone_no'];
    $em = $_SESSION['email'];
    //die($phone);

    $reg_no = $first_name = $last_name = $phone_no = $email = $mode = $address = $dob = $state = $lga = $middle_name = $gender = $nok_firstname = $nok_lastname = $nok_middlename = $nok_phoneno = $nok_address = $nok_relationship = $plate_no = $vehicle_name = $vehicle_colour = $drivers_license = $fileDestination = '';
    $errors = array('reg_no' => '', 'first_name'=> '', 'last_name' => '', 'phone_no' => '', 'mode' => '', 'address' => '', 'state' => '',  'lga' => '', 'dob' => '', 'middle_name' => '', 'gender' => '', 'nok_firstname' => '', 'nok_middlename' => '', 'nok_lastname' => '', 'nok_relationship' => '', 'nok_dob' => '', 'nok_phoneno' => '', 'nok_address' => '', 'plate_no' => '', 'vehicle_name' => '', 'vehicle_colour' => '' , 'image' => '', 'email' => '');

    if(isset($_POST['submit'])){
        
        //print_r($_POST);

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

        if(empty($_POST['email'])){
            $errors['email'] = 'Your email is required <br />';
        }else{
            $email = $_POST['email'];
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
            if(strlen($plate_no) != 8){
                $errors['plate_no'] = "Invalid Plate Number";
            }
        }

        // if(empty($_POST['gender'])){
        //     $errors['gender'] = 'Choose a gender <br />';
        // }else{
        //     $gender = $_POST['gender'];
        // }

        if(empty($_POST['mode'])){
            $errors['mode'] = 'Choose a mode <br />';
        }else{
            $mode = $_POST['mode'];
        }

        if(empty($_POST['address'])){
            $errors['address'] = 'An address is required <br />';
        }else{
            $address = $_POST['address'];
        }
        
        if(empty($_POST['dob'])){
            $errors['dob'] = 'Date of Birth is required <br />';
        }else{
            $dob = $_POST['dob'];
        }

        if(empty($_POST['state'])){
            $errors['state'] = 'State is required <br />';
        }else{
            $state = $_POST['state'];
        }

        if(empty($_POST['lga'])){
            $errors['lga'] = 'An lga is required <br />';
        }else{
            $lga = $_POST['lga'];
        }

        if(empty($_POST['nok_firstname'])){
            $errors['nok_firstname'] = 'This is required <br />';
        }else{
            $nok_firstname = $_POST['nok_firstname'];
        }

        if(empty($_POST['nok_lastname'])){
            $errors['nok_lastname'] = 'This is required <br />';
        }else{
            $nok_lastname = $_POST['nok_lastname'];
        }

        if (empty($_POST['nok_phoneno'])) {
            $errors['nok_phoneno'] = 'This is required <br />';
        } else {
            $nok_phoneno = $_POST['nok_phoneno'];
            if (!preg_match('/^[0-9]{11}+$/', $nok_phoneno)) {
                $errors['nok_phoneno'] = "Invalid Phone Number";
            }
        }

        if(empty($_POST['nok_relationship'])){
            $errors['nok_relationship'] = 'This is required <br />';
        }else{
            $nok_relationship = $_POST['nok_relationship'];
        }
        
        if(empty($_POST['nok_address'])){
            $errors['nok_address'] = 'This is required <br />';
        }else{
            $nok_address = $_POST['nok_address'];
        }

        if(empty($_POST['plate_no'])){
            $errors['plate_no'] = 'This is required <br />';
        }else{
            $plate_no = $_POST['plate_no'];
        }

        if(empty($_POST['vehicle_name'])){
            $errors['vehicle_name'] = 'This is required <br />';
        }else{
            $vehicle_name = $_POST['vehicle_name'];
        }

        if(empty($_POST['vehicle_colour'])){
            $errors['vehicle_colour'] = 'This is required <br />';
        }else{
            $vehicle_colour = $_POST['vehicle_colour'];
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
                //echo $fileSize;
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
            $email = mysqli_real_escape_string($conn, $_POST['email']);
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
            $drivers_license = mysqli_real_escape_string($conn, $_POST['drivers_license']);
            //$fileDestination = mysqli_real_escape_string($conn, $_POST['fileDestination']);
            

            $previous_reg_query = "SELECT * FROM REGISTRATION WHERE reg_no = '$reg_no' ";
            $result = mysqli_query($conn, $previous_reg_query);
            $reg_checker = mysqli_fetch_all($result, MYSQLI_ASSOC);

            
            if(mysqli_query($conn, $previous_reg_query)){
                // success
                if($reg_checker != null){
                    $errors['reg_no'] = 'This registration number exists';  
                } else {
                    // create sql
                    // if(isset($_SESSION['phone_no'])){
                    //     $id = $_SESSION['phone_no'];
                    //     //die($id);
                    // } else {
                    //     // Handle the case when the ID is not provided
                    //     // For example, redirect to an error page or display an error message
                    //     exit('ID not provided');
                    // }
                
                    // $sql = "SELECT * FROM registration WHERE phone_no = '$id' ";
                    // $res = mysqli_query($conn, $sql);
                    // $pn = mysqli_fetch_assoc($res);
                    $sql1 = "INSERT INTO registration(reg_no, first_name, last_name, phone_no, mode, address, middle_name, dob, state, lga, gender, status, nok_firstname, nok_middlename, nok_lastname, nok_relationship, nok_phoneno, nok_address, image, email, drivers_license) 
                    VALUES('$reg_no', '$first_name','$last_name', '$phone_no', '$mode', '$address', '$middle_name', '$dob', '$state', '$lga', '$gender', '$status', '$nok_firstname', '$nok_middlename', '$nok_lastname', '$nok_relationship', '$nok_phoneno', '$nok_address', '$fileDestination', '$email', '$drivers_license')";
                    
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
                        $sql3 = "SELECT * FROM REGISTRATION WHERE reg_no = '$reg_no' ";
                        $result3 = mysqli_query($conn, $sql3);
                        $reg = mysqli_fetch_row($result3);
                        $_SESSION['id'] = $reg[0];
                        $_SESSION['phone_no'] = $reg[5];
                        header('Location: index2.php');
                    } else {
                        // error
                        echo 'query error: ' . mysqli_error($conn);
                    }
                    
                    
                }
            } else {
                // error
                echo 'query error: ' . mysqli_error($conn);
            }
    
            mysqli_free_result($result);
            mysqli_close($conn);
        }
        
    }   
    if(isset($_POST['cancel'])){
        header('Location: signup.php');
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration</title>
    <link rel="stylesheet" href="css/regstyle2.css">
</head>
<body>
<section id="form">
        <div class="container">
            <h3 class="i-name">Complete Registration</h3>

            <!-- Personal -->
            <h4 class="name">Personal</h4>
            <!-- <div class="title">Registration</div> -->
            <form action="reg.php?id=<?php echo $phone; ?>" method="POST" enctype="multipart/form-data">
            <div class="upload">
                <img src="Images/630729-200.png" width="100" height="100" alt="" id="profileDisplay" >
                
                    <input type="file" name="image" id="image"  accept=".jpg, .jpeg, .png" value=""   >
                    <i class="fa fa-solid fa-camera" style="color: #ffffff;"></i>
                    <?php echo $errors['image']; ?>
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
                        <div class="red-text"><?php echo $errors['first_name']; ?></div>
                    </div>
                    <div class="input-box">
                        <span class="details">Middle Name</span>
                        <input type="text" name="middle_name" placeholder="Middle Name" value="<?php echo htmlspecialchars($middle_name) ?>" >
                        <div class="red-text"><?php echo $errors['middle_name']; ?></div>
                    </div>
                    <div class="input-box">
                        <span class="details">Surname</span>
                        <input type="text" name="last_name" placeholder="Surname" value="<?php echo htmlspecialchars($last_name) ?>" >
                        <div class="red-text"><?php echo $errors['last_name']; ?></div>
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
                        <input type="tel" name="phone_no" placeholder="000-000-0000" value="<?php echo htmlspecialchars($phone) ?>" readonly>
                        <!-- s -->
                    </div>
                    <div class="input-box">
                        <span class="details">Email</span>
                        <input type="email" name="email" placeholder="" value="<?php echo htmlspecialchars($em) ?>" readonly>
                    </div>
                    <div class="input-box">
                        <span class="details">Mode</span>
                        <select name="mode" id="mode">
                            <option disabled>--Select--</option>
                            <option value="Shuttle" <?php if($mode == 'Shuttle'){echo 'selected';} ?>>Shuttle</option>
                            <option value="Cab" <?php if($mode == 'Cab'){echo 'selected';} ?>>Cab</option>
                        </select>
                        <div class="red-text"><?php echo $errors['mode']; ?></div>
                    </div>
                    <div class="input-box">
                        <span class="details">Address</span>
                        <input type="text" name="address" placeholder="Enter your address" value="<?php echo htmlspecialchars($address) ?>">
                        <div class="red-text"><?php echo $errors['address']; ?></div>
                    </div>
                    <div class="input-box">
                        <span class="details">Date of Birth</span>
                        <input type="date" name="dob" placeholder="DD/MM/YYYY" value="<?php echo htmlspecialchars($dob) ?>" >
                        <div class="red-text"><?php echo $errors['dob']; ?></div>
                    </div>
                    <div class="input-box">
                        <span class="details">State</span>
                        <input type="text" name="state" placeholder="State" value="<?php echo htmlspecialchars($state) ?>" >
                        <div class="red-text"><?php echo $errors['state']; ?></div>
                    </div>
                    <div class="input-box">
                        <span class="details">LGA</span>
                        <input type="text" name="lga" placeholder="LGA" value="<?php echo htmlspecialchars($lga) ?>" >
                        <div class="red-text"><?php echo $errors['lga']; ?></div>
                    </div>
                    <!-- <div class="input-box">
                        <input type="hidden" name="" placeholder="" value="" >
                    </div> -->

                    <!-- Next Of Kin -->
                    <h4 class="name">Next of Kin</h4>
                    <div class="input-box">
                        <input type="hidden" name="" placeholder="" value="" >
                    </div>
                    <div class="input-box">
                        <span class="details">First Name</span>
                        <input type="text" name="nok_firstname" placeholder="First Name" value="<?php echo htmlspecialchars($nok_firstname) ?>" >
                        <div class="red-text"><?php echo $errors['nok_firstname']; ?></div>
                    </div>
                    <div class="input-box">
                        <span class="details">Middle Name</span>
                        <input type="text" name="nok_middlename" placeholder="Middle name" value="<?php echo htmlspecialchars($nok_middlename) ?>" >
                    </div>
                    <div class="input-box">
                        <span class="details">Surname</span>
                        <input type="text" name="nok_lastname" placeholder="Surname" value="<?php echo htmlspecialchars($nok_lastname) ?>" >
                        <div class="red-text"><?php echo $errors['nok_lastname']; ?></div>
                    </div>
                    <div class="input-box">
                        <span class="details">Relationship</span>
                        <input type="text" name="nok_relationship" placeholder="Relationship" value="<?php echo htmlspecialchars($nok_relationship) ?>" >
                        <div class="red-text"><?php echo $errors['nok_relationship']; ?></div>
                    </div>
                    <div class="input-box">
                        <span class="details">Phone Number</span>
                        <input type="text" name="nok_phoneno" placeholder="000-000-0000" value="<?php echo htmlspecialchars($nok_phoneno) ?>" >
                        <div class="red-text"><?php echo $errors['nok_phoneno']; ?></div>
                    </div>
                    <div class="input-box">
                        <!-- <span class="details">Date of Birth</span> -->
                        <input type="hidden" name="nok_dob" placeholder="DD/MM/YYYY" value="<?php echo htmlspecialchars($nok_dob) ?>" >
                        <div class="red-text"><?php echo $errors['nok_dob']; ?></div>
                    </div>
                    <div class="long-input-box">
                        <span class="details">Address</span>
                        <input type="text" name="nok_address" placeholder="Enter your address" value="<?php echo htmlspecialchars($nok_address) ?>">
                        <div class="red-text"><?php echo $errors['nok_address']; ?></div>
                    </div>

                    <!-- Vehicle Details -->
                    <h4 class="name">Vehicle</h4>
                    <div class="input-box">
                        <input type="hidden" name="" placeholder="" value="" >
                    </div>
                    <div class="input-box">
                        <span class="details">Vehicle Name</span>
                        <input type="text" name="vehicle_name" placeholder="Vehicle Name" value="<?php echo htmlspecialchars($vehicle_name) ?>" >
                        <div class="red-text"><?php echo $errors['vehicle_name']; ?></div>
                    </div>
                    <div class="input-box">
                        <span class="details">Vehicle Colour</span>
                        <input type="text" name="vehicle_colour" placeholder="Vehicle Colour" value="<?php echo htmlspecialchars($vehicle_colour) ?>" >
                        <div class="red-text"><?php echo $errors['vehicle_colour']; ?></div>
                    </div>
                    <div class="input-box">
                        <span class="details">Plate Number</span>
                        <input type="text" name="plate_no" placeholder="Plate Number" value="<?php echo htmlspecialchars($plate_no) ?>" >
                        <div class="red-text"><?php echo $errors['plate_no']; ?></div>
                    </div>
                    <div class="input-box">
                        <span class="details">Driver's License</span>
                        <input type="text" name="drivers_license" placeholder="Driver's License" value="<?php echo htmlspecialchars($drivers_license) ?>" >
                    </div>
                    <div class="input-box">
                        <!-- <span class="details">Route</span> -->
                        <input type="hidden" name="" placeholder="Route" value="" >
                    </div>
                    <div class="input-box">
                        <input type="hidden" name="" placeholder="Route" value="" >
                    </div>
                    <!-- <h4 class="name">Clearance</h4>
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
                    </div> -->

                </div>
                <div class="button" id="submit">
                    <input type="submit" name="submit" value="Submit">
                </div>
                <div class="button2" id="cancel">
                    <input type="submit" name="cancel" value="Cancel">
                </div>
            </form>
        </div>
    </section>
</body>
</html>