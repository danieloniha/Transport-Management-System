<?php 
  //session_start();
  include('config/db_connect.php');
  
  if (isset($_SESSION['phone_no']) && $_SESSION['phone_no'] !== null) {
    $currentUser = $_SESSION['phone_no'];
    // Rest of your code...
} else {
    // Handle the case when 'id' is not set or null
}

  $sql = "SELECT * FROM login WHERE phone_no = '$currentUser' ";
  // echo $currentUser;
  $result = mysqli_query($conn, $sql);
    if($result){
        $profile = mysqli_fetch_assoc($result);
        // print_r($profile);
        $user = $profile['usertype'];
    } else {
        echo 'query error: ' . mysqli_error($conn);
    }

?>

<?php include('templates/header.php') ?>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<section id='menu'>
        <div class="logo">
            <?php $directory = __DIR__;
                $logoPath = $directory.'/Images/University-of-Lagos-courses.jpg';
                // echo $logoPath;
            ?>
            <img src="Images/University-of-Lagos-courses.jpg" alt=""> 
            <h5>University Of Lagos</h5>
        </div>
        <div class="items">
          <?php if($user == 'admin'): ?>
            <a href="index.php"><li><i class="fa fa-pie-chart" aria-hidden="true"></i>Dashboard</li></a>
          <?php endif; ?>
          <?php if($user == 'user'): ?>
            <a href="index2.php"><li><i class="fa fa-pie-chart" aria-hidden="true"></i>Dashboard</li></a>
          <?php endif; ?>
          <?php if($user == 'admin'): ?>
            <a href="form.php"><li><i class="fa fa-regular fa-table" aria-hidden="true"></i>Driver Registration</li></a>
          <?php endif; ?>
          <?php if($user == 'user'): ?>
            <a href="uupdate.php"><li><i class="fa fa-regular fa-table" aria-hidden="true"></i>Edit Registration</li></a>
          <?php endif; ?>
          <?php if($user == 'admin'): ?>
            <a href="staff.php"><li><i class="fa fa-solid fa-user" aria-hidden="true"></i>Staff Registration</li></a>
          <?php endif; ?>

          <?php if($user == 'admin'): ?>
          <a href="inspect.php"><li><i class="fa fa-solid fa-car" aria-hidden="true"></i>Process Inspection</li></a>
          <?php endif; ?>

          <?php if($user == 'user'): ?>
          <a href="uinspect.php"><li><i class="fa fa-solid fa-car" aria-hidden="true"></i>Inspection</li></a>
          <?php endif; ?>

          <?php if($user == 'admin'): ?>
          <a href="penalty.php"><li><i class="fa fa-solid fa-flag"></i>Penalty</li></a>
          <?php endif; ?>

          <?php if($user == 'admin'): ?>
            <a href="table.php"><li><i class="fa fa-regular fa-table"></i>Driver Details</li></a>
          <?php endif; ?>

          <a href="pay.php"><li><i class="fa fa-solid fa-credit-card"></i>Payments</li></a>

          <?php if($user == 'user'): ?>
          <a href="noti.php"><li><i class="fa fa-bell" aria-hidden="true"></i>Notifications</li></a>
          <?php endif; ?>

          <?php if($user == 'admin'): ?>
            <a href="report.php"><li><i class="fa fa-solid fa-folder"></i>Report</li></a>
          <?php endif; ?>

          <a href="profile.php"><li><i class="fa fa-solid fa-key"></i>Change Password</li></a>
          <a href="#" data-toggle="modal" data-target="#logoutModal"><li class="logout"><i class="fa fa-solid fa-arrow-right-from-arc"></i>Log Out</li></a>
        </div>
    </section>

    <!-- Logout Modal-->
  <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true"></span>
          </button>
        </div>
        <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>

          <form action="logout.php" method="POST"> 
          
            <button type="submit" name="logout_btn" class="btn btn-primary">Logout</button>

          </form>


        </div>
      </div>
    </div>
  </div>