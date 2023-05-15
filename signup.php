<?php 

    include('config/db_connect.php');

    if(isset($_POST['submit'])){

        $username = $_POST['username'];
        $phone_no = $_POST['phone_no'];
        $pwd = $_POST['pwd'];
        $pwd_repeat = $_POST['pwd_repeat'];

        require ('functions.php');

        if(emptyInputSignUp($username, $phone_no, $pwd, $pwd_repeat) !== false){
            header("location: signup.php?emptydata");
            exit();
        }
        if(invalidUid($username) !== false){
            header("location: signup.php?invalidusername");
            exit();
        }
        if(invalidPhone($phone_no) !== false){
            header("location: signup.php?error=invalidnumber");
            exit();
        }
        if(pwdMatch($pwd, $pwd_repeat) !== false){
            header("location: signup.php?passworddontmatch");
            exit();
        }
        if(uidExists($conn, $username, $phone_no) !== false){
            header("location: signup.php?userexists");
            exit();
        }

        createUser($conn, $username, $phone_no, $pwd);

    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up Page</title>
    <link rel="stylesheet" href="css/signup.css">
</head>
<body>
    <div class="loginbox">
    <h1>Sign Up</h1>
    <form action="signup.php" method="POST">
        <p>Username</p>
        <input type="text" name="username" placeholder="Enter Username">
        <p>Phone Number</p>
        <input type="text" name="phone_no" placeholder="Enter Phone Number">
        <?php 
            if(isset($_GET['error'])){
                if($_GET['error'] == "invalidnumber"){
                    echo "<h5>Invalid Phone Number</h5>";
                }
            }
        ?>
        <p>Password</p>
        <input type="password" name="pwd" placeholder="Enter Password">
        <p>Confirm Password</p>
        <input type="password" name="pwd_repeat" placeholder="Confirm Password">
        <input type="submit" name="submit" value="Sign Up">
        <a href="#">Already a User? Log In</a><br>
        <!-- <a href="#">Don't have an account?</a> -->
    </form>
</div>
</body>
</html>