<?php
session_start();
if(!isset($_SESSION['is_login']))
{
    header("location:login.html");
    die("请先登录!");
}
if($_SESSION['is_login'])!==true)
{
    header("location:login.html");
    die("请先登录!");
}
if(isset($_SESSION['is_login']))
{
    if($_SESSION['is_login'])==true)
    {
		echo $_SESSION['username'];
		exit();
	}
}
else{
	die("");
}

?>
