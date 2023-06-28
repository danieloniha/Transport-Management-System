<?php 
    session_start();
    include('config/db_connect.php');

    $currentUser = $_SESSION['id'];
    
    $sql = "SELECT * FROM login WHERE id = '$currentUser' ";

    $result = mysqli_query($conn, $sql);
    if($result){
        $profile = mysqli_fetch_assoc($result);
        $existingName = $profile['username'];
        $existingPasswordHash = $profile['password'];
    } else {
        echo 'query error: ' . mysqli_error($conn);
    }

    

    if (isset($_POST['submit'])) {
        // Handle form submission
        
        // Retrieve form inputs
        $old_password = $_POST['old_password'];
        $new_password = $_POST['new_password'];
        $name = $_POST['name'];

        // Perform validation on form inputs (e.g., check for empty fields, password strength, etc.)
        // ...
        
        // Verify the old password
        if (password_verify($old_password, $existingPasswordHash)) {
            // Old password is correct, update the new password in the database
            
            // Hash the new password
            $newPasswordHash = password_hash($new_password, PASSWORD_DEFAULT);
            
            // Update the password in the database
            $sql2 = "UPDATE login SET password = '$newPasswordHash', username = '$name' WHERE id = $currentUser";
            // $updated = mysqli_query($conn, $sql2);
            if(mysqli_query($conn, $sql2)){
                header('Location: profile.php');
            }
            
            // Display a success message or redirect to a success page
            // ...
        } else {
            // Old password is incorrect, display an error message
            // ...
        }
    }
    if(isset($_POST['cancel'])){
        header('Location: index.php');
    }
?>

<!DOCTYPE html>
<html lang="en">
    <?php include('templates/header.php') ?>
    <link rel="stylesheet" href="css/regstyle.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script type="text/javascript" src="js/script.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>

<body>

<?php include('templates/nav.php') ?>
    <section id="form">
        <div class="container2">
            <h3 class="i-name">Update Profile</h3>
            <form action="profile.php" method="POST">
                <div class="user-details">
                    
                    <div class="input-box">
                        <span class="details">Name</span>
                        <input type="name" name="name" placeholder="" value="<?php echo htmlspecialchars($profile['username'])?>" >
                    </div>
                    <div class="input-box">
                        <span class="details"></span>
                        <input type="hidden">
                    </div>
                    <div class="input-box"> 
                        <span class="details">Phone Number</span>
                        <input type="number" name="phone_no" placeholder="" value="<?php echo htmlspecialchars($profile['phone_no'])?>" >
                    </div>
                    <div class="input-box">
                        <span class="details"></span>
                        <input type="hidden">
                    </div>
                    <div class="input-box">
                        <span class="details">Old Password</span>
                        <input type="password" name="old_password" placeholder="" value="" >
                    </div>
                    <div class="input-box">
                        <span class="details"></span>
                        <input type="hidden">
                    </div>
                    <div class="input-box">
                        <span class="details">New Password</span>
                        <input type="password" name="new_password" placeholder="" value="" >
                    </div> 
        <div style="display: flex;">
        <div class="submit2 submit2_1" id="submit">
            <input type="submit" name="submit" value="Submit">
        </div>
        <div class="submit2 submit2_2" id="cancel">
            <input type="submit" name="cancel" value="Cancel">
        </div> 
        </div>                                           
            </form>
        </div>
    </section>


    <style>
        .container2 {
            width: 94%;
    margin: 30px 0 30px 30px;
    padding: 25px 30px;
    overflow: auto;
    background: white;
    border-radius: 8px;
        }

    .submit2 {
        width: 10%;
    }

    .submit2_1 {
        height: 48px;
    }

    .submit2_2 {
        height: 48px;
    }

    .submit2_1 input {
       padding: 10px;
    outline: none;
    color: white;
    border: none;
    font-size: 18px;
    font-weight: 500;
    border-radius: 4px;
    letter-spacing: 1px;
    background: #0059A5;
    }

    .submit2_2 input {
        padding: 10px;
    outline: none;
    color: rgba(0, 0, 0, 0.856);
    border: none;
    font-size: 18px;
    font-weight: 500;
    border-radius: 4px;
    letter-spacing: 1px;
    background: rgb(227, 227, 227);
    }
    </style>
</body>
</html>
