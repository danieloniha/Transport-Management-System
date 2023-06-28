<?php 

    include('config/db_connect.php');

    if(isset($_GET['id'])){
        $id = $_GET['id'];
    }

    $sql1 = "SELECT * FROM registration WHERE id = '$id' ";
    $result = mysqli_query($conn, $sql1);
    $registration = mysqli_fetch_assoc($result);
    $reg_no = $registration['reg_no'];

    $sql = "DELETE FROM registration WHERE id = '$id' ";
    $sql2 = "DELETE FROM vehicle WHERE reg_no = '$reg_no' ";

    if(mysqli_query($conn, $sql2)){

        if(mysqli_query($conn, $sql)){
        } else {
            echo 'query error: ' . mysqli_error($conn);
        }
        header('Location: table.php');
    } else {
        echo 'query error: ' . mysqli_error($conn);
    }

?>