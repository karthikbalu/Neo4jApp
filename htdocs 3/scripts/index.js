$(document).ready(function() {

if (loggedin==0){
	$('.iforgot').css('color','#700');
}

  	$('#semail').focus(function() {
    	$(this).val("");
    });

  	$('#sname').focus(function() {
    	$(this).val("");
    });
    
    $('#spwd').focus(function() {
    	$(this).val("");
    });
    
    
    
    $('#uname').focus(function() {
    	$(this).val("");
    });
    
    $('#upwd').focus(function() {
    	$(this).val("");
    });
    
    
    $('#semail').keypress(function(event){
		var keycode = (event.keyCode ? event.keyCode : event.which);
			if(keycode == '13'){
                document.signup.submit();
            }
	});
	    
    $('#sname').keypress(function(event){
		var keycode = (event.keyCode ? event.keyCode : event.which);
			if(keycode == '13'){
                document.signup.submit();
            }
	});
	
	$('#spwd').keypress(function(event){
		var keycode = (event.keyCode ? event.keyCode : event.which);
			if(keycode == '13'){
                document.signup.submit();
            }
	});
    
    
    
    $('#uname').keypress(function(event){
		var keycode = (event.keyCode ? event.keyCode : event.which);
			if(keycode == '13'){
				 document.signin.submit();
		    }
	});

    $('#upwd').keypress(function(event){
		var keycode = (event.keyCode ? event.keyCode : event.which);
			if(keycode == '13'){
                document.signin.submit();
            }
	});

	$('.ifbbtn').live('click', function() {
		document.signup.submit();
	});

	$('.ibutton').live('click', function() {
		document.signin.submit();
	});
	
	

});