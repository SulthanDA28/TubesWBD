<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="/public/css/adminunban.css">
</head>
<body>
    <div class="judul">
        <h1>Admin Page</h1>
        <h1>Daftar User</h1>
    </div>
    <div class="opsi">
        Opsi Search
    </div>
    <div class="dropdowntempat">
        <select id="dropdown" name="selectedOption">
            <option value="username">Username</option>
            <option value="name">Profile Name</option>
        </select>
    </div>
    <div class="dropdowntempat">
        <select id="sort" name="selectedOption">
            <option value="naik">Menaik</option>
            <option value="turun">Menurun</option>
        </select>
    </div>
    <div class="tmbltoban">
        <input type="text" class="inputnama" id="searchtext"placeholder="Search...">
    </div>
    <div class="tmbltoban">
        <button class="tmbltobaned" id="search">Search</button>
    </div>
    <div class="isikotak">
        <div id="unban" class="input">
            <div class="nam">
                Daftar User yang Telah di Banned
            </div>
            <div id="person-list-unban">
            </div>
        </div>
    </div>
    <div class="tmbltoban">
        <button class="tmbltobaned" id="tmbltobaned"">Kembali</button>
    </div>
    <script src="/public/js/adminunban.js"></script>
</body>
</html>