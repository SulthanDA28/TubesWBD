function showposts(owner_id=null) {
    const xhr = new XMLHttpRequest();
    let url = '/api/getpost/0';
    if(owner_id !== null) {
        url = url.concat("?owner_id=", owner_id);
    }

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
                    var totalpost = response.data.count;
                    var totalPage = Math.ceil(totalpost/10);
                    createPost(response.data.data,totalPage,1,owner_id);
                }
            } else {
                console.error('Gagal melakukan permintaan');
            }
        }
    };
    xhr.send();
}

function createPost(data,totalsemuapage,pagenow,owner_id=null){
    const post = document.getElementById('list-post');
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

        const isitext = document.createElement('p');
        isitext.textContent = element.body;
        isitext.classList.add('isitext');
        isitext.addEventListener('click',function(){gotoPost(element.post_id,element.username)});
        box.appendChild(isitext);
        var pathToRemove = "/var/www/html";
        var path = element.path;
        if(path!=null){
            let gettype = element.path
            let type = gettype.split('.').pop();
            path = path.replace(pathToRemove, '');
            // console.log(path);
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
        const logolike = document.createElement('i');
        logolike.classList.add('fas','fa-thumbs-up');
        const like = document.createElement('button');
        like.classList.add('like-button');
        like.addEventListener('click',function(){likeId(element.post_id,element.id)});
        like.appendChild(logolike);
        const buatbutton = document.createElement('div');
        buatbutton.classList.add('button-container');
        buatbutton.appendChild(like);
        box.appendChild(buatbutton);
        post.appendChild(box);
    });
    const list = document.createElement('ul');
    const pagination = document.createElement('div');
    pagination.classList.add('pagination');
    pagination.appendChild(list);
    post.appendChild(pagination);
    makePagination(totalsemuapage,pagenow,owner_id);
}
function gotoPost(postid,ownerid){
    console.log(postid,"post");
    const xhr = new XMLHttpRequest();
    const url = '/api/clickpost';
    xhr.open('PUT', url, true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4) {
        if (xhr.status === 200) {
            const response = JSON.parse(xhr.responseText);
            if(response.status==="error"){
                console.log(response);
                alert("Failed to go to post reply");
            }
            else if(response.status==="success"){
                console.log(response);
            }
        } else {
            console.error('Gagal melakukan permintaan');
        }
        }
    };
    xhr.send(`post_id=${encodeURIComponent(postid)}&owner_id=${encodeURIComponent(ownerid)}`);
    window.location.href = "/post/"+ownerid+"/"+postid;
}
function gotoProfile(userid){
    console.log(userid,"user");
    window.location.href = "/profiles/"+userid;
}
function likeId(postid,userid){
    console.log("like",postid);
    const xhr = new XMLHttpRequest();
    const url = '/api/like';
    xhr.open('POST', url, true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4) {
        if (xhr.status === 200) {
            const response = JSON.parse(xhr.responseText);
            if(response.status==="failed"){
                alert("Already like post");
            }
            else if(response.status==="success"){
                console.log(response);
                alert("Like post success");
            }
        } else {
            console.error('Gagal melakukan permintaan');
        }
        }
    };
    xhr.send(`post_id=${encodeURIComponent(postid)}&owner=${encodeURIComponent(userid)}`);
}

function makePagination(totalPages,page,owner_id=null){
    console.log(page);
    const ulTag = document.querySelector('ul');
    let liTag = '';
    if(totalPages===0){
        liTag+=`<p class="kosong">Belum ada post</p>`
    }
    else{
        let activeLi;
        let beforePage = page - 1;
        let afterPage = page + 1;
        if(page>1){
            liTag += `<li class="btn prev" onclick="klikPagination(${totalPages},${page-1},${owner_id})"><span><i class="fas fa-angle-left"></i>< Prev</span></li>`;
        }
        if(page>2){
            liTag+=`<li class="numb" onclick="klikPagination(${totalPages},1,${owner_id})"><span>1</span></li>`
            if(page>3){
                liTag+=`<li class="dots"><span>...</span></li>`
            }
        }
        for (let i=beforePage;i<=afterPage;i++){
            if(i>totalPages){
                continue;
            }
            if(i==0){
                i=1
            }

            if(page==i){
                activeLi = "active";
            }
            else{
                activeLi = "";
            }
            liTag+=`<li class="numb ${activeLi}" onclick="klikPagination(${totalPages},${i},${owner_id})"><span>${i}</span></li>`
        }
        if(page<totalPages-1){
            if(page<totalPages-2){
                liTag+=`<li class="dots"><span>...</span></li>`
            }
            liTag+=`<li class="numb" onclick="klikPagination(${totalPages},${totalPages},${owner_id})"><span>${totalPages}</span></li>`
        }
        if(page < totalPages){
            liTag += `<li class="btn next" onclick="klikPagination(${totalPages},${page+1},${owner_id})"><span>Next ><i class="fas fa-angle-right"></i></span></li>`;
        }
    }
    ulTag.innerHTML = liTag;
}

function klikPagination(totalPages,page,owner_id=null){
    makePagination(totalPages,page,owner_id);
    changePage(page,owner_id);
}

function changePage(page,owner_id=null){
    const xhr = new XMLHttpRequest();
    var getpage = (page-1);
    var url = '/api/getpost/'+getpage.toString();
    if(owner_id !== null) {
        url = url.concat("?owner_id=", owner_id);
    }

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
                const box = document.querySelectorAll('.box');
                box.forEach(function(e){
                    e.remove();
                });
                const pagination = document.querySelectorAll('.pagination');
                pagination.forEach(function(e){
                    e.remove();
                });
                var totalpost = response.data.count;
                var totalPage = Math.ceil(totalpost/10);
                createPost(response.data.data,totalPage,page,owner_id);
            }
        } else {
            console.error('Gagal melakukan permintaan');
        }
        }
    };
    xhr.send();
}