<?php 

    function emptyInputSignUp($username, $phone_no, $pwd, $pwd_repeat){
        $result = true;
        if (empty($username) || empty($phone_no) || empty($pwd) || empty($pwd_repeat)){
            $result = true;
        } else {
            $result = false;
        }
        return $result;
    }

    function invalidUid($username){
        $result = true;
        if(!preg_match("/^[a-zA-Z0-9]*$/", $username)){
            $result = true;
        } else {
            $result = false;
        }
        return $result;
    }

    function invalidPhone($phone_no){
        $result = true;
        if(!preg_match('/^[0-9]{11}+$/', $phone_no)){
            $result = true;
        } else {
            $result = false;
        } 
        return $result;
    }

    function pwdMatch($pwd, $pwd_repeat){
        $result = true;
        if($pwd !== $pwd_repeat){
            $result = true;
        } else {
            $result = false;
        }
        return $result;
    }

    function uidExists($conn, $username, $phone_no){
        $sql = "SELECT * FROM login WHERE username = ? OR phone_no = ?;";
        $stmt = mysqli_stmt_init($conn);

        if(!mysqli_stmt_prepare($stmt, $sql)){
            header("location: signup.php");
            exit();
        }

        mysqli_stmt_bind_param($stmt, "ss", $username, $phone_no);
        mysqli_stmt_execute($stmt);

        $resultData = mysqli_stmt_get_result($stmt);
        if($row = mysqli_fetch_assoc($resultData)){
            return $row;
        } else {
            $result = false;
            return $result;
        }
        mysqli_stmt_close($stmt);
    }

    function createUser($conn, $username, $phone_no, $pwd){
        $sql = "INSERT INTO login (username, phone_no, password) VALUES(?, ?, ?);";
        $stmt = mysqli_stmt_init($conn);

        if(!mysqli_stmt_prepare($stmt, $sql)){
            header("location: signup.php?error=stmtfailed");
            exit();
        }

        $hashedPwd = password_hash($pwd, PASSWORD_DEFAULT);

        mysqli_stmt_bind_param($stmt, "sss", $username, $phone_no, $hashedPwd);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        header("location: signup.php?error=none");
        exit();
    }

    function emptyInputLogin($phone_no, $pwd){
        $result = true;
        if (empty($phone_no) || empty($pwd)){
            $result = true;
        } else {
            $result = false;
        }
        return $result;
    }

    function loginUser($conn, $phone_no, $pwd){
        $uidExists = uidExists($conn, $phone_no, $phone_no);

        if($uidExists === false){
            header("location: login.php?error=wronglogin");
            exit();
        }

        $pwdHashed = $uidExists['password'];
        $checkPwd = password_verify($pwd, $pwdHashed);

        if($checkPwd === false){
            header("location: login.php?error=wrongpassword");
            exit();
        } else if ($checkPwd === true){
            session_start();
            $_SESSION['id'] = $uidExists['id'];
            $_SESSION['phone_no'] = $uidExists['phone_no'];
            //header("location: index.php");
            exit();
        }
    }

?>