<!DOCTYPE html>
<html lang="zh">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>注销页</title>

</head>
<body>
    <?php
    session_start();
    $_SESSION=array();
    session_destroy();
    header("location:login.html");
    die("您已成功退出登录。");
    ?>
</body>
</html>
