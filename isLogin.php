<?php
session_start();
if(isset($_SESSION['is_login']))
{
    if($_SESSION['is_login']===true)
    {
		$servername="localhost";
		$SQL_username="root";
		$SQL_PW="";
		$conn=mysqli_connect($servername,$SQL_username,$SQL_PW,"web");
		if(!$conn)
		{die("出错了！请联系网站管理员！");}
		$username=$_SESSION['username'];
		$username=htmlspecialchars($username);
		$username=preg_replace('/\s+/','',$username);
		$SQL="SELECT authority,usergroup,attr,userdate from userpw WHERE username = '".$username."' LIMIT 1;";
		$retval=mysqli_query($conn,$SQL);
		$row=mysqli_fetch_array($retval,MYSQLI_NUM);
		$arr=array('un'=>$username,'auth'=>$row[0],'group'=>$row[1],'attribute'=>$row[2],'date'=>$row[3]);
		
		echo json_encode($arr);
		exit();
	}
}
else{
	die("");
}

exit();
?>
