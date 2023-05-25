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
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Login</title>
  <link rel="stylesheet" href="css/login.css">
  <!-- <link rel="stylesheet" href="style.css"> -->
</head>
<body>
  <div class="container">
    <input type="checkbox" id="check">
    <div class="login form">
      <header>Login</header>
      <form action="login.php" method="POST">
        <input type="text" name="phone_no" placeholder="Enter Username">
        <input type="password" name="pwd" placeholder="Enter Password">
        <a href="#">Forgot password?</a>
        <input type="submit" name="submit" class="button" value="LOGIN">
      </form>
      <div class="signup">
        <span class="signup">Don't have an account?
         <a href="signup.php"><label for="">Signup</label></a>
        </span>
      </div>
    </div>
    
  </div>
</body>
</html>
