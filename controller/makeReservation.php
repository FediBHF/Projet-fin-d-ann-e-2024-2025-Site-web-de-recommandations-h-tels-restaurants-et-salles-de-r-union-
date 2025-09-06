<?php
require_once("../config/database.php");
session_start();

if(!isset($_SESSION['user_id'])){
  header('Location: ../pages/login.php');
  exit();
}

if(isset($_POST['id_establishment'], $_POST['guests'], $_POST['checkin'], $_POST['checkout'])){
  $id_establishment = $_POST['id_establishment'];
  $guests = $_POST['guests'];
  $checkin = $_POST['checkin'];
  $checkout = $_POST['checkout'];

  $stmt = $cnx->prepare("SELECT name, location, type, price FROM establishments WHERE id_establishment = ?");
  $stmt->execute([$id_establishment]);
  $infos = $stmt->fetch();

  if($infos){
      $name = $infos['name'];
      $location = $infos['location'];
      $price = $infos['price'];
      $user_id = $_SESSION['user_id'];

      $checkinDate = new DateTime($checkin);
      $checkoutDate = new DateTime($checkout);
      $duration = $checkinDate->diff($checkoutDate);
      $days = max(1, $duration->days);

      $total_price = $price * $days * $guests;
      if($guests <= 3){
        $total_price *= 0.90;
      }
      else if($guests <= 6){
        $total_price *= 0.80;
      } 
      else{
        $total_price *= 0.70;
      }

      $stmt2 = $cnx->prepare("INSERT INTO reservations (id_establishment, id_user, checkin, checkout, nb_clients, total_price) VALUES (?, ?, ?, ?, ?, ?)");
      $stmt2->execute([$id_establishment, $user_id, $checkin, $checkout, $guests, $total_price]);

      header("Location: ../pages/Hotels.php");
      exit();
    } ;
  }
?>