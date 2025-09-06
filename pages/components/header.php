<?php session_start(); ?>

<header>
    <div class="logo">
      <a href="Accueil.php"><img src="../pictures/logo.svg" width="150px" height="65px" loading="lazy"></a>
    </div>
    <div class="nav">
      <li><a href="Accueil.php" class="nav-link">Accueil</a></li>
      <li class="appear">
        <a href="#recommendations" class="nav-link">Reservation</a>
        <div class="appear-content">
          <h3>CATEGORIES</h3>
          <a href="Hotels.php">Hotels</a>
          <a href="Restaurants.php">Restaurants</a>
          <a href="Salles.php">Salles De Reunion</a>
          <a href="">Co-Working Space</a>
        </div>
      </li>
      <li><a href="profile.php" class="nav-link">Profile</a></li>
      <li><a href="contact.php" class="nav-link">Contact</a></li>
    </div>

    <?php
    require_once("../config/database.php");
    if(!isset($_SESSION["user_id"])){
      echo'
        <div class="connection">
          <li><a href="login.php">Log In</a></li>
          <button id="getstarted">Get Started</button>
        </div>
      ';
    }
    else{
      $user_id = $_SESSION['user_id'];
      $req = "SELECT photo FROM users WHERE id = '$user_id'";
      $res = $cnx->query($req);
      $image = $res->fetchAll();
      if(empty($image[0][0])) {
        echo '
          <div class="profile-picture">
            <img src="../pictures/Default-pfp.svg" alt="" width="50" height="50">
          </div>
        ';
      }
      else {
        echo '
          <div class="profile-picture">
            <img src="'.$image[0][0].'" alt="" width="50" height="50">
          </div>
        ';
      }
    }
    ?>
  </header>