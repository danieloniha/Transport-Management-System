<?php 

    include('config/db_connect.php');

    if(isset($_POST['submit'])){

        $phone_no = $_POST['phone_no'];
        $pwd = $_POST['pwd'];

        require ('functions.php');

        if(emptyInputLogin($phone_no, $pwd) !== false){
            header("location: login.php?emptydata");
            exit();
        }

        loginUser($conn, $phone_no, $pwd);
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="stylesheet" href="css/login.css">
</head>
<body>
    <div class="loginbox">
    <h1>Login</h1>
    <form action="login.php" method="POST">
        <p>Phone Number</p>
        <input type="text" name="phone_no" placeholder="Enter Phone Number">
        <p>Password</p>
        <input type="password" name="pwd" placeholder="Enter Password">
        <input type="submit" name="submit" value="Login">
        <a href="#">Forgot your password?</a><br>
        <a href="#">Don't have an account?</a>
    </form>
</div>
</body>
</html>