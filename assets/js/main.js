var url = window.location.search;


if(url.indexOf("login")!=-1 || url=="?page=login"){

    $("#login").click(function(){
        let objEmail = document.getElementById("email");
        let objPass = document.getElementById("password");
             
        let regEmail = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;

        errors = "";
 
        if (!regEmail.test(objEmail.value)) {
            errors += "<br>Email must be in the format: user@gmail.com<br><br>";
        }
        
        if (objPass.value.length < 8) {
            errors += "The password must contain at least 8 characters<br>";
        }
        
        if (errors.length) {
            $("#loginErrors").html(errors);
        } else {         
            let email = objEmail.value
            let passwordd = objPass.value  
            $.ajax({
            url:"models/login.php",
            method:"POST",
            type:"json",
            data:{
                    email:email,
                    password:passwordd,
                },
                success: function(response, textStatus, xhr) {
                    if (xhr.status === 200) {
                        window.location.href = 'index.php?page=home';
                    }
                },
                error: function(response) {
                    $("#loginErrors").html("<br>" + response.responseText)
                }
            })
              
        }   
    })
}

if(url.indexOf("register")!=-1 || url=="?page=register"){

    $("#register").click(function(){

        let objFirstname = document.getElementById("firstname");
        let objLastname = document.getElementById("lastname");
        let objEmail = document.getElementById("email");
        let objPassword = document.getElementById("password");

        
        let regexName = /^[A-Z][a-z]{2,29}$/;                
        let regexEmail = /^([a-zA-Z0-9_\-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([a-zA-Z0-9\-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;  

        errors = "";

        if(!regexName.test(objFirstname.value)){
            errors += "The firstname must start with a capital letter and contain at least three characters amd max 30 characters, example:<br/>Aleksandar<br><br>";
        }
        
        if(!regexName.test(objLastname.value)){
            errors += "The lastname must start with a capital letter and contain at least three characters amd max 30 characters, example:<br/>Kandic<br><br>";
        }
        
        if(!regexEmail.test(objEmail.value)){
            errors += "Email must be in the format: user@gmail.com<br><br>";
        }
    
        if(objPassword.value.length<8){
            errors += "The password must contain at least 8 characters<br><br>";
        }


        
        
        if(errors.length){
            $("#loginErrors").html("<br>" + errors);
        }
        else{
            let firstname = objFirstname.value
            let lastname = objLastname.value
            let email = objEmail.value
            let password = objPassword.value
        
            $.ajax({
            url:"models/register.php",
            method:"POST",
            type:"json",
            data:{
                    firstname:firstname,
                    lastname:lastname,
                    email:email,
                    password:password,
                },
            success:function(response, textStatus, xhr){
                if (xhr.status === 201) {
                    window.location.href = 'index.php?page=login';
                    document.getElementById("formRegister").reset();
                }
                
            },
            error:function(x){
                $("#loginErrors").html("<br>" + response.responseText)
            }
        
            })
            
            
        }
            
            
            

            
        
       
        
    })
}

if(url.indexOf("setPassword")!=-1 || url=="?page=setPassword"){
    $("#set").click(function(){

        
        let objPassword = document.getElementById("password");
        let objRePassword = document.getElementById("rePassword");

        errors = "";

    
        if(objPassword.value.length<8){
            errors += "The password must contain at least 8 characters<br><br>";
        }

        if(objPassword.value != objRePassword.value){
            errors += "The password must match<br><br>";
        }


        
        
        if(errors.length){
            $("#loginErrors").html("<br>" + errors);
        }
        else{
            let password = objPassword.value
            let rePassword = objRePassword.value

            $.ajax({
            url:"models/setPasswordModel.php",
            method:"POST",
            type:"json",
            data:{
                    password:password,
                    rePassword: rePassword
                },
            success:function(response, textStatus, xhr){
                if (xhr.status === 204) {
                    window.location.href = 'index.php?page=home';
                }
                
            },
            error:function(xhr){
                //alert(xhr.responseText)
                $("#loginErrors").html("<br>" + xhr.responseText)
            }
            })
            
            
        }
        
    })
}

if(url.indexOf("home")!=-1 || url=="?page=home"){
    let buttons = document.querySelectorAll(".getToWork");

    buttons.forEach(button => {
        button.addEventListener("click", function () {
            let taskId = this.dataset.id;
            let btn = this;
    
            $.ajax({
                url: "models/getToWork.php",
                method: "POST",
                data: {
                    id_task: taskId
                },
                success: function (response, textStatus, xhr) {
                    btn.disabled = true;
    
                    let finishButton = document.querySelector(`.finishTask[data-id='${taskId}']`);
                    if (finishButton) {
                        finishButton.disabled = false;
                    }
                },
                error: function (xhr) {
                    alert("Error: " + xhr.responseText);
                }
            });
        });
    });
        let buttons2 = document.querySelectorAll(".finishTask");

        buttons2.forEach(button => {
            button.addEventListener("click", function() {
                let taskId = this.dataset.id;
                let btn = this;

                $.ajax({
                    url: "models/finishTask.php",
                    method: "POST",
                    data: {
                        id_task: taskId
                    },
                    success: function(response, textStatus, xhr) {
                        btn.disabled = true;
                    },
                    error: function(xhr) {
                        alert("Error: " + xhr.responseText);
                    }
                });
            });
        });

        const filters = {};

        function triggerSearch() {
            $.ajax({
                url: 'models/filter.php',
                method: 'GET',
                data: filters,
                success: function(response) {
                    let html = '';

                    if (Array.isArray(response) && response.length > 0) {
                        response.forEach(t => {
                            html += `
                            <div class="task-card">
                                <div class="task-info">
                                    <h3>${t.title}</h3>
                                    <p><strong>Description:</strong> ${t.description}</p>
                                    <p><strong>Task name:</strong> <span style="color:greenyellow">${t.name}</span></p>
                                    <p><strong>Priority:</strong> ${t.priority}</p>
                                    <p><strong>Issued by:</strong> ${t.issuer_firstname} ${t.issuer_lastname}</p>
                                    <p><strong>Date due:</strong> ${t.due_date}</p>
                                    <p><strong>Created at:</strong> ${t.created_at}</p>
                                    ${t.image ? `<img width="300px" src="${t.image}" alt="${t.title}" class="task-image" />` : ''}
                                </div>
                                <div class="task-buttons">
                                    <input type="button" class="getToWork" value="Get to work" data-id="${t.id_task}" ${t.id_status !== 'It has not started' ? 'disabled' : ''} />
                                    <input type="button" class="finishTask" value="Finish task" data-id="${t.id_task}" ${(t.id_status === 'Done' || t.id_status === 'It has not started') ? 'disabled' : ''} />
                                </div>
                            </div>
                            `;
                        });
                    } else {
                        html = "<br><h2 style='color:yellow'>No tasks with your search</h2>";
                    }

                    document.getElementById('rask-result').innerHTML = html;
                },
                error: function() {
                    $('#rask-result').html("<p style='color:red'>Error loading tasks.</p>");
                }
            });
        }

        $('.dd-dropdown-content a').on('click', function (e) {
            e.preventDefault();

            const value = $(this).data('value');
            const filterType = $(this).closest('.dd-dropdown').find('.dd-dropdown-button').data('filter');

            filters[filterType] = value;
            triggerSearch();
        });

        $('#searchInput').on('input', function () {
            filters.search = $(this).val();
            triggerSearch();
        });

};

   


if(url.indexOf("contact")!=-1 || url=="?page=contact"){
    $(document).ready(function() {
        $('#sendBtn').on('click', function() {
            const title = $('#title').val().trim();
            const message = $('#message').val().trim();
            const responseBox = $('#response');
    
            if (title.length < 4 || message.length < 4) {
                responseBox.html("<p style='color:red'>Title and message must be at least 4 characters.</p>");
                return;
            }
    
            $.ajax({
                url: 'models/message.php',
                method: 'POST',
                data: { title: title, message: message },
                success: function() {
                    responseBox.html("<p style='color:green'>Message sent successfully!</p>");
                    $('#contactForm')[0].reset();
                },
                error: function() {
                    responseBox.html("<p style='color:red'>An error occurred. Try again.</p>");
                }
            });
        });
    });
}
        