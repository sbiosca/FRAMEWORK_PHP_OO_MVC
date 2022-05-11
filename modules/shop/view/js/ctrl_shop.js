function ajaxForSearch(url, items = 0, total, search) {
    //var total = 0;
    console.log(search);
    ajaxPromise(url, 'POST' , 'JSON', {total: total, items: items, search: search})
    .then(function(data) {
        
        for (row in data){
            $('<div></div>').attr('class',"services__content").appendTo(".all_cars")
            .html(
                "<div class='caret'  id=" + data[row].enrolment+">" +
                "<p id='p_img'><img id=" + data[row].enrolment+" class='img_car' src='" + friendlyURLImages('views/images/cars/') + data[row].car_img + 
                "'style = 'max-width: 100%;'></img></p><div class='div-likes' id=" + data[row].enrolment+" ><p id=" + data[row].enrolment +"1" + " class='icon-like'>&#x2665</p></div><br>" + 
                "<p id='p_price'>" + data[row].price + "€" + "</p><br>" +
                "<p id='p_brand'>" + data[row].brand_name + " " + data[row].model_name +"</p> <br>" +
                "<p id='p_cambio'>" + data[row].exchange + " | " + data[row].type_name + 
                " | " + data[row].category_name + "</p><br><br>" +
                "<p id='p_date'>" + data[row].date + " " + data[row].km + " KM" +   "<p id='p_city'> "+ data[row].city +" </p></p><br>" +
                "</div><br>"
             );
        }
        mapBox(data);
        read_likes(data);
    }).catch(function(error) {
        console.log(error);
        //window.location.href = 'index.php?modules=modules/exceptions/ctrl/ctrl_exceptions&err=503';
    });
}
function load_filter() {
    ajaxPromise(friendlyURL('?modules=shop&op=filters'), 'POST', 'JSON')
    .then(function(data) {
            $(".form").append(
                "<div class='div_form'><select class='brandss' id='selc'><optgroup id='bran' class='select1' label='ALL BRANDS'>" +
                "<option selected >SELECT THE BRAND</option></optgroup></select><br><br>" +
                "<select class='modelss' id='selc'><optgroup class='select2' label='ALL MODELS'>" +
                "<option selected >SELECT THE MODEL</option></optgroup></select><br><br>" +
                "<select class='colorss' id='selc'><optgroup class='select3' label='ALL COLORS'>" +
                "<option selected >SELECT THE COLOR</option></optgroup></select><br><br>" +
                "<input class='button' name='Submit' type='button' id='filter' value='Filtrar' onclick='filters()'/>"+
                "<button id='remove-filters'><img class='remove-filter' src="+friendlyURLImages('views/images/filter-remove.png')+"></button>" +
                "</div>" +
                "<div>" +
                "<select>" +
                "<option selected>ORDER BY</option>" +
                "<option id='price'>price</option><option id='km'>km</option></select>" +
                "</div>" +
                "</form>"
            )
        for (row in data){
            if (brand1 != data[row].brand_name) {
              $(".select1").append(
                "<option id='brand' value='" +  data[row].brand_name + "'>" +  data[row].brand_name + "</option>" 
                );
              }
                if (data[row].model_name != null) {
              $(".select2").append(   
                "<option id='model' value='" +  data[row].model_name + "'>" +  data[row].model_name + "</option>" 
                );
                }
            if (data[row].color != null) {
              $(".select3").append(   
                "<option id='color' value='" +  data[row].color + "'>" +  data[row].color + "</option>" 
                ); 
            }
              var brand1 = data[row].brand_name;
        }
        load_all_filters();
    }).catch(function(error) {
        console.log(error);
        //window.location.href = 'index.php?modules=modules/exceptions/ctrl/ctrl_exceptions&err=404';
    });
}

function filters() {
    var brand = [];
    var model = [];
    var color = [];
    var filters = [];
    var price = [];
    var km = [];

    localStorage.removeItem('filters');
    $.each($("option[id='brand']:selected"), function(){            
        brand.push($(this).val());
    });
    if(brand.length != 0){
        filters.push(brand)
        localStorage.setItem('brand',brand);
    }
    $.each($("option[id='model']:selected"), function(){            
        model.push($(this).val());
    });
    if(model.length != 0){
        filters.push(model);
        localStorage.setItem('model',model);
    }
    $.each($("option[id='color']:selected"), function(){            
        color.push($(this).val());
    });
    if(color.length != 0){
        filters.push(color);
        localStorage.setItem('color',color);
    }
    $.each($("option[id='price']:selected"), function(){            
        price.push($(this).val());
    });
    if(price.length != 0){
        filters.push(price);
        localStorage.setItem('price',price);
    }
    $.each($("option[id='km']:selected"), function(){            
        km.push($(this).val());
    });
    if(km.length != 0){
        filters.push(km);
        localStorage.setItem('km',km);
    }
    if(filters.length != 0){
       localStorage.setItem('filters', filters); 
    }
    document.filter.submit();
    document.filter.action=friendlyURL('?modules=shop&op=view');
}

function load_all_filters () {
    var filters = localStorage.getItem('filters');
    var search = localStorage.getItem('search');
    if (filters) {
        var brand = localStorage.getItem('brand');
        var model = localStorage.getItem('model');
        var color = localStorage.getItem('color');
        var cate = localStorage.getItem('cate');
        var type = localStorage.getItem('type');
        var price = localStorage.getItem('price');
        var km = localStorage.getItem('km');
        if (brand) {
            var search = "WHERE b.brand_name='"+ filters  + "'";
            //var url = "modules/shop/ctrl/ctrl_shop.php?op=load_filters&search=" + search;
            //var url2 = "modules/shop/ctrl/ctrl_shop.php?op=count_filters&search=" + search;
            var url = friendlyURL("?modules=shop&op=load_filters");
            var url2 = friendlyURL("?modules=shop&op=count_filters");
            //ajaxForSearch(url);
            var select = document.querySelector(".brandss");
            hightlightfilters(select);
        }else if (model) {
            var search = "WHERE m.model_name='"+ filters  + "'";
            var url = friendlyURL("?modules=shop&op=load_filters");
            var url2 = friendlyURL("?modules=shop&op=count_filters");
            //ajaxForSearch(url);
            var select = document.querySelector(".modelss");
            hightlightfilters(select);  
        }else if (color) {
            var search = "WHERE c.color='"+ filters  + "'";
            var url = friendlyURL("?modules=shop&op=load_filters");
            var url2 = friendlyURL("?modules=shop&op=count_filters");
            //ajaxForSearch(url);
            var select = document.querySelector(".colorss");
            hightlightfilters(select);
        }
        if ((brand) && (model) && (!color)) {
            var search = "WHERE b.brand_name='"+ brand  + "' AND m.model_name ='"+ model + "'";
            var url = friendlyURL("?modules=shop&op=load_filters");
            var url2 = friendlyURL("?modules=shop&op=count_filters");
            //ajaxForSearch(url);
            var select = document.querySelector(".brandss");
            select.options[select.selectedIndex];
            var selected = localStorage.getItem('brand');
            if(selected) {
                select.value = selected; 
            }
            var select1 = document.querySelector(".modelss");
            select1.options[select1.selectedIndex];
            var selected = localStorage.getItem('model');
            if(selected) {
                select1.value = selected; 
            }
        }
        else if ((brand) && (color) && (!model)){
            var search = "WHERE b.brand_name='"+ brand  + "' AND c.color ='"+ color + "'";
            var url = friendlyURL("?modules=shop&op=load_filters");
            var url2 = friendlyURL("?modules=shop&op=count_filters");
            //ajaxForSearch(url);
            var select = document.querySelector(".brandss");
            select.options[select.selectedIndex];
            var selected = localStorage.getItem('brand');
            if(selected) {
                select.value = selected; 
            }
            var select1 = document.querySelector(".colorss");
            select1.options[select1.selectedIndex];
            var selected = localStorage.getItem('color');
            if(selected) {
                select1.value = selected; 
            }
        }
        else if ((model) && (color) && (!brand)){
            var search = "WHERE m.model_name='"+ model  + "' AND c.color ='"+ color + "'";
            var url = friendlyURL("?modules=shop&op=load_filters");
            var url2 = friendlyURL("?modules=shop&op=count_filters");
            //ajaxForSearch(url);
            var select = document.querySelector(".modelss");
            select.options[select.selectedIndex];
            var selected = localStorage.getItem('model');
            if(selected) {
                select.value = selected; 
            }
            var select1 = document.querySelector(".colorss");
            select1.options[select1.selectedIndex];
            var selected = localStorage.getItem('color');
            if(selected) {
                select1.value = selected; 
            }
        }
        else if ((model) && (color) && (brand)){
            var search = "WHERE m.model_name='"+ model  + "' AND c.color ='"+ color + "' AND b.brand_name ='" + brand + "'";
            var url = friendlyURL("?modules=shop&op=load_filters");
            var url2 = friendlyURL("?modules=shop&op=count_filters");
            //ajaxForSearch(url);
            var select = document.querySelector(".brandss");
            select.options[select.selectedIndex];
            var selected = localStorage.getItem('brand');
            if(selected) {
                select.value = selected; 
            }
            var select1 = document.querySelector(".colorss");
            select1.options[select1.selectedIndex];
            var selected = localStorage.getItem('color');
            if(selected) {
                select1.value = selected; 
            }
            var select2 = document.querySelector(".modelss");
            select2.options[select2.selectedIndex];
            var selected = localStorage.getItem('model');
            if(selected) {
                select2.value = selected; 
            }
        }
        else if(cate) {
            var search = "WHERE ca.cod_category='"+ filters  + "'";
            var url = friendlyURL("?modules=shop&op=load_filters");
            var url2 = friendlyURL("?modules=shop&op=count_filters");
            //ajaxForSearch(url);
        }
        else if(type) {
            var search = "WHERE t.cod_type='"+ filters  + "'";
            var url = friendlyURL("?modules=shop&op=load_filters");
            var url2 = friendlyURL("?modules=shop&op=count_filters");
            //ajaxForSearch(url);
        }else if(price) {
            var search = "ORDER BY c." + price  + "";
            var url = friendlyURL("?modules=shop&op=load_filters");
            var url2 = friendlyURL("?modules=shop&op=count_filters");
            //ajaxForSearch(url);
        }else if(km) {
            var search = "ORDER BY c." + km  + "";
            var url = friendlyURL("?modules=shop&op=load_filters");
            var url2 = friendlyURL("?modules=shop&op=count_filters");
            //ajaxForSearch(url);
        }
        load_pagination(url2, url, search);
       
    }else if(search) {
        var city = localStorage.getItem('city');
        var model = localStorage.getItem('model');
        var type = localStorage.getItem('type');        
        search = JSON.parse(search);
        if (model){
            var search = "WHERE m.model_name='"+ model  + "'";
            var url = friendlyURL("?modules=shop&op=load_filters");
            //var url = "modules/shop/ctrl/ctrl_shop.php?op=load_filters&search=" + search;
            //ajaxForSearch(url);
        }else if(type){
            var search = "WHERE t.type_name='"+ type  + "'";
            //var url = "modules/shop/ctrl/ctrl_shop.php?op=load_filters&search=" + search;
            var url = friendlyURL("?modules=shop&op=load_filters");
            //ajaxForSearch(url);
        }else if(city){
            var search = "WHERE c.city='"+ city  + "'";
            //var url = "modules/shop/ctrl/ctrl_shop.php?op=load_filters&search=" + search;
            //ajaxForSearch(url);
            var url = friendlyURL("?modules=shop&op=load_filters");
        }
        else if ((type) && (model) && (!city)) {
            var search = "WHERE t.type_name='"+ type  + "' AND m.model_name ='"+ model + "'";
            //var url = "modules/shop/ctrl/ctrl_shop.php?op=load_filters&search=" + search;
            //ajaxForSearch(url);
            var url = friendlyURL("?modules=shop&op=load_filters");
        }
        else if ((type) && (city) && (!model)){
            var search = "WHERE t.type_name='"+ type  + "' AND c.city ='"+ city + "'";
            //var url = "modules/shop/ctrl/ctrl_shop.php?op=load_filters&search=" + search;
            //ajaxForSearch(url);
            var url = friendlyURL("?modules=shop&op=load_filters");
        }
        else if ((model) && (city) && (!type)){
            var search = "WHERE m.model_name='"+ model  + "' AND c.city ='"+ city + "'";
            //var url = "modules/shop/ctrl/ctrl_shop.php?op=load_filters&search=" + search;
            //ajaxForSearch(url);
            var url = friendlyURL("?modules=shop&op=load_filters");
        }
        else if ((model) && (type) && (city)){
            var search = "WHERE m.model_name='"+ model  + "' AND c.city ='"+ city + "' AND t.type_name ='" + type + "'";
            //var url = "modules/shop/ctrl/ctrl_shop.php?op=load_filters&search=" + search;
            //ajaxForSearch(url);  
            var url = friendlyURL("?modules=shop&op=load_filters");
        }
        var items = 0;
        var total = null;
        ajaxForSearch(url, items, total, search);
    }else {
        //modules=shop&op=filters
        $('#remove-filters').remove();
        //var url = "modules/shop/ctrl/ctrl_shop.php?op=list_cars"
        //var url2 = "modules/shop/ctrl/ctrl_shop.php?op=count_pagination"
        var url = friendlyURL("?modules=shop&op=list_cars");
        var url2 =  friendlyURL("?modules=shop&op=count_pagination");
        load_pagination(url2, url);
    }    
}
function hightlightfilters(select) {
        select.options[select.selectedIndex];
        var selected = localStorage.getItem('filters');
        if(selected) {
          select.value = selected; 
        }
}

function remove_filters() {
    $(document).on('click', '#remove-filters', function() {
        localStorage.removeItem('brand');
        localStorage.removeItem('model');
        localStorage.removeItem('color');
        localStorage.removeItem('cate');
        localStorage.removeItem('type');
        localStorage.removeItem('price');
        localStorage.removeItem('km');
        localStorage.removeItem('filters');
        //window.location.href = friendlyURL('?modules=shop&op=view');
        window.location.href = '?modules=shop&op=view';
    });
}

function redirect_details() {
    $(document).on("click",".img_car",function() {
        var id = this.getAttribute('id');
        $(".all_cars").remove();
        details(id);
        count(id);
    });
    $(document).on("click",".more_cars",function() {
        var id = this.getAttribute('id');
        $(".services__content").remove();
        details(id);
        count(id);
    });
    
    $(document).on("click",".popup",function() {
        var id = this.getAttribute('id');
        $(".all_cars").remove();
        $(".services__content").remove();
        details(id);
        count(id);
    });
}

function details(id) {
        ajaxPromise(friendlyURL('?modules=shop&op=list_one_cars'), 'POST', 'JSON', {id: id})
       .then(function(data) {
        console.log(data);
       // if (data[row].date){
         //   toastr.success("El " + data[0].brand_name + " " + data[0].model_name + " seleccionado lo tienes en favoritos");
        //}
            $('<div></div>').attr('class',"services__content").appendTo(".only_car")
                .html(
                    "<div class='caret2'>" +
                    "<p class='p_detail'>" + data[0].price  + " " + data[0].brand_name + " " + data[0].model_name +
                     " " + data[0].doors + "p" + "<br>" + 
                     data[0].category_name +
                     "</p>"
                    + "</div>" 
                    + "<div class='div_only_car'></div>" 
                    + "<div class='button1'></div>"   
                 );
                
            for (row in data){
                $('<div></div>').attr({ 
                "class": ""}).appendTo(".div_only_car")
                .html(
                    "<img class='img_only_car' src='"+friendlyURLImages('views/images/cars/') + data[row].img + 
                    "' style = 'width: 110% height:150px ;'></img>" 
                 );
            }
                $('.div_only_car').slick({
                    infinite: true,
                    speed: 500,
                    fade: true,
                    cssEase: 'linear',
                  });
            $('<div></div>').attr('class',"services__content").appendTo(".button1")
                  .html("<button><a href="+friendlyURL('?modules=shop&op=view')+">VOLVER</a></button>")
            mapBox(data);
            more_cars(data);
        }).catch(function(error) {
            console.log(error);
        });
}

function count(id) {
    ajaxPromise(friendlyURL('modules=shop&op=count'), 'POST', 'JSON', {id: id})
}

function more_cars(data) {
    console.log(data[0].category_name);
    let categ = data[0].category_name;
    let type = data[0].type_name;
    let car = data[0].enrolment;
   ajaxPromise(friendlyURL('?modules=shop&op=more_related'), 'POST', 'JSON', {categ: categ, type: type, car: car})
       .then(function(data) {
        console.log(data);
        for (row in data){
            $('<br><br><div></div>').attr('class',"services__content").appendTo(".only_car")
                .html(
                    "<div class='more_cars' id=" + data[row].enrolment+">" +
                    "<h2>MORE CARS YOU MIGHT BE INTERESTED IN</h2>" +
                    "<img class='img_cate' src='"+friendlyURLImages('views/images/cars/')+ data[row].car_img + 
                    "'style = 'max-width: 100%; '></img>" +
                    "</div>"
                );
                }
        }).catch(function(error) {
            console.log(error);
            //window.location.href = 'index.php?modules=modules/exceptions/ctrl/ctrl_exceptions&err=503';
        });
}

function details_map(map, data) {
    for (row in data) {
        var lon = data[row].lon;
        var lat = data[row].lat;
        const popup = new mapboxgl.Popup({offset : 25})
        .setHTML("<div class='popup' id=" + data[row].enrolment +" ><p>"+ data[row].price +"</p><br><p id='p_brand1'>" 
        + data[row].brand_name + " " + data[row].model_name + 
        "<p id='p_img'><img class='img_car1' src='"+ friendlyURLImages('views/images/cars/') + data[row].car_img + 
        "'style = 'max-width: 100%;'></img></p> <br>" +
        "</p></div>");
        new mapboxgl.Marker({color:'red'})
        .setLngLat([lon, lat])
        .setPopup(popup)
        .addTo(map);   
    }
}

function mapBox(data) {
    mapboxgl.accessToken = 'pk.eyJ1IjoiYmlvc2tpbjk0IiwiYSI6ImNrenloOW5xNDAwZDkzY3BiaXN6eTR3YTAifQ.Pe82p8bfNkNZ_mgJCbnwQw';
    const map = new mapboxgl.Map({
    container: 'map', 
    style: 'mapbox://styles/mapbox/streets-v11', 
    center: [-0.6096918,38.8213929], 
    zoom: 7 
    });
    map.addControl(new mapboxgl.FullscreenControl());
    details_map(map,data);
}

function load_pagination(url2, url, search = null){
    ajaxPromise(url2, 'POST', 'json', {search: search})
    .then(function(data) {
        
        var items = 0;
        var total_prod = data[0].cars - 3;
        console.log(data);
        
        
        $("<button></button>").attr({"class" : "button-pagi1"}).html(
            "<p>1</p>"
        ).appendTo("#pagination");
        $("<button></button>").attr({"class" : "button-pagi2"}).html(
            "<p>2</p>"
        ).appendTo("#pagination");
        $("<button></button>").attr({"class" : "button-pagi3"}).html(
            "<p>3</p>"
        ).appendTo("#pagination");
        $(document).on("click",".button-pagi1",function(){
            $(".services__content").remove();
            ajaxForSearch(url, items, total_prod);
        });
        $(document).on("click",".button-pagi2",function(){
            $(".services__content").remove();
            var items = 3;
            var total_prod = data[0].cars ;
            ajaxForSearch(url, items, total_prod);
        });
        ajaxForSearch(url, items, total_prod, search);

    }).catch(function(error) {
        console.log(error);
        //window.location.href = 'index.php?modules=modules/exceptions/ctrl/ctrl_exceptions&err=503';
    });   
}

function read_likes_user(data,user) {
    console.log(data);
    console.log();
    for (row in data) {
        console.log(data[row].enrolment);
        var car = data[row].enrolment;
        var token = user.replace(/['"]+/g, '');
        ajaxPromise('?modules=shop&op=read_likes', 'POST', 'JSON', {id: car, user: token})
        .then(function(data){
            console.log(data);
            if (data[0].enrolment == null) {
                console.log("NO LIKE");
                //click_likes(user,data[0].likes);
            }else {
                console.log(data[0].enrolment)
                var likee = document.getElementById(data[0].enrolment + "1");
                console.log(likee);
                likee.style.color = '#FF0000';
                //click_likes(user,data[0].likes);
            }
            //
        }).catch(function(eerr){
            console.log(eerr);
        });   
    }
    
}

function click_likes(user){
    $(document).on("click",".div-likes",function() {
        /*$('<p></p>').attr('class',"icon-like").appendTo(".caret")
            .html("")*/
            var id = this.getAttribute('id');
            if (user == null) {
                toastr.error("DEBES INICIAR SESION PARA HACER LIKE", {
                    "timeOut": "5",
                    "extendedTimeout" : "5"
                }
                );
                var url = "?modules=login&op=list_login&log=" + id;
                window.location.href = url;
                var url = "?modules=shop&op=view&log=" + id;
                localStorage.setItem('url',url);
            }
            var token = user.replace(/['"]+/g, '');
            console.log(token);
            
        ajaxPromise('?modules=shop&op=load_likes', 'POST', 'JSON', {id: id, user: token})
        .then(function(data){
            console.log(data);
            if (data == "LIKE") {
                var likee = document.getElementById(id + "1");
                console.log(likee);
                likee.style.color = '#FF0000';
                toastr.success("LIKE REALIZADO CON ÉXITO!");
                localStorage.setItem('likes','like');
            }
            else {
                var likee = document.getElementById(id + "1");
                console.log(likee);
                likee.style.color = '#808080';
                toastr.success("DISLIKE REALIZADO CON ÉXITO!");
                //localStorage.removeItem('likes');
            }
            //
        }).catch(function(error){
            console.log(error);
        });
    });

}

function read_likes(data){
    var user = localStorage.getItem("token")
   
    if (user) {
        console.log("logeado");
        click_likes(user);
        var mg = localStorage.getItem('likes')
        if (mg) {
            read_likes_user(data,user);
        }
        
    }else {
        console.log("no log");
        click_likes();
    }

}

function load_content() {
    if (localStorage.getItem('filters')) {
        load_filter();
        remove_filters();
        redirect_details();
    }else {
        load_filter();
        redirect_details();
    }
}

$(document).ready (function (){
    load_content();
});
