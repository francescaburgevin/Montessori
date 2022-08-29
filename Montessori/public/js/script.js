const showMenu = () => {
    document.querySelector('.toggle-menu').classList.toggle('show-menu');
    document.querySelector('.menu-bar').classList.toggle('hide-bars');
}

const showAddForm = () => {
    document.querySelector('.add-feed-template').classList.toggle('show');
    document.getElementById('add-feed-btn').classList.toggle('hide');
}

const cancelAddForm = () => {
    document.querySelector('.add-feed-template').classList.remove('show');
    document.getElementById('add-feed-btn').classList.remove('hide');
}

const showEditForm = (e) => {
    console.log(e);
    const feedId = e.dataset.id;
    console.log(document.querySelector("#modal-edit"));
    document.querySelector("#modal-edit").classList.toggle("show");
    
    let request = new XMLHttpRequest();
    request.open("GET", "/Montessori/template/feed/xml/edit.php");
    request.onload = function(){
        let feedDetails = JSON.parse(request.responseText);
    };
    request.send();
}

const cancelEditForm = () => {
    document.querySelector('.edit-feed-template').classList.remove('show');
    document.getElementById('edit-feed-btn').classList.remove('hide');
}



const previous = () => {
    let activeSlide = document.querySelector(".active");
    const idValue = activeSlide.id;
    activeSlide.classList.toggle("active");
    if(idValue==1){ document.getElementById("3").classList.add("active"); }
    if(idValue==2){ document.getElementById("1").classList.add("active"); }
    if(idValue==3){ document.getElementById("2").classList.add("active"); }
    activeSlide="";
}

const next = () => {
    const activeSlide = document.querySelector(".active");
    const idValue = activeSlide.id;
    activeSlide.classList.toggle("active");
    if(idValue==1){ document.getElementById("2").classList.add("active"); }
    if(idValue==2){ document.getElementById("3").classList.add("active"); }
    if(idValue==3){ document.getElementById("1").classList.add("active"); }
}


document.addEventListener("DOMContentLoaded", () =>{
    console.log(`javascript is active`);
    
    document.querySelector('.toggle-wrap').addEventListener('click', showMenu);
    
    if(document.getElementById("add-feed-btn")){
        document.getElementById("add-feed-btn").addEventListener('click', showAddForm);
        document.getElementById("add-form-cancel").addEventListener('click', cancelAddForm);
    
    document.querySelectorAll(".btn-edit").forEach((element) => {
        element.addEventListener("click", () => showEditForm(element));
        });
    }
    
    
 
    if(document.querySelector(".carousel-previous")){
        document.querySelector(".carousel-previous").addEventListener("click", previous);
        document.querySelector(".carousel-next").addEventListener("click", next);
        
        const intervalId = window.setInterval(next, 8000);
        
        document.getElementById("home-carousel").addEventListener('mouseenter', ()=>{
            window.clearInterval(intervalId);
        })
        
        document.getElementById("home-carousel").addEventListener('mouseleave', ()=>{
            window.setInterval(next, 8000);
        })
    }
    
    
})



