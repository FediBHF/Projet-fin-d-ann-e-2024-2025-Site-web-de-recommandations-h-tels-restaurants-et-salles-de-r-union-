<!DOCTYPE html>
<html lang="en">
<head>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://kit.fontawesome.com/e31083a9ae.js" crossorigin="anonymous"></script>
  <link rel="shortcut icon" href="icon.ico" type="image/x-icon">
  <link rel="stylesheet" href="../styles/style2.css">
  <link rel="stylesheet" href="../styles/style3.css">
  <link rel="stylesheet" href="../styles/responsive.css">
  <script src="../scripts/script.js"></script>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Contact - RoamMate</title>
</head>
<body>

  <?php include("components/header.php"); ?>
  <?php
    require_once("../config/database.php");
    require_once("../controller/traitement.php");

    $result = null;

    if (isset($_POST['name'], $_POST['email'], $_POST['message'])){
        $data = [
          'name' => $_POST['name'],
          'email' => $_POST['email'],
          'message' => $_POST['message']
        ];
        $result = send_feedback($cnx, $data);
      }
  ?>
  
  <section class="ContactInfo">
    <div class="ContactInfo-content">
        <h1>Contactez-Nous</h1>
        <p>Une question ? Une suggestion ? On est là pour vous</p>
    </div>
  </section>

  <section class="contact-options">
    <div class="option-card">
      <h2>Par Téléphone</h2>
      <p>Appelez-nous. On décroche. Peut-être.</p>
      <a href="tel:+21612345678" class="phone-link"><i class="fa-solid fa-phone"></i> +216 12 345 678</a><br/>
    </div>
    <div class="option-card">
      <h2>Par Email</h2>
      <p>Envoyez-nous un mot pour vos questions ou idées, on répond vite.</p>
      <button class="support-btn" id="Contacter">Contact Support</button>
    </div>
  </section>

  <div class="ContactForm" id="Contact">
    <h2>Ou vous pouvez soumettre ici :</h2>
    <form method="post">
        <input type="text" placeholder="Your Name" name="name" required>
        <input type="email" placeholder="Your Email" name="email" required>
        <textarea placeholder="Your Message ..." name="message" maxlength="400" required></textarea>
        <?php 
          if ($result === "message_sent") {
          echo '<div class="alert alert-success text-center">Message Sent Successfully!</div>';
          }
          else if($result === "message_error"){
          echo '<div class="alert alert-danger text-center">Error . Message not sent !</div>';
          }
        ?>
        <button type="submit">Send</button>
    </form>
  </div>

  <?php include("components/footer.html"); ?>

</body>
</html>