function intval (mixed_var, base) {
  var tmp;

  var type = typeof mixed_var;

  if (type === 'boolean') {
    return +mixed_var;
  } else if (type === 'string') {
    tmp = parseInt(mixed_var, base || 10);
    return (isNaN(tmp) || !isFinite(tmp)) ? 0 : tmp;
  } else if (type === 'number' && isFinite(mixed_var)) {
    return mixed_var | 0;
  } else {
    return 0;
  }
}

function server_command(command_id) {
	if (confirm('Bạn có muốn chạy lệnh này không ?')) {
		if (command_id == '') {
			var cmd = $('#server_command').val();
			$.post('command.php?action=direct_command', {command: cmd}, function(data) {
				alert(data);
			});
		} else {
			$.post('command.php?action=defined_command', {command: command_id}, function(data) {
				alert(data);
			});
		}
	}
}

function clear_contents(select) {
	$(select).val('');
}

function add_command() {
	var cmd = $('#add_command_c').val();
	var name = $('#add_command_n').val();
	$.post('command.php?action=add_command', {command: cmd, command_name: name}, function(data) {
		alert(data);
	});
}

function update_sys_temp() {
	setTimeout(update_sys_temp,10000);
	$.get('command.php?action=get_sys_temp', function(data) {
		$('#sys_temp').html(data);
	});		
}

function update_cpu_load() {
	setTimeout(update_cpu_load,5000);
	$.get('/php/cpu_load.php', function(data) {
			var load = data.split(' ');
			
			$('#cpu_load_1').html(load[0]);
			$('#cpu_load_5').html(load[1]);
			$('#cpu_load_15').html(load[2]);
		});
}

function update_mem_usage() {
	setTimeout(update_mem_usage,5000);
	$.get('/php/memory.php', function(data) {
	var load = data.split('  ');
		
		$('#mem_usage_web').html(load[0]);
		$('#mem_usage_sys').html(load[1]);
		$('#mem_total_sys').html(load[2]);
		$('#mem_percent_sys').html(load[3]);
	});
}

function update_fire_temp() {
	setTimeout(update_fire_temp,5000);
	$.get('/php/fire_temp.php', function(data) {
	var load = data.split('  ');
		
		$('#fire_temp').html(load[0]);
		$('#fire_status').html(load[1]);
		$('#fire_time').html(load[2]);
	});
}

function update_DHT11() {
	setTimeout(update_DHT11,5000);
	$.get('/php/dht11.php', function(data) {
	var load = data.split('  ');
		
		$('#DHT11_temp').html(load[0]);
		$('#DHT11_humidity').html(load[1]);
		$('#fire_time').html(load[2]);
	});
}

function update_anti_thief() {
	setTimeout(update_anti_thief,5000);
	$.get('/php/thief.php', function(data) {
		if (data != '') $('#anti_thief').html('Báo lần cuối: '+data);
		else $('#anti_thief').html('Không có báo động !');
	});
}

function update_MQ2() {
	setTimeout(update_MQ2,5000);
	$.get('/php/gas.php', function(data) {
		var load = data.split('  ');
		
		$('#MQ2_status').html(load[0]);
		$('#MQ2_time').html(load[1]);
	});
}

function light(status) {
	$.get('/php/light.php?action='+status, function(data) {
		if (data != '') alert(data);
	});
}

function door(status) {
	$.get('/php/door.php?action='+status, function(data) {
		if (data != '') alert(data);
	});
}

function update_auto_cam_status(){
	$.get('camera.php?action=auto_cam_status', function(data) {
		if (data.length > 1) {
			$('#auto_camera_status').html(data);
			$('#stop_auto_cam_button').css({'display':'inline'});
		} else {
			$('#auto_camera_status').html('Không hoạt động !');
			$('#stop_auto_cam_button').css({'display':'none'});
		}
	});
}

function stop_auto_cam() {
	$.get('camera.php?action=stop_auto_cam', function(data) {
		alert(data);
		update_auto_cam_status();
		$('#stop_auto_cam_button').css({'display':'none'});
	});
}

function cam_capture() {
	$.get('camera.php?action=capture&type=manual', function(data) {
		alert(data);
	});
}

function cam_set() {
	var fps = $('#cam_fps').val();
	var res = $('#cam_res').val();
	$.get('camera.php?action=set&fps='+fps+'&res='+res, function(data) {
		alert(data);
		location.reload();
	});
}

function auto_camera() {
	var dur = $('#cam_duration').val();
	$.get('camera.php?action=capture&type=auto&duration='+dur);
	alert('Đã gửi lệnh !');
	update_auto_cam_status();
}

function login() {
	var u = $('#username').val();
	var p = $('#password').val();
	$.post('login.php?action=login', {username: u, password: p}, function(data) {
		if (data.length < 1) alert("Đăng nhập thất bại !\nVui lòng kiểm tra lại tên đăng nhập và mật khẩu.");
		else {
			alert("Đăng nhập thành công !");
			window.location.href='index.php';
		}
	});
}

/*function reload_camera(){
	$('#camera').click(function() {
		$(this).attr('src',$(this).attr('src'));
	});
});*/

function popup(w,h) {
	var left = (screen.width - w) / 2;
	var top = (screen.height - h) / 2;
	newwindow = window.open('contact.php', 'Contact Me', 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, copyhistory=no, width=670, height=490, top='+top+', left='+left);
}

function servo(id,deg) {
	$('#servo'+id).val(intval($('#servo'+id).val())+deg);
	if (intval($('#servo'+id).val()) <= 0) $('#servo'+id).val(0)
	else if (intval($('#servo'+id).val()) >= 180) $('#servo'+id).val(180)
	servoChange();
}
function servo_center(id,deg) {
	$('#servo1').val(90);
	$('#servo2').val(90);
	servoChange();
}
function servoChange(){
	$.get('camera.php?action=servo&s1='+$('#servo1').val()+'&s2='+$('#servo2').val());
}


function go(link) {
	window.location.href=link;
}	