<?php

include('/home/www-data/database/sqlite.php');
include('/home/www-data/function/function.php');

$sql = new MyDB('/home/www-data/database/smarthome.db');

$query = $sql->last_row('log_anti_thief');
while($result = $query->fetchArray(SQLITE3_ASSOC)){
    echo $result['time'];
}

$sql->close();


?>
