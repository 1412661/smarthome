
<?php

if ($argv[1] != '')
file_put_contents('/home/www-data/php/readserial.txt', intval($argv[1])."\r\n", FILE_APPEND);

include('/home/www-data/database/sqlite.php');
include('/home/www-data/function/function.php');

$sql = new MyDB('/home/www-data/database/smarthome.db');
$sql->begin_transaction();



$read = intval($argv[1]);
if (($read >> 20) == 0) die();


//debug



$id = $read >> 20;

switch ($id) {
	//Nhiệt độ độ ẩm
	case 4:	
		$temp = ($read >> 10) % 1024;
		$doam = round((($read << 14) / 16384)) % 1024;

		if (($temp > 100) or ($temp < 0)) die();
		if (($doam > 100) or ($doam < 0)) die();
		
		//file_put_contents('/home/www-data/php/readserial.txt', $temp.' '.$doam."\r\n", FILE_APPEND);

		$sql->setquery("INSERT INTO 'sensor_DHT11' ('temp','humidity','time') VALUES($temp,$doam,'".current_time()."')");
		break;
	
	//Báo cháy
	case 2:
		$temp = ($read >> 10) % 1024;
		if (($temp > 100) or ($temp < 0)) die();
		if ($temp > 50) {
			$sql->setquery("INSERT INTO 'sensor_fire' ('val','status','time') VALUES ($temp,'Báo động','".current_time()."')");
			//exec('python /home/www-data/python/GSM.py 0906562266 FIRE_ALERT');
			exec('sudo echo -ne "GSM_SEND 0906562266 FIRE_ALERT\r\n" > /dev/ttyUSB0');
		} else {
			$sql->setquery("INSERT INTO 'sensor_fire' ('val','status','time') VALUES ($temp,'Tốt','".current_time()."')");
		}
		break;
		
	case 3:
		$status = (((3 << 20) or (1 << 19)) and $read);
		
		if ($status == 1) {
			$sql->setquery("INSERT INTO 'sensor_MQ2' ('time','status') VALUES ('".current_time()."', 'Báo động')");
			//exec('python /home/www-data/python/GSM.py 0906562266 GAS_ALERT');
			exec('sudo echo -ne "GSM_SEND 0906562266 GAS_ALERT\r\n" > /dev/ttyUSB0');
		} else {
			$sql->setquery("INSERT INTO 'sensor_MQ2' ('time','status') VALUES ('".current_time()."', 'Không phát hiện')");
		}
		usleep(100*1000);
		break;
	
	
	//Báo trộm
	case 7:
		$status = (((7 << 20) or (1 << 19)) and $read);
		
		if ($status == 1) {
			$sql->setquery("INSERT INTO 'log_anti_thief' ('time','status') VALUES ('".current_time()."', 'Báo động')");
			//exec('python /home/www-data/python/GSM.py 0906562266 THIEF_ALERT');
			exec('sudo echo -ne "GSM_SEND 0906562266 THIEF_ALERT\r\n" > /dev/ttyUSB0');
		} else {
			$sql->setquery("INSERT INTO 'log_anti_thief' ('time','status') VALUES ('".current_time()."', 'Không phát hiện')");
		}
		usleep(100*1000);
		break;
}



$sql->save_transaction();
$sql->close();

usleep(100*1000);

?>
