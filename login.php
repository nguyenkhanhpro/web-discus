<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log in</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <style>
            header {
            border-bottom: 1px solid rgb(176, 175, 175);
            height: 90px;
            width: 100%;
            position: relative;
            }
            .all-content-header {
                display: flex;
                height: 90%;
                width: 80%;
                margin: auto;
                padding: 0px 20px;
            }
            .avatar img{
                width: 15%;
                margin-top: 5%;
                margin-left: 80%;
            }
            .icon {
                width: 200px;
            }
            .search {
                position: relative;
                width: 90%;
                margin: 0px 40px;
            }
            .search input {
                margin: 20px 0px;
                width: 85%;
                height: 40px;
                padding: 0px 50px;
                border-radius: 10px;
                color: rgb(134, 130, 130);
            }
            .search label {
                position: absolute;
                top: 21px;
                left: 2px;
                padding: 8px 10px ;
                font-size: 1.3em;
                color: rgb(134, 130, 130);
                border: none;
                border-radius: 10px 0px 0px 10px;
            }
            .login {
                width: 30%;
                padding: 0;
                margin-top: 2%;
            }
            .login input {
                width: 100%;
                padding: 2%;
                border:none;
                background-color: white;
                cursor: pointer;
            }
            .sign-up {
                width: 30%;
                margin-top: 2%;
                padding: 0;
            }
            .sign-up input{
                border-top-left-radius: 15px;
                border-top-right-radius: 15px;
                border-bottom-right-radius: 15px;
                border-bottom-left-radius: 15px;
                width: 40%;
                padding: 2%;
                border: #ccc 2px solid;
                background-color: #333;
                color: white;
                cursor: pointer;
            }
            .icon-header {
                display: flex;
                padding: 10px;
                margin-top: 25px;
            }
            .icon-header label {
                margin-left: 20px;
            }
            .icon-header i {
                width: 300px;
                padding: 5px;
            }
            .label-ring {
                cursor: pointer;
            }
            .icon-header:hover #label-ring {
                display: block;
            }
            #label-ring {
                position: absolute;
                width: 200px;
                border: 2px solid rgb(155, 154, 154);
                left: 0;
                list-style: none;
                padding: 10px;
                border-radius: 10px;
                display: none;
            }
            #label-ring li a{
                padding: 10px;
                list-style: none;
                text-decoration: none;
            }
            .icon-header-ring #label-ring :hover {
                text-decoration: none;
                color: rgb(92, 91, 91);
                font-weight: 800;
                font-size: 1.05em;
                padding: 0px 12px;
                cursor: pointer;
                border-bottom: #333;
            }
            .icon-header-ring {
                position: relative;
            }   
            .container {
                display: flex;
                flex-wrap: wrap;
                padding: 100px 50px;
                justify-content: center;
                background-color: #f0f2f5;
    
            }
            aside {
                width: 60%;
            }
            aside form input {
                height: 55px;
                width: 100%;
                border: 1px solid #ccc;
                border-radius: 6px;
                margin-bottom: 15px;
                font-size: 1rem;
                padding: 0 14px;
            }
            aside form {
                margin-left: 30%;
                width: 50%;
            }
            .text {
                display:flex;
                
            }
            .link input {
                height: 55px;
                width: 100%;
                background-color: blue;
            }
            form a {
                text-decoration: none;
            }
            .link {
                display: flex;
                flex-direction: column;
            }
            .text {
                display: block;
            }
            section {
                width: 30%;
            }
            .link input{
                color: #ccc;
                cursor: pointer;
            }
            body {
                margin: 0px;
                padding: 0px;
            }
            /* footer */
            footer {
                background: rgb(163, 150, 126);
                height: 200px;
            }
            .footer-content {
                display: flex;
                flex-wrap: wrap;
                width: 90%;
                margin: 20px auto;
            }
            .footer-content ul {
                list-style: none;
                margin: 10px auto;
            }
            #title {
                font-size: 1.1em;
                padding: 10px 0px;
                font-weight: 800;
            }
    </style>
</head>
<body>
    <header>
        <div class="all-content-header">
            <div class="icon">
                <h1>question</h1>
            </div>
            <div class="search">
                <label for="search"><i class='bx bx-search'></i></label>
                <input type="text" name="search" id="search" placeholder="Tìm kiếm">
            </div>
            <div class="login">
                <form action="login.php">
                    <input type="submit" value="login">
                </form>
            </div>
            <div class="sign-up">
                <form action="signup.php">
                    <input type="submit" value="sign up">
                </form>
            </div>
        </div>
    </header>
    <div class="container">
        <section>
            <div class="text">
                <h1>Trang Web giao lưu về kiến thức trong lĩnh vực lập trình</h1>
                <p>Nơi để giao lưu và kết bạn </p>
                <p>Học tập và trao dồi kiến thức mỗi ngày sẽ khiến bạn tốt lên</p>
            </div>
        </section>
        <aside>
            <form method = "POST" action='checklogin.php'>
                <input type="text" placeholder="Tài khoản" name = "account">
                <input type="password" placeholder="Mật khẩu" name ="password">
                <div class="link">
                    <input type="submit" value="login">
                </div>
            <hr/>
            <div class="buttom">
                Don't have a account? <a href="signup.php">Sign up</a>
            </div>
            </form>
            
        </aside>
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