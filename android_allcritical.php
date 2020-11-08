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

$sql_query = "SELECT * 
 FROM ( SELECT '1' as ID,  nurseryvan_db.tbl_inventory.status_pending as 'Status', nurseryvan_db.tbl_product.status_new as 'Status1', '0' as cSupplier from nurseryvan_db.tbl_inventory inner join nurseryvan_db.tbl_product on nurseryvan_db.tbl_inventory.product_id = nurseryvan_db.tbl_product.product_id) AS A
UNION ALL

(SELECT * 
 FROM ( Select '2' as ID, '' as 'a', '' as 'b', count(*)  as cSupplier from (SELECT count(order_id)  from tbl_order where status = 'Ordered' group by order_id order by count(order_id)) AS B) as derivedTbleAlias)";



//$sql_query = "SELECT nurseryvan_db.tbl_inventory.product_id as 'Product ID', nurseryvan_db.tbl_product.product_name as 'Product Name', QTY, nurseryvan_db.tbl_product.remarks as 'SRP', nurseryvan_db.tbl_inventory.status_pending as 'Status', nurseryvan_db.tbl_product.status_new as 'Status1' from nurseryvan_db.tbl_inventory inner join nurseryvan_db.tbl_product on nurseryvan_db.tbl_inventory.product_id = nurseryvan_db.tbl_product.product_id;";
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
