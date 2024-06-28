<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
    require "connect.php";
        $messeneger_time = '2024-01-02 21:03:55';
        $time = "2024-01-02 21:07:49";
        $distance = "SELECT TIMESTAMPDIFF(SECOND,'$messeneger_time','$time') AS distance;";
        $distance = $conn -> query($distance) -> fetch_assoc();
        echo $distance['distance'];
    ?>
</body>
</html>