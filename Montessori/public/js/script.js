const notAllowed = ["<", ">", "(", ")", "[", "]", "\"", "\'", ";", ":", "\\", "#", "§", "!", "°", "@", "*", "%", "$", "€", "£", "`", "=", "--", "+", "||"];
const notAllowedInEmail = ["<", ">", "(", ")", "[", "]", "\"", ";", ":", "\\", "§", "°", "/*", "@@", "--", "||"];
const notAllowedInTextInput = ["<", ">", "(", ")", "[", "]", ";", "\\", "#", "§", "°", "%", "`", "/*", "==", "--", "+", "||"];

let studentSelected = false;
    
// display side bar navigation menu
const showMenu = () => 
{
    document.querySelector('.toggle-menu').classList.toggle('show-menu');
    document.querySelector('.menu-bar').classList.toggle('hide-bars');
}

// display add new user form on account_administrator.phtml
const showAddUser = () => 
{
    document.querySelector('.display-add-user').classList.toggle('hide');
    document.getElementById('add-user-btn').classList.toggle('hide');
    document.getElementById('add-user-cancel').classList.toggle('hide');
}

// hide add new user form on account_administrator.phtml
const cancelAddUser = () => 
{
    document.getElementById('form-add-user').reset();
    document.getElementById('add-user-cancel').classList.toggle('hide');
    document.querySelector('.display-add-user').classList.toggle('hide');
    document.getElementById('add-user-btn').classList.toggle('hide');
}

// display add new comment to feed on parent/faculty_class_feed.phtml
const showAddFirstComment = (e) =>
{
    document.getElementById(e.dataset.feed_id).classList.toggle("hide");
}

// display add new childe comment to parent comment on __feed_comment.phtml
const showAddFollowingComment = (e) =>
{
    document.getElementById(e.dataset.comment_id).classList.toggle("hide");
}

// display add new feed form on faculty_class_feed.phtml
const showAddForm = () => 
{
    document.querySelector('.add-feed-template').classList.toggle('show');
    document.getElementById('add-feed-btn').classList.toggle('hide');
}

// hide add new feed form on faculty_class_feed.phtml
const cancelAddForm = () => 
{
    document.querySelector('.add-feed-template').classList.remove('show');
    document.getElementById('add-feed-btn').classList.remove('hide');
}

// validate upload image has description on __feed_add.phtml
const imageUploaded = () =>
{
    if( (document.getElementById('upload-image')).value !== null)
    {
        document.getElementById("upload-image-description").focus();
        document.getElementById("upload-image-description").placeholder = "La description est obligatoire.";
    }
}

//validate description has been added on __feed_add.phtml
const checkImgDescription = () =>
{
    if( (document.getElementById('upload-image')).value !== null)
    {
        if(document.getElementById('upload-image-description').value !== null)
        {
            document.getElementById("add-feed-list-students").focus();
        }
    }
}

// validate content, then student list, then permit save on __feed_add.phtml
const checkForContent = () =>
{
    if(document.getElementById('content').value.length !==0)
    {
        //does content include restricted characters ?
        let data = document.getElementById("content").value;
        if(data.length > 0)
        {
            if(notAllowedInTextInput.some(item => data.includes(item)))
            {   
                if(document.getElementById("error_feed_content").classList.contains("hide"))
                {
                    document.getElementById("error_feed_content").classList.toggle("hide");
                }
                document.getElementById("add-feed-submit-btn").setAttribute("disabled", true);
            } else {
                if(!document.getElementById("error_feed_content").classList.contains("hide"))
                {
                    document.getElementById("error_feed_content").classList.toggle("hide");
                }
                if(studentSelected)
                {
                    document.getElementById('add-feed-submit-btn').removeAttribute("disabled");
                }
            }
        }
    }
}

// check that a student has been selected, then permit save on __feed_add.phtml
const checkStudentSelected = () =>
{
    if(document.getElementById('add-feed-list-students')){ studentSelected = true;}
    if(studentSelected)
    {
        if(
            ( (document.getElementById('upload-image').value.length !== 0) &&
            (document.getElementById('upload-image-description').value.length !== 0) ) 
            ||
            (document.getElementById('content').value.length !== 0)
        ){
                document.getElementById('add-feed-submit-btn').removeAttribute("disabled");
        } else {
                document.getElementById('add-feed-submit-btn').setAttribute("disabled", true);
        }
    }    
}

// reset add feed form on __feed_add.phtml
const resetForm = () =>
{
    studentSelected = false;
    document.getElementById('upload-image').value.length = 0;
    document.getElementById('upload-image-description').value.length = 0;
    document.getElementById('content').value.length = 0;
    document.getElementById('add-feed-submit-btn').setAttribute("disabled", true);
}

// display delete feed dialog box to confirm deletion on faculty_class_feed.phtml
const showDeleteDialog = (element) => 
{
    document.querySelector(".delete-feed-content").classList.toggle("show");

    document.querySelector("#action-delete-feed-id").value = element.dataset.feed_id;
}

// hide delete feed dialog box on faculty_class_feed.phtml
const cancelDeleteDialog = () => 
{
    document.querySelector(".delete-feed-content").classList.remove('show');
}

// display edit feed dialog box on faculty_class_feed.phtml
const showEditForm = (e) => {
    document.querySelector(".edit-modal-content").classList.toggle("show");

    let url = "/Montessori/index.php?page=xml_edit";
    let request = new XMLHttpRequest();
    request.responseType = 'json';
 
    request.onreadystatechange = function()
    {
        if (this.readyState == 4 && this.status == 200)
        {
            document.querySelector("#action-feed-id").value=this.response.id;
            
            document.querySelector("#edit-existing-image").src = this.response.file_path_image;
            
            if(this.response.image_description)
            {
                document.getElementById("edit-upload-image-description").value = this.response.image_description;
            }
            
            if(this.response.content)
            {
                document.getElementById("edit-content").value = this.response.content;
            }
         
                
            const response = this.response[0];
                
            for(let i=0; i<response.length;i++)
            {
                document.querySelectorAll(".edit-option").forEach((e)=>{
                        
                    if(response[i]["pk_student_id"]==e.value)
                    {
                        e.setAttribute("selected", true);    
                    }
                });
            }
    
            if(this.response.publish_date != null)
            {
                document.getElementById("edit-publish-date").checked = true;
            }
            
        }
    }

    request.open("GET", url+"&feed_id="+e.dataset.feed_id, true);

    request.send();
}

// check if username is unique on __user_add.phtml
const usernameUnique = () => {
    
    const username = document.getElementById("user_username").value;
    
    let url = "/Montessori/index.php?page=xml_username";
    let request = new XMLHttpRequest();
    request.responseType = 'json';
    request.onreadystatechange = function()
    {
        if (this.readyState == 4 && this.status == 200)
        {
            if(this.response==null) 
            {
                if(!document.getElementById("error_username_exists").classList.contains("hide"))
                {
                    document.getElementById("error_username_exists").classList.toggle("hide");
                }
                
                document.getElementById("add-user-submit-btn").removeAttribute("disabled");
             
            }
            
            if(this.response!=null)
            {
                if(username===this.response["username"])
                {
                    if(document.getElementById("error_username_exists").classList.contains("hide"))
                    {
                        document.getElementById("error_username_exists").classList.toggle("hide");
                    }
    
                    document.getElementById("add-user-submit-btn").setAttribute("disabled", true);
                } 
            }
        }
    }
    request.open("GET", url+"&username="+username, true);
    request.send();
}

// hide edit feed dialog box on faculty_class_feed.phtml
const cancelEditForm = () => 
{
    document.querySelector(".edit-modal-content").classList.toggle('edit-modal-vanish');
    document.querySelector(".edit-modal-content").classList.remove('show');
}

// home page carousel right
const next = () => 
{
    const activeSlide = document.querySelector(".active");
    const idValue = activeSlide.id;
    activeSlide.classList.toggle("active");
    if(idValue==1){ document.getElementById("2").classList.add("active"); }
    if(idValue==2){ document.getElementById("3").classList.add("active"); }
    if(idValue==3){ document.getElementById("1").classList.add("active"); }
}

// validate user name __user_add.phtml
const checkUsername = () =>
{
    let data = document.getElementById("user_username").value;
    if(data.length >= 5)
    {
        if(notAllowed.some(item => data.includes(item)))
        {   
             if(document.getElementById("error_username").classList.contains("hide"))
            {
                document.getElementById("error_username").classList.toggle("hide");
            }
            document.getElementById("add-user-submit-btn").setAttribute("disabled", true);
        } else {
            if(!document.getElementById("error_username").classList.contains("hide"))
            {
                document.getElementById("error_username").classList.toggle("hide");
            }
            document.getElementById("add-user-submit-btn").removeAttribute("disabled");
            
            const randomPassword = Math.random().toString(36).slice(-8);
            document.getElementById("user_password").value=randomPassword;
        }
    }
}

// display or hide the automatically generated password __user_add.phtml
const showPassword = ( ) =>
{
    const input = document.getElementById("user_password");
    if(input.type === "password")
    {
        input.type = "text";
        document.getElementById("hide-show-img").classList.toggle("show-password");
        document.getElementById("hide-show-text").innerHTML="Cacher";
    } else {
        input.type = "password";
        document.getElementById("hide-show-img").classList.toggle("show-password");
        document.getElementById("hide-show-text").innerHTML="Rendre visible";
    }
}

// validate user password __user_add.phtml
const checkPassword = () =>
{
    let data = document.getElementById("user_password").value;
    console.log(data);
    
    if(data.length >= 5)
    {
        if(notAllowed.some(item => data.includes(item)))
        {   
            if(document.getElementById("error_password").classList.contains("hide"))
            {
                document.getElementById("error_password").classList.toggle("hide");
            }
            document.getElementById("add-user-submit-btn").setAttribute("disabled", true);
        } else {
            if(!document.getElementById("error_password").classList.contains("hide"))
            {
                document.getElementById("error_password").classList.toggle("hide");
            }
            document.getElementById("add-user-submit-btn").removeAttribute("disabled");
        }
    }
}

// validate firstname __user_add.phtml
const checkFirstname = () =>
{
    let data = document.getElementById("user_firstname").value;
    if(data.length >= 2)
    {
        if(notAllowed.some(item => data.includes(item)))
        {   
            if(document.getElementById("error_firstname").classList.contains("hide"))
            {
                document.getElementById("error_firstname").classList.toggle("hide");
            }
            document.getElementById("add-user-submit-btn").setAttribute("disabled", true);
        } else {
            if(!document.getElementById("error_firstname").classList.contains("hide"))
            {
                document.getElementById("error_firstname").classList.toggle("hide");
            }
            document.getElementById("add-user-submit-btn").removeAttribute("disabled");
        }
    }
}

// validate lastname __user_add.phtml
const checkLastname = () =>
{
    let data = document.getElementById("user_lastname").value;
    if(data.length >= 2)
    {
        if(notAllowed.some(item => data.includes(item)))
        {   
             if(document.getElementById("error_lastname").classList.contains("hide"))
            {
                document.getElementById("error_lastname").classList.toggle("hide");
            }
            document.getElementById("add-user-submit-btn").setAttribute("disabled", true);
        } else {
            if(!document.getElementById("error_lastname").classList.contains("hide"))
            {
                document.getElementById("error_lastname").classList.toggle("hide");
            }
            document.getElementById("add-user-submit-btn").removeAttribute("disabled");
        }
    }
}

// validate lastname __user_add.phtml
const checkEmail = () =>
{
    let data = document.getElementById("user_email").value;
    if(data.length >= 2)
    {
        if(notAllowedInEmail.some(item => data.includes(item)))
        {   
             if(document.getElementById("error_email").classList.contains("hide"))
            {
                document.getElementById("error_email").classList.toggle("hide");
            }
            document.getElementById("add-user-submit-btn").setAttribute("disabled", true);
        } else {
            if(!document.getElementById("error_email").classList.contains("hide"))
            {
                document.getElementById("error_email").classList.toggle("hide");
            }
            document.getElementById("add-user-submit-btn").removeAttribute("disabled");
        }
    }
}

document.addEventListener("DOMContentLoaded", () =>{
    
    // navigation side menu
    document.querySelector('.toggle-wrap').addEventListener('click', showMenu);
    
    /* ADMIN ACCOUNT PAGE */
    if(document.getElementById("add-user-btn"))
    {
        document.getElementById("add-user-btn").addEventListener('click', showAddUser);
        document.getElementById("add-user-cancel").addEventListener('click', cancelAddUser);
        document.getElementById("user_username").addEventListener('input', checkUsername);
        document.getElementById("user_password").addEventListener('input', checkPassword);
        document.getElementById("user_firstname").addEventListener('input', checkFirstname);
        document.getElementById("user_lastname").addEventListener('input', checkLastname);
        document.getElementById("user_email").addEventListener('input', checkEmail);
    }
    
    /* FACULTY FEED PAGE */
    if(document.getElementById("add-feed-btn"))
    {
        document.getElementById("add-feed-btn").addEventListener('click', showAddForm);
        document.getElementById("add-form-cancel").addEventListener('click', cancelAddForm);
    
        document.querySelectorAll(".btn-edit").forEach((element) => {
            element.addEventListener("click", () => showEditForm(element));
            });
        document.querySelector(".edit-form-cancel").addEventListener("click", cancelEditForm);
        
        document.querySelectorAll(".btn-delete").forEach((element) => {
            element.addEventListener("click", () => showDeleteDialog(element));
            });
        document.getElementById("delete-feed-close").addEventListener('click', cancelDeleteDialog);
        
        document.getElementById("add-feed-reset-btn").addEventListener("click", resetForm);
    }
    
    /* FEED PAGE */
    if(document.querySelector(".class-feed"))
    {
        document.querySelectorAll(".add-first-comment-btn").forEach((element) => {
            element.addEventListener("click", () => showAddFirstComment(element));
        });
        
        document.querySelectorAll('.parent-comment-respond').forEach((element) => {
            element.addEventListener("click", () => showAddFollowingComment(element));
        });
    }
    
    /* HOME PAGE */
    if(document.getElementById("home-carousel"))
    {
        const intervalId = window.setInterval(next, 5000);
    }
});