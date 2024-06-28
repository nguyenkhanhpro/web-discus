<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/form.css">
    <link rel="stylesheet" href="../css/cv.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
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
            <div class = "form">
                <h1>HỒ SƠ CỦA BẠN</h1>
                <form action="update_cv.php">
                    <input type="submit" value = "Chỉnh sửa hồ sơ" class = "update">
                </form>
                <?php
                    require "connect.php";
                    $user_id = $_SESSION['user_id'];
                    $sql_select_decs = "SELECT * FROM `users` WHERE user_id = $user_id ";
                    $sql_select_dec = $conn -> query($sql_select_decs);
                    $row = $sql_select_dec-> fetch_assoc();
                    $decentra = $row['decentralization_id'];
                    if (isset($_SESSION["user_id"]) && $decentra == 1)
                    {
                        echo'<form action="delete_account.php">
                        <input type="submit" value = "xóa tài khoản của người dùng" class = "delete_account_user" name = "delete_account_user">
                    </form>';
                    }
                ?>
            </div>
            <div class ="container">
                <div class = "avatar">
                    <?php 
                        require "connect.php";
                        if(isset($_SESSION["user_id"]))
                        {
                            $user_id = $_SESSION['user_id'];
                            $sql = "SELECT * FROM `users` WHERE `user_id` = '$user_id'";
                            $row = $conn -> query($sql) -> fetch_assoc();
                            $avatar = $row['avatar'];
                            if ($conn -> query($sql) == TRUE)
                            {
                                echo "<img src='../img/$avatar' alt='avatar' id ='img_div'>";
                            }
                            else 
                            {
                                echo $conn->error;
                            }
                        }
                    ?>
                </div>
                <div class = "information">
                    <ul class = "infor_list">
                        <?php 
                            require "connect.php";
                            if(isset($_SESSION["user_id"]))
                            {
                                $user_id = $_SESSION['user_id'];
                                $sql = "SELECT * FROM `users` WHERE `user_id` = '$user_id'";
                                $row = $conn -> query($sql) -> fetch_assoc();
                                if ($conn -> query($sql) -> num_rows > 0)
                                {
                                    echo" Click vào đây để <a href='logout.php'>Logout</a>";
                                    echo "<li>".$row['user_name']."</li>";
                                    echo "<li>"."Tài khoản: ". $row['account']."</li>";
                                    echo "<li>"."Email: ".$row['email']."</li>";
                                    echo "<li>"."Số điện thoại: ".$row['phone']."</li>";
                                }
                                else 
                                {
                                    echo $conn->error;
                                }
                            }
                        ?>
                    </ul>
                </div>
            </div>
            <div>
                <div class = "question_self">
                    <?php
                        if(isset($_SESSION["user_id"]))
                        {
                            $user_id = $_SESSION['user_id'];
                            $sql = "SELECT question.posting_time,users.user_name,users.avatar,question.question_id,question.question
                                    FROM `question` 
                                    INNER JOIN users ON question.user_id = users.user_id
                                    WHERE users.`user_id` = '$user_id'
                                    ORDER BY question.posting_time DESC";
                            $result_name= $conn -> query($sql);
                            while ($row = $result_name-> fetch_assoc())
                            {
                                $user_name = $row['user_name'];
                                $question_id = $row['question_id'];
                                $question = $row['question'];
                                $avatar = $row['avatar'];
                                $post_time = $row['posting_time'];
                                echo "<div class = 'question_img'>";
                                echo "<div class ='avatar_question'><img src='../img/$avatar' alt='avatar' id = 'avatar_question'></div>";
                                echo "<div class ='name_posting'>
                                            <div>$user_name</div>
                                            <div class = 'time_post'>$post_time</div>
                                    </div>";
                                echo "<form action='' class = 'change_question' method = 'POST'>";
                                echo"<input type='hidden' value='$question_id' name='question_id_question'>";
                                echo"<input type='submit' value = 'delete' class ='delete' nane='delete'>";
                                echo "</form>";
                                echo "</div>";
                                // Hiển thị bài viết
                                $query_img = "SELECT image FROM image WHERE question_id = $question_id";
                                $img = $conn -> query($query_img);
                                while ($images = $img -> fetch_assoc()) 
                                {
                                    $image = $images['image'];
                                }
                                echo"<div class ='select_question'>
                                    <div><strong>$question</strong></div>
                                    <div class = 'img_question'><img src='../img/$image' alt='ảnh câu hỏi' id ='img_question'></div>
                                </div>";
                                echo " <div class = 'comment'>
                                <h4>What did you say for this?</h4>";
                                echo "<div class='comment_seft'>
                                <div class = 'avatar_comment'><img src='../img/$avatar' alt='avatar' id = 'avatar_comment'></div>
                                <form action='' method = 'POST' class ='form_cmt'>
                                    <input type='text' placeholder='chia sẻ cảm nghĩ của bạn' class = 'text' name ='comment_insert'>
                                    <input type='hidden' value='$question_id' name='question_id_select'>
                                    <input type='submit' class ='submit'>
                                </form>
                                </div>";
                                echo "<form action='' id = 'change_comment' method = 'POST'>";
                                echo"<input type='submit' value = 'delete' name ='delete_comment' id = 'change'>";
                                echo '<hr>';
                                // thêm comment
                                if (isset($_POST['comment_insert']))
                                {
                                    $question_id_select = $_POST['question_id_select'];
                                    $comment_insert=$_POST['comment_insert'];
                                    $sql_insert_comment = "INSERT INTO `comments`(`user_id`, `question_id`, `comment`) 
                                    VALUES ('$user_id','$question_id_select','$comment_insert')";
                                    $conn -> query($sql_insert_comment);
                                }
                                // hiển thị các bài comment
                                echo "<div class = 'change_comment'>";
                                    echo "<p>Populator comment</p>"; 
                                echo "</div>";
                                $query_comment = "SELECT users.user_name, users.avatar, comments.comment,comments.time_comment
                                FROM comments
                                INNER JOIN users ON users.user_id = comments.user_id
                                WHERE comments.question_id = $question_id
                                ORDER BY comments.time_comment DESC";
                                $result_comment = $conn -> query($query_comment);
                                while ($comments = $result_comment -> fetch_assoc())
                                {
                                    $image_comment = $comments['avatar'];
                                    $name = $comments['user_name'];
                                    $time_comment = $comments['time_comment'];
                                    $comment = $comments['comment'];
                                    echo "<div class = 'comment_all' >
                                            <div class = 'avatar_populator'><img src='../img/$image_comment' alt='' id='avatar_populator' ></div>
                                            <div class='name_time_comment'>
                                                <div class='name_time'>
                                                    <div class='name'>$name - $time_comment</div>
                                                </div>
                                                <div class='comment'>$comment</div>
                                            </div>
                                            <input type=checkbox name = 'checkbox[]' value = '".$time_comment."' class='checkbox'>
                                            </form>
                                </div>";
                                }
                                // xóa comment
                                if (isset($_POST['delete_comment']))
                                    {
                                        if (isset($_POST['checkbox']))
                                        {
                                            $chkarr = $_POST['checkbox'];
                                            foreach($chkarr as $dele_comment)   
                                            {
                                                $sql_dele_comment = "DELETE FROM `comments` WHERE `time_comment` = '$dele_comment'";
                                                if ($conn ->query($sql_dele_comment)== TRUE)
                                                {
                                                    echo "Bạn đã xóa thành công bài viết";
                                                }
                                                else
                                                {
                                                    echo "Error: " . $sql_dele_comment . "<br>" . $conn->error;
                                                }
                                            }
                                        }
                                    }
                            }
                            echo "</div>";
                            // xóa bài viêt
                            if ($question != "")
                            {
                                if(isset($_POST['question_id_question']))
                                {
                                    $sql_dele_img = "DELETE FROM `image` WHERE `question_id` = '$question_id'";
                                    $result_dele_img = $conn -> query($sql_dele_img);
                                    $sql_dele_question_comment = "DELETE FROM `comments` WHERE `question_id`= '$question_id'";
                                    $result_dele_question_comment = $conn -> query($sql_dele_question_comment);
                                    $sql_dele_question ="DELETE FROM `question` WHERE `question_id` = '$question_id'";
                                    $result_dele_question = $conn -> query($sql_dele_question);
                                }
                                else
                                {
                                    echo "";
                                }
                            }
                            else
                            {
                                echo "";
                            }
                        }
                        ?>
            </div>
        </section>
        <article>
            <p class='article-header'>Nhóm của bạn</p>
            <ul class='list-rooms'>
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