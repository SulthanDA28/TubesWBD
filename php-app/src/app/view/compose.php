<?php
    require_once PAGE_PATH . "/templates/navbar.php"
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="/public/css/compose.css">
    <link rel="stylesheet" href="/public/css/shared.css" />
    <link href="https://fonts.googleapis.com/css?family=Rubik" rel="stylesheet">
    <title>Post Page</title>
</head>

<body>
    <div class="layout">
        <?php
            echo Navbar();
        ?>
        <section id="overlay">
            <img src="/public/assets/Logo.png" alt="Kicau Logo" id="logo">
            <hr>
            <form enctype="multipart/form-data" action="create" method="POST">
                <h1>Create a post!</h1>
                <section class="post_body">
                    <label for="post_body">Type in the box below:</label>
                    <br>
                    <textarea id="post_body" name="post_body" rows="15" cols="70"></textarea>
                </section>
                <br>

                <section class="file">
                    <label for="file_input">Select a file:</label>
                    <input type="file" id="file_input" name="file_input">
                </section>
                <hr>

                <section class="submission">
                    <input type="submit" id="btn-post" value="Post">
                </section>
            </form>
        </section>
    </div>
</body>

</html>