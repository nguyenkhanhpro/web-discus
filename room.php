<?php
require "connect.php";
session_start();

if (isset($_GET['room_id'])){
    $room_id = $_GET['room_id'];
    // menu
    echo "<nav id='InformationRoom'>
            <ul>
                <li><button class='navigation' data-id='1' id='navigation_id_1'>Thành viên</button></li>
                <li><button class='navigation' data-id='2' id='navigation_id_2'>admin</button></li>
                <li><button class='navigation' data-id='3' id='navigation_id_3'>Tham gia nhóm</button></li>
                <li><button id='exit' onclick='exit()'>thoát</button></li>
            </ul>
        </nav>";
    // thành viên trong nhóm
    $member_room = "SELECT users.user_name, users.avatar
                    FROM members
                    INNER JOIN users ON users.user_id = members.user_id
                    WHERE members.room_id = $room_id";
    $member_room = $conn -> query($member_room);
    echo "<div class='member'>
        <ul>";
    while ($member = $member_room -> fetch_assoc())
    {
        $user_name = $member['user_name'];
        $avatar = $member['avatar'];
        echo "<li>
                <img src='./img/$avatar' alt=''>
                <p>$user_name</p>
             </li>";
    }
    echo"</ul>
        </div>";
    // admin của nhóm
    $admin_room = "SELECT members.room_id,users.user_name, users.avatar
                    FROM members
                    INNER JOIN users ON users.user_id = members.user_id
                    WHERE members.room_id = $room_id";
    $admin_room = $conn -> query($admin_room);
    echo "<div class='admin'>
        <ul>";
        $admin = $admin_room -> fetch_assoc();
        $user_name = $admin['user_name'];
        $avatar = $admin['avatar'];
        echo "<li>
                <img src='./img/$avatar' alt=''>
                <p>$user_name</p>
            </li>";
    echo"</ul>
        </div>";
    // xác nhận có muốn vào nhóm không
    // kiểm tra xem nếu mà câu truy vấn này có dữ liệu thì bạn đã có trong nhóm và hiển thị thông báo nếu c
    // nếu không có dữ liệu thì có nghĩ bạn không có trong nhóm hiển thị giao diện để xác nhận vào tham giá nhóm chat
    echo "<div class='join_group'>
            <form action='join_group.php' method='GET'>";
    if (isset($_SESSION['user_id'])){
        $user_id = $_SESSION['user_id'];
        $check = "SELECT * FROM members WHERE user_id = $user_id AND room_id = $room_id";
        $check = $conn -> query($check);
        if ($check ->  num_rows > 0)
        {
            echo "<p>bạn đã trong nhóm này</p>";
        }
        else 
        {
            echo "<p>bạn có muốn tham gia nhóm này không</p>
                <input type='hidden' value='$room_id' id='room_id' name='room_id'>
                <input type='submit' value='xác nhận' name='confirm' id='confirm'>";
        }
    }
    else 
    {
        echo "<p> bạn cần đăng nhập để tham giá nhóm</p>";
    }
    echo "  </form>
        </div>";             
}