<?php 
    include('config/db_connect.php');
    if(isset($_POST['request'])){
        $request = $_POST['request'];
        $sql2 = "SELECT * FROM penalty WHERE offence ='{$request}'";
        $result3 = mysqli_query($conn, $sql2);  
        // $count = mysqli_num_rows($result3);
                            
        ?>
        <?php 
            //if($count){

        ?>
        <?php 
            while($row2 = mysqli_fetch_assoc($result3)){

        ?>
        <p id="penalty"><?php echo $row2['penalty'] ?></p>
        <?php } ?>
        <?php } ?>
        <?php //} ?>