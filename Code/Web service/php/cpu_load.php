<?php

$load = file_get_contents('/proc/loadavg');
$load = explode(' ',$load);
echo intval($load[0]*100).' '.intval($load[1]*100).' '.intval($load[2]*100);

?>