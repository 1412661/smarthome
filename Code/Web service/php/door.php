<?php

switch ($_GET['action']) {
	case 'OPEN':
		echo exec('sudo echo -ne "SEND_315 1572864\r\n" >> /dev/ttyUSB0');
		break;
		
	case 'CLOSE':
		echo exec('sudo echo -ne "SEND_315 1310720\r\n" >> /dev/ttyUSB0');
		break;
}


?>