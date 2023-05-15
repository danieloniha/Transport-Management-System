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
        <a href="inspect.php"><li><i class="fa fa-solid fa-car" aria-hidden="true"></i>Inspection</li></a>
        <a href="penalty.php"><li><i class="fa fa-solid fa-flag"></i>Penalty</li></a>
        <a href="#"><li><i class="fa fa-solid fa-folder"></i>Report</li></a>
        </div>
    </section>