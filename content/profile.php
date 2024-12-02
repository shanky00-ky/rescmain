<?php 
include(".\conn.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="css/profile.css">
  <title>Volleyball Profile Page</title>
</head>
<body>
  <nav class="navbar">
    <div class="logo">
      <img src="images/volleyball-logo-on-the-background-of-multi-vector-9105476-removebg-preview.webp" alt="Logo">
      <span>Volleyball League</span>
    </div>
    <div class="nav-links">
      <a href="#">Home</a>
      <a href="#">Matches</a>
      <a href="#">Teams</a>
      <a href="#">Logout</a>
    </div>
  </nav>

  <div class="profile-container">
    <div class="profile-header">
      <img src="profile-pic.jpg" alt="User Photo" class="profile-pic">
      <h1>sansakar</h1>
      <p class="user-role">Setter - Team Lightning</p>
    </div>

    <div class="profile-stats">
      <div class="stat-box">
        <h3>Matches Played</h3>
        <p>45</p>
      </div>
      <div class="stat-box">
        <h3>Wins</h3>
        <p>32</p>
      </div>
      <div class="stat-box">
        <h3>Total Points</h3>
        <p>198</p>
      </div>
    </div>

    <div class="edit-profile">
      <button class="btn">Edit Profile</button>
    </div>
  </div>

  <script src="scripts.js"></script>
</body>
</html>
