<?php 
    include('config/db_connect.php');

    if(isset($_POST['submit_search'])){
        $search = mysqli_real_escape_string($conn, $_POST['search']);
        // die($search);
        $sql = "SELECT * FROM registration WHERE id LIKE '%$search%' OR reg_no LIKE '%$search%' OR first_name LIKE '%$search%'";

        $result = mysqli_query($conn, $sql);
        $registration = mysqli_fetch_assoc($result);
        // while($row = mysqli_fetch_assoc($result)){
        //     echo "$row[1]";
        // }
    
    } else {
        $sql = "SELECT * FROM registration";
        $result = mysqli_query($conn, $sql);
    }

    
?>


<!DOCTYPE html>
<html lang="en">
    <?php include('templates/header.php') ?>
    <link rel="stylesheet" href="css/tabstyle.css">
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
                    <i class="fa fa-search" ></i>
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
        <div class="button" id="submit">
            <a href="form.php"><input type="submit" value="Add User"></a>
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
                <tbody>
                <?php while($row = mysqli_fetch_all($result)){ ?>
                    <tr scope="row">
                        <td class="driver">
                            <div class="driver-id">
                                <h5><?php echo $row['id']; ?></h5>
                            </div>
                        </td>
                        <td class="driver">
                            <div class="driver-de">
                                <h5><?php echo $row['reg_no']; ?></h5>
                                <!-- <p>john@example.com</p> -->
                            </div>
                        </td>
                        <td class="driver-phone">
                            <h5><?php echo $row['first_name'] . ' ' . $row['last_name']; ?></h5>
                            <!-- <p>Web Dev</p> -->
                        </td>
                        <td class="driver-plate">
                            <h5><?php echo $row['phone_no']; ?></h5>
                        </td>
                        <td class="driver-reg">
                            <h5><?php echo $row['mode']; ?></h5>
                        </td>
                        <td class="edit"><a href="">View</a></td>
                        <td class="edit"><a href="update.php?id=<?php echo $row['id']; ?>">Edit</a></td>
                        <td class="edit"><a href="delete.php?id=<?php echo $row['id']; ?>">Delete</a></td>
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

            $(document).ready(function () {
                $(document.body).on("click", "tr[data-href]", function () {
                    window.location.href = this.dataset.href;
                });
            });
        </script>
    </section>

</body>
</html>