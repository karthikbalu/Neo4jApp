$(document).ready(function() {

$('.loading')
    .hide()  // hide it initially
    .ajaxStart(function() {
        $(this).show();
    })
    .ajaxStop(function() {
        $(this).hide();
    })
;

$('.profileimg').css('background-image',"url('"+cpic_small+"')");
getIntlist(clofus_id,false);



function setCookie(c_name, value, exdays) {
	console.log(value);
	console.log(c_name);
				var exdate = new Date();
				exdate.setDate(exdate.getDate() + exdays);
				var c_value = escape(value) + ((exdays == null) ? "" : "; expires=" + exdate.toUTCString());
				document.cookie = c_name + "=" + c_value;
}
function getCookie(c_name) {
	var i, x, y, ARRcookies = document.cookie.split(";");
	for( i = 0; i < ARRcookies.length; i++) {
	x = ARRcookies[i].substr(0, ARRcookies[i].indexOf("="));
	y = ARRcookies[i].substr(ARRcookies[i].indexOf("=") + 1);
	x = x.replace(/^\s+|\s+$/g, "");
		if(x == c_name) {
			return unescape(y);
		}
	}
}




function getIntlist(clofus_id,vasync) {

	        if(!vasync) 
                var vasync = "false";
        	
		var data = 'clofus_id=' + clofus_id;

        $.ajax({
                url : "php/clofus_engine.php",
                type : "GET",
                data : data,
                cache : false,
                dataType : 'text',
                success : function(mytv,textStatus, xhr) {
	                if (xhr.readyState === 4 && xhr.status === 0) {
		                console.log("N/W ERROR GET DOCLIST ");	
		            }else{
			            console.log(xhr.status);
			            if (mytv !=='empty' && xhr.status !== 404 ){
                                console.log(mytv);
                                setCookie("cint", mytv, 10000);
                                
                                getDoclist(mytv,false);
                                return mytv;
                        }
                    }
                },
                error : function(json22) {
                        console.log(json22);
                }
	      });

}


function getDoclist(task,vasync) {

	        if(!vasync) 
                var vasync = "false";
        	
		var data = 'interest_slist=' + task;

        $.ajax({
                url : "php/getnews.php",
                type : "GET",
                data : data,
                cache : false,
                dataType : 'html',
                success : function(mytv,textStatus, xhr) {
	                if (xhr.readyState === 4 && xhr.status === 0) {
		                console.log("N/W ERROR GET DOCLIST ");	
		            }else{
			            console.log(xhr.status);
			            if (mytv !=='empty' && xhr.status !== 404 ){
                                console.log(mytv);
                                $('.newsfeed').empty();
                                $(".newsfeed").append(mytv);
                         }
                         else
                         {	
	                         $('.newsfeed').empty();
	                         $('.newsfeed').append("<div class='docdocument'>No content suggested</div>");
	                     }
	                }
	            },
	            error : function(json22) {
                        console.log(json22);
                }

	      });

}//function


});
