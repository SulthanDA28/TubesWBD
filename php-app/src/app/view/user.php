<?php
require_once PAGE_PATH . "/templates/navbar.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User</title>
    <link rel="stylesheet" href="/public/css/shared.css" />
    <link rel="stylesheet" href="/public/css/user.css" />
    <link rel="stylesheet" href="/public/css/home.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
</head>
<body>
    <div class="layout">
    <?php
      echo Navbar();
    ?>
    <div class="dropdowntempat">
        <select id="dropdown" name="selectedOption">
            <option value="username">Username</option>
            <option value="name">Profile Name</option>
        </select>
        <div class="input-search">
          <input type="text" id="search" placeholder="Search" class="input-search-text">
          <button id="search-button" class="search-button">Search</button>
      </div>
      <div id="list-user"></div>
    </div>
    </div>
    <script src="/public/js/user.js"></script>
</body>
</html>