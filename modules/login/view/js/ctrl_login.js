function login() {
    if (validator_login() != 0) {
        var data = $('#login__form').serialize();
        console.log(data);
        ajaxPromise(friendlyURL('?modules=login&op=login'), 'POST', 'JSON', data)
       .then(function(result) {
            console.log(result);
            if(result == "error"){
                $("#error_password").html('La contraseña o usuario no es correcto');
            }else{
                toastr.success("LOGIN CORRECTAMENTE", {
                    "timeOut": "5",
                    "extendedTimeout" : "5"
                });
                localStorage.setItem("token", result);
                    //setTimeout(' window.location.href = '+friendlyURL("?modules=home&op=view")+'; ',1000);
                    window.location.href = friendlyURL("?modules=home&op=view");
                
            }
        }).catch(function(error){
            console.log(error);
            $("#error_password").html('La contraseña o usuario no es correcto');
        });
    }
}

function keylogin() {
    $(document).keypress("#login__form",function(e) {
        var code = (e.keyCode ? e.keyCode : e.which);
        if(code==13){
        	e.preventDefault();
            login();
        }
    });
}
function buttonclick() {
    $(document).on("click",".button-login",function(e) {
        e.preventDefault();
        login();
    });

    $(document).on("click",".button-google",function() {
        social_login("google");
    });
    $(document).on("click",".button-git",function() {
        social_login("github");
    });

    $(document).on("click",".recover_passw",function(e) {
        $('.login').empty();
        e.preventDefault();
        load_form_recover_password();
    });
}

function social_login(data){
    authService = firebase_config();
    authService.signInWithPopup(provider_config(data))
    .then(function(result) {
        console.log('Hemos autenticado al usuario ', result.user);
        console.log(result.user.photoURL);
        console.log(result.user.email);
        console.log(result.user.uid + "_" + result.credential.providerId);

        var username = result.user.email;
        var uid = result.user.uid + "_" + result.credential.providerId;
        var avatar = result.user.photoURL;
        if (result) {
        ajaxPromise(friendlyURL('?modules=login&op=social_login'), 'POST', 'JSON', {user: username, id: uid, avatar: avatar})
        .then(function(done) {
            console.log(done);
            toastr.success("LOGIN CORRECTAMENTE", {
                "timeOut": "5",
                "extendedTimeout" : "5"
            });
            localStorage.setItem("token", done);
            setTimeout(' window.location.href = "?modules=home&op=view"; ',1000);
        }).catch(function(error) {
            console.log(error);
        });
       }
    })
    .catch(function(error) {
        console.log(error);
    });
}

function firebase_config(){
    var config = {
        apiKey: "AIzaSyCYb_cRSfjsPE8uLFJF9DJZV7a1cqNBG5E",
        authDomain: "test-56e9e.firebaseapp.com",
        databaseURL: "https://test-56e9e.firebaseapp.com",
        projectId: "test-56e9e",
        storageBucket: "",
        //messagingSenderId: "613764177727"
    };
    if(!firebase.apps.length){
        firebase.initializeApp(config);
    }else{
        firebase.app();
    }
    return authService = firebase.auth();
}

function provider_config(param){
    if(param === 'google'){
        var provider = new firebase.auth.GoogleAuthProvider();
        provider.addScope('email');
        return provider;
    }else if(param === 'github'){
        return provider = new firebase.auth.GithubAuthProvider();
    }
}

function validator_login() {
    var error = false;

	if(document.getElementById('username').value.length === 0){
		document.getElementById('error_username').innerHTML = "El usuario debe contener algún caracter";
		error = true;
	}else{
        document.getElementById('error_username').innerHTML = "";
    }
	
	if(document.getElementById('password').value.length === 0){
		document.getElementById('error_password').innerHTML = "La contraseña esta vacía";
		error = true;
	}else {
        document.getElementById('error_password').innerHTML = "";
    }
	
    if(error == true){
        return 0;
    }
}

//REVOVER_PASSWORD
function load_form_recover_password(){
    $('<form></form>').attr({'id': 'email__form', 'method': 'post'}).html('<h2>Recover password</h2>').appendTo('.login');
    $('<div></div>').attr({'class': 'form__content'}).appendTo('#email__form');
    $('<div></div>').attr({'class': 'form__input'}).html('<label for="email"><b>Email</b></label>'+
    '<input type="text" placeholder="Enter email" id="email" name="email" required>'+
    '<font color="red"><span id="error_email" class="error"></span></font>').appendTo('.form__content');
    $('<div></div>').attr({'class': 'button_container'}).html('<input class="button" id="button_email" type="button" value = "Enter"/>').appendTo('.form__content');
    click_recover_password();
}

function click_recover_password(){
    $("#email__form").keypress(function(e) {
        var code = (e.keyCode ? e.keyCode : e.which);
        if(code==13){
        	e.preventDefault();
            send_recover_password();
        }
    });

    $('#button_email').on('click', function(e) {
        e.preventDefault();
        send_recover_password();
    }); 
}

function validate_recover_password(){
    var mail_exp = /^[a-zA-Z0-9_\.\-]+@[a-zA-Z0-9\-]+\.[a-zA-Z0-9\-\.]+$/;
    var error = false;

    if(document.getElementById('email').value.length === 0){
		document.getElementById('error_email').innerHTML = "Tienes que escribir un correo";
		error = true;
	}else{
        if(!mail_exp.test(document.getElementById('email').value)){
            document.getElementById('error_email').innerHTML = "El formato del mail es invalido"; 
            error = true;
        }else{
            document.getElementById('error_email').innerHTML = "";
        }
    }
	
    if(error == true){
        return 0;
    }
}

function send_recover_password(){
    if(validate_recover_password() != 0){
        var data = { email : $('#email').val()};
        ajaxPromise(friendlyURL('?modules=login&op=send_recover_email'), 'POST', 'JSON', data)
        .then(function(result) {
             console.log(result);
             if (result == "error") {
                toastr.error("EMAIL NOT CORRECT");
             }else {
                toastr.success("EMAIL SENDED!");
             }
             
         }).catch(function(error){
             console.log(error);
         });  
    }
}

function load_form_new_password(token){
    ajaxPromise(friendlyURL('?modules=login&op=verify_token'), 'POST', 'JSON', {token : token})
        .then(function(result) {
             console.log(result);
             if(result == "verify"){
                $('.login').empty();
                $('<form></form>').attr({'id': 'new_password__form', 'method': 'post'}).html('<h2>New password</h2>').appendTo('.login');
                $('<div></div>').attr({'class': 'form__content'}).appendTo('#new_password__form');
                $('<div></div>').attr({'class': 'form__input'}).html('<label for="password"><b>Password</b></label>'+
                '<input type="password" placeholder="Enter password" id="password" name="password" required>'+
                '<font color="red"><span id="error_password" class="error"></span></font>').appendTo('.form__content');
                $('<div></div>').attr({'class': 'form__input'}).html('<label for="password1"><b>Password</b></label>'+
                '<input type="password" placeholder="Enter password" id="password1" name="password1" required>'+
                '<font color="red"><span id="error_password1" class="error"></span></font>').appendTo('.form__content');
                $('<div></div>').attr({'class': 'button_container'}).html('<input class="button" id="recover" type="button" value = "Enter"/>').appendTo('.form__content');
                click_new_password(token); 
            }else{
                console.log("error");
            }
         }).catch(function(error){
             console.log(error);
         });    
}

function click_new_password(token){
    $("#new_password__form").keypress(function(e) {
        var code = (e.keyCode ? e.keyCode : e.which);
        if(code==13){
        	e.preventDefault();
            send_new_password(token);
        }
    });

    $('#recover').on('click', function(e) {
        e.preventDefault();
        send_new_password(token);
    }); 
}

function validate_new_password(){
    if(document.getElementById('password').value.length === 0){
        document.getElementById('error_password1').innerHTML = "";
		document.getElementById('error_password').innerHTML = "Tienes que escribir la contraseña";
		error = true;
	}else{
        if(document.getElementById('password').value.length < 5){
            document.getElementById('error_password1').innerHTML = "";
            document.getElementById('error_password').innerHTML = "La password tiene que tener 5 caracteres como minimo";
            error = true;
        }else{
            if(document.getElementById('password').value !== document.getElementById('password1').value){
                document.getElementById('error_password').innerHTML = "";
                document.getElementById('error_password1').innerHTML = "Las contraseñas no son iguales";
                error = true;
            }else{
                document.getElementById('error_password').innerHTML = "";
            }
        }
    }
}

function send_new_password(token){    
    if(validate_new_password() != 0){
        var data = {token: token, passwd : $('#password').val()};
        console.log(data);
        ajaxPromise(friendlyURL('?modules=login&op=new_password'), 'POST', 'JSON', data)
        .then(function(result) {
             console.log(result);
             toastr.success('New password');
         }).catch(function(error){
             console.log(error);
         });     
    }
}

function load_content() {
    let path = window.location.pathname.split('/');
    //$('.container').empty();
    if(path[4] === 'recover'){
        load_form_new_password(path[5]);
    }else if (path[4] === 'verify') {
        console.log(path[5]);
        var token_email = path[5];

        ajaxPromise(friendlyURL('?modules=login&op=verify_email'), 'POST', 'JSON', {token: token_email})
        .then(function(data) {
            console.log(data);
            toastr.success("YA PUEDES INICIAR SESION!")
        }).catch(function(error) {
            console.log(error);
        });
        
    }
}

$(document).ready(function(){
    buttonclick();
    keylogin();
    load_content();
});