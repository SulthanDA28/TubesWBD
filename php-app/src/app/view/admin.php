<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="/public/css/admin.css">
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
        <div id="ban" class="input">
            <div class="nam">
                Daftar User yang Unbanned
            </div>
            <div id="person-list">
            </div>
        </div>
    </div>
    <div class="tmbltoban">
        <button class="tmbltobaned" id="tmbltobaned"">Unban</button>
    </div>
    <div class="tmbltoban">
        <button class="tmbltologout" id="logout"">Logout</button>
    </div>
    <script src="/public/js/admin.js"></script>
</body>
</html>