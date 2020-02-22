<!DOCTYPE html> 
<html>
<title>컨테이너 상세 정보 업데이트</title>
<style type="text/css">
	ul {
		list-style-type: none;
		margin: 0;
		padding: 0;
		background-color: #333;
	}
	ul:after{
		content:'';
		display: block;
		clear:both;
	}
	li {
		float: left;
	}
	li a {
		display: block;
		color: white;
		text-align: center;
		padding: 14px 16px;
		text-decoration: none;
	}
	li a:hover:not(.active) {
		background-color: #111;
	}
	.active {
		background-color: #4CAF50;
	}
</style>
<style>
	body {
		font-family: Consolas, monospace;
        	font-family: 12px;
	}
      	table {
	        width: 100%;
      	}
      	th, td {
        	padding: 10px;
        	border-bottom: 1px solid #dadada;
      	}
</style>
<body style="float:center; padding:10px;">
<h1>반드시 장비번호와 ID를 확인하고 입력해주세요!</h1>
<table>
        <thead>
                <tr>
                        <th>장비 번호</th>
                        <th>컨테이너 환경정보 ID</th>
                        <th>컨테이너 관리정보 ID</th>
                        <th>컨테이너 반출입 정보 ID</th>
                        <th>양하 모선</th>
                        <th>선적 모선</th>
                        <th>선적항 </th>
                        <th>양하항 </th>
                        <th>목적지 </th>
                        <th>선적 취소 유무</th>
                </tr>
        </thead>
        <tbody>
<?php
        $con = mysqli_connect("localhost", "VSS", "password", "db");
        $query ="SELECT * FROM Container_info";
        if(mysqli_connect_errno($con))
        {
                echo "MySQL 접속 실패:".mysqli_connect_error();
        }
        mysqli_set_charset($con,"utf8");
        $res = mysqli_query($con,$query);
        $result = array();
        while($row = mysqli_fetch_array($res))
        {
                echo '<tr><td>' .$row['Container_number'] .'</td><td>'. $row['CT_info_env_id'] .'</td><td>'. $row['CT_info_manage_id'] .'</td><td>'. $row['CT_info_ie_id'] .'</td><td>'. $row['Unloding_ship'] .'</td><td>'. $row['Shiping_ship'] .'</td><td>'. $row['Unloding_port'] .'</td><td>'. $row['Shiping_port'] .'</td><td>'. $row['Destination'] .'</td><td>'. $row['Shiping_Cancel'] . '</td></tr>';
        }
        mysqli_close($con);
        ?>
</tbody>
</table>
<center>
<fieldset style="float:center; width:50%;">
	<legend>컨테이너 정보 업데이트</legend>
		<form method = "post" action = "http://119.67.32.123:8840/hanium/CTinfo_main_update.php">
			장비   번호:</br><input type="text" name="Device_number" style = "width:300;"></br>
			컨테이너 환경정보 ID:</br><input type="text" name="CT_info_env_id" style = "width:300;"></br>
			컨테이너 관리정보 ID:</br><input type="text" name="CT_info_manage_id" style = "width:300;"></br>
			컨테이너 반출입정보 ID:</br><input type="text" name="CT_info_ie_id" style = "width:300;"></br>
			양하   모선:</br><input type="text" name="Unloding_ship" style = "width:300;"></br>
			선적   모선:</br><input type="text" name="Shiping_ship" style = "width:300;"></br>
			선적항:</br><input type="text" name="Unloding_port" style = "width:300;"></br>
			양하항:</br><input type="text" name="Shiping_port" style = "width:300;"></br>
			목적지:</br><input type="text" name="Destination" style = "width:300;"></br>
			선적 취소 유무:</br><input type="text" name="Shiping_cancel" style = "width:300;"></br>
			<input type="submit" value="Update">
		</form>
</fieldset>
</center>
<table>
        <thead>
                <tr>
                        <th>컨테이너 관리정보 ID</th>
                        <th>번호</th>
                        <th>구역</th>
                        <th>회사</th>
                        <th>무게</th>
                        <th>소유주</th>
                        <th>데미지</th>
                        <th>정착 시간</th>
                        <th>위험 정보</th>
                        <th>Free Day</th>
                        <th>Hold</th>
                </tr>
        </thead>
        <tbody>
        <?php
        $con = mysqli_connect("localhost", "VSS", "password", "db");
        $query ="SELECT * FROM Container_info_management";
        if(mysqli_connect_errno($con))
        {
                echo "MySQL 접속 실패:".mysqli_connect_error();
        }
        mysqli_set_charset($con,"utf8");
        $res = mysqli_query($con,$query);
        $result = array();
        while($row = mysqli_fetch_array($res))
        {
                echo '<tr><td>' .$row['CT_info_manage_id'] .'</td><td>'. $row['Number']
                .'</td><td>'. $row['Division'] .'</td><td>'. $row['Company']
                .'</td><td>'. $row['Weight'] .'</td><td>'. $row['Owner']
                .'</td><td>'. $row['Damaged'] .'</td><td>'. $row['Placement_time'] .'</td><td>'. $row['Warning_info']
                .'</td><td>'. $row['Free_day'] .'</td><td>'. $row['Hold'] .'</td></tr>';
        }
        mysqli_close($con);
        ?>
        </tbody>
</table>
<center>
<fieldset style="float:center; width:50%;">
	<legend>컨테이너 관리 정보 업데이트</legend>
		<form method = "post" action = "http://119.67.32.123:8840/hanium/CTinfomanage_main_update.php" >
			컨테이너 관리정보 ID:</br><input type="text" name="CT_info_manage_id" style = "width:300;"></br>
			번호:</br><input type="text" name="Number" style = "width:300;"></br>
			구역:</br><input type="text" name="Division" style = "width:300;"></br>
			회사:</br><input type="text" name="Company" style = "width:300;"></br>
			무게:</br><input type="text" name="Weight" style = "width:300;"></br>
			소유주:</br><input type="text" name="Owner" style = "width:300;"></br>
			데미지:</br><input type="text" name="Damaged" style = "width:300;"></br>
			정착 시간:</br><input type="text" name="Placement_time" style = "width:300;"></br>
			위험 정보:</br><input type="text" name="Warning_info" style = "width:300;"></br>
			Free Day:</br><input type="text" name="Free_day" style = "width:300;"></br>
			Hold:</br><input type="text" name="Hold" style = "width:300;"></br>
			<input type="submit" value="Update">
		</form>
</fieldset>
</center>
<table>
        <thead>
                <tr>
                        <th>컨테이너 반입정보 ID</th>
                        <th>반입 차량</th>
                        <th>반출 차량</th>
                        <th>반입 시간</th>
                        <th>반출 시간</th>
                        <th>반입 루트</th>
                        <th>반출 루트</th>
                </tr>
         </thead>
        <tbody>
        <?php
        $con = mysqli_connect("localhost", "VSS", "password", "db");
        $query ="SELECT * FROM Container_info_ie";
        if(mysqli_connect_errno($con))
        {
                echo "MySQL 접속 실패:".mysqli_connect_error();
        }
        mysqli_set_charset($con,"utf8");
        $res = mysqli_query($con,$query);
        $result = array();
        while($row = mysqli_fetch_array($res))
        {
                echo '<tr><td>'. $row['CT_info_ie_id'] .'</td><td>'. $row['Import_car']
                .'</td><td>'. $row['Export_car'] .'</td><td>'. $row['Import_time']
                .'</td><td>'. $row['Export_time'] .'</td><td>'. $row['Import_route']
                .'</td><td>'. $row['Export_route'] .'</td></tr>';
        }
        mysqli_close($con);
        ?>
        </tbody>
</table>
<center>
<fieldset style="float:center; width:50%;">
	<legend>컨테이너 반입 정보 업데이트</legend>
		<form method = "post" action = "http://119.67.32.123:8840/hanium/CTinfoie_main_update.php">
			컨테이너 반입정보 ID:</br><input type="text" name="CT_info_ie_id" style = "width:300;"></br>
			반입 차량:</br><input type="text" name="Import_car" style = "width:300;"></br>
			반출 차량:</br><input type="text" name="Export_car" style = "width:300;"></br>
			반입 시간:</br><input type="text" name="Import_time" style = "width:300;"></br>
			반출 시간:</br><input type="text" name="Export_time" style = "width:300;"></br>
			반입 루트:</br><input type="text" name="Import_route" style = "width:300;"></br>
			반출 루트:</br><input type="text" name="Export_route" style = "width:300;"></br>
			<input type="submit" value="Update">
		</form>
</fieldset>
</center>
</body>
</html>
