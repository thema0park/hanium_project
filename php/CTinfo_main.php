<?php 
	$Device_number = $_POST['Device_number'];//컨테이너 정보로 모두 수정 요망.
    $CT_info_env_id = $_POST['CT_info_env_id'];
    $CT_info_manage_id = $_POST['CT_info_manage_id'];
	$CT_info_ie_id = $_POST['CT_info_ie_id'];
	$Unloding_ship = $_POST['Unloding_ship'];
	$Shiping_ship = $_POST['Shiping_ship'];
    $Unloding_port = $_POST['Unloding_port'];
    $Shiping_port = $_POST['Shiping_port'];
	$Destination = $_POST['Destination'];
	$Shiping_cancel = $_POST['Shiping_cancel'];
	echo $Device_number,$CT_info_env_id,$CT_info_manage_id,$CT_info_ie_id,$Unloding_ship,$Shiping_ship,$Unloding_port,$Shiping_port,$Destination,$Shiping_cancel;
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
	$sql_insert = "insert into Container_info(Container_number,CT_info_env_id,CT_info_manage_id,CT_info_ie_id,Unloding_ship,Shiping_ship,Unloding_port,Shiping_port,Destination,Shiping_cancel)
	values('$Device_number','$CT_info_env_id','$CT_info_manage_id','$CT_info_ie_id','$Unloding_ship','$Shiping_ship','$Unloding_port','$Shiping_port','$Destination','$Shiping_cancel')";
	$sql_update = "update Container_info Set CT_info_env_id='$CT_info_env_id',CT_info_manage_id='$CT_info_manage_id',CT_info_ie_id='$CT_info_ie_id',Unloding_ship='$Unloding_ship',Shiping_ship='$Shiping_ship',Unloding_port='$Unloding_port',Shiping_port='$Shiping_port',Destination='$Destination',Shiping_cancel='$Shiping_cancel' Where Container_number='$Device_number'";
	$rs = mysqli_query($connect,$sql_insert);
	while($rt === false){
		echo mysqli_error($connect);
	}
	$sql_delete = "delete From Container_info Where Container_number='0'";
	$rt = mysqli_query($connect,$sql_delete);
	while($rt === false){
		echo mysqli_error($connect);
	}
	$connect->close();
?>