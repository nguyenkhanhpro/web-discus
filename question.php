<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/form.css">
    <link rel="stylesheet" href="../css/question.css">
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
        <div class="container-body">
            <div class="div-header"><h1>Đặt câu hỏi công khai</h1></div>
            <section class="begin">
                <div>
                    <h4>Viết 1 câu hỏi hay</h4>
                    <p>Bạn đã sẵn sàng đặt câu hỏi liên quan đến lập trình 
                        và biểu mẫu này sẽ giúp hướng dẫn bạn thực hiện quy trình.
                    </p>
                    <p>Bạn muốn hỏi một câu hỏi không liên quan đến lập trình? 
                        Xem các chủ đề ở đây để tìm một trang web có liên quan</p>
                    <p>Các bước sau</p>
                    <ul>
                        <li>Mô tả vấn đề của bạn.</li>
                        <li>Đưa ra hình ảnh mô tả vấn đề(nếu có).</li>
                    </ul>
                </div>
            </section>
            <form method="POST" action="" enctype="multipart/form-data" class ="form-data"> 
            <section class="step-1">
                <div>
                    <h4>Tiêu đề</h4>
                    <p>
                        Hãy cụ thể và tưởng tượng bạn đang đặt câu hỏi cho người khác.
                    </p>
                    <input type="text" placeholder="ví dụ : Cách viết 1 hàm trong php" name = "question" class="input-question">
                </div>
            </section>
            <section class="step-2">
                <div>
                    <h4>Ảnh mô tả vấn đề của bạn?</h4>
                    <p>
                        Đưa ra hình ảnh mô tả vấn đề(nếu có)
                    </p>
                    <input type="file" name="image"> 
                </div>
            </section>
            <button type="submit" name="upload" class ="submit">POST</button>
            <?php
                require 'connect.php';
                if (isset($_POST['question']) and isset($_SESSION["user_id"])) 
                {
                    $user_id = $_SESSION['user_id'];
                    $question = $_POST['question'];
                    $sql_question = "INSERT INTO question(question, user_id) VALUES ('$question',$user_id)";
                    $result_question = $conn -> query($sql_question);
                    if ($result_question == TRUE)
                    {
                        $sql = "SELECT `question_id` FROM `question` ORDER BY `question_id` DESC LIMIT 1";
                        $row = $conn -> query($sql) -> fetch_assoc();
                        $question_id = $row["question_id"];
                        $file = $_FILES['image'];
                        $file_name = $file['name'];
                        $sql_img_question = "INSERT INTO image(question_id, image) VALUES ($question_id,'$file_name')";
                        $result_img = $conn -> query($sql_img_question);
                        if($result_img == TRUE)
                        {
                            echo '<script>alert("Đã upload thành công!");</script>';
                        }
                        else
                        {
                            echo "thêm ảnh thất bại". $errors;
                        }
                        echo '<a href="homeuser.php">Bạn có muốn đi xem bài post?</a>';
                        $conn -> close();
                }
            }
            ?>
            </form>
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