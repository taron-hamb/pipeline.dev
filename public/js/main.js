$(document).ready(function(){

    //Window Start Loading
    window.onbeforeunload = function () { loading(); };

    //Window Loaded
    $(window).load(function(){
        NProgress.done(true);
    });

    var api_token = $('meta[id="api_token"]').attr('content');
    var api_url = $('meta[id="api_url"]').attr('content');

    //Login Click
    $("#login").click(function(e){

        NProgress.start();
        $("#nprogress .bar").css( "display", "none", "important");

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
            loginError();
        }
    });

    //Login key up Enter
    $("#login_form").keyup(function(event){
        if(event.keyCode == 13){
            $("#login").click();
        }
    });

    //Loading
    var loading =function(){
        NProgress.start();
        $("#nprogress .bar").css( "display", "none", "important");
    };

    //Login Error
    var loginError = function () {
        $("#nprogress .bar").css( "display", "block", "important");
        $("#nprogress .bar").css({ "background": "red" });
        $("#nprogress .spinner-icon").css({ "border-top-color": "red" });
        $("#nprogress .spinner-icon").css({ "border-left-color": "red" });
        $("#nprogress .peg").css({ "box-shadow": "0 0 10px red, 0 0 5px red" });

        NProgress.done(true);

        $('#errors').css({ "display": "block"});
    };

    //User Select
    $("#userSelect").change(function(){
        var link = this.options[this.selectedIndex].value;
        if(link != '')
        {
            location.href = link;
        }
    });

});