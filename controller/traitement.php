<?php

function addUser($cnx, $data) {
  $username = $data['username'];
  $email = $data['email'];
  $tel = $data['tel'];
  $password = $data['password'];
  $sexe = $data['sexe'];

  $stmt1 = $cnx->prepare("SELECT * FROM users WHERE email = ?");
  $stmt1->execute([$email]);
  if ($stmt1->rowCount() != 0) {
    return "email_exists";
  }

  $stmt2 = $cnx->prepare("SELECT * FROM users WHERE phone = ?");
  $stmt2->execute([$tel]);
  if ($stmt2->rowCount() != 0) {
    return "tel_exists";
  }

  $mdpHash = password_hash($password, PASSWORD_DEFAULT);
  $stmt3 = $cnx->prepare("INSERT INTO users (username, email, phone, sexe, password) VALUES (?, ?, ?, ?, ?)");
  if ($stmt3->execute([$username, $email, $tel, $sexe, $mdpHash])) {
    return "success";
  } else {
    return "error";
  }
}

function login($cnx, $data) {
  $email = $data['email'];
  $password = $data['password'];

  $stmt = $cnx->prepare("SELECT id, email, password FROM users WHERE email = ?");
  $stmt->execute([$email]);

  if ($stmt->rowCount() == 0) {
    return "email_not_found";
  } else {
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!password_verify($password, $row['password'])) {
      return "invalid_password";
    } else {
      session_start();
      $_SESSION['user_id'] = $row['id'];
      header("Location: Accueil.php");
      exit();
    }
  }
}

function getUserData($cnx, $user_id) {
  $stmt = $cnx->prepare("SELECT * FROM users WHERE id = ?");
  $stmt->execute([$user_id]);
  return $stmt->fetch(PDO::FETCH_ASSOC);
}

function send_feedback($cnx, $data) {
  $name = $data['name'];
  $email = $data['email'];
  $message = $data['message'];

  $stmt = $cnx->prepare("INSERT INTO contacts (name, email, message) VALUES (?, ?, ?)");
  if ($stmt->execute([$name, $email, $message])) {
    return "message_sent";
  } else {
    return "message_error";
  }
}

function updateProfile($cnx, $data) {
  $user_id = $_SESSION['user_id'];

  $req = "SELECT password FROM users WHERE id = " . (int)$user_id;
  $result = $cnx->query($req);
  $user = $result->fetchAll();
  
  if (!password_verify($data['current_password'], $user[0][0])) {
      return ['success' => false, 'message' => 'Incorrect password.'];
  }

  $req = "SELECT username, email, phone FROM users WHERE id = " . (int)$user_id;
  $result = $cnx->query($req);
  $current_data = $result->fetchAll();

  $name = !empty($data['name']) ? $data['name'] : $current_data[0]['name'];
  $email = !empty($data['email']) ? $data['email'] : $current_data[0]['email'];
  $phone = !empty($data['phone']) ? $data['phone'] : $current_data[0]['phone'];

  if (!empty($data['new_password'])) {
      $new_password = password_hash($data['new_password'], PASSWORD_DEFAULT);
      $req = "UPDATE users SET username = '$name', email = '$email', phone = '$phone', password = '$new_password' WHERE id = " . (int)$user_id;
  } else {
      $req = "UPDATE users SET username = '$name', email = '$email', phone = '$phone' WHERE id = " . (int)$user_id;
  }

  if ($cnx->query($req)) {
      return ['success' => true, 'message' => 'Profile updated successfully!'];
  } else {
      return ['success' => false, 'message' => 'Error updating profile: ' . $cnx->error];
  }
}


function admininfo($cnx, $name) {
  $req = "SELECT * FROM admin WHERE name = '$name'";
  $res = $cnx->query($req);
  if ($res) {
    return $res->fetch(PDO::FETCH_ASSOC);
  } else {
    return null;
  }
}
function deletereservation($cnx, $id) {
  $req1 = "SELECT * from reservations where id_reservation='$id'";
  $res = $cnx->query($req1);
  
  if ($res->rowCount() == 0) {
    return "error";
  }

  $req2 = "DELETE from reservations where id_reservation='$id'";
  $cnx->query($req2);
  return "marche";
}
function getmessages($cnx){
  $req = "SELECT * FROM contacts";
  $res = $cnx->query($req);
  if($res){
    $user_infos = $res->fetchAll(PDO::FETCH_ASSOC);
  }
  return $user_infos ?? [];
}
function getmessage($cnx, $name) {
  $req = "SELECT * FROM contacts WHERE name = '$name'";
  $res = $cnx->query($req);

  if ($res !== false) {
      return $res->fetchAll(PDO::FETCH_ASSOC);
  }

  return [];
}

function deletemessage($cnx, $name) {
  $req1 = "SELECT * from contacts where name='$name'";
  $res = $cnx->query($req1);
  
  if ($res->rowCount() == 0) {
    return "error";
  }

  $req2 = "DELETE from contacts where name='$name'";
  $cnx->query($req2);
  return "marche";
}

function loginadmin($cnx, $data) {
  $name = $data['name'];
  $password = $data['password'];

  $req1 = $cnx->prepare("SELECT * FROM admin WHERE name = :name AND password = :password");
  $req1->bindParam(':name', $name);
  $req1->bindParam(':password', $password);
  $req1->execute();

  if ($req1->rowCount() == 0) {
    return "error";
  } else {
    $row = $req1->fetch(PDO::FETCH_ASSOC);
    session_start();
    $_SESSION["name"] = $row['name'];
    return "success";
  }
}

function deleteaccount($cnx, $id) {
  $req1 = "SELECT * from users where ID='$id'";
  $res = $cnx->query($req1);
  
  if ($res->rowCount() == 0) {
    return "error";
  }

  $req2 = "DELETE from users where ID='$id'";
  $cnx->query($req2);
  return "marche";
}

?>