<!DOCTYPE html>
<html lang="zh">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>提示页</title>
</head>
<body>

<?php
header('content-type:text/html; charset=UTF-8');
if(!isset($_POST['authcode']))
{die("请输入验证码！");}
session_start();
if(strtolower($_POST['authcode'])!==strtolower($_SESSION['authcode']))
{
	echo("验证码错误！3秒后将跳转回登录页面");
	header("refresh:3;url=login.html");
	die("验证码错误");
}
unset($_SESSION['authcode']);
$username=$_POST['username'];
$username=substr($username,0,16);
$username=htmlspecialchars($username);
$username=preg_replace('/\s+/','',$username);
$PW=$_POST['PW'];
$PW=substr($PW,0,32);
$PW=htmlspecialchars($PW);
$servername="localhost";
$SQL_username="root";
$SQL_PW="";
$conn=mysqli_connect($servername,$SQL_username,$SQL_PW,"web");
if(!$conn)
{die("出错了！请联系网站管理员！");}
$SQL="SELECT PW from userpw WHERE username = '".$username."' LIMIT 1;";
//echo $SQL;
$retval=mysqli_query($conn,$SQL);
if(!mysqli_num_rows($retval))
{
	echo "用户名不存在。3秒后将回到登录页面。<br/><br/>";
	header("refresh:3;url=login.html");
	mysqli_free_result($retval);
	die("用户名不存在");
}
$row=mysqli_fetch_array($retval,MYSQLI_NUM);
if($row[0]!==$PW)
{
	echo "密码错误。3秒后将回到登录页面。<br/><br/>";
	header("refresh:3;url=login.html");
	mysqli_free_result($retval);
	die("密码错误");
}
else
{
	echo "登录成功！功能开发中";
}
mysqli_free_result($retval);
$_SESSION['is_login']=true;
$_SESSION['username']=$username;
header("location:myself.html");
?>
	
</body>
</html>
