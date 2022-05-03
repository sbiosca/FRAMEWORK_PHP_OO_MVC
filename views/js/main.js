function ajaxPromise(sUrl, sType, sTData, sData) {
    return new Promise((resolve, reject) => {
        $.ajax({
            url: sUrl,
            type: sType,
            dataType: sTData,
            data: sData
        }).done((data) => {
            resolve(data);
        }).fail((jqXHR, textStatus, errorThrow) => {
            reject(errorThrow);
        }); 
    });
}

//FRIENDLY URL 
function friendlyURL(url) {
    var link="";
    url = url.replace("?", "");
    url = url.split("&");
    cont = 0;
    for (var i=0; i<url.length; i++) {
    	cont++;
        var aux = url[i].split("=");
        if (cont == 2) {
        	link +=  "/"+aux[1]+"/";	
        }else{
        	link +=  "/"+aux[1];
        }
    }
    return "http://localhost/FRAMEWORK_PHP_OO_MVC" + link;
}



function menu() {
    $("<li></li>").attr({"class" : "nav-item"}).html(
        //'<a class="nav-link" href="'+ friendlyURL("?modules=home&op=view") + ' " data-tr="HOMEPAGE">HOMEPAGE</a>'
        "<a class='nav-link' href='?modules=home&op=view' data-tr='HOMEPAGE'>HOMEPAGE</a>"
    ).appendTo(".navbar-nav");
    $("<li></li>").attr({"class" : "nav-item"}).html(
        "<a class='nav-link' href='?modules=home&op=view' data-tr='CARS'>CARS</a>"
    ).appendTo(".navbar-nav");
    $("<li></li>").attr({"class" : "nav-item"}).html(
        //"<a class='nav-link' href="+ friendlyURL('?modules=shop&op=view')+ "><img class='img_shop' src='views/images/icon_shop.png'></img></a>"
        "<a class='nav-link' href='?modules=shop&op=view')><img class='img_shop' src='views/images/icon_shop.png'></img></a>"
    ).appendTo(".navbar-nav");
    $("<li></li>").attr({"class" : "nav-item"}).html(
        "<a class='nav-link' href='?modules=contact&op=view'>CONTACT US</a>"
        //'<a class="nav-link" href="'+ friendlyURL("?modules=contact&op=view") + ' ">CONTACT US</a>'
    ).appendTo(".navbar-nav");

    var toke = localStorage.getItem('token');
        console.log(toke);
        if (toke == "USUARIO_REGISTER") {
            toastr.options = {
                'closeButton': true,                
            }
            toastr.success("SE HA REGISTRADO CORRECTAMENTE");
            localStorage.removeItem('token');
        }
        ajaxPromise('modules/login/ctrl/ctrl_login.php?op=user_menu', 'POST', 'JSON', {token: toke})
        .then(function(data) {
            console.log(data);
            menu_logeado(data);
        }).catch(function () {
            $("<button></button>").attr({"class" : "buttonlogin"}).html(
                //"<a href='index.php?modules=modules/login/ctrl/ctrl_login&op=list_login&log=0'>LOGIN</a>"
                "<a href='?modules=login&op=list_login'>LOGIN</a>"
            ).appendTo("#logear");
        });
}

function menu_logeado(data) {
    console.log(data);
    $("<button></button>").attr({"class" : "button-logout"}).html(
        "<a href=''>LOGOUT</a>"
    ).appendTo("#logear");
    $("<a></a>").attr({"class" : "img-avatar"}).html(
        "<img class='avatar' src='"+ data.avatar + "'/>"
    ).appendTo("#logear");
    $("<div></div>").attr({"id" : "popup-user"}).html(
        "<p class='user-avatar'>" + data.username + "</p>" 
    ).appendTo("#logear");
    $('div#popup-user').hide();
    $('a.img-avatar').hover(function(e) {
        $('div#popup-user').show();
      }, function() {
        $('div#popup-user').hide();
      });
    regenerate_token(data);   
}

function clicklogout() {
    $(document).on("click",".button-logout",function() {
        logout();
    });
}

function logout () {
    ajaxPromise('modules/login/ctrl/ctrl_login.php?op=logout', 'POST', 'JSON')
        .then(function(data) {
            console.log(data);
            localStorage.removeItem('token');
            localStorage.removeItem('url');
            window.location.href = 'index.php?modules=modules/home/ctrl/ctrl_home&op=list';
        }).catch(function () {
            window.location.href = 'index.php?modules=modules/exceptions/ctrl/ctrl_exceptions&err=404';
        });
}

$(document).ready(function() {
    menu();
    clicklogout();
});