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

?>



<!DOCTYPE html>
<html lang="en">
<?php include('templates/header.php') ?>
<link rel="stylesheet" href="css/tabstyle.css">
<link rel="stylesheet" href="sweetalert2.min.css">
<script type="text/javascript" src="js/script.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"
    integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8="
    crossorigin="anonymous">
</script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="sweetalert2.all.min.js"></script>
<!-- <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="path/to/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="tabstyle.css">
</head> -->

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
            Driver Details
        </h3>
        <div class="user-details">
            <div class="input-box" id="filter">
                <span class="details">Mode</span>
                <select name="fetchval" id="fetchval" onchange="selectMode()">
                    <option value="All">All</option>
                    <?php while ($row = mysqli_fetch_array($res)) : ?>
                        <option value="<?php echo $row['mode']; ?>"><?php echo $row['mode']; ?></option>
                        <!-- <option value="All">All</option>
                            <option value="Shuttle">Shuttle</option>
                            <option value="Cab">Cab</option> -->
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="button" id="submit">
                <a href="form.php"><input type="submit" value="Add User"></a>
            </div>
        </div>
        <div class="board">
            <table width="100%">
                <thead>
                    <tr>
                        <td>No</td>
                        <td>RegNo</td>
                        <td>Name</td>
                        <td>Phone No</td>
                        <!-- <td>Address</td> -->
                        <!-- <td>DOB</td> -->
                        <td>Mode</td>
                        <td></td>
                    </tr>
                </thead>
                <tbody id="ans">

                    <?php $count = 1;
                    foreach ($registration as $driver) { ?>
                        <tr scope="row">
                            <td class="driver">
                                <div class="driver-id">
                                    <h5><?php echo $count++; ?></h5>
                                </div>
                            </td>
                            <td class="driver">
                                <div class="driver-de">
                                    <h5><?php echo htmlspecialchars($driver['reg_no']); ?></h5>
                                </div>
                            </td>
                            <td class="driver-phone">
                                <h5><?php echo htmlspecialchars($driver['first_name'] . ' ' . $driver['last_name']); ?></h5>
                                <!-- <p>Web Dev</p> -->
                            </td>
                            <td class="driver-plate">
                                <h5><?php echo htmlspecialchars($driver['phone_no']); ?></h5>
                            </td>
                            <td class="driver-reg">
                                <h5><?php echo htmlspecialchars($driver['mode']); ?></h5>
                            </td>
                            <td class="edit"><a href="details.php?id=<?php echo htmlspecialchars($driver['id']); ?>">View</a></td>
                            <td class="edit"><a href="update.php?id=<?php echo htmlspecialchars($driver['id']); ?>">Edit</a></td>
                            <td class="edit_delete"><a href="delete.php?id=<?php echo htmlspecialchars($driver['id']); ?>">Delete</a></td>
                            <!-- <td class="edit"><form action="index.php" method="POST">
                            <input type="hidden" name="id_to_delete" value="<?php echo $registration['id'] ?>">
                            <input type="submit" name="delete" class="edit_delete" value="Delete">
                        </form>
                        </td> -->
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


            $(document).ready(function() {
                $(document.body).on("click", "tr[data-href]", function() {
                    window.location.href = this.dataset.href;
                });
            });
        </script>
        <!-- <script>
            $('.edit_delete').on('click', function(e) {
                        e.preventDefault();
                        const href = $(this).attr('href')
                        Swal.fire({
                            title: 'Are you sure?',
                            text: "You won't be able to revert this!",
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Yes, delete it!'
                        }).then((result) => {
                            if (result.value) {
                                document.location.href = href;
                                Swal.fire(
                                    'Deleted!',
                                    'Your file has been deleted.',
                                    'success'
                                )
                            }
                        })
                    })
        </script> -->
    </section>

</body>

</html>
<?php
mysqli_free_result($result);
mysqli_close($conn);
?>