<?php
  session_start();
  require_once("../config/database.php");
  require_once("../controller/traitement.php");

  if (!isset($_SESSION['name'])) {
    header("Location: signinadmin.php"); 
    exit();
  }
  $name = $_SESSION['name'];
  $info = admininfo($cnx, $name);
  ?>
  <?php
      $result=null;
      if (isset($_POST['username1'])){  
         $result = deleteaccount($cnx, $_POST['username1']);
       }
  ?>
    <?php
  $reservation=null;
      if (isset($_POST['reservation'])){
         $reservation = deletereservation($cnx, $_POST['reservation']);
       }
  ?>

<!DOCTYPE html>
<html lang="en">
<head>
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
   <link rel="shortcut icon" href="icon.ico" type="image/x-icon">
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link rel="stylesheet" href="style4.css">
   <title>Document</title>
</head>
<body>
   <div class="sidebar">
      <a href="Admin.html" class="adp"><h2 class="ad">Admin Panel</h2></a>
      <div class="profile">
         <img src="../pictures/defaultpfp.jpg" class="pic" alt="Photo de profil">
         <p class="bnj">Good Morning<?php echo "<br>Mr(s) ".htmlspecialchars($name);?> </p>
     </div><br>
      <a href="#" class="conteneur">Dashboard</a>
      <a href="admin.php   " class="conteneur">Account management</a>
      <a href="#" class="conteneur">Settings</a>
      <a href="#" class="conteneur">Logout</a>
  </div>
  <div class="content">
   <h2>Users</h2>
   <table>
       <thead>
           <tr>
               <th>ID</th>
               <th>Name</th>
               <th>E-mail</th>
               <th>Phone</th>
               <th>Location</th>
               <th>Gender</th>
           </tr>
       </thead>
       <tbody>
            <?php 
              $req="SELECT * from users";
              $res=$cnx->query($req);
            foreach ($res as $row){
               ?>
           <tr>
               <td><?php echo  htmlspecialchars($row["id"]) ?></td>
               <td><?php echo  htmlspecialchars($row["username"]) ?></td>
               <td><?php echo  htmlspecialchars($row["email"]) ?></td>
               <td><?php echo  htmlspecialchars($row["phone"]) ?></td>
               <td><?php echo  htmlspecialchars($row["location"]) ?></td>
               <td>
               <?php echo  htmlspecialchars($row["sexe"]) ?>
               </td>
               
           </tr>
           <?php } if($res->rowCount()==0) {?><tr><td colspan="5">No Users Yet</td></tr><?php }?>
       </tbody>
       
   </table><br>
   <h3>Delete User</h3>
   <form method="POST" class="user-form">
       <div class="form-group">
           <label for="username">ID:</label>
           <input type="number" id="username" name="username1"  placeholder="Enter ID" required>
       </div>

       <div class="form-group">

           <input type="submit" class="delete-btn" value="Delete Account">
       </div>
       <?php
           if($result=="error")
           {
            echo '<div class="alert alert-danger text-center">Reservation ID Not Exist !</div>';
           }
           if($result=="marche"){
            echo "<div class='alert alert-success text-center'>Reservation Successfully Deleted!</div>";
           }
           ?>
   </form>
   <hr>
</div>
<div class="content">
   <h2>Reservations</h2>
   <table>
       <thead>
           <tr>
               <th>ID Reservation</th>
               <th>ID Utilisateur</th>
               <th>ID Etablissement</th>
               <th>Checkin - Checkout</th>
               <th>Nombre de Clients</th>
               <th>Prix totale</th>
           </tr>
       </thead>
       <tbody>
       <?php 
  $req = "SELECT * FROM reservations";
  $res = $cnx->query($req);

   if ($res->rowCount() > 0) {
      foreach ($res as $row) {
         ?>
         <tr>
            <td><?php echo htmlspecialchars($row["id_reservation"]) ?></td>
            <td><?php echo htmlspecialchars($row["id_user"]) ?></td>
            <td><?php echo htmlspecialchars($row["id_establishment"]) ?></td>
            <td><?php echo htmlspecialchars($row["checkin"]) ?> - <?= htmlspecialchars($row["checkout"]) ?></td>
            <td><?php echo htmlspecialchars($row["nb_clients"]) ?></td>
            <td><?php echo htmlspecialchars($row["total_price"]) ?></td>
         </tr>
         <?php 
            }
         } else {
         ?>
         <tr><td colspan="5" class="text-center">No reservation Yet</td></tr>
         <?php 
         }
         ?>

       </tbody>
   </table><br>
   <h3>Delete Reservation</h3>
   <form  method="POST" class="user-form">
       <div class="form-group">
           <label for="username">Reservation ID:</label>
           <input type="number" id="username" name="reservation" placeholder="Reservation ID" required>
       </div>
      <?php if($reservation == "error")
           {
            echo '<div class="alert alert-danger text-center">ID Not Exist !</div>';
           }
           if($reservation == "marche"){
            echo "<div class='alert alert-success text-center'>Account Successfully Deleted!</div>";
           }
           ?>
           <input type="submit" value="Delete Reservation" class="delete-btn">
           </form>
       <hr>


</div>
<footer>
   <h3>Page Admin pour les configurations<br> &copy; GoBookIt Ltd 2025 – 2026</h3>
</footer>
</body>
</html>