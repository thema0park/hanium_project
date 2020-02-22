<?php $conn = mysqli_connect("localhost", "VSS", "password", "db"); 
 
$query ="SELECT * FROM state_GPS_data WHERE 
str_to_date(time_t,'%Y-%m-%d %h:%i:%s') IN ( SELECT 
max(str_to_date(time_t,'%Y-%m-%d %h:%i:%s')) FROM state_GPS_data GROUP 
BY equip_number) ORDER BY equip_number";
 
 
if($result = mysqli_query($conn, $query)){
    $row_num = mysqli_num_rows($result);
    
    echo "{";
    
        echo "\"status\":\"OK\",";
        
        echo "\"rownum\":\"$row_num\",";
    
        echo "\"result\":";
        
            echo "[";
            
                for($i = 0; $i < $row_num; $i++){
                    $row = mysqli_fetch_array($result);
                    echo "{";
                    
		    echo "\"time\":\"$row[time_t]\", \"equip_number\":\"$row[equip_number]\", \"longitude\":\"$row[longitude]\", \"latitude\":\"$row[latitude]\"";
                    
                    echo "}";
                    if($i<$row_num-1){
                        echo ",";
                    }
                }
 
                        
                
            echo "]";
            
    echo "}";
}
else{
	echo "failed to get data from database.";
}
?>
