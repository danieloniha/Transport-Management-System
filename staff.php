<?php  
    session_start();
    include('config/db_connect.php');
    $first_name = $middle_name = $last_name = $staff_no = $phone_no = $role = $dept = '';
    $errors = array('first_name' => '', 'middle_name' => '', 'last_name' => '', 'staff_no' => '', 'phone_no' => '', 'role' => '', 'dept' => '');

    if(isset($_POST['submit'])){
        if(empty($_POST['first_name'])){
            $errors['first_name'] = 'First Name is required <br />';
        } else {
            $first_name = $_POST['first_name'];
        }

        if(empty($_POST['middle_name'])){
            $errors['middle_name'] = 'Middle Name is required <br />';
        } else {
            $middle_name = $_POST['middle_name'];
        }

        if(empty($_POST['last_name'])){
            $errors['last_name'] = 'Last Name is required <br />';
        } else {
            $last_name = $_POST['last_name'];
        }

        if(empty($_POST['phone_no'])){
            $errors['phone_no'] = 'Phone Number is required <br />';
        } else {
            $phone_no = $_POST['phone_no'];
        }

        if(empty($_POST['staff_no'])){
            $errors['staff_no'] = 'Staff Number is required <br />';
        } else {
            $staff_no = $_POST['staff_no'];
        }

        if(array_filter($errors)){
            
        } else {
            $first_name = mysqli_real_escape_string($conn, $_POST['first_name']);
            $middle_name = mysqli_real_escape_string($conn, $_POST['middle_name']);
            $last_name = mysqli_real_escape_string($conn, $_POST['last_name']);
            $staff_no = mysqli_real_escape_string($conn, $_POST['staff_no']);
            $phone_no = mysqli_real_escape_string($conn, $_POST['phone_no']);

            $sql = "INSERT INTO staff(first_name, middle_name, last_name, staff_no, phone_no) VALUES('$first_name', '$middle_name', '$last_name', '$staff_no', '$phone_no') ";

            if(mysqli_query($conn, $sql)){
                $_SESSION['status'] = "Staff Added";
                $_SESSION['status_code'] = "success";
                header('Location:staff.php');
            } else {
                $_SESSION['status'] = "Staff Not Added";
                $_SESSION['status_code'] = "error";
                echo 'query error: ' . mysqli_error($conn);
            }
        } 
    }
?>


<!DOCTYPE html>
<html lang="en">
    <?php include('templates/header.php') ?>
    <link rel="stylesheet" href="css/regstyle.css">
    <link rel="stylesheet" href="sweetalert2.min.css">
<!-- <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration</title>
    <link rel="stylesheet" href="regstyle.css">
</head> -->
<script type="text/javascript" src="js/script.js"></script>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"
    integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8="
    crossorigin="anonymous">
</script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="sweetalert2.all.min.js"></script>


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
            <h3 class="i-name">Staff Registration</h3>
            <!-- <h4 class="name">Personal</h4> -->
            <form action="staff.php" method="POST">
                <div class="user-details">
                    <div class="input-box">
                        <span class="details">First Name</span>
                        <input type="text" name="first_name" placeholder="First name" value="<?php echo htmlspecialchars($first_name) ?>" >
                        <div class="red-text"><?php echo $errors['first_name']; ?></div>
                    </div>
                    <div class="input-box">
                        <span class="details">Middle Name</span>
                        <input type="text" name="middle_name" placeholder="Middle name" value="<?php echo htmlspecialchars($middle_name) ?>" >
                        <div class="red-text"><?php echo $errors['middle_name']; ?></div>
                    </div>
                    <div class="input-box">
                        <span class="details">Last Name</span>
                        <input type="text" name="last_name" placeholder="Last name" value="<?php echo htmlspecialchars($last_name) ?>" >
                        <div class="red-text"><?php echo $errors['last_name']; ?></div>
                    </div>
                    <div class="input-box">
                        <span class="details">Phone No</span>
                        <input type="text" name="phone_no" placeholder="Phone Number" value="<?php echo htmlspecialchars($phone_no) ?>" >
                        <div class="red-text"><?php echo $errors['phone_no']; ?></div>
                    </div>
                    <div class="input-box">
                        <span class="details">Staff No</span>
                        <input type="number" name="staff_no" placeholder="Staff number" value="<?php echo htmlspecialchars($staff_no) ?>" >
                        <div class="red-text"><?php echo $errors['staff_no']; ?></div>
                    </div>
                    <div class="input-box">
                        <span class="details">Role</span>
                        <select name="" id="role">
                            <option selected disabled>--Select Role--</option>
                        </select>
                    </div>
                    <div class="input-box">
                        <span class="details">Department</span>
                        <select name="" id="dept">
                            <option selected disabled>--Select Department--</option>
                        </select>
                    </div>
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
    <script>
        session_code = `<?php echo isset($_SESSION['status_code']) ? $_SESSION['status_code'] : NULL ;?>`;
        session_val = `<?php echo isset($_SESSION['status']) ? $_SESSION['status'] : NULL ;?>`;

        console.log(session_code.session_val);
        if(session_val != ''){
            Swal.fire({
                icon: session_code,
                title: session_val,
            });   
        }
    </script>
    <?php 
                unset($_SESSION['status_code']);
                unset($_SESSION['status']);
            ?>
</body>
</html>