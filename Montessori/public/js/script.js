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

const showDeleteDialog = (element) => {
    document.querySelector(".delete-feed-content").classList.toggle("show");
    console.log(element);
    console.log(element.dataset.feed_id);
    document.querySelector("#action-delete-feed-id").value=element.dataset.feed_id;
}

const cancelDeleteDialog = () => {
    document.querySelector(".delete-feed-content").classList.remove('show');
}

const showEditForm = (e) => {
    document.querySelector(".edit-modal-content").classList.toggle("show");

    let url = "/Montessori/index.php?page=xml_edit";
    let request = new XMLHttpRequest();
    request.responseType = 'json';
    request.onreadystatechange = function(){
        if (this.readyState == 4 && this.status == 200){


            document.querySelector("#action-feed-id").value=this.response.id;
            
            document.querySelector("#edit-existing-image").src = this.response.file_path_image;
            
            if(this.response.image_description){
                document.getElementById("edit-upload-image-description").value = this.response.image_description;
            }
            
            if(this.response.content){
                document.getElementById("edit-content").value = this.response.content;
            }
         
            document.querySelectorAll(".edit-option").forEach((e)=>{
                const value = e.value;
                const response = this.response[0];
                
                if(response.includes( parseInt(value) )){
                    e.setAttribute("selected", true);    
                    console.log(e);
                }
            });
    
            if(this.response.publish_date != null){
                document.getElementById("edit-publish-date").checked = true;
            }
            
        }
    }

    request.open("GET", url+"&feed_id="+e.dataset.feed_id, true);

    request.send();
}

const cancelEditForm = () => {
    document.querySelector(".edit-modal-content").classList.remove('show');
}

const publishComment = (e) => {
    console.log(e);
    console.log(e.dataset.comment_id);
    
    let url = "/Montessori/index.php?page=xml_edit";
    let request = new XMLHttpRequest();
    request.responseType = 'json';
    request.onreadystatechange = function(){
        if (this.readyState == 4 && this.status == 200){


            document.querySelector("#action-feed-id").value=this.response.id;
            
            document.querySelector("#edit-existing-image").src = this.response.file_path_image;
            
            if(this.response.image_description){
                document.getElementById("edit-upload-image-description").value = this.response.image_description;
            }
            
            if(this.response.content){
                document.getElementById("edit-content").value = this.response.content;
            }
         
            document.querySelectorAll(".edit-option").forEach((e)=>{
                const value = e.value;
                const response = this.response[0];
                
                if(response.includes( parseInt(value) )){
                    e.setAttribute("selected", true);    
                    console.log(e);
                }
            });
    
            if(this.response.publish_date != null){
                document.getElementById("edit-publish-date").checked = true;
            }
            
        }
    }

    request.open("GET", url+"&feed_id="+e.dataset.feed_id, true);

    request.send();
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
    
/* FEED PAGE */
    if(document.getElementById("add-feed-btn")){
        document.getElementById("add-feed-btn").addEventListener('click', showAddForm);
        document.getElementById("add-form-cancel").addEventListener('click', cancelAddForm);
        document.querySelector(".edit-form-cancel").addEventListener("click", cancelEditForm);
    
        document.querySelectorAll(".btn-edit").forEach((element) => {
            element.addEventListener("click", () => showEditForm(element));
            });
        
        document.querySelectorAll(".btn-delete").forEach((element) => {
            element.addEventListener("click", () => showDeleteDialog(element));
            });
            
        document.getElementById("delete-feed-close").addEventListener('click', cancelDeleteDialog);
        
        document.querySelectorAll(".btn-edit-publish-comment").forEach((element) => {
            element.addEventListener("click", () => publishComment(element));
            });
    }
    
/* HOME PAGE */
 
    if(document.querySelector(".carousel-buttons")){
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



