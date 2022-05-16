function loadbrands(load = 0) {
    let items = 12;
    let loaded = load;

    console.log(items);
    console.log(loaded);
    ajaxPromise(friendlyURL('?modules=home&op=carrousel_brand'), 'POST', 'JSON')
   .then(function(data) {
        console.log(data);
        for (row in data) {
            $('<div></div>').attr({'id': data[row].brand_name, 
            "class": "single-slide"})
            .appendTo('.owl-carousel')
            .html('<img id=' + data[row].brand_name + ' class="img_brand" src = "'+ friendlyURLImages("views/images/logos/") + data[row].brand_img 
            + '" style = "width: 50%;  height: 130px; "></img><h1>'+ data[row].brand_name +'</h1>');
        }
        jQuery("#carousel").owlCarousel({
            center: true,
            loop:true,
            autoplay: true,
            rewind: true,
            margin: 30,
            responsiveClass: true,
            autoHeight: true,
            autoplayTimeout: 7000,
            smartSpeed: 800,
            nav: true,
            responsive: {
              0: {
                items: 1
              },
          
              600: {
                items: 3
              },
          
              1024: {
                items: 4
              },
          
              1366: {
                items: 4
              }
            }
          });
    }).catch(function(error) {
        console.log(error);
    });
}

function loadcategory() {
    ajaxPromise(friendlyURL('?modules=home&op=categ'), 'POST', 'json')  
    .then(function(data) {
        for (row in data) {
            $('<div></div>').attr('class',"services__content").appendTo(".container_categ")
            .html(
                "<img id=" + data[row].cod_category + " class='img_cate' src='" + friendlyURLImages('views/images/') + data[row].category_img + 
                "'style = 'max-width: 100%; '></img>"
             );
             $('<div></div>').attr('class',"services__content").appendTo(".container_categ2")
             .html(
                 "<p class='name_cate'>" + data[row].category_name + "</p>"
              );
        }
        
    }).catch(function(error) {
        console.log(error);
    });
}

function loadtype() {
    ajaxPromise(friendlyURL('?modules=home&op=type'), 'POST', 'json')
   .then(function(data) {
        for (row in data) {
            $('<div></div>').attr('class',"services__content").appendTo(".container_type").html( 
                "<img id="+ data[row].cod_type +" class='img_type' src='" + friendlyURLImages('views/images/') + data[row].type_img + "'style = 'max-width: 100%; height: 200px;'></img>"
             )
             
        }
    }).catch(function(error) {
      console.log(error);
    });
    
}

function click() {
    $(document).on("click",".img_brand",function() {
        var brand = [];
        var filters = [];
        filters.push(this.getAttribute('id'));
        brand.push(this.getAttribute('id'));
        localStorage.removeItem('filters')
        localStorage.removeItem('brand')
        localStorage.setItem('filters',filters);
        localStorage.setItem('brand', brand);
            setTimeout(function(){ 
            window.location.href = friendlyURL('?modules=shop&op=view');
            }, 500);  
    });

    $(document).on("click",".img_cate",function() {
        var cate = [];
        var filters = [];
        filters.push(this.getAttribute('id'));
        cate.push(this.getAttribute('id'));
        localStorage.removeItem('filters')
        localStorage.removeItem('cate')
        localStorage.setItem('filters',filters); 
        localStorage.setItem('cate',cate); 
            setTimeout(function(){ 
            window.location.href = friendlyURL('?modules=shop&op=view');
            }, 500);  
    });

    $(document).on("click",".img_type",function() {
        var type = [];
        var filters = [];
        filters.push(this.getAttribute('id'));
        type.push(this.getAttribute('id'));
        localStorage.removeItem('filters')
        localStorage.removeItem('type')
        localStorage.setItem('filters',filters); 
        localStorage.setItem('type',type); 
            setTimeout(function(){ 
            window.location.href = friendlyURL('?modules=shop&op=view');
            }, 500);  
    });
}

function loadall() {
    ajaxPromise(friendlyURL("?modules=home&op=load_more"), 'POST', 'JSON')
    //ajaxPromise("modules/home/ctrl/ctrl_home.php?op=load_all", 'POST', 'JSON')
    .then(function(data) {
      total_brands = data[0].count;
      loadbrands();
      console.log(data[0].count);
      $(document).on("click",'.loadmore', function (){
        var brands = $('.single-slide').length + 3;
        if (total_brands <= brands) {
          $('.buttonmore').empty();
        }
        loadbrands($('div.single-slide').length);
        console.log($('div.single-slide').length);
      });
    }).catch(function() {
        //window.location.href = 'index.php?modules=modules/exceptions/ctrl/ctrl_exceptions&err=404';
    }); 
}

function news() {
    if (document.getElementById('content_news')) {
      ajaxPromise( "https://newsapi.org/v2/everything?q=tesla&from=2022-02-28&sortBy=publishedAt&apiKey=32bfbed9c8054aec9b22a6378caf9773", 'GET', 'JSON')
      .then(function(data) {
          console.log(data.articles);
          $("<div></div>").attr({"id" : "news-api"}).html(
            "<a class='api1' href=" + data.articles[1].url +"><img class='new-api1' src='"+ data.articles[1].urlToImage + "'/></a>" 
            //"<a class='api2' href=" + data.articles[2].url +"><img class='new-api2' src='"+ data.articles[2].urlToImage + "'/></a>"  
          ).appendTo("#content_news");

          $("<div></div>").attr({"id" : "news-hover"}).html(
            "<a class='title-api'>" + data.articles[1].title + "</a>"
          ).appendTo("#content_news");

          $('div#news-hover').hide();
          $('.api1').hover(function(e) {
            $('div#news-hover').show();
          }, function() {
            $('div#news-hover').hide();
          });
      });; 
      }
}
function loadDivs() {
    $('<h1></h1>').html('').appendTo('#homePage').attr("style", "padding-bottom: 50px");
    $('<div></div>').attr({'id': "containerCategories", 'class':'row1'}).appendTo('#homePage');
    //loadbrands();
    click();
    loadcategory();
    loadtype();
    loadall();
    news();
}


$(document).ready (function (){
    loadDivs(); 
});

