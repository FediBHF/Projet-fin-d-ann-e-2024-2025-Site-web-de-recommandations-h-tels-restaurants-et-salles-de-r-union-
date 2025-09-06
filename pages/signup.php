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
  <title>RoamMate - Sign Up</title>
</head>
<body>

<?php
  require_once("../config/database.php");
  require_once("../controller/traitement.php");

  $result = null;

  if (isset($_POST['tel'], $_POST['email'], $_POST['password'], $_POST['username'], $_POST['sexe'])) {
    $data = [
      'username' => $_POST['username'],
      'email'    => $_POST['email'],
      'tel'      => $_POST['tel'],
      'password' => $_POST['password'],
      'sexe'     => $_POST['sexe']
    ];

    $result = addUser($cnx, $data);
  }
?>
  <div class="container">
    <div class="title">
      <center><h1>Sign-up</h1></center>
      <center><p>Entrer vos données personnelles, nous allons les protéger !</p></center>
    </div>
    <form method="post">
      <div class="input">
        <input type="text" placeholder="Entrer username" name="username" value="<?php if(isset($_POST['username'])) echo htmlspecialchars($_POST['username']); ?>" required>
        <input type="email" placeholder="Entrer email" name="email" required>
        <input type="text" placeholder="Entrer numéro de téléphone" name="tel" required>
        <input type="password" placeholder="Entrer mot de passe" name="password" required>
      </div>
      
      <div class="sexe">
        <label>Sexe :</label>
        <input type="radio" name="sexe" value ="Male" required><p>Homme</p>
        <input type="radio" name="sexe" value="Female" required><p>Femme</p>
      </div>

      <?php
        if ($result === "email_exists") {
          echo '<div class="alert alert-danger text-center">Email existe déjà Veuillez essayer avec un autre email !</div>';
        }
        else if ($result === "tel_exists") {
          echo '<div class="alert alert-danger text-center">Phone number existe déjà Changez le !</div>';
        }
        else if ($result === "success") {
          echo "<div class='alert alert-success text-center'>Account successfully created!</div>";
        }
        else if ($result === "error") {
          echo "<div class='alert alert-danger text-center'>Erreur lors de la création du compte !</div>";
        }
      ?>
      <input type="submit" value="S'inscrire">
    </form>

    <div class="register">
      <p>- Déjà enregistré ? -</p>
      <center><a href="login.php">Se connecter</a></center>
    </div>
  </div>

</body>
</html>
