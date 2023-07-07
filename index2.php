<?php
    session_start();
    include('config/db_connect.php');

    $query = "SELECT DISTINCT mode FROM registration";
    $res = mysqli_query($conn, $query);
    
    if(isset($_POST['submit_search'])){
        $search = mysqli_real_escape_string($conn, $_POST['search']);
        
        $sql = "SELECT * FROM registration WHERE id LIKE '%$search%' OR reg_no LIKE '%$search%' OR first_name LIKE '%$search%' OR last_name LIKE '%$search%' OR phone_no LIKE '%$search%' OR mode LIKE '%$search%'";

        $result = mysqli_query($conn, $sql);
        $registration = mysqli_fetch_all($result, MYSQLI_ASSOC);
        
    }else if(isset($_POST['request'])){
        $request = $_POST['id'];
        $request = trim($request);
        if($request === "All"){
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
    <script type="text/javascript" src="js/script.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
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
        <div class="cards">
            
            <div class="card-single">
                <div>
                    <h1>0</h1>
                    <span class="card-text">Messages</span>
                </div>
                <div>
                    <span class="fa fa-duotone fa-book" style="color: #0059a5;" aria-hidden="true"></span>
                </div>
            </div>
            <div class="card-single">
                <div>
                    <h1>0</h1>
                    <span class="card-text">Penalties</span>
                </div>
                <div>
                    <span class="fa fa-solid fa-flag" style="color: #0059a5;" aria-hidden="true"></span>
                </div>
            </div>
            </div>
            <!-- <div class="card-single">
                <div>
                    <h1>79</h1>
                    <span class="card-text">Drivers</span>
                </div>
                <div>
                    <span class="fa fa-solid fa-car" style="color: #0059a5;" aria-hidden="true"></span>
                </div>
            </div> -->
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

           

            $(document).ready(function () {
                $(document.body).on("click", "tr[data-href]", function () {
                    window.location.href = this.dataset.href;
                });
            });
        </script>
    </section>
    
</body>
</html>
<?php 
    mysqli_free_result($result);
    mysqli_close($conn);
?>