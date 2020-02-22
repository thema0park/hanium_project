<?php 
	$con = mysqli_connect("localhost", "VSS", "password", "db");
	$query ="SELECT * FROM Device_info";
	if(mysqli_connect_errno($con))
	{
		echo "MySQL 접속 실패:".mysqli_connect_error();
	}
	mysqli_set_charset($con,"utf8");
	$res = mysqli_query($con,$query);
	$result = array();
	while($row = mysqli_fetch_array($res))
	{
		echo '<tr><td>' .$row['Device_number'].$row['Check_data'].$row['Check_Reason'].$row['Total_Usingtime'].$row['Total_distance'].'</td></tr>';
	}
	mysqli_close($con);
?>

