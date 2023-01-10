function myFunction() {
    var x = document.getElementById("resp-dashboard");
    if (x.className === "dashboard") {
        x.className += " responsive";
    } else {
        x.className = "dashboard";
    }
}


var coll = document.getElementsByClassName("collapsible");
var i;

for(i = 0; i < coll.length; i++){
    coll[i].addEventListener("click",function(){
        this.classList.toggle("active");
        var content = this.nextElementSibling;
        if(content.style.maxHeight){
            content.style.maxHeight = null;
        }else{
            content.style.maxHeight = content.scrollHeight + "px";
        }
    });
}

