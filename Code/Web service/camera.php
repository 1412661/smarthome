<?php

session_start();

include_once('/home/www-data/function/function.php');
include_once('/home/www-data/database/sqlite.php');

error_reporting(E_ERROR | E_WARNING | E_PARSE);

$sql = new MyDB('/home/www-data/database/smarthome.db');

switch ($_GET['action']) {
	case 'set':
		$fps = $_GET['fps'];
		$res = $_GET['res'];
		echo shell_exec('sudo killall mjpg_streamer');
		echo shell_exec('sudo mjpg_streamer -i "/usr/local/lib/input_uvc.so -n -f '.$fps.' -r '.$res.'" -o "/usr/local/lib/output_http.so -p 4 -n -w /usr/local/www" -b');
		echo "Bạn đã cài đặt lại camera thành công !\nĐộ phân giải video: $res\nKhung hình trên giây: $fps\n\nHệ thống sẽ tự động tải lại trang web để cập nhật thay đổi";
		break;
		
		
		
		
	case 'capture':
		switch ($_GET['type']) {
			case 'manual':
				$date = getdate();
				$folder = $date['mday'].'.'.$date['mon'].'.'.$date['year'];
				$link = "/home/www-data/pictures/files/manual/$folder/";
				$time = $date['hours'].'.'.$date['minutes'].'.'.$date['seconds'];
				$filename = $link.$time.'.jpg';
				$img = 'http://'.$_SERVER['HTTP_HOST'].':4/?action=snapshot';

				if (!is_dir($link)) mkdir($link,0777);

				file_put_contents($filename,file_get_contents($img));
				chmod($filename,0777);
				echo 'Đã chụp ảnh! File '.$time.'.jpg đã được lưu lại.';
				break;
				
			case 'auto':
				$duration = intval($_GET['duration']);
				file_put_contents('/home/www-data/config/cam_duration.txt',$duration);
				shell_exec("php /home/www-data/php/auto_cam.php > /dev/null &");
				break;
		}
		break;
	case 'stop_auto_cam':
		file_put_contents('/home/www-data/config/cam_duration.txt','');
		echo 'Đã dừng chức năng tự động chụp hình !';
		break;
	case 'auto_cam_status':
		$duration = intval(file_get_contents('/home/www-data/config/cam_duration.txt'));
		switch ($duration) {
			case 0: echo ''; break;
			case 5: echo 'Chụp ảnh sau: 5 giây'; break;
			case 20: echo 'Chụp ảnh sau: 20 giây'; break;
			case 60: echo 'Chụp ảnh sau: 1 phút'; break;
			case 300: echo 'Chụp ảnh sau: 5 phút'; break;
			case 1200: echo 'Chụp ảnh sau: 20 phút'; break;
			case 3600: echo 'Chụp ảnh sau: 1 giờ'; break;
			case 18000: echo 'Chụp ảnh sau: 5 giờ'; break;
			case 43200: echo 'Chụp ảnh sau: 12 giờ'; break;
			case 86400: echo 'Chụp ảnh sau: 24 giờ'; break;
		}
		break;
	case 'servo':
		shell_exec('sudo echo -ne "S '.intval($_GET['s1']).' '.intval($_GET['s2']).'\r\n" >> /dev/ttyUSB0');
		echo 'sudo echo -ne "S '.$_GET['s1'].' '.$_GET['s2'].'\r\n" >> /dev/ttyUSB0';
		break;
	case 'servo_center':
		exec('python /home/www-data/python/servo.py 9090');
		break;
}

$sql->close();

?>