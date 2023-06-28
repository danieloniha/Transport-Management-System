<?php 
    session_start();
    include('config/db_connect.php');

    $sql4 = "SELECT * FROM registration";
    $result = mysqli_query($conn, $sql4);

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

    if(isset($_GET['id'])){
        $id = $_GET['id'];
        

    $sql = "SELECT * FROM registration r, driver_penalty d, penalty p WHERE d.id = '$id' LIMIT 1" ;
    //die($sql);
    $result = mysqli_query($conn, $sql);
    $registration = mysqli_fetch_assoc($result);

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

        $sql5 = "UPDATE driver_penalty SET amount = '$amount', dof = '$dof', penalizer = '$penalizer' WHERE id = '$idnew' ";

        //$result = mysqli_query($conn, $sql);

        if(mysqli_query($conn, $sql5)){
            // success
            header('Location: penalty.php');
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
    <link rel="stylesheet" href="css/inspectstyle.css">

    <script type="text/javascript" src="js/script.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"
        integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8="
        crossorigin="anonymous">
    </script>
<body>
<?php include('templates/nav.php') ?>
    
<section id="form">
        <div class="container">
            <h3 class="i-name">Penalty</h3>
            <!-- <h4 class="name">Personal</h4> -->
            <form action="pen_edit.php?id_new=<?php echo $id; ?>" method="POST">
                
                <div class="user-details"> 
                    <div class="input-box">
                        <span class="details">Mode</span>
                        <select name="mode" id="mode" onchange="fetchDriverE(this.value)" >
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
                        <span class="details">Amount</span>
                        <input type="tel" name="amount" value="<?php echo htmlspecialchars($registration['amount']) ?> ">  
                        </select>
                    </div>
                    <div class="input-box">
                        <span class="details">Date Of Offence</span>
                        <input type="date" name="dof" value="<?php echo htmlspecialchars($registration['dof']) ?>">
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
                        
                    </div>
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