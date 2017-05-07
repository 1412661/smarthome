<?php

sleep(1);

while (true) {
	$duration = intval(file_get_contents('/home/www-data/config/cam_duration.txt'));
	if ($duration == 0) break;
	
	$date = getdate();
	$folder = $date['mday'].'.'.$date['mon'].'.'.$date['year'];
	$link = "/home/www-data/pictures/files/auto/$folder/";
	$time = $date['hours'].'.'.$date['minutes'].'.'.$date['seconds'];
	$filename = $link.$time.'.jpg';
	if (!is_dir($link)) mkdir($link,0777);
	shell_exec("cd $link & wget http://localhost:4/?action=snapshot -O $filename &");
	chmod($filename,0777);
	sleep($duration);
}

?>