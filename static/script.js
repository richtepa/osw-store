function toggleSignInUp() {
    document.getElementById("signInUp-dialog").classList.toggle("invisible")
}

function toggleUpload() {
    document.getElementById("upload-dialog").classList.toggle("invisible")
}

function vote(user, title, callback){
    url = "/vote?uid=" + user + "&title=" + title;
    var xmlHttp = new XMLHttpRequest();
    xmlHttp.onreadystatechange = function() { 
        if (xmlHttp.readyState == 4 && xmlHttp.status == 200){
            location.reload();
        }
    }
    xmlHttp.open("GET", url, true);
    xmlHttp.send(null);
}

window.onload = function(){
    for(el of document.getElementsByClassName("heart")){
        el.addEventListener("click", function(){
            item = this.getAttribute("item").split("/");
            vote(item[0], item[1]);
        });
    }
}
