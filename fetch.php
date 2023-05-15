<?php 
//     if(isset($_POST['request'])) {
//         $request = $_POST['request'];
//         $sql = "SELECT * FROM REGISTRATION WHERE mode= '$request'";
//         $result = mysqli_query($conn, $sql);
//         $registration = mysqli_fetch_all($result, MYSQLI_ASSOC);
// }

include('config/db_connect.php');

    if(isset($_POST['request'])){
        $request = $_POST['request'];
        $request = trim($request);
        if($request === "All"){
            $query = "SELECT * FROM registration";
            $result = mysqli_query($conn, $query);
            $count = mysqli_num_rows($result);
            // $registration = mysqli_fetch_all($result, MYSQLI_ASSOC);
        } else {
            $query = "SELECT * FROM registration WHERE mode='{$request}'";
            $result = mysqli_query($conn, $query);
            $count = mysqli_num_rows($result);
        }
    
    // $request = $_POST['id'];
    // $request = trim($request);
    // $query = "SELECT * FROM registration WHERE mode='{$request}'";
    // $res = mysqli_query($conn, $query);
    // $registration = mysqli_fetch_all($res, MYSQLI_ASSOC);
    // while($row = mysqli_fetch_array($res)){

    // }
    

?>

<table width="100%">
        <?php 
            if($count){

        ?>
        
                <thead>
                    

                    <?php 
                }else{
                    echo "Sorry not found";
                }
                    ?>
                </thead>

                <tbody>
                    <?php 
                        while($row = mysqli_fetch_assoc($result)){
                            ?>
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
<?php } ?>