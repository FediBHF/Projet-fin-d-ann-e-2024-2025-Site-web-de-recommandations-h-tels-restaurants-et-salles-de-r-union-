<?php
  require_once("../config/database.php");
  require_once("../controller/index_establishments.php");

  $results = [];
  if (isset($_GET['query'])){
    $results = SearchEst($cnx, $_GET['query']);
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  <script src="https://kit.fontawesome.com/e31083a9ae.js" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="../styles/style2.css">
  <link rel="stylesheet" href="../styles/style3.css">
  <link rel="stylesheet" href="../styles/reservation_form.css">
  <link rel="stylesheet" href="../styles/responsive.css">
  <script src="../scripts/script.js"></script>
  <link rel="shortcut icon" href="icon.ico" type="image/x-icon">
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>
<style>
#search-loader{
  top: 0;
  left: 0;
  width: 100vw;
  height: 100vh;
  position: fixed;
  display: flex;
  align-items: center;
  z-index: 10;
  justify-content: center;
  background: linear-gradient(135deg, #ffecd2,rgb(255, 255, 255));
}
</style>
<body>

  <?php include("components/header.php"); ?>

  <div id="search-loader">
    <div class="d-flex justify-content-center align-items-center" style="height: 100px;">
      <div class="spinner-border text-primary" role="status">
        <span class="visually-hidden">Loading...</span>
      </div>
    </div>
  </div>

  <div class="results-container">
    <div class="search-container">
      <form action="results.php">
        <input 
          type="search" 
          name="query" 
          placeholder="Search" 
          id="searchBar" 
          value="<?php echo isset($_GET['query']) ? htmlspecialchars($_GET['query']) : ''; ?>" 
          required>
        <button id="search">Search</button>
      </form>
    </div>

    <div class="recomm-options">
    <?php if (count($results) === 0): ?>
        <p style="padding: 2rem;">Aucun établissement trouvé.</p>
    <?php else: ?>
        <?php foreach ($results as $row): ?>
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
        <?php endforeach; ?>
    <?php endif; ?>              
    </div>
  </div>

  <?php include("components/footer.html"); ?>

</body>
</html>