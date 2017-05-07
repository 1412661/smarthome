<?php

include('/home/www-data/database/sqlite.php');
include('/home/www-data/function/function.php');

$sql = new MyDB('/home/www-data/database/smarthome.db');
//$sql->begin_transaction();


$query = $sql->last_row('sensor_fire');
while($result = $query->fetchArray(SQLITE3_ASSOC)){
    echo $result['val'].'  '.$result['status'].'  '.$result['time'];
}

//$sql->save_transaction();
$sql->close();


?>
