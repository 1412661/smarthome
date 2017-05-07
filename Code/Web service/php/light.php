<?php

switch ($_GET['action']) {
	case 'ON':
		echo exec('sudo echo -ne "SEND_315 6815744\r\n" >> /dev/ttyUSB0');
		break;
		
	case 'ON':
		echo exec('sudo echo -ne "SEND_315 6291456\r\n" >> /dev/ttyUSB0');
		break;
}


?>