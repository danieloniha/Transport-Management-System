<?php
    session_start();
    include('config/db_connect.php');

    $driver = $offence = $penalizer = '';
    $errors = array('driver' => '', 'offence' => '', 'penalizer' => '');

    $sql = "SELECT * FROM registration";
    $result = mysqli_query($conn, $sql);

    $query = "SELECT * FROM penalty";
    $result2 = mysqli_query($conn, $query);

    $query2 = "SELECT DISTINCT mode FROM registration";
    $res = mysqli_query($conn, $query2);

    $query3 = "SELECT * FROM staff";
    $res2 = mysqli_query($conn, $query3);

    if(isset($_POST['mode_id'])){
        $mode_id = $_POST['mode_id'];
        $query = "SELECT * FROM registration WHERE `mode` = '$_POST[mode_id]' ";
        //print_r($query);
        // die('ok');
        // $result = $db->query($query);
        
        $result = mysqli_query($conn, $query);
        if(mysqli_num_rows($result)> 0){
            echo '<option disabled value="" >Select Vehicle No</option>';
            while($row = mysqli_fetch_assoc($result)){
                echo '<option value='.$row['id'].'>'.$row['reg_no'].'</option>';
            }
        } else {
            echo '<option value="">No Driver Record </option>';
        }
    }

    if(isset($_POST['submit'])){

        if(empty($_POST['driver'])){
            $errors['driver'] = 'This field is required <br />';
        } else {
            $driver = $_POST['driver'];
        }

        if(empty($_POST['offence'])){
            $errors['offence'] = 'This field is required <br />';
        } else {
            $offence = $_POST['offence'];
        }

        if(empty($_POST['penalizer'])){
            $errors['penalizer'] = 'This field is required <br />';
        } else {
            $penalizer = $_POST['penalizer'];
        }

        if(array_filter($errors)){

        } else {

            $driver = mysqli_real_escape_string($conn, $_POST['driver']);
            $offence = mysqli_real_escape_string($conn, $_POST['offence']);
            $penalizer = mysqli_real_escape_string($conn, $_POST['penalizer']);

            $sql2 = "SELECT * FROM registration WHERE id = '$driver' ";
            //print_r($sql2);
            $result3 = mysqli_query($conn, $sql2);
            $registration = mysqli_fetch_assoc($result3);
            //print_r($registration);
            $reg_no = $registration['reg_no'];
            

            $sql3 = "SELECT * FROM penalty WHERE id = '$offence' ";
            $result4 = mysqli_query($conn, $sql3);
            $penalty = mysqli_fetch_assoc($result4);
            $id = $penalty['id'];

            $amount = mysqli_real_escape_string($conn, $_POST['amount']);
            $dof = mysqli_real_escape_string($conn, $_POST['dof']);

            $sql4 = "INSERT INTO driver_penalty(reg_no, penalty_id, amount, penalizer, dof) VALUES('$reg_no', '$id', '$amount', '$penalizer', '$dof') ";

            if(mysqli_query($conn, $sql4)){
                   
                // $sql6 = "SELECT * FROM driver_penalty WHERE pen_id = '$id' ";
                $title = "Penalty";
                $pen = $penalty['offence'];
                $message = "You have been penalized for $pen with the amount of $amount";
                $sql5 = "INSERT INTO notification(reg_no, title, message)VALUES('$reg_no', '$title', '$message') ";
                

                if(mysqli_query($conn, $sql5)){
                    // success
                    $_SESSION['status'] = "Driver Penalized";
                    $_SESSION['status_code'] = "success";
                    header('Location: penalty.php');
                } else {
                    // error
                    $_SESSION['status'] = "Error";
                    $_SESSION['status_code'] = "error";
                    echo 'query error: ' . mysqli_error($conn);
                }
                
            } else {
                // error
                echo 'query error: ' . mysqli_error($conn);
            }

        }   
    }

    if(isset($_POST['cancel'])){
        header('Location: penalty.php');
    }
?>


<!DOCTYPE html>
<html lang="en">
    <?php include('templates/header.php') ?>
    <link rel="stylesheet" href="css/inspectstyle.css">
    <link rel="stylesheet" href="sweetalert2.min.css">
<!-- <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration</title>
    <link rel="stylesheet" href="regstyle.css">
</head> -->
<script type="text/javascript" src="js/script.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"
    integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8="
    crossorigin="anonymous">
</script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="sweetalert2.all.min.js"></script>
<!-- <script>
    $(document).ready(function(){
        $("#offence").on('change',function(){
            var value = $(this).val();
            $.ajax({
            url:"fetch_offence.php",
            method: "POST",
            data: 'request=' + value,
            
            success:function(data){
                $('#penalty').html(data);
            }
            })
        })

    })
</script> -->
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
            <h3 class="i-name">Penalty</h3>
            <!-- <h4 class="name">Personal</h4> -->
            <form action="pen_form.php" method="POST">

                <div class="user-details"> 
                    <div class="input-box">
                        <span class="details">Mode</span>
                        <select name="mode" id="mode" onchange="fetchDriver(this.value)" >
                            <option >--Select--</option>
                            <?php while($row = mysqli_fetch_array($res)): ?>
                            <option value="<?php echo $row['mode']; ?>"><?php echo $row['mode']; ?></option>
                        <?php endwhile; ?>
                        </select>
                    </div>
                    <div class="input-box">
                        <span class="details">Vehicle No</span>
                        <select name="driver" id="driver" > 
                        </select>
                        <div class="red-text"><?php echo $errors['driver']; ?></div>
                    </div>
                </div>
                <div class="user-details">
                    <div class="input-box">
                            <span class="details">Penalty</span>
                            <select name="offence" id="offence">
                                <option >--Select--</option>
                                <!-- <option value="">Overspeeding</option>
                                <option value="">Skipped Vehicle Inspection</option> -->
                                <?php while($row = mysqli_fetch_array($result2)){ ?>
                                <option value="<?php echo $row[0]; ?>"><?php echo $row[1] . ' - ' . $row[2] ?></option>
                                <?php } ?>
                            </select>
                            <div class="red-text"><?php echo $errors['offence']; ?></div>
                            <p id="penalty"></p>
                    </div>
                    <div class="input-box">
                        <span class="details">Amount</span>
                        <input type="tel" name="amount">   
                        </select>
                    </div>
                    <div class="input-box">
                        <span class="details">Date Of Offence</span>
                        <input type="date" name="dof" value="dof">
                        </select>
                    </div>
                    <div class="input-box">
                        <span class="details">Name of Penalizer</span>
                        <select name="penalizer" id="penalizer"> 
                        <option value="" >--Select--</option>
                        <?php while($row = mysqli_fetch_array($res2)){ ?>
                        <option value="<?php echo $row[0]; ?>"><?php echo $row[1] . ' ' . $row[3] ?></option>
                        <?php } ?>
                        </select>
                        <div class="red-text"><?php echo $errors['penalizer']; ?></div>
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