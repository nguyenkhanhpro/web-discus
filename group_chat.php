<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/form.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="../css/group_chat.css">
    <script src='../js/group_chat.js'></script>
</head>
<body>
    <?php
        if (isset($_GET['nontification'])){
            $nontification = $_GET['nontification'];
            echo "<div class='nontification'>
                        <p>$nontification</p>
                        <button onclick='HiddenNontification()'>Ok</button>
                    </div";
        }
        ?>
    <header>
        <div class='header'>
            <p id='logo'>D</p>
            <h2>Discus</h2>
            <form action="">
                <button><i class='bx bx-search'></i></button>
                <input type="text" name='search' id='search' placeholder="tìm kiếm">
            </form>
            <?php
            require 'connect.php';
            session_start();
            if (isset($_SESSION["user_id"]))
            {
                $user_id = $_SESSION["user_id"];
                $user = "SELECT * FROM users WHERE user_id = $user_id";
                $query = $conn -> query($user);
                $user = $query -> fetch_assoc();
                $avatar = $user['avatar'];
                echo "<button id='user'><a href='#'><img src='../img/$avatar' alt=''></a></button>";
                echo " <button id='mail'><i class='bx bxs-envelope'></i></button>";
            }
            ?>
        </div>
    </header>
    <div class="content">
        <nav>
            <ul>
                <li><a href='homeuser.php'><i class='bx bxs-home-alt-2'></i>Trang Chủ</a></li>
                <li><a href="question.php"><i class='bx bx-question-mark'></i>Câu Hỏi</a></li>
                <li><a href="cv.php"><i class='bx bxs-user-circle'></i>Người Dùng</a></li>
                <?php
                if (isset($_SESSION['user_id']))
                {
                    echo "<li><a href='messenger.php'><i class='bx bxs-chat'></i>Chat</a></li>";
                    echo "<li><a href='group_chat.php' id='status'><i class='bx bxs-group'></i>Group Chat</a></li>";
                    echo "<li><a href='logout.php?logout=logout'><i class='bx bxs-log-out-circle'></i>Đăng xuất</a></li>";
                }
                else
                {
                    echo "<li><a href='login.php'><i class='bx bxs-log-in-circle' ></i>Đăng nhập</a></li>";
                }
                ?>
            </ul>
        </nav>
        <section>
            <div class='all_function'>
                <input type="text" id='search-room' placeholder='Tìm Kiếm Nhóm'>
                <p id='create_group'>tạo nhóm của bạn! <button onclick='create_chat()'>tại đây.</button></p>
                <div class="create-room">
                    <h1 id='title-create'>tạo phòng</h1>
                    <?php
                    if (isset($_SESSION['user_id']))
                    {
                        echo "<form action='create_group.php' id='create-room' enctype='multipart/form-data' method='POST'>
                                <div class='input-box'>
                                    <input type='text' placeholder='Tên Nhóm' id='GroupName' name='GroupName' require>
                                </div>
                                <div class='input-box'>
                                    <label for='avatar-room'>Ảnh Nhóm</label>
                                    <input type='file' id='avatar-room' name='FileImg' require>
                                </div>
                                <button id='create'>Tạo Nhóm</button>
                            </form>";
                    }
                    else {
                        echo "<p> bạn cần đăng nhập để tạo nhóm</p>";
                    }
                    ?>
                </div>
            </div>
            <div class="InformationRoom">
            </div>
            <!--hiển thị dang sách nhóm mà mình đã tham gia-->
            <ul class='list-room'>
                <?php
                $query_room = "SELECT * FROM rooms";
                $resulft = $conn -> query($query_room);
                if ($resulft -> num_rows > 0) 
                {
                    while ($room = $resulft -> fetch_assoc())
                    {
                        $room_id = $room['room_id'];
                        $room_name = $room['name'];
                        $avatar_room = $room['avatar_room'];
                        echo "<li>";
                        echo "<img src='../img/$avatar_room'>
                                <p>$room_name</p>
                                <button data-room='$room_id' class='room_id'><i class='bx bxl-flickr'></i></button>";
                        echo "</li>";
                    }
                }
                ?>
            </ul>
        </section>
        <article>
            <p class='article-header'>Nhóm của bạn</p>
            <ul class='list-rooms'>
                <?php
                if (isset($_SESSION['user_id']))
                {
                    $sql = "SELECT rooms.name, rooms.avatar_room, rooms.room_id
                    FROM members
                    INNER JOIN rooms
                    ON members.room_id = rooms.room_id
                    WHERE members.user_id = $user_id";
                    $resulft = $conn -> query($sql);
                    if ($resulft -> num_rows > 0) 
                    {
                        echo "<form action='leave_group.php' method='POST' enctype='multipart/form-data'>";
                        echo "<input type='submit' value='Rời nhóm' name='leave_group'";
                        while ($row = $resulft -> fetch_assoc())
                        {
                            $room_id = $row['room_id'];
                            $img = $row['avatar_room'];
                            $name = $row['name'];
                            echo "<li>
                                    <button type='button'onclick='chat() id='list-rooms'>
                                        <input type='checkbox' name='delete_room[]' value='$room_id'>
                                        <img src='../img/$img'>
                                        <p>$name</p>
                                    </button>
                                </li>";
                        }
                        echo "</form>";
                    }
                }
                else
                {
                    echo "<h3 style='margin-top: 200px;
                    color:rgb(137, 134, 134); '>bạn cần đăng nhập để xem nhóm của bạn</h3>";
                }
                ?>
            </ul>
        </article>
    </div>
    <footer>
        <div class="footer-content">
            <h3>Giao lưu và chia sẻ</h3>
            <ul>
                <li id="title">chức năng</li>
                <li>Đặt câu hỏi</li>
                <li>Tìm người trợ giúp</li>
                <li>Chat</li>
                <li>Trả lời câu hỏi</li>
            </ul>
            <ul>
                <li id="title">Lợi ích của người dùng</li>
                <li>Giúp củng cố kiến thức lập trình</li>
                <li>Giao lưu chia sẻ các kiến thức về lập trình</li>
                <li>Học hỏi nhiều kiến thức về lập trình</li>
                <li>Kết nối mọi người cùng ngành với nhau</li>
            </ul>
        </div>
    </footer>
</body>
</html>