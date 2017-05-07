<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>Dự án Ngôi nhà thông minh - SmartHome</title>
	<link rel="shortcut icon" href="template/image/favicon.ico" type="image/x-icon" />
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />	<link rel="stylesheet" type="text/css" href="template/css/style.css"/>	<script type="text/javascript" src="js/function.js"></script>	<script type="text/javascript" src="js/jquery-1.7.2.min.js"></script>
</head>
<body><br /><div class="wrapper" style="width: 420px;"><div class="center"><img src="/template/image/login.jpg" style="width: 100px; height: 100px"/></div><br />
	<table class="table">
		<tr>
			<td colspan="2">
				<div class="header" style="margin-bottom: 0px">Đăng nhập hệ thống</div>
			</td>
		</tr>
		<tr>
			<td><b>Tên đăng nhập:</b></td>
			<td><input type="text" id="username"/></td>
		</tr>
		<tr>			<td><b>Mật khẩu:</b></td>
			<td><input type="password" id="password"/></td>
		</tr>
	</table>	<br />	<div class="center"><button onclick="login()">Đăng nhập</button>        <button onclick="clear_contents('#username'); clear_contents('#password');">Nhập lại</button></div>	<br /></div>
</body>
</html>