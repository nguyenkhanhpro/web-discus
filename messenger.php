<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/form.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="../css/messenger.css">
    <script src='./js/messenger.js'></script>
</head>
<body>
    <header>
        <div class='header'>
            <p id='logo'>D</p>
            <h2>Discus</h2>
            <form action="">
                <button><i class='bx bx-search'></i></button>
                <input type="text" name='question' id='question' placeholder="tìm kiếm" list = "datalist">
                <!-- hiển thị gợi ý question -->
                <datalist id="datalist">
                    <option value="">
                    <?php
                        require 'connect.php';
                        mysqli_set_charset($conn, 'UTF8');
                        $sql = $conn->query('SELECT DISTINCT question FROM `question`');
                        while($data = $sql->fetch_assoc()){
                            echo "<option value='". $data['question'] ."'>";
                        }
                    ?>
                </datalist>
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
                echo "<button id='user'><a href='cv.php'><img src='../img/$avatar' alt=''></a></button>";
                echo " <button id='mail'><i class='bx bxs-envelope'></i></button>";
            }
            ?>
        </div>
    </header>
    <div class="content">
        <nav>
            <ul>
                <li><a href="homeuser.php"><i class='bx bxs-home-alt-2'></i>Trang Chủ</a></li>
                <li><a href="question.php"><i class='bx bx-question-mark'></i>Câu Hỏi</a></li>
                <li><a href="#"><i class='bx bxs-purchase-tag-alt'></i>thẻ</a></li>
                <li><a href="cv.php"><i class='bx bxs-user-circle'></i>Người Dùng</a></li>
                <?php
                if (isset($_SESSION['user_id']))
                {
                    echo "<li><a href='messenger.php' id='status'><i class='bx bxs-chat'></i>Chat</a></li>";
                    echo "<li><a href='group_chat.php'><i class='bx bxs-group'></i>Group Chat</a></li>";
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
            <div class='chat'>
            </div> 
            <div class='sender-messenger' onsubmit='messenger(event)'>
                <form id='submit'>
                    <input type='text' id='messenger' placeholder='Nhập tin nhắn của bạn'>
                    <input type="hidden" id='room_id' value='0'>
                    <button id='send' type='submit'><i class='bx bxs-send' ></i></button>
                </form>
            </div>
        </section>
        <article>
            <p class='article-header'>Nhóm của bạn</p>
            <input type="text" id='search-room' onkeyup="SearchRoom()" placeholder='Tìm kiếm nhóm chat'>
            <ul class='list-rooms'>
                <?php
                if (isset($_SESSION['user_id']))
                {
                    $sql = "SELECT rooms.room_id, rooms.name, rooms.avatar_room
                    FROM members
                    INNER JOIN rooms
                    ON members.room_id = rooms.room_id
                    WHERE members.user_id = $user_id";
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
    <!--
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
            -->
</body>
</html>