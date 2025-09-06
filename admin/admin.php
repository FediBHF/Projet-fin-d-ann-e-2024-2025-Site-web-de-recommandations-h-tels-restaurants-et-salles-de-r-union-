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
<!DOCTYPE html>

<head>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
   <link rel="shortcut icon" href="icon.ico" type="image/x-icon">
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Panel - Reservations</title>
  <link rel="stylesheet" href="style4.css">
</head>


  <div class="sidebar">
    <a href="Admin.html" class="adp"><h2 class="ad">Admin Panel</h2></a>
    <div class="profile">
      <img src="../pictures/defaultpfp.jpg" class="pic" alt="Profile Picture">
      <p class="bnj">Good Morning <?php echo "<br>Mr(s) ".htmlspecialchars($name);?></p>
    </div><br>

    <a href="dashboard.php" class="conteneur">Dashboard</a>
    <a href="admin.php" class="conteneur">Account Management</a>
    <a href="#" class="conteneur">Settings</a>
    <a href="logout.php" class="conteneur">Logout</a>
  </div>

  <div class="content">
    <div class="header">
      <h1>Admin Dashboard</h1>
    </div>

    <div class="profile-section">
      <div class="profile-card">
        <img src="../pictures/defaultpfp.jpg" alt="Admin Photo">
        <h2><?php echo htmlspecialchars($name); ?></h2>
        <p>Administrateur Principal</p>
        <p>Name: <strong><?php echo "<br>Mr(s) ".htmlspecialchars($name);?></strong></p>
        <p>Email: <strong><?php echo htmlspecialchars($info['email']); ?></strong></p>
        <p>Location: <strong><?php echo htmlspecialchars($info['localisation']); ?></strong></p>
        <button>Edit Profile</button>
      </div>

      <div class="stats">
        <h2>Statistics</h2>
        <div class="stats-grid">
          <div class="stat-box">
            <h3>Users</h3><p>
            <?php
            $req="SELECT * from users";
            $res=$cnx->query($req);
            echo htmlspecialchars($res->rowCount() );
            ?></p>
          </div>
          <div class="stat-box">
            <h3>Messages</h3>
            <p>
            <?php
            $req="SELECT * from contacts";
            $res=$cnx->query($req);
            echo htmlspecialchars($res->rowCount() );
            ?>
            </p>
          </div>
          <div class="stat-box">
            <h3>Reports</h3>
            <p>34</p>
          </div>
          <div class="stat-box">
            <h3>Notifications</h3>
            <p>18</p>
          </div>
        </div>
      </div>
    </div>   
  </div>


  <div class="content">
  <div class="header">
      <h1>Messages</h1>
    </div>      
    <?php
      $cont = getmessages($cnx);
      foreach($cont as $row)
      {
      ?>
  <div class="profile-section">

      <div class="profile-card">
         <h2>User Name: <?php echo "Mr(s) " . htmlspecialchars($row['name']); ?></h2>
         <p></p>
         <p>Email: <strong><?php echo htmlspecialchars($row['email']); ?></strong></p>
         <p><H3>Message:</H3> <strong><?php echo htmlspecialchars($row['message']); ?></strong></p>
      </div>

    </div> <br><hr>
    <?php
      }echo "<br>";
      ?>
  </div>


  <div class="content">
  <div class="header">
      <h1>Delete Or Find Message</h1>
    </div>
    <?php
      $del=null;
      if (isset($_POST['name'])){
         $del=deletemessage($cnx, $_POST['name']);
       }
       else{
        $del=null;
       }
      
    ?>
    <form method="POST" class="user-form">
      <div class="form-group">
           <label for="username">Name:</label>
           <input type="text" name="name"  placeholder="Enter Name" required>
       </div>
       <div class="form-group">
         <input type="submit" class="delete-btn" value="Delete Message">
      </div></form>
      <?php

          if($del=="error")
           {
            echo '<div class="alert alert-danger text-center">Name Not Exist !</div>';
           }
           if($del=="marche"){
            echo "<div class='alert alert-success text-center'>Message Successfully Deleted!</div>";
           }
      

           ?><hr><hr>
      <h1>FIND :</h1>
      <?php
         $m = [];
        $dd=null;
      if (isset($_POST['message'])) {
         $name = $_POST['message'];
         $m = getmessage($cnx, $name);
         $dd="hi";
       }
       else{
        $dd=null;
       }
      ?>
      <form method="post">
    <div class="form-group">
        <label for="username">Message Name:</label>
        <input type="text" id="username" name="message" placeholder="Find Message" required>
    </div>
    <div class="form-group">
        <input type="submit" class="edit-btn" value="Find Message">
    </div>

    <?php if (isset($m) && $dd!=null && count($m) === 0): ?>
        <div class="alert alert-danger text-center">Message not Found !</div>
    <?php endif; ?>

    <?php if (isset($m) && count($m) && $dd!=null > 0): ?>
        <?php foreach ($m as $row): ?>
            <div class="profile-section">
                <div class="profile-card">
                    <h2>User Name: <?php echo "Mr(s) " . htmlspecialchars($row['name']); ?></h2>
                    <p>Email: <strong><?php echo htmlspecialchars($row['email']); ?></strong></p>
                    <p><h3>Message:</h3> <strong><?php echo htmlspecialchars($row['message']); ?></strong></p>
                </div>
            </div>
            <br><hr>
        <?php endforeach; ?>
    <?php endif; ?>

      </form>
      </div>
           


  
  <footer>
    <p>Admin Panel for Configuration<br> &copy; GoBookIt Ltd 2025 – 2026</p>
  </footer>
</body>
</html>
