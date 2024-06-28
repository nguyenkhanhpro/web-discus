<?php
require "connect.php";
session_start();
$UserId = $_SESSION['user_id'];
$FileName = $_FILES['FileImg'];
$GroupName = $_POST['GroupName'];
$Status = true;
$nontification = "";

$UploadFonder = "img/";
$Path = $UploadFonder . basename($UserId.'_'.$FileName['name']);
$ImgFileType = strtolower(pathinfo($FileName['name'], PATHINFO_EXTENSION));
if (isset($_POST['FileName'])){
    $check = getimagesize($FileName['tmp_name']); // thông tin của ảnh chiều cao chiều rộng ...;
    if ($check != false){
        $Status = true;
    }
    else{
        $nontification = $nontification . "Đây không phải file ảnh!". "\n";
        $Status = false;
    }
}

if($ImgFileType != "jpg" && $ImgFileType != "png" && $ImgFileType != "jpeg"
&& $ImgFileType != "gif" ){
    $nontification = $nontification . "chỉ chấp nhận file 'jpg', 'png', 'jpeg', 'gif'"."\n";
    $Status = false;
}
if ($Status == true){
    // kiểm tra xem ảnh đã tồn tại trog 
    // khai báo một hàm checkpath truyền vào đường dẫn lưu ảnh kiểm tra nếu nó đã 
    //tông tại thì 
    function CheckPath($FolderPath){
        $check =  file_exists($FolderPath);
        if ($check == true){
            $number = rand();
            $location = strpos($FolderPath, '.');
            $path = substr($FolderPath,0 , $location);
            $FileFomat = substr($FolderPath, $location);
            $FolderPath = $path. "($number)" . $FileFomat;
            return CheckPath($FolderPath);
        }
        else {
            return $FolderPath;
        }
    };
    $FolderPath = CheckPath($Path);
    if (move_uploaded_file($FileName['tmp_name'], $FolderPath));
    {
        $AvatarRoom = basename($FolderPath);
        // tạo nhóm
        $CreateGroup = "INSERT rooms(admin, name, avatar_room) VALUES($UserId, '$GroupName', '$AvatarRoom')";
        $create = $conn -> query($CreateGroup);
        // query id nhóm mới được tạo
        $Room = "SELECT room_id FROM rooms WHERE admin = $UserId ORDER BY room_id DESC LIMIT 1";
        $Room = $conn -> query($Room) -> fetch_assoc();
        $RoomId = $Room['room_id'];
        // thêm Admin vào bảng member
        $AddMember = "INSERT INTO members(user_id, room_id) VALUES($UserId, $RoomId)";
        $conn -> query($AddMember);

        if ($create == true){
            header("location:group_chat.php?nontification=Bạn đã tạo nhóm thành công");
        }
        else {
            header("location:group_chat.php?nontification=đã sảy ra lỗi upload ảnh");
        }
    }
}
else {
    header("location:group_chat.php?nontification=$nontification");
}