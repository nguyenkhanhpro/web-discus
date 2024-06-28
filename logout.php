<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
        session_start();
        if (isset($_SESSION["use_id"]))
        {
            unset($_SESSION["use_id"]);
        }
        header("Location:login.php");
    ?>
</body>
</html>