<!DOCTYPE html> 
<html>

<title>장비 상세 정보 업데이트</title>
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
<body style = "float:center; padding:10px;">
<h1>장비 번호를 확인하고 넣어주세요! </h1>
<table>
      	<thead>
        	<tr>
          	<th>Device_number</th>
          	<th>Check_data</th>
          	<th>Check_Reason</th>
          	<th>Total_Usingtime</th>
          	<th>Total_distance</th>
        	</tr>
      	</thead>
<tbody>
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
                echo '<tr><td>' .$row['Device_number'].'</td><td>' .$row['Check_data'].'</td><td>' .$row['Check_Reason'].'</td><td>' .$row['Total_Usingtime'].'</td><td>' .$row['Total_distance'].'</td></tr>';
        }
        mysqli_close($con);
        ?>
</tbody>
</table>
<center>
<fieldset style = "float:center; padding:10px; width:50%;">
	<legend>장비 정보 업데이트</legend>
	<form method = "post" action = "http://119.67.32.123:8840/hanium/main_update.php">
				장비   번호:</br><input type="text" name="equipData" style = "width:300;"></br>
				점검   원인:</br><input type="text" name="checkdata" style = "width:300;"></br>
				점검   이유:</br><input type="text" name="checkreason" style = "width:300;"></br>
				총 사용 시간:</br><input type="text" name="Totaluingtime" style = "width:300;"></br>
				총 이동 거리:</br><input type="text" name="Totaldistance" style = "width:300;"></br>
				<input type="submit" value="Update">
				</br>
		</fieldset>
</center>
	</form>
</body>
</html>
