
function createPersonListunban(data) {
    const personList = document.getElementById("person-list-unban");
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
        printButton.textContent = "Unban";
        printButton.addEventListener("click", () => {
            unbanId(person.id);
        });

        personDiv.appendChild(nameSpan);
        personDiv.appendChild(username);
        personDiv.appendChild(printButton);
        personList.appendChild(personDiv);
    });
}
function unbanId(personId) {
    const xhr = new XMLHttpRequest();
        const url = 'http://localhost:8008/api/unban';
        
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
            createPersonListunban(response.ban);
        }
    } else {
        console.error('Gagal melakukan permintaan');
    }
    }
};
xhr.send();

document.getElementById('tmbltobaned').addEventListener('click', function() {
    window.location.href = "/admin/*";
});
const valuedropdown = document.querySelector('#dropdown');
const search = document.querySelector('#searchtext');
const valuesort = document.querySelector('#sort');
document.getElementById('search').addEventListener('click', function() {
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
                            response.ban.sort(function(a, b){return a.id - b.id});
                        }
                        else if(valuesort.value==="turun"){
                            response.ban.sort(function(a, b){return b.id - a.id});
                        }
                        var hapus = document.querySelectorAll(".person");
                        hapus.forEach(function(e){
                            e.remove();
                        });
                        createPersonListunban(response.ban);
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
                            response.ban.sort(function(a, b){return a.id - b.id});
                        }
                        else if(valuesort.value==="turun"){
                            response.ban.sort(function(a, b){return b.id - a.id});
                        }
                        let ambil = [];
                        for(let i=0;i<response.ban.length;i++){
                            var regex = new RegExp(`.*${search.value}.*`);
                            if(regex.test(response.ban[i].username)){
                                ambil.push(response.ban[i]);
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
                            createPersonListunban(ambil);
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
                            response.ban.sort(function(a, b){return a.id - b.id});
                        }
                        else if(valuesort.value==="turun"){
                            response.ban.sort(function(a, b){return b.id - a.id});
                        }
                        var hapus = document.querySelectorAll(".person");
                        hapus.forEach(function(e){
                            e.remove();
                        });
                        createPersonListunban(response.ban);
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
                            response.ban.sort(function(a, b){return a.id - b.id});
                        }
                        else if(valuesort.value==="turun"){
                            response.ban.sort(function(a, b){return b.id - a.id});
                        }
                        let ambil = [];
                        for(let i=0;i<response.ban.length;i++){
                            var regex = new RegExp(`.*${search.value}.*`);
                            if(regex.test(response.ban[i].profile_name)){
                                console.log(response.ban[i].profile_name);
                                ambil.push(response.ban[i]);
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
                            createPersonListunban(ambil);
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