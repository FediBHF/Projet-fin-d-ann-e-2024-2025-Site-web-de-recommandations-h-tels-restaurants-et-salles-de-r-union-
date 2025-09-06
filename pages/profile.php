<!DOCTYPE html>
<html lang="en">
<head>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://kit.fontawesome.com/e31083a9ae.js" crossorigin="anonymous"></script>
  <link rel="shortcut icon" href="icon.ico" type="image/x-icon">
  <link rel="stylesheet" href="../styles/style2.css">
  <link rel="stylesheet" href="../styles/style3.css">
  <link rel="stylesheet" href="../styles/reservation_form.css">
  <link rel="stylesheet" href="../styles/responsive.css">
  <script src="../scripts/script.js"></script>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Profile</title>
</head>
<body>

<?php include("components/header.php") ?>
<?php
  require_once("../config/database.php");
  require_once("../controller/traitement.php");

  if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
  }
  $user_id = $_SESSION['user_id'];
  $user_infos = getUserData($cnx, $user_id);

  if($_POST){
    updateProfile($cnx, $_POST);
  }
?>

<div class="container">
  <div class="aside">
    <div class="card profile-card">
      <div class="pfp">
        <?php
        $stmt = $cnx->prepare("SELECT photo FROM users WHERE id = ?");
        $stmt->execute([$user_id]);
        $image = $stmt->fetchAll();
        if(empty($image[0][0])){
          echo '
              <img src="../pictures/Default-pfp.svg" alt="" width="50" height="50">
          ';
        }
        else{
          echo '
              <img src="'.$image[0][0].'" alt="" width="50" height="50">
          ';
        }
        ?>
      </div>
      <div class="profile-info">
        <span><?php echo htmlspecialchars($user_infos['username']); ?></span>
        <p>#<?php echo htmlspecialchars($user_infos['id']); ?></p>
      </div>
      <div class="profile-contact">
        <div class="contact-item">
          <i class="fas fa-phone"></i>
          <span>+66 <?php echo htmlspecialchars($user_infos['phone']); ?></span>
        </div>
        <div class="contact-item">
          <i class="fas fa-envelope"></i>
          <span><?php echo htmlspecialchars($user_infos['email']); ?></span>
        </div>
        <div class="contact-item">
          <i class="fas fa-map-marker-alt"></i>
          <span>Switzerland, Geneve</span>
        </div>
        <div class="contact-item">
          <i class="fa-solid fa-venus-mars"></i>
          <span><?php echo htmlspecialchars($user_infos['sexe']); ?></span>
        </div>
      </div>
      <button class="edit-btn">Edit Profile</button>
    </div>

    <div class="update-card">
      <div class="update-content">
        <h3><i class="fa-solid fa-users-gear"></i>Update your profile</h3>
        <form action="" method="POST">
          <div class="newInfo">
            <input type="text" placeholder="Update username" name="name">
            <input type="email" placeholder="Update e-mail" name="email">
            <input type="text" placeholder="Update phone number" name="phone">
            <input type="password" placeholder="Update password" name="new_password">
            <input type="password" placeholder="Enter old password (REQUIRED)" name="current_password" required>
            <input type="file" name="image">
          </div>
          <div class="btns-container">
            <button id="annuler" class="close-update">Annuler</button>
            <button id="confirmer" type="submit" class="confirm-update">Confirmer</button>
          </div>
        </form>
      </div>
    </div>

    <div class="card">
      <div class="profile-settings">
        <div class="setting-item">
          <span>Account Settings</span>
        </div>
        <div class="setting-item">
          <a href="#">Personal Information</a>
        </div>
        <div class="setting-item">
          <a href="#">Payment Methods</a>
        </div>
        <div class="setting-item">
          <a href="#">Notifications</a>
        </div>
        <div class="setting-item">
          <a href="#">Privacy & Security</a>
        </div>
        <div class="setting-item">
          <a href="#">Preferences</a>
        </div>
        <div class="logout-item">
          <a href="#" id="logout-btn"><span>Log Out</span></a>
        </div>
      </div>
    </div>
  </div>

  <div class="logout-card">
    <div class="logout-content">
      <h3>Are you sure to log out ?</h3>
      <div class="btns-container">
        <button id="annuler" class="annuler">Annuler</button><button id="confirmer" class="confirmer">Confirmer</button>
      </div>
    </div>
  </div>

  <div class="main">

    <div class="newreserv">
      <div class="desc-item">
        <h1>My Reservations</h1>
        <p>Manage all your bookings in one place</p>
      </div>
      <div class="btn-item">
        <button id="reserver">Make reservation</button>
      </div>
    </div>

    <div class="myreservations-container">
      <div class="choice-item">
        <a href="#hotel" class="tab-link"><div class="choice"><i class="fa-solid fa-hotel"></i><span>Hotels</span></div></a>
        <a href="#restaurant" class="tab-link"><div class="choice"><i class="fa-solid fa-utensils"></i><span>Restaurants</span></div></a>
        <a href="#salle" class="tab-link"><div class="choice"><i class="fa-solid fa-business-time"></i><span>Salles de Reunion</span></div></a>
      </div>

      <div class="myreservations">
        <?php
          $req2 = "SELECT * FROM RESERVATIONS r JOIN ESTABLISHMENTS e ON r.id_establishment = e.id_establishment WHERE id_user = $user_id ORDER BY checkin desc";
          $res2 = $cnx->query($req2);
          if ($res2->rowCount() > 0){
            foreach ($res2 as $row) {
        ?>
              <div class="reserv1" id="<?php echo  htmlspecialchars($row["type"]) ?>">
                <div class="reserv-photo">
                  <img src="../pictures/est/<?php echo htmlspecialchars($row['photo']) ?>" alt="" loading="lazy">
                </div>
                <div class="info-item-container">
                  <div class="info-item">
                    <div class="infos1" id="first">
                      <h3><?php echo htmlspecialchars($row["name"]) ?></h3>
                      <p><?php echo htmlspecialchars($row["location"]) ?></p>
                    </div>
                    <div class="infos1">
                      <span><i class="fa-solid fa-map-pin"></i>Check-in</span>
                      <h4><?php echo htmlspecialchars($row["checkin"]) ?></h4>
                      <p>From 3:00 PM</p>
                    </div>
                    <div class="infos1">
                      <span><i class="fa-solid fa-map-pin"></i>Check-out</span>
                      <h4><?php echo htmlspecialchars($row["checkout"]) ?></h4>
                      <p>Until 11:00 AM</p>
                    </div>
                  </div>

                  <div class="info-item">
                    <div class="infos1" id="first">
                      <h4>Number of Clients</h4>
                      <p><?php echo htmlspecialchars($row["nb_clients"]) ?> Clients</p>
                    </div>
                    <div class="infos1">
                      <h4>Total Price</h4>
                      <p><?php echo htmlspecialchars($row["total_price"]) ?>DT</p>
                    </div>
                    <div class="infos1">
                      <h4>Change details</h4>
                      <button data-bs-toggle="modal" data-bs-target="#<?php echo $row['id_reservation']; ?>"><?php echo (new DateTime($row["checkout"]) < new DateTime()) ? "Delete" : "Cancel"; ?></button>  
                    </div>
                  </div>
                </div>
              </div>

              <div class="modal fade" id="<?php echo $row['id_reservation']; ?>" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                  <div class="modal-content">
                    <form action="../controller/delete_reservation.php" method="POST">

                      <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"><?php echo htmlspecialchars($row['name']); ?></h5>
                        <h6 class="modal-title" id="exampleModalLabel"><i class="fas fa-map-marker-alt"></i> <?php echo htmlspecialchars($row['location']); ?></h5>
                      </div>

                      <input type="hidden" name="id_reservation" value="<?php echo $row['id_reservation']; ?>">

                      <div class="reservation-buttons">
                        <button type="button" class="btn btn-secondary" id="annuler" data-bs-dismiss="modal">Annuler</button>
                        <button type="submit" class="btn btn-primary" id="confirmer">Delete</button>
                      </div>

                    </form>
                  </div>
                </div>
              </div>
        <?php
            }
          } 
          else{
            echo '<h1>No reservations made</h1>';
          }
        ?>

      </div>
    </div>
  </div>
</div>

<?php include("components/footer.html"); ?>

</body>
</html>
