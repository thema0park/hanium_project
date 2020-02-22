<?php $conn = mysqli_connect("localhost", "VSS", "password", "db"); 
 
$query ="SELECT * FROM state_CTgps_data WHERE 
time_t IN ( SELECT 
max(time_t) FROM state_CTgps_data GROUP 
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
