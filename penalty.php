<?php
session_start();
include('config/db_connect.php');

$sql = "SELECT * FROM registration r, penalty p, driver_penalty d WHERE r.reg_no = d.reg_no AND d.penalty_id = p.id";
// $sql = "SELECT registration.*, driver_penalty.*, penalty.*
// FROM registration
// JOIN driver_penalty ON registration.reg_no = driver_penalty.reg_no
// JOIN penalty ON driver_penalty.penalty_id = penalty.id
// WHERE registration.reg_no = 'reg_no'
// AND penalty.id = 'id';
// ";
$result = mysqli_query($conn, $sql);
// if($result){
//     while($row = mysqli_fetch_assoc($result)){

//     }
// } else {
//     echo 'query error: ' . mysqli_error($conn);
// }
//die($result);
$penalties = mysqli_fetch_all($result, MYSQLI_ASSOC);
// $query = "SELECT * FROM driver_penalty";
// $res = mysqli_query($conn, $query);
// $pen = mysqli_fetch_assoc($res);
?>




<!DOCTYPE html>
<html lang="en">
<?php include('templates/header.php') ?>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<link rel="stylesheet" href="css/penstyle.css">
<link rel="stylesheet" href="sweetalert2.min.css">

<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="sweetalert2.all.min.js"></script>

<body>
    <?php include('templates/nav.php') ?>
    <!-- <section id='menu'>
        <div class="logo">
            <img src="/Images/University-of-Lagos-courses.jpg" alt=""> 
            <h2>University Of Lagos</h2>
        </div>
        <div class="items">
            <li><i class="fa fa-pie-chart" aria-hidden="true"></i><a href="#">Dashboard</a></li>
            <li><i class="fa fa-user" aria-hidden="true"></i><a href="#">Manage Profile</a></li>
            <li><i class="fa fa-pie-chart" aria-hidden="true"></i><a href="#">Status</a></li>
            <li><i class="fa fa-cog" aria-hidden="true"></i><a href="#">Settings</a></li>
        </div>
    </section> -->

    <section id="interface">
        <div class="navigation">
            <div class="n1">
                <form action="table.php" method="POST">
                    <div class="search">
                        <i class="fa fa-search"></i>
                        <input type="text" name="search" placeholder="Search">
                        <input type="submit" name="submit_search" value="Search"></input>
                    </div>
            </div>
            </form>
            <div class="profile">
                <i class="fa fa-bell"></i>
            </div>
        </div>
        <h3 class="i-name">
            Penalty
        </h3>
        <div class="button" id="submit">
            <a href="pen_form.php"><input type="submit" value="Penalize Driver"></a>
        </div>
        <div class="button" id="submit" style="color: green;">
            <a href="export.php"><input type="submit" value="Export"></a>
        </div>
        <div class="board">
            <?php if (isset($_SESSION['status'])) {
            ?>
                <div class="alert alert-success" role="alert">
                    <?php echo $_SESSION['status']; ?>
                </div>
            <?php
                
                unset($_SESSION['status']);
            }
            ?>
            <table width="100%">
                <thead>
                    <tr>
                        <td>No</td>
                        <td>RegNo</td>
                        <td>Name</td>
                        <td>Mode</td>
                        <td>Offence</td>
                        <td>Penalty</td>
                        <td></td>
                    </tr>
                </thead>
                <tbody>
                    <?php $count = 1;
                    foreach ($penalties as $penalty) { ?>
                        <tr scope="row">
                            <td class="driver">
                                <div class="driver-id">
                                    <h5><?php echo $count++; ?></h5>
                                </div>
                            </td>
                            <td class="driver">
                                <div class="driver-de">
                                    <h5><?php echo htmlspecialchars($penalty['reg_no']); ?></h5>
                                </div>
                            </td>
                            <td class="driver-phone">
                                <h5><?php echo htmlspecialchars($penalty['first_name'] . ' ' . $penalty['last_name']); ?></h5>
                            </td>
                            <td class="driver-plate">
                                <h5><?php echo htmlspecialchars($penalty['mode']); ?></h5>
                            </td>
                            <td class="driver-reg">
                                <h5><?php echo htmlspecialchars($penalty['offence']); ?></h5>
                            </td>
                            <td class="driver-reg">
                                <h5><?php echo htmlspecialchars($penalty['penalty']); ?></h5>
                            </td>
                            <!-- <td class="edit"><a href="">View</a></td> -->
                            <td class="edit"><a href="pen_edit.php?id=<?php echo htmlspecialchars($penalty['id']); ?>">Edit</a></td>
                            <td class="edit"><a href="pen_del.php?id=<?php echo htmlspecialchars($penalty['id']); ?>">Delete</a></td>

                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
        <script>
            document.addEventListener("DOMContentLoaded", () => {
                const rows = document.querySelectorAll("tr[data-href]");

                rows.forEach(row => {
                    row.addEventListener("click", () => {
                        window.location.href = row.dataset.href;
                    });
                });
            });

            // function addRow () {
            //     document.querySelector("tbody").insertAdjacentHTML("beforeend", `

            //     `);
            // };

            $(document).ready(function() {
                $(document.body).on("click", "tr[data-href]", function() {
                    window.location.href = this.dataset.href;
                });
            });
        </script>
    </section>

</body>

</html>