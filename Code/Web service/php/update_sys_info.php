<?php

include('/home/www-data/database/sqlite.php');
include('/home/www-data/function/function.php');

while (true) {
	$temp = intval(file_get_contents('/sys/class/thermal/thermal_zone0/temp'))/1000;

	$load = file_get_contents('/proc/loadavg');
	$load = explode(' ',$load);

	$m1 = intval($load[0]*100);
	$m5 = intval($load[1]*100);
	$m15 = intval($load[2]*100);

	$sql = new MyDB('/home/www-data/database/smarthome.db');
	$sql->begin_transaction();

	$sql->setquery("INSERT INTO 'sensor_sys_temp' ('val','time') VALUES($temp,'".current_time()."')");
	$sql->setquery("INSERT INTO 'log_cpu_load' ('m1','m5','m15','time') VALUES($m1,$m5,$m15,'".current_time()."')");

	$sql->save_transaction();
	$sql->close();
	
	sleep(300);
}

?>