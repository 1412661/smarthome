<?php

include('/home/www-data/database/sqlite.php');
include('/home/www-data/function/function.php');

$sql = new MyDB('/home/www-data/database/smarthome.db');

$query = $sql->last_row('sensor_DHT11');
while($result = $query->fetchArray(SQLITE3_ASSOC)){
    echo $result['temp'].'  '.$result['humidity'].'  '.$result['time'];
}

$sql->close();


?>
