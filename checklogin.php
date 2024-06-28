<?php         
    if(isset($_POST["account"]))
    {
        require "connect.php";
        $account = $_POST["account"];
        $fisrt_password = $_POST["password"];
        $sql = "SELECT user_id, account, password FROM users WHERE account = '$account'";
        $resulft = $conn -> query($sql);
        $row = $resulft -> fetch_assoc();
        if ($resulft -> num_rows == 0)
        {
            echo "tài khoản không tồn tại";
            echo'<form action="login.php"><input type="submit" value = "return"></form>';
            exit;
        }
        if ($fisrt_password != $row['password'])
        {
            echo "mật khẩu không đúng";
            echo'<form action="login.php"><input type="submit" value = "return"></form>';
            exit;
        }
        session_start();
        $user_id = $row['user_id'];
        $_SESSION["user_id"] = $user_id;
        header("Location:homeuser.php");
    }
?>