$(document).ready(function(){

    //Login
    $("#login").click(function(e){
        e.preventDefault();
        var email = $('input[id="email"]').val();
        var password = $('input[id="password"]').val();
        var data = null;
        $.ajax({
            type: 'POST',
            url: "https://api.pipedrive.com/v1/authorizations?api_token=".config('constants.api_token'),
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
                url: '/login',
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
                window.location.href = '/';
            }else{
                window.location.href = '/';
            }
        }else{
            window.location.href = '/';
        }
    });

    $("#login_form").keyup(function(event){
        if(event.keyCode == 13){
            $("#login").click();
        }
    });

});