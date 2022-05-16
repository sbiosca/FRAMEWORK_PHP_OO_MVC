function load_type() {
    ajaxPromise(friendlyURL('?modules=search&op=load_type'), 'POST', 'json')
       .then(function(data) {
            for (row in data) {
                $('#type').append('<option value = "' + data[row].type_name + '">' + data[row].type_name + '</option>');
            }
        }).catch(function(error) {
            console.log(error);
        });
}

function load_model(data = undefined) {
    console.log(data);
    ajaxPromise(friendlyURL('?modules=search&op=load_model'), 'POST', 'JSON', data)
       .then(function(data) {
            $('#model').empty();
            $('#model').append('<option value="0">MODEL</option>');
            for (row in data) {
                $('#model').append('<option value = "' + data[row].model_name + '">' + data[row].model_name + '</option>');
            }
        }).catch(function(error) {
            console.log(error);
        });
}

function load_search(){
    load_type();
    load_model();
    $('#type').on('change', function(){
        let name = {type: $(this).val()};
        if (name === 0) {
            load_model();
        }else {
            load_model(name);
        }
    });
}

function autocomplete() {
    $(document).on('keyup', '#city', function() {
        let infor =  {complete: $(this).val()};
        if (($('#type').val() != 0)){
            infor.type = $('#type').val();
            if(($('#type').val() != 0) && ($('#model').val() != 0)){
                infor.model = $('#model').val();
             }
        }
        if(($('#type').val() == 0) && ($('#model').val() != 0)){ 
            infor.model = $('#model').val();
        }
        ajaxPromise(friendlyURL('?modules=search&op=autocomplete'), 'POST', 'JSON', infor)
        .then(function(data) {
            $('#search_city').empty();
            $('#search_city').fadeIn(1000);
            for (row in data) {
                $('<div></div>').appendTo('#search_city').html(data[row].city).attr({'class': 'searchElement', 'id': data[row].city});
            }
            $(document).on('click', '.searchElement', function() {
                $('#city').val(this.getAttribute('id'));
                $('#search_city').fadeOut(1000);
            });
            
        }).catch(function(error) {
            console.log(error);
        });

    });
}

function icon_search() {
    $(document).on('click', '.icon-search', function() {
        var search = [];
        var type = [];
        var model = [];
        var city = [];
    
        localStorage.removeItem('search');
        if(($('#type').val() == 0) && ($('#model').val() == 0)){
            if($('#city').val() != ""){
                city.push($('#city').val());
                search.push(city)
                localStorage.setItem('city',city);
            }
        }else if(($('#type').val() != 0) && ($('#model').val() == 0)){
            if($('#city').val() != ""){
                city.push($('#city').val());
                search.push(city)
                localStorage.setItem('city',city);
            }
            type.push($('#type').val());
            search.push(type)
            localStorage.setItem('type',type);
        }else if(($('#type').val() == 0) && ($('#model').val() != 0)){
            if($('#city').val() != ""){
                city.push($('#city').val());
                search.push(city)
                localStorage.setItem('city',city);
            }
            model.push($('#model').val());
            search.push(model)
            localStorage.setItem('model',model);
        }else{
            if($('#city').val() != ""){
                city.push($('#city').val());
                search.push(city)
                localStorage.setItem('city',city);
            }
            type.push($('#type').val());
            search.push(type)
            localStorage.setItem('type',type);
            model.push($('#model').val());
            search.push(model)
            localStorage.setItem('model',model);
        }    
        localStorage.removeItem('search');
        if(search.length != 0){
            localStorage.setItem('search', JSON.stringify(search));
        }
        window.location.href=friendlyURL("?modules=shop&op=view");
    });

    $(document).on('click', '#remove-search', function() {
        localStorage.removeItem('filters');
        localStorage.removeItem('search');
        localStorage.removeItem('city');
        localStorage.removeItem('model');
        localStorage.removeItem('type');
        window.location.href = '?modules=shop&op=view';

    });
}
$(document).ready(function() {
    autocomplete();
    load_search();
    icon_search();
    
});