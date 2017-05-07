<!-- BEGIN: main -->{FILE "template/header.tpl"}

<body>
<!--<div id="banner">
	<a href="index.php#"><img src="template/image/banner.png" alt="banner"/></a>
</div>-->

{FILE "template/dialog.tpl"}
<div class="wrapper center">
	<h2>Bảng điều khiển Ngôi nhà thông minh</h3>
	<br />
</div>

<br />
<div class="wrapper">
	<div style="float: left; width: 510px;">
		<div class="header">Tình trạng hệ thống</div>

		<table class="table">
			<tr>
				<td style="width: 150px;"><b>Cảm biến</b></td>
				<td style="width: 320px;">
					Nhiệt độ: <span id="DHT11_temp"></span> &deg;C<br />
					Độ ẩm: <span id="DHT11_humidity"></span>%<br /><br />
					Khí gas: <span id="MQ2_status"></span><br />
					Báo lần cuối: <span id="MQ2_time"></span>
					<hr />
					Nhiệt độ máy chủ: <span id="sys_temp"></span> &deg;C
				</td>
			</tr>
			<tr>
				<td><b>Hỏa hoạn</b></td>
				<td>
					Nhiệt độ: <span id="fire_temp"></span> &deg;C -> <span id="fire_status"></span><br />Cập nhật: <span id="fire_time"></span>
				</td>
			</tr>
			<!--<tr>
				<td><b>Giếng trời</b></td>
				<td>
					Trạng thái: {hole_status} Đang mở
				</td>
			</tr>-->
			<tr>
				<td><b>Báo trộm</b></td>
				<td>
					<span id="anti_thief"></span>
				</td>
			</tr>
			<tr>
				<td><b>Ánh sáng:</b></td>
				<td>
					<button onclick="light('ON')">Bật đèn</button><!-- | <button onclick="light('OFF')">Tắt đèn</button>-->
				</td>
			</tr>
			<tr>
				<td><b>Quản lí ra vào</b></td>
				<td>
					<button onclick="door('CLOSE')">Đóng cửa</button> | <button onclick="door('OPEN')">Mở cửa</button>
				</td>
			</tr>
			<tr>
				<td><b>CPU sử dụng</b></td>
				<td>
					Phút trước: <span id="cpu_load_1"></span> %<br />
					5 phút trước: <span id="cpu_load_5"></span> %<br />
					15 phút trước: <span id="cpu_load_15"></span> %
				</td>
			</tr>
			<tr>
				<td><b>Bộ nhớ (RAM)</b></td>
				<td>
					Web server: <span id="mem_usage_web"></span><br />
					Hệ thống: <span id="mem_usage_sys"></span> / <span id="mem_total_sys"></span> (<span id="mem_percent_sys"></span>)
				</td>
			</tr>
		</table>

		<br /><br />
		<div class="header">Điều khiển máy chủ</div>
		<table class="table">
			<tr>
				<td style="width: 150px;"><b>Chạy lệnh:</b></td>
				<td style="width: 320px;">
					Nhập lệnh: <input id="server_command" type="text" style="width: 230px"/><br />
					<div class="center"><button onclick="server_command('')">Chạy lệnh</button>      <button onclick="clear_contents('#server_command')">Nhập lại</button></div>
				</td>
			</tr>
			<tr>
				<td style="width: 150px;"><b>Quản lý lệnh</b></td>
				<td style="width: 320px;">
					Lệnh dựng sẵn: <button onclick="server_command(2)">Khởi động lại</button> | <button onclick="server_command(1)">Tắt máy</button><br /><br />
					<b>Thêm lệnh:<b/>
					<table class="no_table">
						<tr>
							<td>Tên lệnh:</td>
							<td><input type="text" id="add_command_n" style="width: 100%"/></td>
						</tr>
						<tr>
							<td>Nội dung:</td>
							<td><input type="text" id="add_command_c" style="width: 100%"/></td>
						</tr>
					</table>
					<div class="center"><button onclick="add_command()">Gửi</button>      <button onclick="clear_contents('#add_command_c'); clear_contents('#add_command_n');">Nhập lại</button></div>
					<br />
					<b>Danh sách lệnh thêm vào:</b><br />
					<!-- BEGIN: defined_command -->
					<button onclick="server_command({command_id})">{command_name}</button>
					<!-- END: defined_command -->
				</td>
			</tr>
			<tr>
				<td><b>Cơ sở dữ liệu</b></td>
				<td>
					MySQLite: <button onclick="go('/database')">Đăng nhập</button><br />
					Kích thước cơ sở dữ liệu: {db_size}
				</td>
			</tr>
		</table>
	</div>

	<div style="float: right; width: 430px; margin: auto;">
		<div class="header">Camera</div>
		<table class="table" style="width: 400px">
			<tr>
				<td colspan="2">
					<div class="center">
						<img id="camera" src="http://{host}:4/?action=stream" style="width: 320px; height: 240px;"/>
						<!--<img id="camera" src="http://{host}:4/?action=snapshot" style="width: 320px; height: 240px;"/>
						<br />
						<i>Bấm vào ảnh để tải lại ảnh</i>-->
					</div>
				</td>
			</tr>
				<td><b>Điều khiển:</b></td>
				<td>
				<input type='hidden' id="servo1" value="90">
				<input type='hidden' id="servo2" value="90">
					<table class="table center">
						<tr>
							<td style="width: 80px;"><button onclick="cam_capture()">Chụp ảnh</button></td>
							<td style="width: 80px;"><button class="direction" onclick="servo(1,-10)">Lên</button></td>
							<td style="width: 80px;"></td>
						</tr>
						<tr>
							<td><button class="direction" onclick="servo(2,-10)">Phải</button></td>
							<td><button class="direction" onclick="servo_center()">Giữa</button></td>
							<td><button class="direction" onclick="servo(2,10)">Trái</button></td>
						</tr>
						<tr>
							<td></td>
							<td><button class="direction" onclick="servo(1,10)">Xuống</button></td>
							<td></td>
						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td><b>Cài đặt:</b></td>
				<td>
					<table class="no_table">
						<tr>
							<td><b>Độ phân giải camera:</b></td>
							<td>
								<select id="cam_res">
									<option value="160x120" selected>Tối thiểu: 160x120</option>
									<option value="320x240">Trung bình: 320x240</option>
									<option value="640x480">Chuẩn: 640x480</option>
									<option value="1080x720">Tối đa: 1080x720</option>
								</select>
							</td>
						<tr>
							<td><b>Khung hình/giây:</b></td>
							<td>
								<select id="cam_fps" style="width: 100%">
									<option value="5" selected>Tối thiểu: 5</option>
									<option value="10">Trung bình: 10</option>
									<option value="20">Chuẩn: 20</option>
									<option value="30">Tối đa: 30</option>
								</select>
							</td>
						</tr>
					</table>
					<div class="center"><button onclick="cam_set()">Đặt lại camera</button></div>
					<br />
					<b>Tự động chụp ảnh:</b>
					<br />
					Chụp ảnh sau mỗi:
					<select id="cam_duration">
						<option value="5">5 giây</option>
						<option value="20">20 giây</option>
						<option value="60" selected>1 phút</option>
						<option value="300">5 phút</option>
						<option value="1200">20 phút</option>
						<option value="3600">1 giờ</option>
						<option value="18000">5 giờ</option>
						<option value="43200">12 giờ</option>
						<option value="86400">24 giờ</option>
					</select>
					<button onclick="auto_camera()">Chụp</button><br />
					Trạng thái: <span id="auto_camera_status"></span>
					<span id="stop_auto_cam_button" style="display: none"><button onclick="stop_auto_cam()">Dừng</button></span>
				</td>
			</tr>
			<tr>
				<td><b>Quản lí ảnh:</b></td>
				<td><button onclick="go('/pictures')">Đăng nhập</button></td>
			</tr>
		</table>
	</div>
	<div class="clear"></div>
	<br /><br />
</div>

<div class="center">
	<div id="footer">
		Dự án Ngôi nhà thông minh - SmartHome<br />
		Tác giả: <a href="mailto:quocbao747@gmail.com">Nguyễn Quốc Bảo</a> - Đoàn Phú Yên.
	</div>

	<div class="center">
		Bây giờ là: {current_date}<br />
		Thời gian xử lí: <b>{sec}</b> giây
	</div>
</div>

</body>
</html><!-- END: main -->