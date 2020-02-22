<?php 
	$CT_info_manage_id = $_POST['CT_info_manage_id'];
	$Number = $_POST['Number'];
	$Division = $_POST['Division'];
	$Company = $_POST['Company'];
	$Weight = $_POST['Weight'];
	$Owner = $_POST['Owner'];
	$Damaged = $_POST['Damaged'];
	$Placement_time = $_POST['Placement_time'];
	$Warning_info = $_POST['Warning_info'];
	$Free_day = $_POST['Free_day'];
	$Hold = $_POST['Hold'];
	echo $CT_info_manage_id,$Number,$Division,$Company,$Weight,$Owner,$Damaged,$Placement_time,$Warning_info,$Free_day,$Hold;
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
	$sql_insert = "insert into Container_info_management(CT_info_manage_id,Number,Division,Company,Weight,Owner,Damaged,Placement_time,Warning_info,Free_day,Hold) values('$CT_info_manage_id','$Number','$Division','$Company','$Weight','$Owner','$Damaged','$Placement_time','$Warning_info','$Free_day','$Hold')";
	$sql_update = "update Container_info_management Set Number='$Number',Division='$Division',Company='$Company',Weight='$Weight',Owner='$Owner',Damaged='$Damaged',Placement_time='$Placement_time',Warning_info='$Warning_info',Free_day='$Free_day',Hold='$Hold' Where CT_info_manage_id='$CT_info_manage_id'";
	$rs = mysqli_query($connect,$sql_update);
	while($rs === false){
		echo mysqli_error($connect);
	}
	$connect->close();
?>
