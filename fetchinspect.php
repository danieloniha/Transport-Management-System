<?php 

    include('config/db_connect.php');

    if(isset($_POST['submit'])){

        $answer1 = $_POST['answer1'];
        $answer2 = $_POST['answer2'];

        $sql2 = "INSERT INTO inspect(question_ans) VALUES('$answer1')";

        if(mysqli_query($conn, $sql2)){

            header('Location: fetchinspect.php');

        } else {
            // error
            echo 'query error: ' . mysqli_error($conn);
        }
        

    }

?>

<div class="radio-details" id="radform">           
    <div>
        <p class="rad" id="1">Does he have a fire extinguisher</p>
        <input type="radio" name="answer1" value="">
        <label for="Yes" class="rad-space">Yes</label>
        <input type="radio" name="answer1" value="">
        <label for="no" class="rad-space">No</label>
    </div>

    <div>
        <p class="rad" id="2">Does he have a fire extinguisher</p>
        <input type="radio" name="answer2" value="">
        <label for="Yes" class="rad-space">Yes</label>
        <input type="radio" name="answer2" value="">
        <label for="no" class="rad-space">No</label>
    </div>
</div>

<div class="button" id="submit">
    <input type="submit" name="submit" value="Submit">
</div>