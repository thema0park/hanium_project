<?php  
$con = mysqli_connect("localhost", "VSS", "password", "db");
 
$query ="SELECT * FROM Device_info";
 
if(mysqli_connect_errno($con))
{ echo "MySQL 접속 실패:".mysqli_connect_error();}
mysqli_set_charset($con,"utf8");
$res = mysqli_query($con,$query);
$result = array();
while($row = mysqli_fetch_array($res))
{ array_push($result,array('Device_number'=>$row[0],'Check_data'=>$row[1],'Check_Reason'=>$row[2],'Total_Usingtime'=>$row[3],'Total_distance'=>$row[4]));}
echo json_encode(array("result"=>$result),JSON_UNESCAPED_UNICODE);
mysqli_close($con);
?>
