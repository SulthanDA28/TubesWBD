let currUrl = window.location.href;
currUrl = currUrl.split('/');
postid = currUrl[currUrl.length-1];
ownerid = currUrl[currUrl.length-2];
function makePostID(element){
    const box = document.getElementById('content');
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
    identitas.addEventListener('click',function(){window.location.href = '/profiles/'+ownerid});
    identitas.appendChild(fotoprofile);
    identitas.appendChild(simpanidentitas);
    box.appendChild(identitas);

    const isitext = document.createElement('p');
    isitext.textContent = element.body;
    isitext.classList.add('isitext-post');
    box.appendChild(isitext);
    var pathToRemove = "/var/www/html";
    var path = element.path;
    if(path!=null){
        let gettype = element.path
        let type = gettype.split('.').pop();
        path = path.replace(pathToRemove, '');
        console.log(path);
        if(type=='jpg' || type=='jpeg' || type=='png'){
            const isifoto = document.createElement('img');
            isifoto.src = path;
            isifoto.classList.add('foto');
            box.appendChild(isifoto);
        }
        else if(type=='mp4'){
            const isivideo = document.createElement('video');
            isivideo.src = path;
            isivideo.classList.add('video');
            isivideo.controls = true;
            box.appendChild(isivideo);
        }
        else if(type=='mp3'){
            const isiaudio = document.createElement('audio');
            isiaudio.src = path;
            isiaudio.classList.add('audio');
            isiaudio.controls = true;
            box.appendChild(isiaudio);
        }
    }
}
function makeReply(element){
    const box = document.createElement('div');
    box.classList.add('box');

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
    identitas.addEventListener('click',function(){window.location.href = '/profiles/'+element.id});
    identitas.appendChild(fotoprofile);
    identitas.appendChild(simpanidentitas);
    box.appendChild(identitas);

    const isitext = document.createElement('p');
    isitext.textContent = element.body;
    isitext.classList.add('isitext-post');
    box.appendChild(isitext);
    var pathToRemove = "/var/www/html";
    var path = element.path;
    if(path!=null){
        let gettype = element.path
        let type = gettype.split('.').pop();
        path = path.replace(pathToRemove, '');
        console.log(path);
        if(type=='jpg' || type=='jpeg' || type=='png'){
            const isifoto = document.createElement('img');
            isifoto.src = path;
            isifoto.classList.add('foto');
            box.appendChild(isifoto);
        }
        else if(type=='mp4'){
            const isivideo = document.createElement('video');
            isivideo.src = path;
            isivideo.classList.add('video');
            isivideo.controls = true;
            box.appendChild(isivideo);
        }
        else if(type=='mp3'){
            const isiaudio = document.createElement('audio');
            isiaudio.src = path;
            isiaudio.classList.add('audio');
            isiaudio.controls = true;
            box.appendChild(isiaudio);
        }
    }
    const listreply = document.getElementById('list-reply');
    listreply.appendChild(box);
}

const xhr = new XMLHttpRequest();
const url = '/api/getpostid/'+ownerid+'/'+postid;
xhr.open('GET',url,true);
xhr.setRequestHeader('Content-Type','application/json');
xhr.onreadystatechange = function () {
    if (xhr.readyState === 4) {
    if (xhr.status === 200) {
        const response = JSON.parse(xhr.responseText);
        if(response.status==="error"){
            alert(response.message);
        }
        // console.log(response);
        makePostID(response);
    } else {
        console.error('Gagal melakukan permintaan');
    }
    }
};
xhr.send();

const inputreply = document.getElementById('reply');
const buttonreply = document.getElementById('reply-button');
buttonreply.addEventListener('click',function(){
    const valuereply = inputreply.value;
    let regex = /^\s/;
    if(valuereply==="" || regex.test(valuereply)){
        alert("Reply tidak boleh kosong atau hanya spasi");
    }
    else if(valuereply!==""){
        let url = '/api/reply/'+ownerid+'/'+postid;
        console.log(valuereply);
        let xhr = new XMLHttpRequest();
        xhr.open('POST',url,true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4) {
            if (xhr.status === 200) {
                const response = JSON.parse(xhr.responseText);
                if(response.status==="failed"){
                    alert(response.message);
                }
                else{
                    window.location.reload();
                }
            } else {
                console.error('Gagal melakukan permintaan');
            }
            }
        };
        xhr.send(`body=${encodeURIComponent(valuereply)}`);
    }
});

const xhr2 = new XMLHttpRequest();
const url2 = '/api/getreply/'+ownerid+'/'+postid;
xhr2.open('GET',url2,true);
xhr2.setRequestHeader('Content-Type','application/json');
xhr2.onreadystatechange = function () {
    if (xhr2.readyState === 4) {
    if (xhr2.status === 200) {
        const response = JSON.parse(xhr2.responseText);
        console.log(response);
        if(response.status==="error"){
            alert(response.message);
        }
        // console.log(response);
        if(response.status!=="kosong"){
            response.forEach(element => {
                makeReply(element);
            });
        }
    } else {
        console.error('Gagal melakukan permintaan');
    }
    }
};
xhr2.send();
