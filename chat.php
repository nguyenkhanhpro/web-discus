<?php
session_start();
$user_id = $_SESSION['user_id'];
require "connect.php";
# nhận đoạn tin nhắn và 
if (isset($_GET['send']))
{
    $room_id = $_GET['room_id'];
    $messenger = $_GET['messenger'];
    $insert_messenger = "INSERT INTO messengers(user_id, room_id,messenger) 
            VALUES ($user_id, $room_id, '$messenger')";
    $messenger = $conn -> query($insert_messenger);
}
if (isset($_GET['room_id']))
{
    # hiển thị phần thông tin ảnh nhóm và tên nhóm
    $room_id = $_GET["room_id"];
    $room = "SELECT * FROM rooms WHERE room_id = $room_id";
    $rooms = $conn -> query($room);
    $room = $rooms -> fetch_assoc();
    $room_name = $room['name'];
    $avatar_room = $room['avatar_room'];
    echo "<div class='room'>
            <img src='./img/$avatar_room' alt=''>
            <p id='name-room'>$room_name</p>
            <button onclick='DisplayInformation()'><i class='bx bx-menu'></i></button>
        </div>";
    // thông tin về nhóm chat
    echo "<div class='information-room'>
            <div id='header-room'>
                <h2 id='group-nontifi'>Nhóm</h2>
                <button onclick='HiddenInformation()'><i class='bx bx-x'></i></button>
            </div>
            <nav class='menu'>
                <ul>
                    <li id='group'><button class='mandates' data-mandates='group'>nhóm</button></li>
                    <li id='member'><button class='mandates' data-mandates='member'>thành viên</button></li> 
                </ul>
            </nav>
            <div class='resulft'>
            <!--nội dung của chức năng xem thành viên-->
                <div class='search-member'>
                    <form action=''>
                        <button><i class='bx bxs-search'></i></button>
                        <input type='text' id='search-member' placeholder='tìm thành viên'>
                    </form> 
                </div>";
                echo "<ul id='resulft-ul'>";
                $QueryMember = "SELECT users.user_name, users.avatar
                                FROM members 
                                INNER JOIN users ON users.user_id = members.user_id
                                WHERE members.room_id = $room_id";
                $QueryMember = $conn -> query($QueryMember);
                if ($QueryMember -> num_rows > 0) {
                    while ($members = $QueryMember -> fetch_assoc()) {
                        $name = $members["user_name"];
                        $avatar = $members["avatar"];
                        echo "<li>
                                <img src='./img/$avatar' alt=''>
                                <p>$avatar</p>
                                <button><i class='bx bxs-x-circle'></i></button>
                            </li>";
                    }
                }
                echo "</ul>";
        echo "</div>";
        // thay đổi  ảnh và tên nhóm
        echo "<div class='group'>
                <div class='avatar-room'>
                    <img src='./img/$avatar_room' alt=''>
                    <button id='change-avatar' onclick='ImgRoom()'>
                        <i class='bx bxs-image-add'></i>
                    </button>
                    <form action='' id='change-avatar'>
                        <p>bạn muốn đổi ảnh đại diện không</p>
                        <input type='file' accept='image/*' id='change-avatar-group' require>
                        <input type='submit' value='đổi ảnh' id='submit-img'>
                    </form>
                </div>
                <div class='name-room'>
                    <p>$room_name</p>
                    <button onclick='NameRoom()'><i class='bx bxs-edit-alt' ></i></button>
                    <form action='' class='change-name'>
                        <input type='text' id='change-name' placeholder='nhập tên mới'>
                        <input type='submit' value='đổi' id='submit-new-name'>
                    </form>
                </div>
            </div>";
    echo "</div>";
    # hiển thị các tin nhắn
    $query_messenger = "SELECT users.user_id,users.user_name, users.avatar, messengers.messenger, messengers.messenger_sending_time 
                        FROM messengers
                        INNER JOIN users ON messengers.user_id = users.user_id
                        WHERE messengers.room_id = $room_id
                        GROUP BY messengers.messenger_sending_time DESC";
    $messengers = $conn -> query($query_messenger);
    if ($messengers -> num_rows > 0)
    {
        echo "<div class='messenger'>";
        echo "<ul id='list-messenger'>";
        while ($row = $messengers -> fetch_assoc())
        {
            $sender = $row['user_id'];
            $sender_name = $row['user_name'];
            $avatar_sender = $row['avatar'];
            $messenger = $row['messenger'];
            $messenger_sending_time = $row['messenger_sending_time'];
            
            if ($user_id == $sender)
            {
                echo " <li id='user-send'>
                            <img src='./img/$avatar_sender' alt='' id='sender-avatar'>
                            <p id='sender-name'>$sender_name</p>
                            <p id='content-messenger'>$messenger</p>
                            <input type='hidden' value='$messenger_sending_time' id='messenger_sending_time'> 
                        </li>";
            }
            else
            {
                echo "<li id='sender'>
                        <img src='./img/$avatar_sender' alt='' id='sender-avatar'>
                        <p id='sender-name'>$sender_name</p>
                        <p id='content-messenger'>$messenger</p>
                        <input type='hidden' value='$messenger_sending_time' id='messenger_sending_time'>
                    </li>";     
            }
        }
        echo "</ul>";
        echo "</div>";
    }
}
// tìm kiếm nhóm chát
if (isset($_GET['query']))
{
    $query = $_GET['query'];

    $sql = "SELECT rooms.room_id, rooms.name, rooms.avatar_room
            FROM members
            INNER JOIN rooms
            ON members.room_id = rooms.room_id
            WHERE members.user_id = $user_id AND rooms.name LIKE '%$query%'";
    $resulft = $conn -> query($sql);
    if ($resulft -> num_rows > 0) 
    {
        while ($row = $resulft -> fetch_assoc())
        {
            $img = $row['avatar_room'];
            $name = $row['name'];
            $room_id = $row['room_id'];
            echo "<li>
                    <button id='list-rooms' class='list-room' data-roomid='$room_id'>
                        <img src='./img/$img'>
                        <p>$name</p>
                    </button>
                </li>";
        }
    }
    else 
    {
        echo "<h2> không có nhóm khớp</h2>";
    }
}
// cập nhật tin nhắn
if (isset($_GET["messenger_time"])) {
    $messenger_time = $_GET["messenger_time"];
    $RoomId = $_GET["RoomId"];
    $MessengerLast = "SELECT messenger_sending_time 
                        FROM messengers 
                        WHERE room_id = $RoomId
                        GROUP BY messenger_sending_time DESC LIMIT 1";
    $TimeLast = $conn -> query($MessengerLast) -> fetch_assoc();
    $time = $TimeLast['messenger_sending_time'];
    //
    $distance = "SELECT TIMESTAMPDIFF(SECOND,'$messenger_time','$time') AS distance;";
    $distance = $conn -> query($distance) -> fetch_assoc();
    if ($distance['distance'] > 0 ) {
        $query_messenger = "SELECT users.user_id,users.user_name, users.avatar, messengers.messenger, messengers.messenger_sending_time 
                        FROM messengers
                        INNER JOIN users ON messengers.user_id = users.user_id
                        WHERE messengers.room_id = $RoomId 
                        GROUP BY messengers.messenger_sending_time DESC LIMIT 1";
        $messengers = $conn -> query($query_messenger);
        if ($messengers -> num_rows > 0)
        {
            while ($row = $messengers -> fetch_assoc())
            {
                $sender = $row['user_id'];
                $sender_name = $row['user_name'];
                $avatar_sender = $row['avatar'];
                $messenger = $row['messenger'];
                $messenger_sending_time = $row['messenger_sending_time'];
                
            echo "<img src='./img/$avatar_sender' alt='' id='sender-avatar'>
                    <p id='sender-name'>$sender_name</p>
                    <p id='content-messenger'>$messenger</p>
                    <input type='hidden' value='$messenger_sending_time' id='messenger_sending_time'>";     
            }
        }
    }
    else 
    {
        echo "null";
    }
}