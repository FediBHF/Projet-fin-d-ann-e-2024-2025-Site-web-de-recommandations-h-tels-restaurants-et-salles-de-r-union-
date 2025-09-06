<?php

session_start();
if(isset($_SESSION['user_id'])){
  header("Location: profile.php");
  exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <link rel="shortcut icon" href="icon.ico" type="image/x-icon">
  <link rel="stylesheet" href="../styles/style.css">
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>RoamMate - Log In</title>
</head>
<body>

<?php
  require_once("../config/database.php");
  require_once("../controller/traitement.php");

  $result = null;

  if (isset($_POST['email'], $_POST['password'])) {
    $data = [
      'email'    => $_POST['email'],
      'password' => $_POST['password']
    ];

    $result = login($cnx, $data);
  }
?>

<div class="container">
  <div class="title">
    <center><h1>Log-in</h1></center>
    <center><p>Entrer vos données personnelles, nous allons les protéger !</p></center>
  </div>

  <form method="post">
    <div class="input">
      <input type="email" placeholder="Entrer email" name="email" value="<?php if(isset($_POST['email'])) echo htmlspecialchars($_POST['email']); ?>" required>
      <input type="password" placeholder="Entrer mot de passe" name="password" required>
    </div>
    
    <div class="forget">
      <a href="#">Mot de passe oublié ?</a>
    </div>

    <?php
      if ($result === "email_not_found") {
        echo '<div class="alert alert-danger text-center">Email n\'existe pas. Veuillez essayer avec un autre email !</div>';
      } elseif ($result === "invalid_password") {
        echo '<div class="alert alert-danger text-center">Email ou mot de passe invalide !</div>';
      }
    ?>

    <input type="submit" value="Se Connecter">

    <div class="register">
      <p>- Pas enregistré ? -</p>
      <center><a href="signup.php">S\'enregistrer</a></center>
    </div>
  </form>
</div>

</body>
</html>
