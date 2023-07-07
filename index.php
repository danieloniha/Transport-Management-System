<?php
session_start();
include('config/db_connect.php');

$query = "SELECT DISTINCT mode FROM registration";
$res = mysqli_query($conn, $query);

if (isset($_POST['submit_search'])) {
    $search = mysqli_real_escape_string($conn, $_POST['search']);

    $sql = "SELECT * FROM registration WHERE id LIKE '%$search%' OR reg_no LIKE '%$search%' OR first_name LIKE '%$search%' OR last_name LIKE '%$search%' OR phone_no LIKE '%$search%' OR mode LIKE '%$search%'";

    $result = mysqli_query($conn, $sql);
    $registration = mysqli_fetch_all($result, MYSQLI_ASSOC);
} else if (isset($_POST['request'])) {
    $request = $_POST['id'];
    $request = trim($request);
    if ($request === "All") {
        $query = "SELECT * FROM registration";
        $result = mysqli_query($conn, $query);
        $registration = mysqli_fetch_all($result, MYSQLI_ASSOC);
    } else {
        $query = "SELECT * FROM registration WHERE mode='{$request}'";
        $result = mysqli_query($conn, $query);
        $registration = mysqli_fetch_all($result, MYSQLI_ASSOC);
    }
} else {
    $sql = "SELECT * FROM registration";
    $result = mysqli_query($conn, $sql);
    $registration = mysqli_fetch_all($result, MYSQLI_ASSOC);

    // mysqli_free_result($result);
    // mysqli_close($conn);
}

if (isset($_SESSION['phone_no']) && $_SESSION['phone_no'] !== null) {
    $currentUser = $_SESSION['phone_no'];
    // Rest of your code...
} else {
    // Handle the case when 'id' is not set or null
}

$sql = "SELECT * FROM login WHERE phone_no = '$currentUser' ";
// echo $currentUser;
$result = mysqli_query($conn, $sql);
if ($result) {
    $profile = mysqli_fetch_assoc($result);
    // print_r($profile);
    $user = $profile['usertype'];
} else {
    echo 'query error: ' . mysqli_error($conn);
}

if ($user == 'user') {
    $hideCard1 = true;
    $hideCard2 = true;
    $hideCard3 = false;
    $hideCard4 = false;
}
if ($user == 'admin') {
    $hideCard1 = false;
    $hideCard2 = false;
    $hideCard3 = true;
    $hideCard4 = true;
}

$sql2 = "SELECT SUM(amount) AS total_amount FROM driver_penalty WHERE status = 'Paid'";
$result2 = mysqli_query($conn, $sql2);

// Check if the query was successful
if ($result2) {
    // Fetch the total amount from the result set
    $row = mysqli_fetch_assoc($result2);
    $totalAmount = $row['total_amount'];
} else {
    // Handle the error case
    $totalAmount = 'N/A';
    echo 'Query error: ' . mysqli_error($conn);
}

?>



<!DOCTYPE html>
<html lang="en">
<?php include('templates/header.php') ?>
<link rel="stylesheet" href="css/tabstyle.css">
<script type="text/javascript" src="js/script.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>


<body>
    <?php include('templates/nav.php') ?>


    <section id="interface">
        <div class="navigation">
            <div class="n1">
                <form action="index.php" method="POST">
                    <div class="search">
                        <i class="fa fa-search"></i>
                        <input type="text" name="search" placeholder="Search">
                        <input type="submit" name="submit_search" value="Search"></input>
                    </div>
                </form>
            </div>
            <div class="profile">
                <i class="fa fa-bell"></i>
            </div>
        </div>
        <h3 class="i-name">
            Dashboard
        </h3>
        <div class="cards">


            <div class="card-single" <?php if ($hideCard1) echo 'style="display: none;"'; ?>>
                <a href="table.php">
                    <div>
                        <?php
                        $dash_drivers = "SELECT * FROM registration";
                        $dash_drivers_num = mysqli_query($conn, $dash_drivers);

                        if ($dash_total = mysqli_num_rows($dash_drivers_num)) {
                            echo '<h1>' . $dash_total . '</h1>';
                        } else {
                            echo '<h1>0</h1>';
                        }

                        ?>

                        <span class="card-text">Drivers</span>
                    </div>
                    <div>
                        <span class="fa fa-solid fa-car" style="color: #0059a5;" aria-hidden="true"></span>
                    </div>
                </a>
            </div>

            <div class="card-single" <?php if ($hideCard2) echo 'style="display: none;"'; ?>>
                <div>
                    <h1><?php echo $totalAmount; ?></h1>
                    <span class="card-text">Payments</span>
                </div>
                <div>
                    <span class="fa fa-duotone fa-book" style="color: #0059a5;" aria-hidden="true"></span>
                </div>
            </div>
            <div class="card-single" <?php if ($hideCard3) echo 'style="display: none;"'; ?>>
                <div>
                    <!-- <?php
                    $dash_penalty = "SELECT * FROM driver_penalty";
                    $dash_penalty_num = mysqli_query($conn, $dash_penalty);

                    if ($dash_totalP = mysqli_num_rows($dash_penalty_num)) {
                        echo '<h1>' . $dash_totalP . '</h1>';
                    } else {
                        echo '<h1>0</h1>';
                    }
                    ?> -->
                    <h1>0</h1>
                    <span class="card-text">Penalties</span>
                </div>
                <div>
                    <span class="fa fa-solid fa-flag" style="color: #0059a5;" aria-hidden="true"></span>
                </div>
            </div>
            <div class="card-single" <?php if ($hideCard4) echo 'style="display: none;"'; ?>>
                <div>
                    <h1>0</h1>
                    <span class="card-text">Messages</span>
                </div>
                <div>
                    <span class="fa fa-duotone fa-book" style="color: #0059a5;" aria-hidden="true"></span>
                </div>
            </div>

        </div>

        <!-- Index B -->
        <script>
            document.addEventListener("DOMContentLoaded", () => {
                const rows = document.querySelectorAll("tr[data-href]");

                rows.forEach(row => {
                    row.addEventListener("click", () => {
                        window.location.href = row.dataset.href;
                    });
                });
            });



            $(document).ready(function() {
                $(document.body).on("click", "tr[data-href]", function() {
                    window.location.href = this.dataset.href;
                });
            });
        </script>
        <script>
            // Count the number of visible cards
            const visibleCards = document.querySelectorAll('.card-single:not(.hidden)').length;

            // Calculate the new grid-template-columns value
            const gridTemplateColumns = `repeat(${visibleCards}, 1fr)`;

            // Apply the updated grid-template-columns property to the .cards container
            document.querySelector('.cards').style.gridTemplateColumns = gridTemplateColumns;
        </script>
    </section>

</body>

</html>
<?php
mysqli_free_result($result);
mysqli_close($conn);
?>