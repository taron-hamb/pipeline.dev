$(document).ready(function(){

    var api_token = $('meta[id="api_token"]').attr('content');
    var api_url = $('meta[id="api_url"]').attr('content');

    //Login
    $("#login").click(function(e){
        e.preventDefault();
        var email = $('input[id="email"]').val();
        var password = $('input[id="password"]').val();
        var data = null;


        $.ajax({
            type: 'POST',
            url: api_url+"/authorizations?api_token="+api_token,
            data:{
                email: email,
                password: password
            },
            success: function(result){
                data = result.additional_data.user.profile;
            },
            error: function(error){
                console.log(error);
            },
            async: false
        });
        if(data != null){
            var login = null;
            $.ajax({
                url: '/authenticate',
                type: 'POST',
                beforeSend: function (xhr) {
                    var token = $('input[name="_token"]').val();
                    if (token) {
                        return xhr.setRequestHeader('X-CSRF-TOKEN', token);
                    }
                },
                data: {
                    pipedrive_id: data.id,
                    email: data.email,
                    name: data.name
                },
                success: function (result) {
                    login = result;
                },
                error: function (error) {
                    login = error;
                },
                async: false
            });
            if(login == 'success'){
                window.location.href = '/dashboard';
            }else{
                window.location.href = '/';
            }
        }else{
            $('#errors').css({ "display": "block"})
        }
    });

    $("#login_form").keyup(function(event){
        if(event.keyCode == 13){
            $("#login").click();
        }
    });

});