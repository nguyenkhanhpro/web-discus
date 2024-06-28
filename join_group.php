<?php
require "connect.php";
session_start();
$user_id = $_SESSION['user_id'];
$room_id = $_GET['room_id'];
$AddMember = "INSERT INTO members(user_id, room_id) VALUES($user_id, $room_id)";
$AddMember = $conn -> query($AddMember);
if ($AddMember == true){
    header('Location:group_chat.php?nontification=bạn tham gia nhóm thành công');
}
else {
    header('Location:group_chat.php?nontification=bạn tham gia nhóm thất bại vui lòng kiểm tra lại');
}