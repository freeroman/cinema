<?php

try{
  $db = new PDO('mysql:host=localhost;dbname=cinema','root','');
  
  $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
  echo "Nelze se pripojit k db ".$e->getMessage();
  exit; // die
}


$stmt = $db->query("UPDATE bookings SET id_booking_states=3 WHERE created_dt <= (NOW() - INTERVAL 5 MINUTE) AND (id_booking_states=2)");
$stmt->execute();