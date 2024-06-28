<?php
session_start();
require "connect.php";
$user_id = $_SESSION['user_id'];
if (isset($_POST)) {
    $DeleteRoom = $_POST['delete_room'];
    foreach ($DeleteRoom as $room) {
        $LeaveRoom = "DELETE FROM members 
                      WHERE room_id = $room AND user_id = $user_id";
        $leave = $conn -> query($LeaveRoom);
        $QueryAdmin = "SELECT admin FROM rooms WHERE room_id = $room AND admin = $user_id";
        $admin = $conn -> query($QueryAdmin);
        if ($admin -> num_rows > 0 )
        {
            $QueryMember = "SELECT user_id FROM members WHERE room_id = $room LIMIT 1";
            $member = $conn -> query($QueryMember);
            if ($member -> num_rows > 0) {
                $VeteranMember = $member -> fetch_assoc();
                $NewAdmin = $VeteranMember['user_id'];
                $franchise = "UPDATE members SET user_id = $NewAdmin WHERE room_id = $Room";
            }
        }
    }
    header("Location:group_chat.php");
}
