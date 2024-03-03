<?php
require_once PAGE_PATH . "/templates/navbar.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="/public/css/home.css" />
    <link rel="stylesheet" href="/public/css/shared.css" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
</head>
<body>
    <div class="layout">
    <?php
      echo Navbar();
    ?>
    <div class="gridcontent">
      <div id="content" class="box">
      </div>
      <div class="input-reply">
          <input type="text" id="reply" placeholder="Reply" class="input-reply-text">
          <button id="reply-button" class="reply-button">Reply</button>
      </div>
      <div id="list-reply">
      </div>
    </div>
  </div>
    <script src="/public/js/reply.js"></script>
</body>
</html>