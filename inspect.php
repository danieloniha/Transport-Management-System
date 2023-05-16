<?php

    include('config/db_connect.php');

    $sql = "SELECT * FROM registration";
    $result = mysqli_query($conn, $sql);

    $query = "SELECT DISTINCT mode FROM registration";
    $res = mysqli_query($conn, $query);

    $query2 = "SELECT * FROM question_inspect";
    $res2 = mysqli_query($conn, $query2);
    $questions = mysqli_fetch_all($res2, MYSQLI_ASSOC);

    $query3 = "SELECT type FROM question_inspect";
    $res3 = mysqli_query($conn, $query3);
    $type = mysqli_fetch_assoc($res3);


    if(isset($_POST['mode_id'])){
        $mode_id = $_POST['mode_id'];
        $query = "SELECT * FROM registration WHERE `mode` = '$_POST[mode_id]' ";
        //print_r($query);
        // die('ok');
        // $result = $db->query($query);
        $result = mysqli_query($conn, $query);
        if(mysqli_num_rows($result)> 0){
            echo '<option value="">Select Driver</option>';
            while($row = mysqli_fetch_assoc($result)){
                echo '<option value='.$row['id'].'>'.$row['first_name'].'</option>';
            }
        } else {
            echo '<option value="">No Driver Record </option>';
        }
    }

    if(isset($_POST['submit'])){

        $answer1 = $_POST[$question['answer1']];
        //die($answer1);
        $answer2 = $_POST['answer2'];

        $sql2 = "INSERT INTO answer_inspect(answer1, answer2) VALUES('$answer1', '$answer2')";

        if(mysqli_query($conn, $sql2)){
            $sql3 = "SELECT id FROM answer_inspect ";
            $result2 = mysqli_query($conn, $sql3);
            $id = mysqli_fetch_assoc($result2);
            print_r($id['id']);
            
            $sql4 = "INSERT INTO ques_answer_inspect(a_id, q_id) VALUES('$id[id]', '$id[id]) ";
            // $sql5 = "INSERT INTO ques_answer_inspect(q_id) VALUES('$id') ";

            if(mysqli_query($conn, $sql4)){
                if(mysqli_query($conn, $sql5)){

                    $driver = $_POST['driver'];

                    $sql6 = "SELECT reg_no FROM registration WHERE reg_no = '$driver' ";
                    $result3 = mysqli_query($conn, $sql6);
                    $result3 = mysqli_query($conn, $sql2);
                    $registration = mysqli_fetch_assoc($result3);
                    $reg_no = $registration['reg_no'];

                    $sql7 = "INSERT INTO inspect(reg_no, question_id, answer_id) VALUES('$reg_no', '$id', '$id') ";
                    
                    if(mysqli_query($conn, $sql7)){

                    } else {
                    // error
                    echo 'query error: ' . mysqli_error($conn);
                }

                } else {
                    // error
                    echo 'query error: ' . mysqli_error($conn);
                }
            } else {
                // error
                echo 'query error: ' . mysqli_error($conn);
            }          

            header('Location: inspect.php');

        } else {
            // error
            echo 'query error: ' . mysqli_error($conn);
        }
        
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
    <script>
        $(document).ready(function(){
        $("#driver").change(function(){
            //console.log("i am changed")
            //$("#radform").load("fetchinspect.php");
            $("input:radio[class^=radio_button]").each(function(i) {
                this.checked = false
            })
        });
    });
    </script>
<!-- <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration</title>
    <link rel="stylesheet" href="regstyle.css">
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
    <section id="form">
        <div class="container">
            <h3 class="i-name">Inspection</h3>
            <!-- <h4 class="name">Personal</h4> -->
            <form action="inspect.php" method="POST">
                <div class="user-details">
                <div class="input-box">
                        <span class="details">Inspection Type</span>
                        <select name="inspector" id="inspector" > 
                            <option value="">Annual</option>
                            <option value="">Monthly</option>
                            <option value="">Casual</option>
                        </select>
                    </div>
                    <div class="input-box">
                        <span class="details">Mode</span>
                        <select name="mode" id="mode" onchange="fetchDriver(this.value)" required>
                            <option >--Select--</option>
                            <?php while($row = mysqli_fetch_array($res)): ?>
                            <option value="<?php echo $row['mode']; ?>"><?php echo $row['mode']; ?></option>
                        <?php endwhile; ?>
                        </select>
                    </div>
                    <div class="input-box">
                        <span class="details">Driver</span>
                        <select name="driver" id="driver"  required> 
                        </select>
                    </div>
                </div>
                <div class="radio-details" id="radform">             
                    <div>
                        <?php foreach($questions as $question): ?>
                            <?php
                                switch ($question['type']) {
                                    case 'radio':
                                        ?>
                                        <input type="hidden" name="question_id" >
                                        <p class="rad" id="<?php echo htmlspecialchars($question['id']); ?>">
                                            <?php 
                                                echo htmlspecialchars($question['question']);
                                            ?>
                                        </p>
                                        <?php if($question['answer1'] != null)
                                            {
                                        ?>
                                        <input type="radio" class="radio_button" name="answer1" value="<?php echo htmlspecialchars($question['answer1']); ?>">
                                        <label for="<?php echo htmlspecialchars($question['id']); ?>" class="rad-space"><?php echo htmlspecialchars($question['answer1']); ?></label>
                                        <?php 
                                            } 
                                        ?>
                                        <?php if($question['answer2'] != null)
                                            {
                                        ?>
                                        <input type="radio" class="radio_button" name="answer2" value="<?php echo htmlspecialchars($question['answer2']); ?>">
                                        <label for="<?php echo htmlspecialchars($question['answer2']); ?>" class="rad-space"><?php echo htmlspecialchars($question['answer2']); ?></label>
                                        <?php 
                                            } 
                                        ?>
                                        <?php if($question['answer3'] != null)
                                            {
                                        ?>
                                        <input type="radio" class="radio_button" name="answer3" value="<?php echo htmlspecialchars($question['answer3']); ?>">
                                        <label for="<?php echo htmlspecialchars($question['answer3']); ?>" class="rad-space"><?php echo htmlspecialchars($question['answer3']); ?></label>
                                        <?php 
                                            } 
                                        ?>
                                <?php   
                                        break;
                                        
                                        case 'dropdown':
                                            ?>
                                            <input type="hidden" name="question_id" >
                                            <p class="rad" id="<?php echo htmlspecialchars($question['id']); ?>">
                                                <?php 
                                                    echo htmlspecialchars($question['question']);
                                                ?>
                                            </p> 
                                            <!-- <select name="result" id="result"> 
                                            <option value=""><?php echo htmlspecialchars($question['answer1']) ?></option> -->
                                            
                                    <?php 
                                    default:
                                        # code...
                                        break;
                                }
                            ?>
                            
                                
                        <?php endforeach; ?>
                        <!-- <p class="rad" id="question1">Does he have a fire extinguisher?</p>
                        <input type="radio" class="radio_button" name="answer1" value="Good">
                        <label for="Good" class="rad-space">Good</label>
                        <input type="radio" class="radio_button" name="answer1" value="Fair">
                        <label for="Fair" class="rad-space">Fair</label>
                        <input type="radio" class="radio_button" name="answer1" value="Bad">
                        <label for="Bad" class="rad-space">Bad</label> -->
                    </div>
                    <!-- <div>
                        <p class="rad" id="question2">Does he have hazard light?</p>
                        <input type="radio" class="radio_button" name="answer2" value="Yes">
                        <label for="Yes" class="rad-space">Yes</label>
                        <input type="radio" class="radio_button" name="answer2" value="No">
                        <label for="no" class="rad-space">No</label>
                    </div> -->
                    </div>
                <div class="button" id="submit">
                    <input type="submit" name="submit" value="Submit">
                </div>
            </form>
        </div>
    </section>
    <!-- <script type="text/javascript">
        function fetchDriver(id){
            $('#driver').html('');   
            $.ajax({
                type: 'POST',
                url: 'inspect.php',
                data: {id},
                success: function(data){
                    $('#driver').html(data);
                }
            })
        }
    </script> -->
</body>
</html>