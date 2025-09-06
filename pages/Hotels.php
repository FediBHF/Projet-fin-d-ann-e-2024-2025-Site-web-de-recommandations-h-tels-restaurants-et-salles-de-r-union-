<!DOCTYPE html>
<html lang="en">
<head>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  <script src="https://kit.fontawesome.com/e31083a9ae.js" crossorigin="anonymous"></script>
  <link rel="shortcut icon" href="icon.ico" type="image/x-icon">
  <link rel="stylesheet" href="../styles/style2.css">
  <link rel="stylesheet" href="../styles/responsive.css">
  <link rel="stylesheet" href="../styles/reservation_form.css">
  <script src="../scripts/script.js"></script>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>RoamMate - Hotels</title>
</head>
<body>

  <?php
    include("components/header.php");
    require_once("../config/database.php");
  ?>

  <div class="search" id="hotels">
    <h1>Trouver l'hotel de vos reves aujourd'hui</h1>
    <div class="search-container">
      <form action="results.php" method="GET">
        <input type="search" placeholder="Search" name="query" required>
        <button id="search" type="submit">Search</button>
      </form>
    </div>
  </div>

  <div class="articles-container" id="art">
    <div class="sub-recommendations">
      <h4>Les meilleurs hôtels de monde</h4>
      <p>Trouvez des hôtels proches pour un séjour inoubliable.</p>
      <div class="recomm-options">
        <?php
          $req = "SELECT * FROM establishments WHERE type = 'Hotel' ORDER BY stars desc, price desc LIMIT 6";
          $res = $cnx->query($req);
          if($res->rowCount() > 0){
            foreach($res as $row){
        ?>
        <div class="article1">
          <div class="photo-cont">
            <img src="../pictures/est/<?php echo htmlspecialchars($row['photo']);?>" alt="" loading="lazy">
          </div>
          <div class="article-info">
            <div class="name">
              <h5><?php echo htmlspecialchars($row['name']) ?></h5>
              <p><i class="fa-solid fa-signs-post"></i> <?php echo htmlspecialchars($row['location']) ?> </p>
            </div>
            <div class="rating">
              <?php
                for ($i = 0; $i < $row['stars']; $i++) {
                  echo '<i class="fa-solid fa-star"></i>';
                }
              ?>
            </div>
          </div>
          <div class="article-info">
            <div class="price"><h5><?php echo htmlspecialchars($row['price']) ?>DT</h5><p>par nuit</p></div>
            <button data-bs-toggle="modal" data-bs-target="#<?php echo $row['id_establishment']; ?>">Reserver</button> 
          </div>
        </div>

        <div class="modal fade" id="<?php echo $row['id_establishment'];?>" tabindex="-1" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
              <form action="../controller/makeReservation.php" method="POST">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel"><?php echo htmlspecialchars($row['name']); ?></h5>
                  <h6 class="modal-title" id="exampleModalLabel"><i class="fas fa-map-marker-alt"></i> <?php echo htmlspecialchars($row['location']); ?></h5>
                </div>

                <div class="modal-body">
                  <input type="hidden" name="id_establishment" value="<?php echo $row['id_establishment']; ?>">

                  <div class="mb">
                    <label>Nombre de personnes</label>
                    <input type="number" name="guests" required min="1" value="1">
                  </div>

                  <div class="mb">
                    <label class="form-label">Date d'arrivée</label>
                    <input type="date" name="checkin" required>
                  </div>

                  <div class="mb">
                    <label class="form-label">Date de départ</label>
                    <input type="date" name="checkout" required>
                  </div>

                  <div class="mb">
                    <label class="form-label">Price per day (for 1 person) :</label>
                    <input type="text" value="<?php echo htmlspecialchars($row['price']); ?> DT" disabled>
                  </div>
                </div>

                <div class="reservation-buttons">
                  <button type="button" class="btn btn-secondary" id="annuler" data-bs-dismiss="modal">Annuler</button>
                  <button type="submit" class="btn btn-primary" id="confirmer">Confirmer</button>
                </div>

              </form>
            </div>
          </div>
        </div>

        <?php
            }
          }
          else{
            echo "<h1>No articles available ...</h1>";
          }
        ?>
        </div>
      </div>
  </div>

  <div class="panel-container">
    <div class="panels">
      <div class="panel1">
        <div class="photo-container">
          <img src="../pictures/offres.png" alt="" loading="lazy">
        </div>
        <div class="panel-content">
          <h4>Offres d'hôtel avantageuses</h4>
          <p>Nous recherchons les offres des principaux hôtels du monde entier et mettons les résultats à votre disposition.</p>
        </div>
      </div>

      <div class="panel1">
        <div class="photo-container">
          <img src="../pictures/prix.png" alt="" loading="lazy">
        </div>
        <div class="panel-content">
          <h4>Prix actualisés</h4>
          <p>Nous vous montrons toujours les prix les plus récents que nous pouvons trouver, afin que vous sachiez exactement à quoi vous attendre.</p>
        </div>
      </div>
      <div class="panel1">
        <div class="photo-container">
          <img src="../pictures/temp.png" alt="" loading="lazy">
        </div>
        <div class="panel-content">
          <h4>Recherche précise</h4>
          <p>Trouvez des hôtels avec piscine, annulation gratuite et réservation flexible. Ou ce qui compte le plus pour vous.</p>
        </div>
      </div>
    </div>
  </div>

  <div class="infos-rapide">
    <center><h5>Infos rapides</h5></center>
    <div class="infos-container">
      <div class="infos">
        <i class="fa-solid fa-hotel"></i>
        <h6>Des Hotels dans tout le monde</h6>
        <h6>700 000+</h6>
      </div>
      <div class="infos">
        <i class="fa-solid fa-location-dot"></i>
        <h6>Des Hotels dans la Tunisie</h6>
        <h6>800+</h6>
      </div>
      <div class="infos">
        <i class="fa-solid fa-earth-europe"></i>
        <h6>Pays Couverts</h6>
        <h6>150+</h6>
      </div>
    </div>
  </div>

  <?php include("components/footer.html"); ?>
  
</body>
</html>