<!DOCTYPE html>
<html lang="en">
<head>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <link rel="shortcut icon" href="icon.ico" type="image/x-icon">
  <link rel="stylesheet" href="../styles/style.css">
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>GoBookIt - Log In</title>
</head>
<body>

<?php
  require_once("../config/database.php");
  require_once("../controller/traitement.php");

  $result = null;

  if (isset($_POST['name'], $_POST['password'])) {
    $data = [
      'name'    => $_POST['name'],
      'password' => $_POST['password']
    ];

    $result = loginadmin($cnx, $data);
 
    if ($result === "success") {
      header("Location: admin.php");
      exit();
    }
  }
?>


<div class="container">
  <div class="title">
    <center><h1>Log-in</h1></center>
    <center><p>Entrer vos données personnelles, nous allons les protéger !</p></center>
  </div>

  <form method="post">
    <div class="input">
      <input type="text" placeholder="Entrer Name" name="name" required>
      <input type="password" placeholder="Entrer mot de passe" name="password" required>
    </div>
    
    <div class="forget">
      <a href="#">Mot de passe oublié ?</a>
    </div>

    <?php
      if ($result === "error") {
        echo '<div class="alert alert-danger text-center">Name ou password n\'existe pas. Veuillez essayer avec un autre Name ou password !</div>';
      } 
    ?>

    <input type="submit" value="Se Connecter">

  </form>
</div>

</body>
</html>
