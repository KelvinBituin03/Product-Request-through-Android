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

$sql_query = "SELECT nurseryvan_db.tbl_order.order_id as 'Order ID', nurseryvan_db.tbl_product.product_name as 'Product', nurseryvan_db.tbl_order.status as 'Status', nurseryvan_db.tbl_order.total_due as 'Total Due', nurseryvan_db.tbl_order.quantity as 'Ordered QTY', nurseryvan_db.tbl_order.quantity_receive as 'QTY Received', nurseryvan_db.tbl_order.damage_product as 'Damaged Product', nurseryvan_db.tbl_supplierinfo.company as 'Supplier Name' ,nurseryvan_db.tbl_order.date_ordered as 'Date Ordered', nurseryvan_db.tbl_order.date_expected as 'Date Expected' FROM nurseryvan_db.tbl_order inner join nurseryvan_db.tbl_product on nurseryvan_db.tbl_order.product_id = nurseryvan_db.tbl_product.product_id inner join nurseryvan_db.tbl_supplierinfo on nurseryvan_db.tbl_order.supplier_id = nurseryvan_db.tbl_supplierinfo.supplier_id  where nurseryvan_db.tbl_order.status != 'Stocked' and nurseryvan_db.tbl_order.status != 'Cancelled order' and nurseryvan_db.tbl_order.status = 'Ordered' order by nurseryvan_db.tbl_order.order_id desc;";
$result = mysqli_query($conn, $sql_query);


if(mysqli_num_rows($result) > 0){
	$response['success'] = 1;
	$Supplier = array();
	while ($row = mysqli_fetch_assoc($result)){
		
		array_push($Supplier, $row);
		
		
	}
	$response['Suppliers'] = $Supplier;
	
}
else{
	
	$response['success'] = 0;
	$response['message'] = 'No data';
	
	
}

echo json_encode($response);
mysqli_close($conn);





?>
