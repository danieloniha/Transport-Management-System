<?php
session_start();
$ref = $_GET['reference'];
if($ref == ""){
    header('Location:javascript://history.go(-1)');
}
?>
<?php 
  $curl = curl_init();
  
  curl_setopt_array($curl, array(
    CURLOPT_URL => "https://api.paystack.co/transaction/verify/" . rawurlencode($ref),
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "GET",
    CURLOPT_HTTPHEADER => array(
      "Authorization: Bearer sk_test_c7b0e14bd5727c161a80f9bb87ebed261ae79e7d",
      "Cache-Control: no-cache",
    ),
  ));
  
  $response = curl_exec($curl);
  $err = curl_error($curl);

  curl_close($curl);
  
  if ($err) {
    echo "cURL Error #:" . $err;
  } else {
    // echo $response;
    $result = json_decode($response);
  }
  if($result->data->status == 'success'){

    $status = $result->data->status;
    $reference = $result->data->reference;
    $last_name = $result->data->customer->last_name;
    $first_name = $result->data->customer->first_name;
    $full_name = $last_name . ' ' . $first_name;
    $cus_email = $result->data->customer->email;
    date_default_timezone_set('Africa/Lagos');
    $date_time = date('m/d/Y h:i:s a', time());

    include('config/db_connect.php');
    $stmt = $conn->prepare("INSERT INTO payment_details(status, reference, full_name, date_purchased, email) VALUES(?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $status, $reference, $full_name, $date_time, $cus_email);
    $stmt->execute();
    if(!$stmt){
        echo 'There was a problem on your code' . mysqli_error($conn);
    } else {
        // header("Location: success.php?status=success");
        $currentUser = $_SESSION['phone_no'];

        $sql = "SELECT * FROM login WHERE phone_no = '$currentUser' ";        

        $result = mysqli_query($conn, $sql);
        if ($result) {
          $profile = mysqli_fetch_assoc($result);
          $email = $profile['email'];
          //$username = $profile['username'];
          $sql3 = "SELECT * FROM registration WHERE email = '$email' ";
          $res = mysqli_query($conn, $sql3);
          $reg = mysqli_fetch_assoc($res);
          $reg_no = $reg['reg_no'];
        } else {
          echo 'query error: ' . mysqli_error($conn);
        }
        $sql2 = "UPDATE driver_penalty SET status='Paid' WHERE reg_no = '$reg_no' ";
        if(mysqli_query($conn, $sql2)){
            header("Location: pay.php");
        } else {
          echo 'query error: ' . mysqli_error($conn);
        }
        exit;
    }
    $stmt->close();
    $conn->close();

  } else {
        header('Location: error.html');
    exit;
  }
?>