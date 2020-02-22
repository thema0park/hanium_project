<?php 
	$equipData=$_POST['equipData'];
    $checkdata=$_POST['checkdata'];
    $checkreason=$_POST['checkreason'];
	$totalusingtime=$_POST['Totaluingtime'];
	$totaldistance=$_POST['Totaldistance'];
	echo $equipData,$checkdata,$checkreason,$totalusingtime,$totaldistance;
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
	$sql_insert = "insert into Device_info(Device_number,Check_data,Check_Reason,Total_Usingtime,Total_distance)values('$equipData','$checkdata','$checkreason','$totalusingtime','$totaldistance')";
	$sql_update = "update Device_info Set Check_data='$checkdata',Check_Reason='$checkreason',Total_Usingtime='$totalusingtime',Total_distance='$totaldistance' Where Device_number='$equipData'";
	$rs = mysqli_query($connect,$sql_insert);
	while($rs === false){
		echo mysqli_error($connect);
	}
	$sql_delete = "DELETE From Device_info WHERE Device_number='0'";
	$rt = mysqli_query($connect,$sql_delete);
	while($rt === false){
		echo mysqli_error($connect);
	}
	$connect->close();
?>