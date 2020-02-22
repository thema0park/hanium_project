<?php 
	$CT_info_ie_id = $_POST['CT_info_ie_id'];//컨테이너 정보로 모두 수정 요망.
	$Import_car = $_POST['Import_car'];
	$Export_car = $_POST['Export_car'];
	$Import_time = $_POST['Import_time'];
	$Export_time = $_POST['Export_time'];
	$Import_route = $_POST['Import_route'];
	$Export_route = $_POST['Export_route'];
	echo $CT_info_ie_id,$Import_car,$Export_car,$Import_time,$Export_time,$Import_route,$Export_route;
	$host = '119.67.32.123';
	$user = 'VSS';
	$pw = 'password';
	$dbName = 'db';
	$mysql_port= '3306';
	$connect = mysqli_connect($host,$user,$pw,$dbName);
	if(mysqli_connect_error()){
		die('Connect Error: '.mysqli_connect_error());
	}
	mysqli_select_db($connect,$dbName) or die('DB 선택 실패');
	$sql_insert = "insert into Container_info_ie(CT_info_ie_id,Import_car,Export_car,Import_time,Export_time,Import_route,Export_route) values('$CT_info_ie_id','$Import_car','$Export_car','$Import_time','$Export_time','$Import_route','$Export_route')";
	$sql_update = "update Container_info_ie Set Import_car='$Import_car',Export_car='$Export_car',Import_time='$Import_time',Export_time='$Export_time',Import_route='$Import_route',Export_route='$Export_route' Where CT_info_ie_id='$CT_info_ie_id'";
	$rs = mysqli_query($connect,$sql_update);
	while($rs === false){
		echo mysqli_error($connect);
	}
	$connect->close();
?>
