<?php

    include('config/db_connect.php');

    $sql = "SELECT * FROM registration";
    $result = mysqli_query($conn, $sql);

    $query = "SELECT * FROM penalty";
    $result2 = mysqli_query($conn, $query);

    $query2 = "SELECT DISTINCT mode FROM registration";
    $res = mysqli_query($conn, $query2);

    if(isset($_POST['mode_id'])){
        $mode_id = $_POST['mode_id'];
        $query = "SELECT * FROM registration WHERE `mode` = '$_POST[mode_id]' ";
        //print_r($query);
        // die('ok');
        // $result = $db->query($query);
        
        $result = mysqli_query($conn, $query);
        if(mysqli_num_rows($result)> 0){
            echo '<option disabled value="" >Select Driver</option>';
            while($row = mysqli_fetch_assoc($result)){
                echo '<option value='.$row['reg_no'].'>'.$row['first_name'].'</option>';
            }
        } else {
            echo '<option value="">No Driver Record </option>';
        }
    }

    if(isset($_POST['submit'])){

        $driver = $_POST['driver'];
        $offence = $_POST['offence'];

        $sql2 = "SELECT * FROM registration WHERE id = '$driver' ";
        print_r($sql2);
        $result3 = mysqli_query($conn, $sql2);
        $registration = mysqli_fetch_assoc($result3);
        print_r($registration);
        $reg_no = $registration['reg_no'];
        

        $sql3 = "SELECT * FROM penalty WHERE id = '$offence' ";
        $result4 = mysqli_query($conn, $sql3);
        $penalty = mysqli_fetch_assoc($result4);
        $id = $penalty['id'];

        $sql4 = "INSERT INTO driver_penalty(reg_no, penalty_id) VALUES('$reg_no', '$id') ";

        if(mysqli_query($conn, $sql4)){
            
            header('Location: pen_form.php');

            if(mysqli_query($conn, $sql5)){
                // success
            } else {
                // error
                echo 'query error: ' . mysqli_error($conn);
            }
            
        } else {
            // error
            echo 'query error: ' . mysqli_error($conn);
        }
    }

?>


<!DOCTYPE html>
<html lang="en">
    <?php include('templates/header.php') ?>
    <link rel="stylesheet" href="css/inspectstyle.css">
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
                        <select name="mode" id="mode" onchange="fetchDriver(this.value)" required>
                            <option >--Select--</option>
                            <?php while($row = mysqli_fetch_array($res)): ?>
                            <option value="<?php echo $row['mode']; ?>"><?php echo $row['mode']; ?></option>
                        <?php endwhile; ?>
                        </select>
                    </div>
                    <div class="input-box">
                        <span class="details">Driver</span>
                        <select name="driver" id="driver"  required> 
                        </select>
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
                            <p id="penalty"></p>
                    </div>
                    <div class="input-box">
                        <span class="details">Date Of Offence</span>
                        <input type="date">
                        </select>
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