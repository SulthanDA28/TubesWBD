const tepi = document.querySelector('.tepi');
const login = document.querySelector('.login-link');
const register = document.querySelector('.register-link');

register.addEventListener('click', () => {
  tepi.classList.add('ganti');
}
);

login.addEventListener('click', () => {
    tepi.classList.remove('ganti');
    }
);

document.getElementById('tmblbuatlogin').addEventListener('click', function() {
    var usernameambil = document.getElementById('username').value;
    var passwordambil = document.getElementById('password').value;
    if(usernameambil==="" || passwordambil===""){
        alert("Username atau password tidak boleh kosong");
    }
    else{
        const xhr = new XMLHttpRequest();
        const url = 'http://localhost:8008/api/login';
        const username = usernameambil;
        const password = passwordambil;
        
        xhr.open('POST', url, true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        
        xhr.onreadystatechange = function () {
          if (xhr.readyState === 4) {
            if (xhr.status === 200) {
              const response = JSON.parse(xhr.responseText);
                if(response.status==="error"){
                    alert(response.message);
                }
                else if(response.status==="sukses"){
                    if(response.role==="admin"){
                        window.location.href = "/admin/*";//nanti diganti
                    }
                    else if(response.role==="user"){
                        if(response.statusakses==="ban"){
                            alert("Akun anda telah diblokir oleh admin");
                        }
                        else
                        {
                            window.location.href = "/";
                        }
                    }
                }
            } else {
              console.error('Gagal melakukan permintaan');
            }
          }
        };
        
        const formData = `username=${encodeURIComponent(username)}&password=${encodeURIComponent(password)}`;
        xhr.send(formData);
        
    }
    
});
document.getElementById('tmblreg').addEventListener('click', function() {
    var userreg = document.getElementById('userreg').value;
    var passreg = document.getElementById('passreg').value;
    var namareg = document.getElementById('namareg').value;
    var regex = /^\S+$/;
    if(userreg==="" || passreg==="" || namareg===""){
        alert("Username, password, atau nama tidak boleh kosong");
    }
    else  if(regex.test(userreg)===false || regex.test(passreg)===false){
        alert("Username atau password tidak boleh mengandung spasi");
    }
    else if(userreg.length<5 || passreg.length<5){
        alert("Username atau password minimal 5 karakter");
    }
    else{
        const xhr = new XMLHttpRequest();
        const url = 'http://localhost:8008/api/register';
        const username = userreg;
        const password = passreg;
        const nama = namareg;
        
        xhr.open('POST', url, true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        
        xhr.onreadystatechange = function () {
          if (xhr.readyState === 4) {
            if (xhr.status === 200) {
                const response = JSON.parse(xhr.responseText);
                if(response.status==="error"){
                    alert(response.message);
                }
                else if(response.status==="sukses"){
                    alert(response.message);
                    tepi.classList.remove('ganti');
                }
            } else {
                console.error('Gagal melakukan permintaan');
            }
          }
        };
        
        const formData = `username=${encodeURIComponent(username)}&password=${encodeURIComponent(password)}&nama=${encodeURIComponent(nama)}`;
        xhr.send(formData);
    }   
});

