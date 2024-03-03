

// Fungsi untuk membuat daftar orang dari data JSON
function createPersonList(data) {
    const personList = document.getElementById("person-list");
    data.forEach((person) => {
        const personDiv = document.createElement("div");
        personDiv.classList.add("person");

        const nameSpan = document.createElement("span");
        nameSpan.textContent = person.profile_name;
        nameSpan.classList.add("name");

        const username = document.createElement("span");
        username.textContent = "Username : " + person.username;
        username.classList.add("username");

        const printButton = document.createElement("button");
        printButton.textContent = "Ban";
        printButton.addEventListener("click", () => {
            banId(person.id);
        });

        const deleteButton = document.createElement("button");
        deleteButton.textContent = "Delete";
        deleteButton.addEventListener("click", () => {
            deleteId(person.id);
        });

        personDiv.appendChild(nameSpan);
        personDiv.appendChild(username);
        personDiv.appendChild(printButton);
        personDiv.appendChild(deleteButton);
        personList.appendChild(personDiv);

    });
}
function banId(personId) {
    const xhr = new XMLHttpRequest();
        const url = 'http://localhost:8008/api/ban';
        
        xhr.open('PUT', url, true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        
        xhr.onreadystatechange = function () {
          if (xhr.readyState === 4) {
            if (xhr.status === 200) {
                const response = JSON.parse(xhr.responseText);
                alert(response.message);
                window.location.reload();
            } else {
                console.error('Gagal melakukan permintaan');
            }
          }
        };
        
        const formData = `id=${encodeURIComponent(personId)}`;
        xhr.send(formData);
}
function deleteId(personId) {
    const xhr = new XMLHttpRequest();
    const url = 'http://localhost:8008/api/deleteuser';
    
    xhr.open('DELETE', url, true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4) {
        if (xhr.status === 200) {
            const response = JSON.parse(xhr.responseText);
            alert(response.message);
            window.location.reload();
        } else {
            console.error('Gagal melakukan permintaan');
        }
        }
    };
    
    const formData = `id=${encodeURIComponent(personId)}`;
    xhr.send(formData);
    
}
const xhr = new XMLHttpRequest();
const url = 'http://localhost:8008/api/admin';

xhr.open('GET', url, true);
xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

xhr.onreadystatechange = function () {
    if (xhr.readyState === 4) {
    if (xhr.status === 200) {
        const response = JSON.parse(xhr.responseText);
        if(response.status==="error"){
            alert(response.message);
        }
        else if(response.status==="sukses"){
            console.log(response);
            createPersonList(response.unban);
        }
    } else {
        console.error('Gagal melakukan permintaan');
    }
    }
};
xhr.send();

document.getElementById('tmbltobaned').addEventListener('click', function() {
    window.location.href = "/admin/unban/*";
});
document.getElementById('logout').addEventListener('click', function() {
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
    window.location.href = "/login";
});
const valuedropdown = document.querySelector('#dropdown');
const search = document.querySelector('#searchtext');
const valuesort = document.querySelector('#sort');
document.getElementById('search').addEventListener('click', function() {
    console.log(valuesort.value);
    if(valuedropdown.value==="username"){
        if(search.value===""){
            const xhr = new XMLHttpRequest();
            const url = 'http://localhost:8008/api/admin';

            xhr.open('GET', url, true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4) {
                if (xhr.status === 200) {
                    const response = JSON.parse(xhr.responseText);
                    if(response.status==="error"){
                        alert(response.message);
                    }
                    else if(response.status==="sukses"){
                        console.log(response);
                        if(valuesort.value==="naik"){
                            //id
                            response.unban.sort(function(a, b){return a.id - b.id});
                        }
                        else if(valuesort.value==="turun"){
                            response.unban.sort(function(a, b){return b.id - a.id});
                        }
                        var hapus = document.querySelectorAll(".person");
                        hapus.forEach(function(e){
                            e.remove();
                        });
                        createPersonList(response.unban);
                    }
                } else {
                    console.error('Gagal melakukan permintaan');
                }
                }
            };
            xhr.send();
        }
        else
        {
            const xhr = new XMLHttpRequest();
            const url = 'http://localhost:8008/api/admin';

            xhr.open('GET', url, true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4) {
                if (xhr.status === 200) {
                    const response = JSON.parse(xhr.responseText);
                    if(response.status==="error"){
                        alert(response.message);
                    }
                    else if(response.status==="sukses"){
                        // console.log(response);
                        if(valuesort.value==="naik"){
                            //id
                            response.unban.sort(function(a, b){return a.id - b.id});
                        }
                        else if(valuesort.value==="turun"){
                            response.unban.sort(function(a, b){return b.id - a.id});
                        }
                        let ambil = [];
                        for(let i=0;i<response.unban.length;i++){
                            var regex = new RegExp(`.*${search.value}.*`);
                            if(regex.test(response.unban[i].username)){
                                ambil.push(response.unban[i]);
                            }
                        }
                        if(ambil.length===0){
                            alert("Username tidak ditemukan");
                        }
                        else{
                            console.log(ambil);
                            var hapus = document.querySelectorAll(".person");
                            hapus.forEach(function(e){
                                e.remove();
                            });
                            createPersonList(ambil);
                        }
                    }
                } else {
                    console.error('Gagal melakukan permintaan');
                }
                }
            };
            xhr.send();

        }
    }
    else if(valuedropdown.value==="name"){
        if(search.value===""){
            const xhr = new XMLHttpRequest();
            const url = 'http://localhost:8008/api/admin';

            xhr.open('GET', url, true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4) {
                if (xhr.status === 200) {
                    const response = JSON.parse(xhr.responseText);
                    if(response.status==="error"){
                        alert(response.message);
                    }
                    else if(response.status==="sukses"){
                        console.log(response);
                        if(valuesort.value==="naik"){
                            //id
                            response.unban.sort(function(a, b){return a.id - b.id});
                        }
                        else if(valuesort.value==="turun"){
                            response.unban.sort(function(a, b){return b.id - a.id});
                        }
                        var hapus = document.querySelectorAll(".person");
                        hapus.forEach(function(e){
                            e.remove();
                        });
                        createPersonList(response.unban);
                    }
                } else {
                    console.error('Gagal melakukan permintaan');
                }
                }
            };
            xhr.send();
        }
        else{
            const xhr = new XMLHttpRequest();
            const url = 'http://localhost:8008/api/admin';

            xhr.open('GET', url, true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4) {
                if (xhr.status === 200) {
                    const response = JSON.parse(xhr.responseText);
                    if(response.status==="error"){
                        alert(response.message);
                    }
                    else if(response.status==="sukses"){
                        // console.log(response);
                        if(valuesort.value==="naik"){
                            //id
                            response.unban.sort(function(a, b){return a.id - b.id});
                        }
                        else if(valuesort.value==="turun"){
                            response.unban.sort(function(a, b){return b.id - a.id});
                        }
                        let ambil = [];
                        for(let i=0;i<response.unban.length;i++){
                            var regex = new RegExp(`.*${search.value}.*`);
                            if(regex.test(response.unban[i].profile_name)){
                                console.log(response.unban[i].profile_name);
                                ambil.push(response.unban[i]);
                            }
                        }
                        if(ambil.length===0){
                            alert("Nama tidak ditemukan");
                        }
                        else{
                            console.log(ambil);
                            var hapus = document.querySelectorAll(".person");
                            hapus.forEach(function(e){
                                e.remove();
                            });
                            createPersonList(ambil);
                        }
                    }
                } else {
                    console.error('Gagal melakukan permintaan');
                }
                }
            };
            xhr.send();
        }

    }
}
);