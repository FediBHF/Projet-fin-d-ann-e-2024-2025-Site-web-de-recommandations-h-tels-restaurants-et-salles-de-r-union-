<?php
session_start();
session_destroy();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<title>Déconnexion</title>
<meta http-equiv="refresh" content="3;url=login.php">
<style>
body {
  margin: 0;
  padding: 0;
  font-family: "Segoe UI", sans-serif;
  background: linear-gradient(135deg, #ffecd2, #125291);
  height: 100vh;
  display: flex;
  align-items: center;
  justify-content: center;
  color: #333;
}
.logout-container {
  background: white;
  padding: 40px 50px;
  border-radius: 15px;
  box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
  text-align: center;
  width: 400px;
}
.logout-container h1 {
  margin-bottom: 15px;
  color: #05203c;
}
.logout-container p {
  font-size: 1rem;
}
.loader {
  margin-top: 20px;
  border: 5px solid #f3f3f3;
  border-top: 5px solid #05203c;
  border-radius: 50%;
  width: 30px;
  height: 30px;
  animation: spin 1s linear infinite;
  margin-left: auto;
  margin-right: auto;
}
@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}
</style>
</head>
<body>
  <div class="logout-container">
    <h1>Déconnexion réussie</h1>
    <p>Vous allez être redirigé vers la page de connexion...</p>
    <div class="loader"></div>
  </div>
</body>
</html>