<?php
require_once PAGE_PATH . "/templates/navbar.php";
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link rel="stylesheet" href="/public/css/profile.css" />
    <link rel="stylesheet" href="/public/css/home.css" />
    <link rel="stylesheet" href="/public/css/shared.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
</head>

<body>
  <div class="layout">
    <?php
      echo Navbar();
    ?>
    <div>
      <div class="box-iden" id="box">
          <div class="iden">
                  <img src="/public/assets/kajuha.jpg" alt="" class="fotoprofil">
                  <div class="kolom">
                      <p id="namaprofile"></p>
                      <p id="username"></p>
                  </div>
          </div>
      </div>
      <div id="list-post">
      </div>
    </div>
  </div>
    <script src="/public/js/post.js"></script>
    <script src="/public/js/profile.js"></script>
</body>
</html>