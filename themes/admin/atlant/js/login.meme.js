$(document).ready(function(){
    login._init();
});
 
login = {
    _init : function(){
        $('#btn_login').click(function(){
            login.actLogin();
        });
        $('#login_pass').keypress(function(e) {
            if(e.which == 13) {
                login.actLogin();
            }
        });
    },
    actLogin : function(){
        $('#btn_login').html('Loading...');
        var request = $.ajax({
          url: AUTH_URL,
          type: "POST",
          data: { 
            username      : $('#login_username').val(),
            password      : $('#login_pass').val(),
            login         : true
          },
          dataType: "json"
        });
        
        
        request.done(function( obj ) {
            if(obj.status==0){
                $('#alert_message').removeClass('alert-success').addClass('alert-danger').fadeIn();
                $('#txt_message').html(obj.message);
                $('#login_username,#login_pass').val('');
                $('#login_username').focus();
            }else{
                $('#alert_message').removeClass('alert-danger').addClass('alert-success').fadeIn();
                $('#txt_message').html(obj.message);
                document.location = obj.data.go_to;
            }
            $('#btn_login').html('Login');
            return false;
        });
        
        
        request.fail(function( jqXHR, textStatus ) {
          alert( "Request data id failed: " + textStatus );
           $('#btn_login').html('Login');
        });
    }
}