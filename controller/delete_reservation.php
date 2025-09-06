<?php
require_once("../config/database.php");
session_start();

if (isset($_POST['id_reservation']) && isset($_SESSION['user_id'])) {
  $id_reservation = $_POST['id_reservation'];
  $id_user = $_SESSION['user_id'];

  $checkStmt = $cnx->prepare("SELECT * FROM RESERVATIONS WHERE id_user = ?");
  $checkStmt->execute([$id_user]);

  if ($checkStmt->rowCount() > 0) {
    $deleteStmt = $cnx->prepare("DELETE FROM RESERVATIONS WHERE id_reservation = ?");
    $deleteStmt->execute([$id_reservation]);
  }

  header("Location: ../pages/profile.php");
  exit();
}
?>