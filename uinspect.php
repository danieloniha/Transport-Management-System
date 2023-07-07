<?php
    require_once __DIR__ . '/vendor/autoload.php';

    use Mpdf\Mpdf;

    session_start();
    include('config/db_connect.php');

    

    if(isset($_SESSION['phone_no'])){
        $id = $_SESSION['phone_no'];
        
    } else {
        exit('ID not provided');
        }
    
    $sql = "SELECT * FROM registration WHERE phone_no = '$id' ";
    
    $result = mysqli_query($conn, $sql);
    $reg = mysqli_fetch_array($result);

    $reg_no = $name = $start_work = $drivers_license = $payment_year = $rrr = $amount = $receipt = $date = '';
    $errors = array('reg_no' => '', 'name' => '', 'start_work' => '', 'drivers_license' => '', 'payment_year' => '', 'rrr' => '', 'amount' => '', 'receipt' => '', 'date' => '');

    if(isset($_POST['save'])){
        if(empty($_POST['start_work'])){
            $errors['start_work'] = 'This is required <br />';
        } else {
            $start_work = $_POST['start_work'];
        }

        if(empty($_POST['drivers_license'])){
            $errors['drivers_license'] = 'Drivers License is required <br />';
        } else {
            $drivers_license = $_POST['drivers_license'];
        }

        if(empty($_POST['payment_year'])){
            $errors['payment_year'] = 'This is required <br />';
        } else {
            $phone_no = $_POST['payment_year'];
            if(!preg_match('/^[0-9]{4}+$/', $phone_no)) {
                $errors['payment_year'] = "Write a Valid Year";
            }
        }

        if(empty($_POST['rrr'])){
            $errors['rrr'] = 'This is required <br />';
        } else {
            $rrr = $_POST['rrr'];
        }

        if(empty($_POST['amount'])){
            $errors['amount'] = 'This is required <br />';
        } else {
            $amount = $_POST['amount'];
        }

        if(empty($_POST['receipt'])){
            $errors['receipt'] = 'This is required <br />';
        } else {
            $receipt = $_POST['receipt'];
        }

        if(empty($_POST['date'])){
            $errors['date'] = 'This is required <br />';
        } else {
            $date = $_POST['date'];
        }

        if(array_filter($errors)){

        } else {

            $reg_no = mysqli_real_escape_string($conn, $_POST['reg_no']);
            $name = mysqli_real_escape_string($conn, $_POST['name']);
            $start_work = mysqli_real_escape_string($conn, $_POST['start_work']);
            $drivers_license = mysqli_real_escape_string($conn, $_POST['drivers_license']);
            $payment_year = mysqli_real_escape_string($conn, $_POST['payment_year']);
            $rrr = mysqli_real_escape_string($conn, $_POST['rrr']);
            $amount = mysqli_real_escape_string($conn, $_POST['amount']);
            $receipt = mysqli_real_escape_string($conn, $_POST['receipt']);
            $date = mysqli_real_escape_string($conn, $_POST['date']);

            $sql = "INSERT INTO user_inspect(reg_no, name, start_work, drivers_license, payment_year, rrr, amount, receipt, date)
            VALUES('$reg_no', '$name', '$start_work', '$drivers_license', '$payment_year', '$rrr', '$amount', '$receipt', '$date')";
            

            if(mysqli_query($conn, $sql)){
                $_SESSION['status'] = "Form Submitted";
                $_SESSION['status_code'] = "success";
                $data = '';
                $data.='<h1>Your Details</h1>';

                $data.= '<strong>Reg No</strong>' . $reg_no . '<br />';
                $data.= '<strong>Name</strong>' . $name . '<br />';
                $data.= '<strong>Work Date</strong>' . $start_work . '<br />';
                $data.= '<strong>Drivers License</strong>' . $drivers_license . '<br />';
                $data.= '<strong>Year of Payment</strong>' . $payment_year . '<br />';
                $data.= '<strong>RRR Number</strong>' . $rrr . '<br />';
                $data.= '<strong>Amount</strong>' . $amount . '<br />';
                $data.= '<strong>Receipt</strong>' . $receipt . '<br />';
                $data.= '<strong>Date</strong>' . $date . '<br />';

                $mpdf = new Mpdf();
                ob_start();
                $mpdf->WriteHTML($data);
                $pdfContent = ob_get_contents();
                ob_end_clean();

                $mpdf->Output('Inspection File.pdf', 'D');
                echo $pdfContent;
                header('Location:uinspect.php');
            } else {
                $_SESSION['status'] = "Error";
                $_SESSION['status_code'] = "error";
                echo 'query error: ' . mysqli_error($conn);
            }
        
    }
    
}

    if(isset($_POST['cancel'])){
        header('Location: index.php');
    }
    
?>



<!DOCTYPE html>
<html lang="en">
    <?php include('templates/header.php') ?>
    <link rel="stylesheet" href="css/inspectstyle.css">
    <script type="text/javascript" src="js/script.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"
    integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8="
    crossorigin="anonymous"></script>
<body>
<?php include('templates/nav.php') ?>
    
    <section id="form">
        <div class="container">
            <h3 class="i-name">Inspection</h3> 
            <form action="uinspect.php?id=<?php echo $id; ?>" method="POST">
                <div class="user-details">
                    <div class="input-box">
                        <span class="details">Name</span>
                        <input type="text" name="name" placeholder="Name" value="<?php echo htmlspecialchars($reg['first_name']) . ' ' . $reg['last_name']; ?>" readonly >
                    </div>
                    <div class="input-box">
                        <span class="details">Reg No</span>
                        <input type="text" name="reg_no" placeholder="Reg No" value="<?php echo htmlspecialchars($reg['reg_no']) ?>" readonly>
                    </div>
                    <div class="input-box">
                        <span class="details">When did you start working?</span>
                        <input type="date" name="start_work" placeholder="" value="" >
                        <div class="red-text"><?php echo $errors['start_work']; ?></div>
                    </div>
                    <div class="input-box">
                        <span class="details">Drivers License</span>
                        <input type="text" name="drivers_license" placeholder="" value="<?php echo htmlspecialchars($reg['drivers_license']) ?>" >
                        <div class="red-text"><?php echo $errors['drivers_license']; ?></div>
                    </div>
                    <div class="input-box">
                        <span class="details">Payment Year</span>
                        <input type="tel" name="payment_year" placeholder="Year" value="" >
                        <div class="red-text"><?php echo $errors['payment_year']; ?></div>
                    </div>
                    <div class="input-box">
                        <span class="details">RRR Number</span>
                        <input type="text" name="rrr" placeholder="" value="" >
                        <div class="red-text"><?php echo $errors['rrr']; ?></div>
                    </div>
                    <div class="input-box">
                        <span class="details">Amount Paid</span>
                        <input type="text" name="amount" placeholder="Amount" value="" >
                        <div class="red-text"><?php echo $errors['amount']; ?></div>
                    </div>
                    <div class="input-box">
                        <span class="details">Receipt No</span>
                        <input type="text" name="receipt" placeholder="Receipt No" value="" >
                        <div class="red-text"><?php echo $errors['receipt']; ?></div>
                    </div>
                    <div class="input-box">
                        <span class="details">Date of Payment</span>
                        <input type="date" name="date" placeholder="" value="" >
                        <div class="red-text"><?php echo $errors['date']; ?></div>
                    </div>
                </div>
                <h6 style="padding-bottom: 8px; font-weight:bold;" >INSTRUCTIONS</h6>
                <h6>-Come along with your vehicle papers</h6>
                <h6>-Ensure the vehicle state is in good condition</h6>
                <div class="button" id="submit">
                    <input type="submit" name="save" value="Submit">
                </div>
                <div class="button2" id="cancel">
                    <input type="submit" name="cancel" value="Cancel">
                </div>
            </form>
        </div>
    </section>
    <?php

    

    
?>
</body>
</html>

