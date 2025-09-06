<!DOCTYPE html>
<html lang="en">
<head>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  <script src="https://kit.fontawesome.com/e31083a9ae.js" crossorigin="anonymous"></script>
  <script src="../scripts/script.js"></script>
  <link rel="shortcut icon" href="icon.ico" type="image/x-icon">
  <link rel="stylesheet" href="../styles/style2.css">
  <link rel="stylesheet" href="../styles/responsive.css">
  <link rel="stylesheet" href="../styles/reservation_form.css">
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>RoamMate</title>
</head>
<style>

body.loading{
  overflow: hidden;
}

#loader-wrapper{
  position: fixed;
  top: 0;
  left: 0;
  width: 100vw;
  height: 100vh;
  background: linear-gradient(135deg, #ffecd2,rgb(255, 255, 255));
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  z-index: 10;
}
#loader-wrapper img{
  margin-top: -150px;
}

.loader {
  display: flex;
  justify-content: space-between;
  width: 60px;
  margin-top: -40px;
}
.loader div {
  width: 14px;
  height: 14px;
  background-color:rgb(0, 0, 0);
  border-radius: 50%;
  animation: loader-bounce 0.6s infinite ease-in-out both;
}
.loader div:nth-child(1) {
  animation-delay: -0.2s;
}
.loader div:nth-child(2) {
  animation-delay: -0.1s;
}
.loader div:nth-child(3) {
  animation-delay: 0;
}

@keyframes loader-bounce {
  0%, 80%, 100% {
    transform: scale(0);
  }
  40% {
    transform: scale(1);
  }
}

</style>

<?php
  include("components/header.php");
  if (isset($_SESSION['user_id'])) {
    require_once("../controller/AI/getData.php");
    require_once("../controller/recommend_establishments.php");
  }
?>

<?php
if (empty($establishmentIds)) {
    $grouped = ['hotel'=>[], 'restaurant'=>[], 'workspace'=>[]];
} else {
    $placeholders = implode(',', array_fill(0, count($establishmentIds), '?'));
    $stmt = $cnx->prepare(
      "SELECT id_establishment, name, location, price, stars, type, photo
       FROM establishments
       WHERE id_establishment IN ($placeholders)"
    );
    $stmt->execute($establishmentIds);
    $ests = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $grouped = ['hotel'=>[], 'restaurant'=>[], 'workspace'=>[]];
    foreach ($ests as $est) {
        $type = strtolower($est['type']);
        if (isset($grouped[$type])) {
            $grouped[$type][] = $est;
        }
    }
}
?>


<body class="loading">

  <div id="loader-wrapper">
    <img src="../pictures/logo.svg" alt="" width="200px" height="200px">
    <div class="loader">
      <div></div>
      <div></div>
      <div></div>
    </div>
  </div>
  
  <div class="offres">
    <div id="carouselExampleDark" class="carousel slide carousel-fade" data-bs-ride="carousel" data-bs-wrap="true" data-bs-pause="false">
      <div class="carousel-indicators">
        <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
        <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="1" aria-label="Slide 2"></button>
        <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="2" aria-label="Slide 3"></button>
      </div>
      <div class="carousel-inner">
        <div class="carousel-item active" data-bs-interval="10000">
          <img src="../pictures/slides/photo1.jpg" class="d-block w-100" alt="..." loading="lazy">
          <div class="carousel-caption d-none d-md-block">
            <h5>Hotels</h5>
            <p>Discover your new favorite stay</p>
          </div>
        </div>
        <div class="carousel-item" data-bs-interval="10000">
          <img src="../pictures/slides/photo2.jpg" class="d-block w-100" alt="..." loading="lazy">
          <div class="carousel-caption d-none d-md-block">
            <h5>Restaurants</h5>
            <p>Find your new favorite spot to dine!</p>
          </div>
        </div>
        <div class="carousel-item" data-bs-interval="10000">
          <img src="../pictures/slides/photo3.jpg" class="d-block w-100" alt="..." loading="lazy">
          <div class="carousel-caption d-none d-md-block">
            <h5>Salles de Reunion</h5>
            <p>Discover the perfect meeting place!</p>
          </div>
        </div>
      </div>
      <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleDark" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
      </button>
      <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleDark" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
      </button>
    </div>
  </div>

  <div class="reservation2">
    <div class="options">
      <a href="Hotels.php">
        <div class="opt1">
          <i class="fa-solid fa-hotel"></i>
          <span>Hotels</span>
        </div>
      </a>
      <a href="Restaurants.php">
        <div class="opt1">
          <i class="fa-solid fa-utensils"></i>
          <span>Restaurants</span>
        </div>
      </a>
      <a href="Salles.php">
        <div class="opt1">  
          <i class="fa-solid fa-business-time"></i>
          <span>Salles de Reunion</span>
        </div>
      </a>
    </div>
  </div>

  <div class="articles-container" id="recommendations">

    <div class="recommendations-container">

      <h4>Recommendations</h4>
      <!-- Hotels -->
      <div class="sub-recommendations">
        <h4>Les meilleurs hôtels pour vous</h4>
        <p>Trouvez des hôtels proches de chez vous pour un séjour inoubliable.</p>
        <div class="recomm-options">
          <?php foreach ($grouped['hotel'] as $est): ?>
            <div class="article1">
              <div class="photo-cont">
                <img src="../pictures/est/<?php echo htmlspecialchars($est['photo']);?>" alt="" loading="lazy">
              </div>
              <div class="article-info">
                <div class="name">
                  <h5><?= htmlspecialchars($est['location']) ?></h5>
                  <p><i class="fa-solid fa-signs-post"></i> <?= htmlspecialchars($est['location']) ?></p>
                </div>
                <div class="rating">
                  <?php 
                    $full = floor($est['stars']);
                    $half = ($est['stars'] - $full) >= 0.5;
                    for ($i = 0; $i < $full; $i++) echo '<i class="fa-solid fa-star"></i>';
                    if ($half) echo '<i class="fa-solid fa-star-half"></i>';
                  ?>
                </div>
              </div>
              <div class="article-info">
                <div class="price">
                  <h5><?= htmlspecialchars($est['price']) ?>DT</h5><p>par nuit</p>
                </div>
                <button data-bs-toggle="modal" data-bs-target="#<?php echo $est['id_establishment']; ?>">Reserver</button>
              </div>
            </div>
          <div class="modal fade" id="<?php echo $est['id_establishment'];?>" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
              <div class="modal-content">
                <form action="../controller/makeReservation.php" method="POST">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"><?php echo htmlspecialchars($est['name']); ?></h5>
                    <h6 class="modal-title" id="exampleModalLabel"><i class="fas fa-map-marker-alt"></i> <?php echo htmlspecialchars($est['location']); ?></h5>
                  </div>

                  <div class="modal-body">
                    <input type="hidden" name="id_establishment" value="<?php echo $est['id_establishment']; ?>">

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
                      <input type="text" value="<?php echo htmlspecialchars($est['price']); ?> DT" disabled>
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
        </div>
      </div>

      <!-- Restaurants -->
      <div class="sub-recommendations">
        <h4>Les meilleurs restaurants pour vous</h4>
        <p>Pas besoin de voyager loin pour goûter de nouvelles saveurs. Découvrez les meilleurs restaurants près de chez vous.</p>
        <div class="recomm-options">
          <?php foreach ($grouped['restaurant'] as $est): ?>
            <div class="article1">
              <div class="photo-cont">
                <img src="../pictures/est/<?php echo htmlspecialchars($est['photo']);?>" alt="" loading="lazy">
              </div>
              <div class="article-info">
                <div class="name">
                  <h5><?= htmlspecialchars($est['location']) ?></h5>
                  <p><i class="fa-solid fa-signs-post"></i> <?= htmlspecialchars($est['location']) ?></p>
                </div>
                <div class="rating">
                  <?php 
                    $full = floor($est['stars']);
                    $half = ($est['stars'] - $full) >= 0.5;
                    for ($i = 0; $i < $full; $i++) echo '<i class="fa-solid fa-star"></i>';
                    if ($half) echo '<i class="fa-solid fa-star-half"></i>';
                  ?>
                </div>
              </div>
              <div class="article-info">
                <div class="price">
                  <h5><?= htmlspecialchars($est['price']) ?>DT</h5><p>par couvert</p>
                </div>
                <button data-bs-toggle="modal" data-bs-target="#<?php echo $est['id_establishment']; ?>">Reserver</button>
              </div>
            </div>
          <div class="modal fade" id="<?php echo $est['id_establishment'];?>" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
              <div class="modal-content">
                <form action="../controller/makeReservation.php" method="POST">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"><?php echo htmlspecialchars($est['name']); ?></h5>
                    <h6 class="modal-title" id="exampleModalLabel"><i class="fas fa-map-marker-alt"></i> <?php echo htmlspecialchars($est['location']); ?></h5>
                  </div>

                  <div class="modal-body">
                    <input type="hidden" name="id_establishment" value="<?php echo $est['id_establishment']; ?>">

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
                      <input type="text" value="<?php echo htmlspecialchars($est['price']); ?> DT" disabled>
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
        </div>
      </div>

      <!-- Workspaces -->
      <div class="sub-recommendations">
        <h4>Espaces de coworking populaires pour vous</h4>
        <p>Trouvez l’endroit idéal pour travailler confortablement et efficacement.</p>
        <div class="recomm-options">
          <?php foreach ($grouped['workspace'] as $est): ?>
            <div class="article1">
              <div class="photo-cont">
                <img src="../pictures/est/<?php echo htmlspecialchars($est['photo']);?>" alt="" loading="lazy">
              </div>
              <div class="article-info">
                <div class="name">
                  <h5><?= htmlspecialchars($est['location']) ?></h5>
                  <p><i class="fa-solid fa-signs-post"></i> <?= htmlspecialchars($est['location']) ?></p>
                </div>
                <div class="rating">
                  <?php 
                    $full = floor($est['stars']);
                    $half = ($est['stars'] - $full) >= 0.5;
                    for ($i = 0; $i < $full; $i++) echo '<i class="fa-solid fa-star"></i>';
                    if ($half) echo '<i class="fa-solid fa-star-half"></i>';
                  ?>
                </div>
              </div>
              <div class="article-info">
                <div class="price">
                  <h5><?= htmlspecialchars($est['price']) ?>DT</h5><p>par jour</p>
                </div>
                <button data-bs-toggle="modal" data-bs-target="#<?php echo $est['id_establishment']; ?>">Reserver</button> 
              </div>
            </div>

          <div class="modal fade" id="<?php echo $est['id_establishment'];?>" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
              <div class="modal-content">
                <form action="../controller/makeReservation.php" method="POST">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"><?php echo htmlspecialchars($est['name']); ?></h5>
                    <h6 class="modal-title" id="exampleModalLabel"><i class="fas fa-map-marker-alt"></i> <?php echo htmlspecialchars($est['location']); ?></h5>
                  </div>

                  <div class="modal-body">
                    <input type="hidden" name="id_establishment" value="<?php echo $est['id_establishment']; ?>">

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
                      <input type="text" value="<?php echo htmlspecialchars($est['price']); ?> DT" disabled>
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
        </div>
      </div>
    </div>

      <div class="sub-recommendations">
          <h4>Frequent Questions</h4>
          <div class="accordion" id="accordionPanelsStayOpenExample">

            <div class="accordion-item">
              <h2 class="accordion-header">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#q1" aria-expanded="true" aria-controls="q1">
                  How can I book a hotel, restaurant, or coworking space?
                </button>
              </h2>
              <div id="q1" class="accordion-collapse collapse show">
                <div class="accordion-body">
                  Simply search for your preferred location or establishment, select the one you like, and click on "Reserve". You will receive a confirmation after your reservation is submitted.
                </div>
              </div>
            </div>

            <div class="accordion-item">
              <h2 class="accordion-header">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#q2" aria-expanded="false" aria-controls="q2">
                  How does the AI recommendation system work?
                </button>
              </h2>
              <div id="q2" class="accordion-collapse collapse">
                <div class="accordion-body">
                  Our AI analyzes your search preferences and location to recommend the best-rated hotels, restaurants, and coworking spaces near you.
                </div>
              </div>
            </div>

            <div class="accordion-item">
              <h2 class="accordion-header">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#q3" aria-expanded="false" aria-controls="q3">
                  Can I cancel or modify my reservation?
                </button>
              </h2>
              <div id="q3" class="accordion-collapse collapse">
                <div class="accordion-body">
                  Yes, you can manage your reservations through your account dashboard. Look for the reservation you want to change and follow the options provided.
                </div>
              </div>
            </div>

            <div class="accordion-item">
              <h2 class="accordion-header">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#q4" aria-expanded="false" aria-controls="q4">
                  "Help! There are so many hotel options. How can I make my choice?"
                </button>
              </h2>
              <div id="q4" class="accordion-collapse collapse">
                <div class="accordion-body">
                  A hotel search can return a large number of results. To make things simpler, avoid opening too many tabs or windows, and focus on what matters most to you. Are you looking for a hotel for a family trip, a romantic getaway, or a business trip? You can also use filters based on specific amenities you want, such as a spa or parking. <br><br>

                  Search according to your preferences and only look at the results that match perfectly.
                </div>
              </div>
            </div>

            <div class="accordion-item">
              <h2 class="accordion-header">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#q5" aria-expanded="false" aria-controls="q5">
                  Is my personal information secure?
                </button>
              </h2>
              <div id="q5" class="accordion-collapse collapse">
                <div class="accordion-body">
                  Absolutely. We use secure encryption protocols to protect your personal data and ensure your privacy at all times.
                </div>
              </div>
            </div>

            <div class="accordion-item">
              <h2 class="accordion-header">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#q6" aria-expanded="false" aria-controls="q5">
                  What if I don’t find what I’m looking for?
                </button>
              </h2>
              <div id="q6" class="accordion-collapse collapse">
                <div class="accordion-body">
                  Try refining your search or using different keywords. Our AI-powered search engine also supports synonyms and similar phrases to help you find relevant results.
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="sub-recommendations">
          <h4>Our Sponsors</h4>
          <div class="sponsors">
            <img src="../pictures/sponsors.png" alt="">
          </div>
        </div>

  </div>


  <?php include("components/footer.html"); ?>

</body>
</html>