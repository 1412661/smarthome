<?php

session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
//if (!$_SESSION['login']) die();
$_SESSION['user'] = 'test';

include_once('/home/www-data/database/sqlite.php');
include_once('/home/www-data/function/function.php');

$sql = new MyDB('/home/www-data/database/smarthome.db');
$sql->begin_transaction();

switch ($_GET['action']) {
	case 'direct_command':
		$command = $_POST['command'];
		$r = shell_exec($command);
		if ($r == null) echo 'Đã gửi lệnh !';
		else echo $r;
		$sql->setquery("INSERT INTO 'log_server_command' ('command','result','time') VALUES ('$command', '$r', '".current_time()."')");

		break;
		
	case 'defined_command':
		$command_id = intval($_POST['command']);
		$query = $sql->setquery("SELECT * FROM 'defined_command' WHERE id = $command_id");
		while($result = $query->fetchArray(SQLITE3_ASSOC)){
			$command = $result['command'];
			$r = shell_exec($command);
			
			if ($r == null) echo 'Đã gửi lệnh !'; 
			else echo $r;
			$sql->setquery("INSERT INTO 'log_server_command' ('command','result','time') VALUES ('$command', '$r', '".current_time()."')");
		}
		break;
		
	case 'get_sys_temp':
		$temp = intval(file_get_contents('/sys/class/thermal/thermal_zone0/temp'))/1000;
		echo $temp;
		break;
		
	case 'add_command':
		$command = $_POST['command'];
		$command_name = $_POST['command_name'];
		$sql->setquery("INSERT INTO 'defined_command' ('name','command','time','add) VALUES ('$command_name', '$command', '".current_time()."')");
		echo 'Đã thêm lệnh thành công !';
		break;
	case 'servo':
		
}

$sql->save_transaction();
$sql->close();


?>