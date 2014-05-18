<?php

try{
  $db = new PDO('mysql:host=localhost;dbname=cinema','root','');
  
  $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
  echo "Nelze se pripojit k db ".$e->getMessage();
  exit; // die
}


if(!empty($_GET['seats']) && !empty($_GET['id']) && !empty($_GET['state']))
{
	$arr = json_decode($_GET['seats']);
	
	$stmt = $db->prepare("UPDATE bookings SET id_booking_states=:state, code=:code, created_dt=NOW() WHERE seat=:seat AND id_performances=:id");
	$stmt->bindValue(':id', $_GET['id']);
	$stmt->bindValue(':state', $_GET['state']);
	$code = uniqid();
	$stmt->bindValue(':code', $code);
	
	foreach($arr as $seat)
	{
		$stmt->bindValue(':seat', $seat);	
		$stmt->execute();
	}
	echo json_encode($code);	
} 
elseif(!empty($_GET['seat']) && !empty($_GET['id']) && !empty($_GET['state']))
{
	$stmt = $db->prepare("UPDATE bookings SET id_booking_states=:state, created_dt=NOW() WHERE seat=:seat AND id_performances=:id");
	
	$stmt->bindValue(':seat', $_GET['seat']);
	$stmt->bindValue(':id', $_GET['id']);
	$stmt->bindValue(':state', $_GET['state']);
	$stmt->execute();

} else {
	$stmt = $db->prepare("SELECT * FROM bookings WHERE seat=:seat AND id_performances=:id AND (id_booking_states=1 OR id_booking_states=2)");

	$stmt->bindValue(':seat', $_GET['seat']);
	$stmt->bindValue(':id', $_GET['id']);
	$stmt->execute();

	if($stmt->fetch()){
		echo json_encode(false);
	} else {
		echo json_encode(true);
	}
}