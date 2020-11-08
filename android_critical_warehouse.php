<?php

$host = 'localhost';
$user = 'root';
$pwd = '1234';
$db = 'nurseryvan_db';

$conn = mysqli_connect($host, $user, $pwd, $db);

if(!$conn){
	die("Error in connection: ".mysqli_connect_error());
	
	
	
}
$response = array();

$sql_query = "Select * from tbl_product where stock <= critical and stock != 0;";
$result = mysqli_query($conn, $sql_query);

if(mysqli_num_rows($result) > 0){
	$response['success'] = 1;
	$warehouse = array();
	while ($row = mysqli_fetch_assoc($result)){
		
		array_push($warehouse, $row);
		
		
	}
	$response['CriticalWarehouse'] = $warehouse;
	
}
else{
	
	$response['success'] = 0;
	$response['message'] = 'No data';
	
	
}
echo json_encode($response);
mysqli_close($conn);





?>
