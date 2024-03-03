<?php
require_once PAGE_PATH . "/templates/navbar.php";
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="/public/css/home.css" />
    <link rel="stylesheet" href="/public/css/shared.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
</head>

<body>
  <div class="layout">
    <?php
      echo Navbar();
    ?>
    <div id="list-post">
    </div>
  </div>
    <script src="/public/js/post.js"></script>
    <script src="/public/js/home.js"></script>
</body>
</html>