<?php
// NHÓM HÀM XỬ LÍ/CHUẨN HÓA DỮ LIỆU ******************************************************
function optimize_output($str) {
	$str = preg_replace('/[\r\n]*/', null, $str);	//Xóa like break
	$str = preg_replace('/\t*/', null, $str);		//Xóa kí tự "tab"
	$str = preg_replace('/<!--(.*)-->/Uis', null, $str); 	//Xóa comment trong html
	$str = clear_space($str); 			//Xóa kí tự rỗng
	//fix coding style
	$str = str_replace('" >', '">', $str);			//VD: <span id="#obj1" ></span>	-> <span id="#obj1"></span>
	$str = str_replace('" />', '"/>', $str);		//VD: <img src="image.jpg " /> -> <img src="image.jpg "/>
	//$str = str_replace('> <', '><', $str);		//Có thể làm sai lệch nội dung trang
	return $str;
}
//Chuyển tiếng Việt có dấu sang tiếng Việt không dấu
function uni2non_uni($str) {
	$uni_char = array(
		'a'=>'á|à|ả|ã|ạ|ă|ắ|ặ|ằ|ẳ|ẵ|â|ấ|ầ|ẩ|ẫ|ậ',
		'd'=>'đ',
		'e'=>'é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ',
		'i'=>'í|ì|ỉ|ĩ|ị',
		'o'=>'ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ',
		'u'=>'ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự',
		'y'=>'ý|ỳ|ỷ|ỹ|ỵ',
		'A'=>'Á|À|Ả|Ã|Ạ|Ă|Ắ|Ặ|Ằ|Ẳ|Ẵ|Â|Ấ|Ầ|ẩ|Ẫ|Ậ',
		'D'=>'Đ',
		'E'=>'É|È|Ẻ|Ẽ|Ẹ|Ê|Ế|Ề|Ể|Ễ|Ệ',
		'I'=>'Í|Ì|Ỉ|Ĩ|Ị',
		'O'=>'Ó|Ò|Ỏ|Õ|Ọ|Ô|Ố|Ồ|Ổ|Ỗ|Ộ|Ơ|Ớ|Ờ|Ở|Ỡ|Ợ',
		'U'=>'Ú|Ù|Ủ|Ũ|Ụ|Ư|Ứ|Ừ|Ử|Ữ|Ự',
		'Y'=>'Ý|Ỳ|Ỷ|Ỹ|Ỵ'
		);		
	foreach ($uni_char as $non_uni_char => $uni) {
		$str = preg_replace("/$uni/", $non_uni_char, $str);
	}
	return $str;
}
//Xóa kí tự rỗng
function clear_space($str) {
	$str = preg_replace('/ * /', ' ', $str);
	$str = trim($str);
	return $str;
}function del_space($str) {	return str_replace(' ', '', $str);}
//Đếm số từ trong câu
function count_word($str) {
	if(!is_string($str)) {
		return 0;
	}
	return count(explode(' ', $str));
}

//Lấy tên học sinh. VD: Nguyễn Quốc Bảo -> Quốc Bảo
function get_name($name, $num) {
	$getname = explode(' ', $name);
	if ($num > count($getname)) {
		return '';
	} else {
		$result = null;
		for ($i = (count($getname)-$num); $i <= (count($getname)-1); $i++) {
			$result .= $getname[$i].' ';
		}		
		return rtrim($result, ' ');	}
}

//Chuẩn hóa tên về dạng viết hoa chữ đầu tiên của mỗi từ. VD: Quốc Bảo
function standard_name($str) {
	$str = clear_space($str);
	$str = mb_strtolower($str, 'UTF-8');
	$str = mb_convert_case($str, MB_CASE_TITLE, 'UTF-8');
	return $str;
}

//Tính phần trăm
function percent($number, $total, $round = false) {
	$percent = $number / $total * 100;
	if ($round) {
		return round($percent, $round);
	} else {
		return $percent;
	}
}
//Xóa kí tự đặc biệt
function clear_spec_char($data) {
	$spec_char = array('`', '~', '!', '@', '#', '$', '%', '^', '&', '*', '(', ')', '-', '_', '+', '=', '|', '[', ']', '{', '}', ';', ':', '"', "'", ',', '<', '.', '>', '/', '?', '*', chr(92)/*   char: \  */);
	return str_replace($spec_char, null, $data);
}
//Lọc input vào câu lệnh MySQL
function sql_filter($data) {
	//$data = trim(strip_tags($data));
	/*if (get_magic_quotes_gpc()) {
		$data = stripslashes($data);
	}*/	$data = del_space($data);		$danger = array('=','*','x',',','.',')','(','/','\\');	$data = str_replace($danger, null, $data);
	$data = addslashes($data);
	return $data;
}

//Xóa kí tự không hợp lệ (cho việc đặt tên file)
function clear_invalid_fname($str) {
	$invalid_fname = array(
		chr(92), #char: \
		chr(47), #char: /
		chr(58), #char: :
		chr(42), #char: *
		chr(63), #char: ?
		chr(34), #char: "
		chr(62), #char: >
		chr(60), #char: <
		chr(124), #char: |
	);
	$str = str_replace($invalid_fname, null, $str);
	$str = str_replace(' ', '_', $str);
	return $str;
}

//Cho ý nghĩa của error code khi upload file (Update Database)
function upload_file_error($code) {
	if (($code > 8) or ($code < 0)) {
		return 'Unknow error';
	}
	switch($code) {
		case UPLOAD_ERR_OK:
			return false;
		case UPLOAD_ERR_INI_SIZE:
			return 'Kích thước file của bạn vượt quá kích thước file tối đa mà phiên bản PHP trên hệ thống cho phép ! (The uploaded file exceeds the upload_max_filesize directive in php.ini)';
		case UPLOAD_ERR_FORM_SIZE:
			return 'Kích thước file của bạn vượt quá kích thước form HTML của bạn cho phép upload ! (The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form)';
		case UPLOAD_ERR_PARTIAL:
			return 'Quá trình upload file đã bị gián đoạn ! (The uploaded file was only partially uploaded)';
		case UPLOAD_ERR_NO_FILE:	
			return 'Không có file nào được gửi đến hệ thống hoặc hệ thống chưa nhận được file bạn gửi ! (No file was uploaded)';
		case UPLOAD_ERR_NO_TMP_DIR:
			return 'Không tìm thấy thư mục temporary trên hệ thống ! (Missing a temporary folder)';
		case UPLOAD_ERR_CANT_WRITE:
			return 'Không thể lưu trữ file trên hệ thống ! (Failed to write file to disk)';		
		case UPLOAD_ERR_EXTENSION:
			return 'Phiên bản PHP trên hệ thống không chấp nhận phần mở rộng (file extension) của bạn ! (A PHP extension stopped the file upload. PHP does not provide a way to ascertain which extension caused the file upload to stop; examining the list of loaded extensions with phpinfo() may help)';
	}
	return false;
}

//Rút gọn tên
function reduce_name($sub_name) {
	$reduced = strtolower(str_replace(' ', null, uni2non_uni($sub_name)));
	return $reduced;
}
function explode_($delim, $str) {
	$arr = explode($delim, $str);
	$i = 1;
	foreach ($arr as $val) {
		$result[$i] = $val;
		$i++;
	}
	return $result;
}function file_size($size) {	$unit=array('B','KB','MB','GB','TB','PB');	return @round($size/pow(1024,($i=floor(log($size,1024)))),2).' '.$unit[$i];}
// END NHÓM HÀM XỬ LÍ/CHUẨN HÓA DỮ LIỆU ////////////////////////////////////////







// BEGIN: NHÓM HÀM LẤY/TẠO DỮ LIỆU *************************************************************
function get_user_ip() {
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
		$ip = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
		$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
		$ip = $_SERVER['REMOTE_ADDR'];
    }
    return $ip;
}
function file_list($dir) {
	if ($dir[strlen($dir)-1] != '/') {$dir[strlen($dir)] = '/';}
	if (!exist_dir($dir)) {return array();}
	$scanned_dir = array_diff(scandir($dir), array('..', '.'));
	$flist = array();	
	foreach ($scanned_dir as $item) {
		if (is_file($dir.$item)) {			if (($item <> 'index.html') and ($item <> 'readme.txt')) {
				$flist[] = $item;			}
		}
	}
	asort($flist);
	if ($flist == array()) {
		return false;
	} else {
		return $flist;
	}
}
function get_upload_max_filesize_in_php_dot_ini() {
	$ini_maxsize = ini_get('upload_max_filesize');
	if (!is_numeric($ini_maxsize)) {
		if (strpos($ini_maxsize, 'K')) {
			return intval($ini_maxsize);
		} elseif (strpos($ini_maxsize, 'M')) {
			return intval($ini_maxsize)*1024;
		} elseif (strpos($ini_maxsize, 'G')) {
			return intval($ini_maxsize)*1024*1024;
		} elseif (strpos($ini_maxsize, 'T')) {
			return intval($ini_maxsize)*1024*1024*1024;
		} elseif (strpos($ini_maxsize, 'P')) {
			return intval($ini_maxsize)*1024*1024*1024*1024;
		}
	} else {
		return $ini_maxsize;
	}
}
function current_time() {
	return date('H:i:s d/m/Y');
}
function current_date() {
	$weekday_vi = array('Chủ nhật', 'Thứ hai', 'Thứ ba', 'Thứ tư', 'Thứ năm', 'Thứ sáu', 'Thứ 7');
	$getday = getdate();
	return "{$weekday_vi[$getday['wday']]} ngày {$getday['mday']}/{$getday['mon']}/{$getday['year']} lúc ".date('H:i:s');
}
/*function pagelink() {
    $s = empty($_SERVER['HTTPS']) ? '' : ($_SERVER['HTTPS'] == 'on') ? 's' : '';
    $sp = strtolower($_SERVER['SERVER_PROTOCOL']);
    $protocol = substr($sp, 0, strpos($sp, '/')).$s;
    $port = ($_SERVER['SERVER_PORT'] == '80') ? '' : (':'.$_SERVER['SERVER_PORT']);	
    return $protocol.'://'.$_SERVER['SERVER_NAME'].$port.$_SERVER['REQUEST_URI'];
}*/
// END: NHÓM HÀM LẤY DỮ LIỆU ///////////////////////////////////////////////////////






// BEGIN: NHÓM HÀM KIỂM TRA ********************************************************function is_number($var) {	for ($i = 0; $i <= strlen($var)-1; $i++) {		if ((intval($var[$i]) == 0) and ($var[$i] <> '0')) {			return false;		}	}		return true;}
function exist_dir($dir_name = false, $path = './') {
	if (!$dir_name) {return false;}
	if (is_dir($path.$dir_name)) {return true;}
	$tree = glob($path.'*', GLOB_ONLYDIR);
	if (($tree) and (count($tree)>0)) {
		foreach($tree as $dir) {
			if (exist_dir($dir_name, $dir.'/'))	{return true;}
		}
	}
	return false;
}

function is_uni($str) {
	if (strlen($str) != strlen(utf8_decode($str))) {
		return true;
	} else {
		return false;
	}
}

function var_set($var) {
	if ((isset($var)) and (!empty($var)) and ($var != null)) {
		return true;
	} else {
		return false;
	}
}
// END: NHÓM HÀM KIỂM TRA /////////////////////////////////////////////////////////////////







// BEGIN: NHÓM HÀM THỰC HIỆN LỆNH *******************************************************
function del_all_file($dir, $ext) {
	if ($dir[strlen($dir)-1] != '/') {$dir[strlen($dir)] = '/';}
	$files = glob($dir.'*.'.$ext); 	
	foreach($files as $file) {
		unlink($file);
	}	
	if (file_list($dir) == array()) {
		return true;
	} else {
		return false;
	}
}

function del_file($dir, $file) {	if (($file <> 'index.html') and ($file <> 'readme.txt')) {
		if ($dir[strlen($dir)-1] != '/') {			$dir[strlen($dir)] = '/';		}		
		@unlink($dir.$file);	}
}
function sql_dump($tables = '*', $method = 'all') {
	global $sql;
	//get table list
	if($tables == '*') {
		$query = $sql->setquery('SHOW TABLES');
		$tables = array();
		while($row = mysql_fetch_row($query)) {
			$tables[] = $row[0];
		}
	} else {
		$tables = is_array($tables) ? $tables : explode(',',$tables);
	}
	$result = null;
	$date = current_time();
	foreach($tables as $table) {
		$query = $sql->setquery('SELECT * FROM '.$table);
		$num_fields = mysql_num_fields($query);
		$result .= "/* Backup MySQLite Database for table [$table]\n Current time: $date\n\n */";
		if (($method == 'all') or ($method == 'structure')) {
			$row2 = mysql_fetch_row($sql->setquery('SHOW CREATE TABLE '.$table));
			$result .= "\n".$row2[1].";\n\n";
		}
		if (($method == 'all') or ($method == 'data')) {
			for ($i = 0; $i < $num_fields; $i++) {
				while($row = mysql_fetch_row($query)) {
					$result.= 'INSERT INTO '.$table.' VALUES(';
					for($j = 0 ;$j < $num_fields; $j++){
						$row[$j] = addslashes($row[$j]);
						if (isset($row[$j])) {
							$result .= '"'.$row[$j].'"';
						} else {
							$result .= '""';
						}
						if ($j < ($num_fields-1)) {
							$result .= ',';
						}
					}
					$result .= ");\n";
				}
			}
		}		
	$result .= "\n\n\n";
	}	
	mysql_free_result($query);
	if (mysql_error() != null) {
		return false;
	} else {
		return $result;
	}
}
// END: NHÓM HÀM THỰC HIỆN LỆNH /////////////////////////////////////////////////////////







// BEGIN: NHÓM HÀM DEBUG ****************************************************************
function debug($var) {
	error_reporting(E_ALL);
	echo '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />';
	var_dump($var);
	die();
}
function debug_($var) {
	error_reporting(E_ALL);
	echo '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />';
	var_dump($var);
}

function a() {
	echo '---------- STILL PROCESS HERE ! ----------';
}

// END: NHÓM HÀM DEBUG /////////////////////////////////////////////////////////////////

?>