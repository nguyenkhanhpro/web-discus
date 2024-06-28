<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/form.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <!-- tìm kiếm câu hỏi -->
</head>
<body>
    <header>
        <div class='header'>
            <p id='logo'>D</p>
            <h2>Discus</h2>
            <form action="find_question.php" method = "GET">
                <button><i class='bx bx-search'></i></button>
                <input type="text" name='question' id='question' placeholder="Tìm kiếm câu hỏi" list = "datalist">
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
            <button id='user'><a href="cv.php">
                <?php
                session_start();
                    require "connect.php";
                    if(isset($_SESSION["user_id"]))
                    {
                        $user_id = $_SESSION['user_id'];
                        $sql = "SELECT * FROM `users` WHERE `user_id` = '$user_id'";
                        $row = $conn -> query($sql) -> fetch_assoc();
                        $avatar = $row['avatar'];
                        if ($conn -> query($sql) == TRUE)
                        {
                            echo "<img src='../img/$avatar' alt='avatar'>";
                        }
                        else 
                        {
                            echo $conn->error;
                        }
                    }
                ?>
            </a></button>
            <button id='mail'><i class='bx bxs-envelope'></i></button>
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
            <form action="" method = "GET">
            Nhập id bạn muốn xóa : 
            <input type="text" name = "delete_account">
            <input type="submit" name = "submit" value = "delete">
            <?php
                if(isset($_GET["delete_account"]))
                {
                    require 'connect.php';
                    $delete_account = $_GET["delete_account"];
                    $sql = "SELECT question.`question_id` FROM `question` 
                    INNER JOIN users ON users.user_id = question.user_id
                    WHERE question.user_id = '$delete_account'";
                    $result_name= $conn -> query($sql);
                    while ($row = $result_name-> fetch_assoc())
                    {
                        $question_id = $row['question_id'];
                        $sql_dele_img = "DELETE FROM `image` WHERE `question_id` = '$question_id'";
                        $result_dele_img = $conn -> query($sql_dele_img);
                        $sql_dele_question_comment = "DELETE FROM `comments` WHERE `question_id`= '$question_id'";
                        $result_dele_question_comment = $conn -> query($sql_dele_question_comment);
                        $sql_dele_question ="DELETE FROM `question` WHERE `question_id` = '$question_id'";
                        $result_dele_question = $conn -> query($sql_dele_question);
                    }
                    $sql_dele = "DELETE FROM `users` WHERE `user_id` = '$delete_account' ";
                    if ($conn -> query($sql_dele) == TRUE)
                    {
                        echo '<br>';
                        echo "Bạn đã xóa thành công tài khoản với id là : $delete_account";
                        echo '<br>';
                        echo '<a href="homeuser.php">Bạn có muốn quay lại trang chủ?</a>';
                    }
                    else 
                    {
                        echo $conn->error;
                    }
                }
                ?>
            </form>
        </section>
        <article>
        <?php
                require 'connect.php';
                if(isset($_SESSION["user_id"]))
                {
                    $user_id = $_SESSION['user_id'];
                    $sql = "SELECT rooms.name, rooms.avatar_room
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
                            echo "<li>
                                    <button onclick='chat() id='list-rooms'>
                                        <img src='$img'>
                                        <p>$name</p>
                                    </button>
                                </li>";
                        }
                    }
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