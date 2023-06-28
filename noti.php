<?php 

    session_start();
    include('config/db_connect.php');

    $current_user = $_SESSION['phone_no'];
    
    $sql = "SELECT * FROM registration WHERE phone_no = '$current_user' ";
    $result = mysqli_query($conn, $sql);
    if($result){
        $profile = mysqli_fetch_assoc($result);
        $reg_no = $profile['reg_no'];
    } else {
        echo 'query error: ' . mysqli_error($conn);
    }
    //die($reg_no);

    $sql2 = "SELECT * FROM notification WHERE reg_no = '$reg_no' ";
    $result2 = mysqli_query($conn, $sql2);
    //$msg = mysqli_fetch_array($result2);

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
            <h3 class="i-name">Notification</h3>
            <!-- <h4 class="name">Personal</h4> -->
            <?php while ($row = mysqli_fetch_array($result2)) : ?>
                <h4><?php echo $row['title'] ?></h4>
                <h6><?php echo $row['message'] ?></h6>
            <?php endwhile; ?>    
            
        </div>
    </section>
</body>
</html>