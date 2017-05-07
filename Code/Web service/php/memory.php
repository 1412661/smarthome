<?php

include_once('/home/www-data/function/function.php');

$data = file_get_contents('/proc/meminfo');
$data = explode(' ',$data);
$sys_mem_total = file_size($data[9]*1000);
$sys_mem_usage = file_size(($data[9] - $data[20])*1000);
$sys_percent = percent($sys_mem_usage,$sys_mem_total,2);

$web_mem = file_size(memory_get_usage());

echo $web_mem.'  '.$sys_mem_usage.'  '.$sys_mem_total.'  '.$sys_percent.'%';


?>