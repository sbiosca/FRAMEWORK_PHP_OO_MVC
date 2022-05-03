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
                var url = localStorage.getItem('url')
                
                if (url){
                    window.location.href = url;
                    click_likes(result);
                }else {
                    setTimeout(' window.location.href = "index.php?modules=modules/home/ctrl/ctrl_home&op=list"; ',1000);
                }
            }	
        }).catch(function(){
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


$(document).ready(function(){
    buttonclick();
    keylogin();
});