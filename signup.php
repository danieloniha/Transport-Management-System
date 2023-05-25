<?php 

    include('config/db_connect.php');

    $errors = "";

    if(isset($_POST['submit'])){

        $username = $_POST['username'];
        $phone_no = $_POST['phone_no'];
        $pwd = $_POST['pwd'];
        $pwd_repeat = $_POST['pwd_repeat'];

        require ('functions.php');

        if(emptyInputSignUp($username, $phone_no, $pwd, $pwd_repeat) !== false){
            $errors = "empty data";
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
            $errors = "Password don't match";
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
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Sign Up</title>
  <link rel="stylesheet" href="css/login.css">
  <!-- <link rel="stylesheet" href="style.css"> -->
</head>
<body>
  <div class="container">
    <input type="checkbox" id="check">
    <div class="login form">
    <header>Signup</header>
    <p class="errors"><?php echo $errors; ?></p>
      <form action="signup.php" method="POST">
        <input type="text" name="username" placeholder="Enter Username">
        <input type="text" name="phone_no" placeholder="Enter Phone Number">
        <input type="password" name="pwd" placeholder="Enter your password">
        <input type="password" name="pwd_repeat" placeholder="Confirm your password">
        <input type="submit" name="submit" class="button" value="SIGN UP">
      </form>
      <div class="signup">
        <span class="signup">Already have an account?
         <a href="login.php"><label for="">Login</label></a>
        </span>
      </div>
    </div>
    <div class="registration form">
      <header>Signup</header>
      <form action="signup.php" method="POST">
        <input type="text" name="username" placeholder="Enter Username">
        <input type="text" name="phone_no" placeholder="Enter Phone Number">
        <input type="password" name="pwd" placeholder="Enter your password">
        <input type="password" name="pwd_repeat" placeholder="Confirm your password">
        <input type="submit" name="submit1" class="button" value="SIGN UP">
      </form>
      <div class="signup">
        <span class="signup">Already have an account?
         <label for="check">Login</label>
        </span>
      </div>
    </div>
  </div>
</body>
</html>
