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

$sql_query = "(SELECT * 
 FROM (   Select '1' as ID, count(*)  as 'Critical_All' from (SELECT count(product_id)  from tbl_product where status_new = 'Critical Level' group by product_id order by count(product_id)) as DerivedTableAlias) AS A)
UNION

(SELECT * 
 FROM ( Select '2' as ID, count(*) as 'C_Branch' from (SELECT count(nurseryvan_db.tbl_store.store_id)  from nurseryvan_db.tbl_inventory inner join nurseryvan_db.tbl_store on nurseryvan_db.tbl_store.store_id = nurseryvan_db.tbl_inventory.store_id where nurseryvan_db.tbl_inventory.status_pending  = 'Not Available' group by nurseryvan_db.tbl_store.store_name order by count(nurseryvan_db.tbl_store.store_name)) as DerivedTableAlias) AS B)";
$result = mysqli_query($conn, $sql_query);


if(mysqli_num_rows($result) > 0){
	$response['success'] = 1;
	$branches = array();
	while ($row = mysqli_fetch_assoc($result)){
		
		array_push($branches, $row);
		
		
	}
	$response['CriticalBranches'] = $branches;
	
}
else{
	
	$response['success'] = 0;
	$response['message'] = 'No data';
	
	
}

echo json_encode($response);
mysqli_close($conn);





?>
