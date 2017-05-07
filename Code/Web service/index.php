<?php

$time1 = microtime(true);

session_start();

if ($_SESSION['login'] == false) header('Location: login.php');

include_once('/home/www-data/config/config.php');
include_once('/home/www-data/function/function.php');

include_once('/home/www-data/database/sqlite.php');
include_once('/home/www-data/class/xtemplate/xtemplate.class.php');

$sql = new MyDB('/home/www-data/database/smarthome.db');

error_reporting(E_ERROR | E_WARNING | E_PARSE);

$tpl = new XTemplate('template/index.tpl');

$time2 = microtime(true);
$sec =	round($time2-$time1, 4);
$tpl->assign('current_date', current_date());
$tpl->assign('sec', $sec);

$tpl->assign('db_size', file_size(filesize('/home/www-data/database/smarthome.db')));

$query = $sql->last_row('sensor_DHT11');
while($result = $query->fetchArray(SQLITE3_ASSOC)){
    $tpl->assign('temp', $result['temp']);
    $tpl->assign('humidity', $result['humidity']);
}

$query = $sql->setquery('SELECT * FROM "defined_command" WHERE "add_by" <> "system"');
while($result = $query->fetchArray(SQLITE3_ASSOC)){
    $tpl->set_autoreset();
	
	$tpl->assign('command_name', $result['name']);
    $tpl->assign('command_id', $result['id']);
	
	$tpl->parse('main.defined_command');
}

$tpl->assign('host', $_SERVER['HTTP_HOST']);

$tpl->parse('main');
$tpl->out('main');
$sql->close();

?>