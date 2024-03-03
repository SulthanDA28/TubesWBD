const valuedropdown = document.querySelector('#dropdown');
const valuesearch = document.querySelector('#search');
const buttonsearch = document.getElementById('search-button');

function makeListUser(data){
    const listuser = document.getElementById('list-user');
    data.forEach(element => {
        const username =  document.createElement('p');
        username.textContent = "@"+element.username;
        const nama =  document.createElement('p');
        nama.textContent = element.profile_name;

        const simpanidentitas = document.createElement('div');
        simpanidentitas.classList.add('kolom');
        simpanidentitas.appendChild(nama);
        simpanidentitas.appendChild(username);

        const fotoprofile = document.createElement('img');
        fotoprofile.classList.add('fotoprofil');
        if(element.profile_picture_path==null){
            fotoprofile.src = '/public/assets/kajuha.jpg';
        }
        else{
            path = element.profile_picture_path;
            path = path.replace("/var/www/html", '');
            fotoprofile.src = path;
        }

        const identitas = document.createElement('div');
        identitas.classList.add('iden');
        identitas.appendChild(fotoprofile);
        identitas.appendChild(simpanidentitas);
        identitas.addEventListener('click',function(){gotoProfile(element.id)});

        const box = document.createElement('div');
        box.classList.add('box');
        box.appendChild(identitas);
        listuser.appendChild(box);
    });
}
const xhr = new XMLHttpRequest();
xhr.open('GET','/api/getalluser');
xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
xhr.onreadystatechange = function () {
    if (xhr.readyState === 4) {
    if (xhr.status === 200) {
        const response = JSON.parse(xhr.responseText);
        makeListUser(response.data);
    } else {
        console.error('Gagal melakukan permintaan');
    }
    }
};
xhr.send();
buttonsearch.addEventListener('click',function(){
    const xhr = new XMLHttpRequest();
    xhr.open('GET','/api/getalluser');
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4) {
        if (xhr.status === 200) {
            const response = JSON.parse(xhr.responseText);
            let data = response.data
            ambildata = [];
            if(valuedropdown.value=='username'){
                for (let index = 0; index < data.length; index++) {
                    var regex = new RegExp(`.*${valuesearch.value}.*`);
                    if(regex.test(data[index].username)){
                        ambildata.push(data[index]);
                    }
                }
            }
            else if(valuedropdown.value=='name'){
                for (let index = 0; index < data.length; index++) {
                    var regex = new RegExp(`.*${valuesearch.value}.*`);
                    if(regex.test(data[index].profile_name)){
                        ambildata.push(data[index]);
                    }
                }
            }
            var hapus = document.querySelectorAll(".box");
            hapus.forEach(function(e){
                e.remove();
            });
            makeListUser(ambildata);
        } else {
            console.error('Gagal melakukan permintaan');
        }
        }
    };
    xhr.send();

});

function gotoProfile(userid){
    console.log(userid,"user");
    window.location.href = "/profiles/"+userid;
}
