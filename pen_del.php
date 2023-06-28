<?php 

    include('config/db_connect.php');

    if(isset($_GET['id'])){
        $id = $_GET['id'];
    }

    // $sql1 = "SELECT * FROM driver_penalty WHERE id = '$id' ";
    // $result = mysqli_query($conn, $sql1);
    // $registration = mysqli_fetch_assoc($result);
    // $reg_no = $registration['reg_no'];

    $sql = "DELETE FROM driver_penalty WHERE id = '$id' ";
    //die($sql);

    if(mysqli_query($conn, $sql)){
        header('Location: penalty.php');
        
    } else {
        echo 'query error: ' . mysqli_error($conn);
    }

?>