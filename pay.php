<?php
session_start();
//include('templates/security.php');
include('config/db_connect.php');

$currentUser = $_SESSION['phone_no'];

$sql = "SELECT * FROM login WHERE phone_no = '$currentUser' ";

$result = mysqli_query($conn, $sql);
if ($result) {
  $profile = mysqli_fetch_assoc($result);
  $email = $profile['email'];
  $username = $profile['username'];
} else {
  echo 'query error: ' . mysqli_error($conn);
}

// $query = "SELECT * FROM payment";
// $res = mysqli_query($conn, $query);

//$regAmount = 25000;
$sql4 = "SELECT * FROM registration WHERE phone_no = '$currentUser' ";
$res3 = mysqli_query($conn, $sql4);
$reg = mysqli_fetch_assoc($res3);
$reg_no = $reg['reg_no'];

$sql2 = "SELECT *
        FROM driver_penalty dp
        INNER JOIN penalty p ON dp.penalty_id = p.id
        WHERE dp.reg_no = '$reg_no' AND dp.status = 'Not Paid'";
//die($sql2);
$res2 = mysqli_query($conn, $sql2);

//$rowPenalty = mysqli_fetch_array($res2);
//$penaltyAmount = $rowPenalty['amount'];


?>


<!DOCTYPE html>
<html lang="en">
<?php include('templates/header.php') ?>
<link rel="stylesheet" href="css/regstyle.css">
<link rel="stylesheet" href="sweetalert2.min.css">

<script type="text/javascript" src="js/script.js"></script>
<script src="https://code.jquery.com/jquery-3.6.4.min.js" integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous">
</script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="sweetalert2.all.min.js"></script>


<body>
  <?php include('templates/nav.php') ?>

  <section id="form">
    <div class="container">
      <h3 class="i-name">Payments</h3>
      <!-- <h4 class="name">Personal</h4> -->
      <form id="paymentForm" action="pay.php" method="POST">
        <div class="user-details">
          <div class="input-box">
            <span class="details">Generate Payment</span>
            <select name="" id="payment_type">
              <option selected disabled>--Select Payment--</option>
              <?php while ($row = mysqli_fetch_array($res2)) : ?>
                <option amount = "<?php echo $row['amount']?>" value="<?php echo $row['id']; ?>"><?php echo $row['offence'].' - '.$row['amount']; ?></option>
              <?php endwhile; ?>
            </select>
          </div>
        </div>
      

      <div class="form-group">
        <!-- <label for="email">Email Address</label> -->
        <input type="hidden" id="email-address" value="<?php echo htmlspecialchars($profile['email']) ?>" required />
      </div>
      <div class="form-group">
      <?php while ($row = mysqli_fetch_array($res2)) : ?>
        <!-- <label for="amount">Amount</label> -->
        <input type="hidden" id="amount"  required />
        <?php endwhile; ?>
      </div>
      <!-- <div class="form-group">
    <label for="first-name">First Name</label>
    <input type="text" id="first-name" />
  </div>
  <div class="form-group">
    <label for="last-name">Last Name</label>
    <input type="text" id="last-name" />
  </div> -->
      <div class="button" id="submit">
        <input type="submit" onclick="payWithPaystack()"></input>
      </div>
      <div class="button2" id="cancel">
        <input type="submit" name="cancel" value="Cancel">
      </div>
      </form>


      <script src="https://js.paystack.co/v1/inline.js"></script>
    </div>
  </section>
  <script>
    $("#payment_type").on('change', function(e) {
        console.log($(this));
        $("#amount").val($("#payment_type option:selected").attr('amount'));
    });

    const paymentForm = document.getElementById('paymentForm');
    paymentForm.addEventListener("submit", payWithPaystack, false);

    function payWithPaystack(e) {
      e.preventDefault();
      let am = $("#payment_type option:selected").attr('amount');
      console.log(am);
      let handler = PaystackPop.setup({
        key: 'pk_test_dc355c64a5241254bfbc5b54a517b86cb6682723', // Replace with your public key
        email: document.getElementById("email-address").value,
        amount: am * 100,
        //amount: document.getElementById("amount").value * 100,
        ref: '' + Math.floor((Math.random() * 1000000000) + 1), // generates a pseudo-unique reference. Please replace with a reference you generated. Or remove the line entirely so our API will generate one for you
        // label: "Optional string that replaces customer email"
        onClose: function() {
          window.location = "http://localhost/project_php/pay.php?transaction=cancelled";
          alert('Transaction Cancelled.');
        },
        callback: function(response) {
          let message = 'Payment complete! Reference: ' + response.reference;
          alert(message);
          window.location = "http://localhost/project_php/verify_transaction.php?reference=" + response.reference;
        }
      });

      handler.openIframe();
    }
  </script>
</body>

</html>