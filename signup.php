<?php
session_start();
?>
<!DOCTYPE html>
<html lang="zh">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>注册页</title>
	<style>
		.hint{
			color: grey;
			font-size: small;
		}
		.note{
			color:red;
			font-size: small;
			visibility: hidden;
		}
	</style>
</head>

<body>
	<form action="" method="POST" onsubmit="return verify()">
		<fieldset>
			<legend>注册 SIGN UP</legend>
			<label>用户名&nbsp;&nbsp;：</label>
			<input type="text" name="username" maxlength="14" required="required" onblur="verifyUn()" />
			<span class="note" id="un_note">用户名格式不正确</span>
			<p class='hint'>4~14个字符的数字、英文字母、下划线</p>

			<label>密&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;码：</label>
			<input type="password" name="PW" maxlength="16" required="required" onblur="verifyPW()" />
			<span class="note" id="PW_note">密码格式不正确</span>
			<p class='hint'>6~16个字符的数字、英文字母、-和下划线</p>

			<label>确认密码：</label>
			<input type="password" name="PWrep" maxlength="16" required="required" onblur="verifyPWrep()" />
			<span class="note" id="PWrep_note">两次密码输入不一致</span>

			<br/><br/>
			<label>验证码：&nbsp;&nbsp;&nbsp;</label>
            <input type="text" name="authcode" autocomplete="off" maxlength="4" required="required" onblur="checkCap()"/>
            <img id="cap_img" border="1" src="./captcha.php" width="125" height="25" align="middle" onclick="this.src=this.src+'?r='+Math.random()" />
            <div id="cap_note" style="font-size:small;color:red">&nbsp;</div>
			<input type="submit" name="SSS" value="确认注册" />
		</fieldset>
	</form>
</body>
<script src="./md5.js"></script>
<script>
	document.getElementsByName("PW")[0].value="";
	var old_q_un="";
	function verifyUn(){
		var un_note=document.getElementById('un_note');
		var str=document.getElementsByName('username')[0].value;
		var pat=/[^A-Za-z0-9_]/;
		var len=str.length;
		if (len>14||len<4)
		{
			un_note.innerText="用户名长度不符合要求";
			un_note.style.visibility="visible";
			return false;
		}
		if(pat.test(str))
		{
			un_note.innerText="用户名包含其他字符";
			un_note.style.visibility="visible";
			return false;
		}
		if(old_q_un!==str)
		{resbool=unAJAX(str);
		//console.log(resbool);
		}
		if(un_note.style.visibility=="visible")
		{
			return false;
		}
		un_note.style.visibility="hidden";
		un_note.innerText="用户名格式不正确";//恢复默认设置
		return true;
	}
	function unAJAX(str){
		var xmlhttp = new XMLHttpRequest();
		xmlhttp.onreadystatechange=function(){
			if (xmlhttp.readyState==4 && xmlhttp.status==200)
			{
				var respText=xmlhttp.responseText;
				if(respText=="1")
				{
					document.getElementById('un_note').innerHTML="该用户名已被注册，请更换一个";
					document.getElementById('un_note').style.visibility="visible";
					return false;
				}
				if(respText=="0")
				{
					document.getElementById('un_note').style.visibility="hidden";
					document.getElementById('un_note').innerHTML="用户名格式不正确";//恢复默认设置
					return true;
				}
			}
		}
		xmlhttp.open("GET","./usernamecheck.php?q="+str,true);
		xmlhttp.send();
		old_q_un=str;
	}

	function verifyPW(){
		var PW_note=document.getElementById('PW_note');
		var str=document.getElementsByName('PW')[0].value;
		var pat=/[^A-Za-z0-9_-]/;
		var len=str.length;
		if (len>16||len<6)
		{
			PW_note.innerText="密码长度不符合要求";
			PW_note.style.visibility="visible";
			return false;
		}
		if(pat.test(str))
		{
			PW_note.innerText="密码包含其他字符";
			PW_note.style.visibility="visible";
			return false;
		}
		PW_note.innerText="密码格式不正确";//恢复默认设置
		PW_note.style.visibility="hidden";
		return true;
	}
	function verifyPWrep(){
		var str_rep=document.getElementsByName('PWrep')[0].value;
		var str=document.getElementsByName('PW')[0].value;
		var PWrep_note=document.getElementById('PWrep_note');
		if (str===str_rep){
			PWrep_note.style.visibility="hidden";
			return true;
		}
		else{
			PWrep_note.style.visibility="visible";
			return false;
		}
	}
	function checkCap(){
            if(document.getElementsByName('authcode')[0].value.length<4)
            {
                document.getElementById('cap_note').innerText="请输入验证码!";
                return false;
            }
            document.getElementById('cap_note').innerText="";
            return true;
    }
	function verify()
	{
		if(verifyUn()&&verifyPW()&&verifyPWrep()&&checkCap())
		{
			document.getElementsByName("PWrep")[0].value = md5(document.getElementsByName("PWrep")[0].value);
			return true;
		}
		else {return false;}
	}
</script>
</html>

<?php
if(!isset($_POST['SSS']))
{exit();}
if(!isset($_POST['authcode']))
{die("请输入验证码！");}
if(!isset($_SESSION['authcode']))
{die("session error");}
if(strtolower($_POST['authcode'])!==strtolower($_SESSION['authcode']))
{
	//echo("验证码错误！3秒后将跳转回注册页面");
	//header("refresh:3;url=''");
	//echo strtolower($_POST['authcode']);
	//echo strtolower($_SESSION['authcode']);
	die("<div style='color:red'>验证码错误!</div>");
}
unset($_SESSION['authcode']);
$servername="localhost";
$SQL_username="root";
$SQL_PW="";
$username=$_POST['username'];
$username=substr($username,0,14);
if (strlen($username)<4||preg_match('/[^0-9A-Za-z_]/',$username))
{
	echo "<script>alert(\"用户名非法输入！\")</script>";
	die("用户名非法输入！");
}
$username=htmlspecialchars($username);
$PW=$_POST['PW'];
$PW=substr($PW,0,16);
$PWrep=$_POST['PWrep'];
if (strlen($PW)<6||preg_match('/[^0-9A-Za-z_-]/',$PW)||md5($PW)!==$PWrep)
{
	echo "<script>alert(\"密码非法输入！\")</script>";
	die("密码非法输入！");
}
$conn=mysqli_connect($servername,$SQL_username,$SQL_PW,"web");
if(!$conn)
{echo "<script>alert(\"出错了！请联系网站管理员！\")</script>";die("connection error");}
$SQL="SELECT PW from userpw WHERE username = '".$username."';";
$retval=mysqli_query($conn,$SQL);
if (mysqli_num_rows($retval))
{
	echo "<script>alert(\"此用户名已被注册！！！\")</script>";
	die("1");
}
$SQL="INSERT INTO userpw (username,PW,attr) VALUES ('".$username."','".$PWrep."', -1);";
if(!mysqli_query($conn,$SQL))
{echo "<script>alert(\"出错了！请联系网站管理员！\")</script>";die("mysqli_query error");}
mysqli_close($conn);
echo "注册成功！请牢记密码";
//header("location:login.html");
echo "<script>alert(\"注册成功！请牢记密码\");window.location.href=\"login.html\"</script>";
?>


