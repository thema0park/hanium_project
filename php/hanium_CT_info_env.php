<?php $conn = mysqli_connect("localhost", "VSS", "password", "db"); 
 
//$query ="SELECT * FROM Container_info_env WHERE 
//str_to_date(time_t,'%Y-%m-%d %h:%i:%s') IN ( SELECT 
//max(str_to_date(time_t,'%Y-%m-%d %h:%i:%s')) FROM Container_info_env GROUP 
//BY CT_info_env_id) ORDER BY CT_info_env_id";

$query ="SELECT * FROM Container_info_env WHERE time_t IN (SELECT MAX(time_t) FROM Container_info_env GROUP BY CT_info_env_id) ORDER BY CT_info_env_id";



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
                    
                    echo "\"time\":\"$row[time_t]\", \"CT_into_env_id\":\"$row[CT_info_env_id]\", \"Temperature\":\"$row[Temperature]\", \"Humidity\":\"$row[Humidity]\"\"Door\":\"$row[Door]\",\"Cooling\":\"row[Cooling]\"";
                    
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
