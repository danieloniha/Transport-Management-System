<?php include('templates/header.php') ?>
<section id='menu'>
        <div class="logo">
            <?php $directory = __DIR__;
                $logoPath = $directory.'/Images/University-of-Lagos-courses.jpg';
                // echo $logoPath;
            ?>
            <img src="Images/University-of-Lagos-courses.jpg" alt=""> 
            <h3>University Of Lagos</h3>
        </div>
        <div class="items">
        <a href="index.php"><li><i class="fa fa-pie-chart" aria-hidden="true"></i>Dashboard</li></a>
        <a href="driver.php"><li><i class="fa fa-regular fa-table" aria-hidden="true"></i>Driver Registration</li></a>
        <a href="index.php"><li><i class="fa fa-solid fa-user" aria-hidden="true"></i>Staff Registration</li></a>
        <a href="inspect.php"><li><i class="fa fa-solid fa-car" aria-hidden="true"></i>Inspection</li></a>
        <a href="penalty.php"><li><i class="fa fa-solid fa-flag"></i>Penalty</li></a>
        <a href="table.php"><li><i class="fa fa-regular fa-table"></i>Driver Details</li></a>
        <a href="#"><li><i class="fa fa-solid fa-folder"></i>Report</li></a>
        </div>
    </section>