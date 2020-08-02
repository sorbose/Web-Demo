<?php
session_start();
if(!isset($_SESSION['is_login']))
{
	echo("未登录或登录过期，3秒后跳转回登录页面");
	header("refresh:3;url=login.html");
	die();
}
if($_SESSION['is_login']!==true)
{
	echo("未登录或登录过期，3秒后跳转回登录页面");
	header("refresh:3;url=login.html");
	die();
}
if(strtolower($_POST['authcode'])!==strtolower($_SESSION['authcode']))
{
	echo("验证码错误！");
	header("refresh:3;url=changePW.html");
	die();
}
unset($_SESSION['authcode']);
$username=$_SESSION['username'];
$username=htmlspecialchars($username);
$username=preg_replace('/\s+/','',$username);
$PW=$_POST['PW'];
$PW=substr($PW,0,16);
$PWrep=$_POST['PWrep'];
$PWold=substr($_POST['PWold'],0,32);
if (strlen($PW)<6||preg_match('/[^0-9A-Za-z_-]/',$PW)||md5($PW)!==$PWrep)
{
	echo "<script>alert(\"密码非法输入！\")</script>";
	die("密码非法输入！");
}
$servername="localhost";
$SQL_username="root";
$SQL_PW="";
$conn=mysqli_connect($servername,$SQL_username,$SQL_PW,"web");
if(!$conn)
{die("出错了！请联系网站管理员！");}
$SQL="SELECT PW from userpw WHERE username = '".$username."' LIMIT 1;";
$retval=mysqli_query($conn,$SQL);
if(!mysqli_num_rows($retval))
{
	die("出错了！请联系管理员.session un sql error");
}
$row=mysqli_fetch_array($retval,MYSQLI_NUM);
if($row[0]!==$PWold)
{
	echo "原密码输入错误!3秒后回到刚才的页面";
	header("refresh:3;url=changePW.html");
	mysqli_free_result($retval);
	die("");
}
else
{
	$SQL="UPDATE userpw SET PW='".$PWrep."' WHERE username='".$username."';";
	if(!mysqli_query($conn,$SQL))
	{die("出错了！请联系网站管理员。mysqli_query update error");}
}
mysqli_close($conn);
echo "成功修改密码！请牢记新密码";
//header("location:login.html");
echo "<script>alert(\"修改成功！请牢记新密码\");window.location.href=\"login.html\"</script>";
?>
