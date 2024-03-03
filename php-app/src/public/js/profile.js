const namaprofile = document.getElementById('namaprofile');
const username = document.getElementById('username');


let currUrl = window.location.href;
let splitUrl = currUrl.split('/');
if(splitUrl[splitUrl.length-1] == "profiles"){
    const xhr = new XMLHttpRequest();
    xhr.open('GET', '/api/profile');
    xhr.setRequestHeader('Content-type', 'application/json');
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4) {
        if (xhr.status === 200) {
            const response = JSON.parse(xhr.responseText);
            if(response.status==="failed"){
                alert(response.message);
            }
            else{
                namaprofile.textContent = response.data.profile_name;
                username.textContent = "@"+response.data.username;
                
                // show posts of the user to the page
                const profile_id = response.data.id;
                showposts(profile_id);
            }
        } else {
            console.error('Gagal melakukan permintaan');
        }
        }
    };
    xhr.send();
}
else{
    let id = splitUrl[splitUrl.length-1];
    const xhr = new XMLHttpRequest();
    xhr.open('GET', '/api/profileuser/'+id);
    xhr.setRequestHeader('Content-type', 'application/json');
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4) {
        if (xhr.status === 200) {
            const response = JSON.parse(xhr.responseText);
            console.log(response);
            if(response.status==="success2"){
                namaprofile.textContent = response.data.profile_name;
                username.textContent = "@"+response.data.username;
                const buttonfollow = document.createElement('button');
                buttonfollow.classList.add('buttonfollow');
                buttonfollow.textContent = "Follow";
                buttonfollow.addEventListener('click', function(){
                    follow(id);
                });
                const box = document.getElementById('box');
                box.appendChild(buttonfollow);
                
                // show posts of the user to the page
                const profile_id = id;
                showposts(profile_id);
            }
            else if(response.status==="success"){
                namaprofile.textContent = response.data.profile_name;
                username.textContent = "@"+response.data.username;
                const buttonfollow = document.createElement('button');
                buttonfollow.classList.add('buttonunfollow');
                buttonfollow.textContent = "Unfollow";
                buttonfollow.addEventListener('click', function(){
                    unfollow(id);
                });
                const box = document.getElementById('box');
                box.appendChild(buttonfollow);
                
                // show posts of the user to the page
                const profile_id = id;
                showposts(profile_id);
            }
            else if(response.status==="success3"){
                window.location.href = '/profiles';
            }
            else{
                window.location.href = '/';
            }
        } else {
            console.error('Gagal melakukan permintaan');
        }
        }
    };
    xhr.send();
}

function follow(id){
    const xhr = new XMLHttpRequest();
    xhr.open('POST', '/api/follow');
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4) {
        if (xhr.status === 200) {
            const response = JSON.parse(xhr.responseText);
            if(response.status==="failed"){
                alert(response.message);
            }
            else{
                alert(response.message);
                window.location.reload();
            }
        } else {
            console.error('Gagal melakukan permintaan');
        }
        }
    };
    xhr.send(`userid=${encodeURIComponent(id)}`);
}

function unfollow(id){
    const xhr = new XMLHttpRequest();
    xhr.open('DELETE', '/api/unfollow');
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4) {
        if (xhr.status === 200) {
            const response = JSON.parse(xhr.responseText);
            if(response.status==="failed"){
                alert(response.message);
            }
            else{
                alert(response.message);
                window.location.reload();
            }
        } else {
            console.error('Gagal melakukan permintaan');
        }
        }
    };
    xhr.send(`userid=${encodeURIComponent(id)}`);
}