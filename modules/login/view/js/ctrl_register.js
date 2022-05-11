function avatar() {
    ajaxPromise('https://randomuser.me/api/', 'GET', 'json')
       .then(function(data) {
            var user = data.results[0].picture.large;
            console.log(data);
            keyregister(user);
            button(user);
        });

}
function register(user){
    if(validator_register() != 0){
        var data = $('#register__form').serialize() + "&avatar=" +user;
        console.log(data);
        ajaxPromise(friendlyURL('?modules=login&op=register'), 'POST', 'JSON', data)
       .then(function(data) {
            console.log(data);
            if (data == "REGISTRADO") {
                console.log("DONE!");
                toastr.success("REGISTRADO CORRECTAMENTE, VERIFICA QUE ERES TU EN EL CORREO");
                localStorage.setItem("token", data);
                //toastr.success("EMAIL VERIFICADO")
                setTimeout(' window.location.href = "?modules=home&op=view"; ',1000);
            }
            else {
                console.log("Failed!");
                $("#error_email").html('El email ya existe');
            }
            
        }).catch(function(error){
            console.log(error);
        });
    }
}

function keyregister(user) {
    $(document).keypress("#register__form",function(e) {
        var code = (e.keyCode ? e.keyCode : e.which);
        if(code==13){
        	e.preventDefault();
            register(user);
        }
    });
}

function button(user) {
    $(document).on("click","#register",function(e) {
        e.preventDefault();
        register(user);
    });
}

function validator_register() {
    var mail_exp = /^[a-zA-Z0-9_\.\-]+@[a-zA-Z0-9\-]+\.[a-zA-Z0-9\-\.]+$/;
    var error = false;

	if(document.getElementById('username').value.length === 0){
		document.getElementById('error_username').innerHTML = "Tienes que escribir el usuario";
		error = true;
	}else{
        if(document.getElementById('username').value.length < 8){
            document.getElementById('error_username').innerHTML = "El username tiene que tener 8 caracteres como minimo";
            error = true;
        }else{
            document.getElementById('error_username').innerHTML = "";
        }
    }

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
	
	if(document.getElementById('password').value.length === 0){
		document.getElementById('error_password').innerHTML = "Tienes que escribir la contraseña";
		error = true;
	}else{
        if(document.getElementById('password').value.length < 5){
            document.getElementById('error_password').innerHTML = "La password tiene que tener 8 caracteres como minimo";
            error = true;
        }else{
            document.getElementById('error_password').innerHTML = "";
        }
    }
	
    if(error == true){
        return 0;
    }
}


$(document).ready(function(){
    avatar();
});