function myFunction() {
    var x = document.getElementById("resp-dashboard");
    if (x.className === "dashboard") {
        x.className += " responsive";
    } else {
        x.className = "dashboard";
    }
}

/*------------------------------------------- Add Vehicle Modal -------------------------------------------------*/
//Get the modal
var modal = document.getElementById("VModalPop");

//Get the button tat open the modal
var btn = document.getElementById("btn-add");

//Get the <Span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

//When the user clicks on the button, open the modal
btn.onclick = function() {
    modal.style.display = "block";
}

//When the user clicks on <span> (x), close the modal
span.onclick = function(){
    modal.style.display = "none";
}

//When the user clicks anywhere outside of the modal, close it
window.onclick = function(event){
    if(event.target == modal){
        modal.style.display = "none";
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

