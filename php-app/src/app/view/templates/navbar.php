<?php

// require_once PROJECT_ROOT_PATH . "/public/templates/UserProfile.php";

function Navbar()
{
//   $userProfile = UserProfile();

  $html = <<<"EOT"
    <div class="layout__left-sidebar">
        <div class="sidebar-menu">
            <img src="/public/assets/Logo.png" class="brand" />
            <a href="/">
                <div class="sidebar-menu__item sidebar-menu__item--active">
                    <img src="/public/assets/home.svg" class="sidebar-menu__item-icon" />
                    Home
                </div>
            </a>
            <a href="/user">
                <div class="sidebar-menu__item sidebar-menu__item--active">
                    <img src="/public/assets/followed.jpg" class="sidebar-menu__item-icon" />
                    User
                </div>
            </a>
            <a href="/profiles">
                <div class="sidebar-menu__item sidebar-menu__item--active">
                    <img src="/public/assets/profile.svg" class="sidebar-menu__item-icon" />
                    Profile
                </div>
            </a>
            <a href="/compose/kicau">
                <div class="sidebar-menu__compose">
                    Post
                </div>
            </a>
            <a href="/login">
                <div class="sidebar-menu__compose_logout" id="logout">
                    Logout
                </div>
            </a>
            <script>
                document.getElementById("logout").addEventListener("click", function() {
                    const xhr = new XMLHttpRequest();
                    const url = 'http://localhost:8008/api/logout';

                    xhr.open('GET', url, true);
                    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

                    xhr.onreadystatechange = function () {
                        if (xhr.readyState === 4) {
                        if (xhr.status === 200) {
                            alert("Berhasil Logout");
                        } else {
                            console.error('Gagal melakukan permintaan');
                        }
                        }
                    };
                    xhr.send();
                });
            </script>
        </div>
    </div>
  EOT;

  return $html;
}
