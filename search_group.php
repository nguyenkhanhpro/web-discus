<?php
require "connect.php";
$query = $_GET['query'];
$query_room = "SELECT * FROM rooms WHERE name LIKE '%$query%'";
$resulft = $conn -> query($query_room);
if ($resulft -> num_rows > 0) 
{
    while ($room = $resulft -> fetch_assoc())
    {
        $room_id = $room['room_id'];
        $room_name = $room['name'];
        $avatar_room = $room['avatar_room'];
        echo "<li>";
        echo "  <img src='./img/$avatar_room'>
                <p>$room_name</p>
                <button data-room='$room_id' class='room_id'><i class='bx bxl-flickr'></i></button>";
        echo "</li>";
    }
}