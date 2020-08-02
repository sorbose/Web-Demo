<?php
echo "欢迎","你<br/>";
echo "hello "."world<br/><br/>";
print "连接到MySQL...<br/><br/>";
$servername="localhost";
$username="root";
$PW="";
$conn = mysqli_connect($servername,$username,$PW);
if(!$conn)
{
    die("连接失败".mysqli_connect_errno().mysqli_connect_error());
}
echo "连接成功！";

?>
