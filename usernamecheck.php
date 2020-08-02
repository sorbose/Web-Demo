<?php
$servername="localhost";
$SQL_username="root";
$SQL_PW="";
$q=$_GET['q'];
$q=substr($q,0,20);
$q=htmlspecialchars($q);
$q=preg_replace('/\s+/','',$q);
$conn=mysqli_connect($servername,$SQL_username,$SQL_PW,"web");
if(!$conn)
{die("出错了！请联系网站管理员！");}
$SQL="SELECT PW from userpw WHERE username = '".$q."';";
$retval=mysqli_query($conn,$SQL);
if (mysqli_num_rows($retval))
{
	die("1");
}
else {die("0");}
?>
