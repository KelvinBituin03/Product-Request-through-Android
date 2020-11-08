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

$sql_query = "select * from tbl_store where status = 'Available'";
$result = mysqli_query($conn, $sql_query);

if(mysqli_num_rows($result) > 0){
	$response['success'] = 1;
	$branches = array();
	while ($row = mysqli_fetch_assoc($result)){
		
		array_push($branches, $row);
		
		
	}
	$response['Branches'] = $branches;
	
}
else{
	
	$response['success'] = 0;
	$response['message'] = 'No data';
	
	
}
echo json_encode($response);
mysqli_close($conn);





?>