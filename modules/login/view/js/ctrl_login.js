function login() {
    if (validator_login() != 0) {
        var data = $('#login__form').serialize();
        console.log(data);
        //ajaxPromise('modules/login/ctrl/ctrl_login.php?op=login', 'POST', 'json', data)
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
                //var url = localStorage.getItem('url')
                
                /*if (url){
                    window.location.href = url;
                    click_likes(result);
                }else {*/
                    setTimeout(' window.location.href = "?modules=home&op=view"; ',1000);
                
            }
        }).catch(function(error){
            console.log(error);
            //$("#error_password").html('La contraseña o usuario no es correcto');
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
}

function social_login(data){
    authService = firebase_config();
    authService.signInWithPopup(provider_config(data))
    .then(function(result) {
        console.log('Hemos autenticado al usuario ', result.user);
        console.log(result.user.displayName);
        console.log(result.user.email);
        console.log(result.user.photoURL);
       
        if (result) {
        ajaxPromise(friendlyURL('?modules=login&op=social_login'), 'POST', 'JSON', token_email)
        .then(function(done) {
            console.log(done);
        }).catch(function(error) {
            console.log(error);
        });
       }
    })
    .catch(function(error) {
        console.log('Se ha encontrado un error:', error);
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

function load_content() {
    let path = window.location.pathname.split('/');
    //$('.container').empty();
    if(path[3] === 'recover'){
        load_form_new_password(path[4]);
    }else if (path[4] === 'verify') {
        console.log(path[5]);
        console.log("HOLAAAAAAAAAAAAAA");
        var token_email = path[5];

        ajaxPromise(friendlyURL('?modules=login&op=verify_email'), 'POST', 'JSON', token_email)
        .then(function(data) {
            console.log(data);
        }).catch(function(error) {
            console.log(error);
        });
        
    }
    /*else if (path[2] === 'register') {
        load_register();
    }else if(path[2] === 'login'){
        load_login();
    }*/
}

$(document).ready(function(){
    buttonclick();
    keylogin();
    load_content();
});