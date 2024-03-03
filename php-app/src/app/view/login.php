<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" type='text/css' href="/public/css/login.css">
</head>
<body>
    
    <div class="tepi">
        <div class="isi-box login">
            <h2>
                Login
            </h2>
            <div>
                <div class="input-box">
                    <span class="icon">
                        <ion-icon name="people-outline"></ion-icon>
                    </span>
                    <input type="text" required id="username">
                    <label >Username</label>
                </div>
                <div class="input-box">
                    <span class="icon">
                        <ion-icon name="lock-closed-outline"></ion-icon>
                    </span>
                    <input type="password" required id="password">
                    <label >Password</label>
                </div>
                <button type="submit" class="tmbllogin" id="tmblbuatlogin">
                    Login
                </button>
                <div class="register">
                    <p>Don't have account?<a href="#" class="register-link">Register</a></p>
                </div>
            </div>
        </div>
        <div class="isi-box register">
            <h2>
                Register
            </h2>
            <div>
                <div class="input-box">
                    <span class="icon">
                        <ion-icon name="text-outline"></ion-icon>
                    </span>
                    <input type="text" required id="namareg">
                    <label >Name</label>
                </div>
                <div class="input-box">
                    <span class="icon">
                        <ion-icon name="people-outline"></ion-icon>
                    </span>
                    <input type="text" required id="userreg">
                    <label >Username</label>
                </div>
                <div class="input-box">
                    <span class="icon">
                        <ion-icon name="lock-closed-outline"></ion-icon>
                    </span>
                    <input type="password" required id="passreg">
                    <label >Password</label>
                </div>
                <button type="submit" class="tmbllogin" id="tmblreg">
                    Register
                </button>
                <div class="register">
                    <p>Already have account?<a href="#" class="login-link">Login</a></p>
                </div>
            </div>
        </div>

    </div>
    <script src="/public/js/login.js"></script>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>
</html>