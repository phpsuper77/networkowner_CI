/*global jQuery:false */
/*jshint unused: true */
/*exported fbs_click */


	

/*-----------------------------------------------------------------------------------

 Email forms
 
----------------------------------------------------------------------------------*/



var requestSent = false;


function getURLParameters(paramName) 
{
    var sURL = window.document.URL.toString();  
    if (sURL.indexOf("?") > 0)
    {
       var arrParams = sURL.split("?");         
       var arrURLParams = arrParams[1].split("&");      
       var arrParamNames = new Array(arrURLParams.length);
       var arrParamValues = new Array(arrURLParams.length);     
       var i = 0;
       for (i=0;i<arrURLParams.length;i++)
       {
        var sParam =  arrURLParams[i].split("=");
        arrParamNames[i] = sParam[0];
        if (sParam[1] != "")
            arrParamValues[i] = unescape(sParam[1]);
        else
            arrParamValues[i] = "No Value";
       }

       for (i=0;i<arrURLParams.length;i++)
       {
                if(arrParamNames[i] == paramName){
            //alert("Param:"+arrParamValues[i]);
                return arrParamValues[i];
             }
       }
       return "No Parameters Found";
    }

}


function SelectPublisher()
{
    $("#c2").attr('checked',true);
    $("#c2").attr("disabled", true);
    $("#c3").attr('checked',false);
    $("#c3").attr("disabled", false);
    
    $("#user_type").val("3");
}
function SelectAdvertiser()
{
    $("#c2").attr('checked',false);
    $("#c2").attr("disabled", false); 
    $("#c3").attr('checked',true);
    $("#c3").attr("disabled", true); 
    
    $("#user_type").val("2");
}
jQuery(document).ready(function($) {
	"use strict";
	$(function(){
		$(".signup-form").find(".button").click(function(){$(".signup-form").submit();});
		$(".signup-form").on(".email.error",function(){$(this).removeClass("error");});
		$(".signup-form").submit(function(e){
			e.preventDefault();

			///validate form
            var pass = $("#password").val();
            var confirm = $("#fieldConfirm").val();
            if(pass != confirm)
            {
                $("#tick-text2").html("Please check password again");
                $("#box-sign-up").addClass("success");
                
            }
            else
            {    
                if($('#c1').is(':checked')) 
                {     
                    if(requestSent) 
                    {
                        requestSent = false;
                        //alert("aaa");
                        return;
                    }
                    requestSent = true;
                    var serializedData = $(".signup-form").serialize();
                    
                      // fire off the request to /form.php
                      
                    var request;
                    request = $.ajax({
                        url: "signup.php",
                        type: "post",
                        data: serializedData
                    });

                    // callback handler that will be called on success
                    request.done(function (response, textStatus, jqXHR){
                        // log a message to the console
                        console.log("Hooray, it worked!");
                        $("#signup-div").css("display","none");
                        $("#tick-text2").html(response);
                         $("#box-sign-up").addClass("success");
                    });

                    // callback handler that will be called on failure
                    request.fail(function (jqXHR, textStatus, errorThrown){
                        // log the error to the console
                        console.error(
                            "The following error occured: "+
                            textStatus, errorThrown
                        );
                    });
                }
                else
                {
                    $("#tick-text2").html("Please agree Term & Conditions");
                     $("#box-sign-up").addClass("success");
                }
            }
		});
	});
    
    
 
/*-----------------------------------------------------------------------------------

	Modal windows
 
----------------------------------------------------------------------------------*/

 $("#sign-up").hide();
 $("#sign-in").hide();
 $("#forget").hide();
 
 
 
 var mode = getURLParameters('mode');
 var error = getURLParameters('error');
    
if(mode=='login')
{
     window.scrollTo(0, 0);
     $("#sign-in").fadeIn(); 
     
     
     if(error == 'suspend')
     {
          $("#tick-text4").html("Your account is suspended!");
          $("#box-login").addClass("success");
     }
     else if(error == 'review')
     {
         $("#tick-text4").html("Your account is still pending review.");
         $("#box-login").addClass("success");
     }
     else if(error == 'wrong')
     {
         $("#tick-text4").html("Wrong user name and/or password!");
         $("#box-login").addClass("success");
     }
}
else if(mode=='forget')
{
    window.scrollTo(0, 0);
    $("#forget").fadeIn();
    
    if(error == 'noemail')
    {
        $("#forget #tick-text4").html("Your email is not registerd.");
        $("#box-forget").addClass("success");
    }
    else if(error == 'success')
    {
        $("#forget #tick-text4").html("Your password has been sent, please check your email.");
        $("#box-forget").addClass("success");
    }    
}


 $(".notify-button, .footer-button").click(function(){
 	 window.scrollTo(0, 0);
 $("#sign-up").fadeIn(); 
 });

 $(".white-btn, .black-btn").click(function(){
     $("#box-sign-up").removeClass("success");
 	 window.scrollTo(0, 0);
 $("#sign-up").fadeIn(); 
 });

$(".top-bar .black-btn").click(function(){
    $("#box-login").removeClass("success");
     window.scrollTo(0, 0);
     $("#sign-in").fadeIn(); 
 });
  
$("#box-login #forget_btn").click(function(){
    $("#box-forget").removeClass("success");
     window.scrollTo(0, 0);
     $("#forget").fadeIn(); 
 }); 

 $(".disclaimer a").click(function(){
 	 window.scrollTo(0, 0);

 });



 $(".cross").click(function(){
 $("#sign-in").fadeOut(); 
 $("#sign-up").fadeOut();
 $("#forget").fadeOut(); 

 });

 SelectPublisher(); //when start , select publisher as default
//...

/*-----------------------------------------------------------------------------------

Dropdown elements
 
----------------------------------------------------------------------------------*/
 
$(function() {
 
    var dd = new DropDown( $('#dd') );
 
    $(document).click(function() {
        // all dropdowns
        $('.wrapper-dropdown-1').removeClass('active');
    });
 
});


function DropDown(el) {
    this.dd = el;
    this.placeholder = this.dd.children('span');
    this.opts = this.dd.find('ul.dropdown > li');
    this.val = '';
    this.index = -1;
    this.initEvents();
}
DropDown.prototype = {
    initEvents : function() {
        var obj = this;
 
        obj.dd.on('click', function(event){
            $(this).toggleClass('active');
            return false;
        });
 
        obj.opts.on('click',function(){
            var opt = $(this);
            obj.val = opt.text();
            obj.index = opt.index();
            //obj.placeholder.text('Gender: ' + obj.val);
        });
    },
    getValue : function() {
        return this.val;
    },
    getIndex : function() {
        return this.index;
    }
}





/*-----------------------------------------------------------------------------------

Parallax
 
----------------------------------------------------------------------------------*/

jQuery(document).ready(function(){


	


 /* Scroll event handler */
 $(window).bind('scroll',function(){
 parallaxScroll();
 });
var scrolled;
function parallaxScroll(){
	scrolled = $(window).scrollTop();
	$('#parallax-background').css('top',(0-(scrolled*0.02))+'px');
	$('#parallax-banner-text').css('top',(0-(scrolled*0.17))+'px');
	$('#parallax-macbook').css('top',(0-(scrolled*0.20))+'px');
	$('#parallax-under-content').css('top',(0-(scrolled*0.25))+'px');
	$('#parallax-iphone-banner').css('top',(0-(scrolled*1.00))+'px');
	$('#parallax-panels').css('top',(0-(scrolled*0.5))+'px');
	$('#parallax-panel-content').css('top',(0-(scrolled*0.75))+'px');
	$('#parallax-footer').css('top',(0-(scrolled*0.85))+'px');
	$('.background').css('top',(0-(scrolled*0.85))+'px');
	
}


/*-----------------------------------------------------------------------------------

 Buttons
 
----------------------------------------------------------------------------------*/



/* getting viewport width */
var responsive_viewport = $(window).width();


function removeOrengeTopLineFromMenu()
{
    $('#go-home').removeClass('current-menu-item');
    $('#go-sum').removeClass('current-menu-item');
    $('#go-pub').removeClass('current-menu-item');
    $('#go-advert').removeClass('current-menu-item');
    $('#go-about').removeClass('current-menu-item');
    $('#go-contact').removeClass('current-menu-item');
    //$(this).closest('li').addClass('menu-item current-menu-item');
}

if (responsive_viewport > 1100) {

$('.panel-plan .button').click(function() {
	$('html, body').animate({
        scrollTop: (16005)
    }, 700);
    return false;

})
                          
$('#go-home').click(function(){

    removeOrengeTopLineFromMenu();
    //$('.menu-item current-menu-item').removeClass('current-menu-item');
    $(this).addClass('current-menu-item');
    //$('#go_contact').last().addClass('current-menu-item');
       
    $('html, body').animate({
        scrollTop: (0)
    }, 700);
    return false;
})
$('#go-home-footer').click(function(){

    removeOrengeTopLineFromMenu();
    //$('.menu-item current-menu-item').removeClass('current-menu-item');
    $(this).addClass('current-menu-item');
    //$('#go_contact').last().addClass('current-menu-item');
       
    $('html, body').animate({
        scrollTop: (0)
    }, 700);
    return false;
})

$('#go-contact').click(function(){

	removeOrengeTopLineFromMenu();
    //$('.menu-item current-menu-item').removeClass('current-menu-item');
    $(this).addClass('current-menu-item');
    //$('#go_contact').last().addClass('current-menu-item');
       
    $('html, body').animate({
        scrollTop: (16005)
    }, 700);
    return false;
})
$('#go-contact-footer').click(function(){

    removeOrengeTopLineFromMenu();
    //$('.menu-item current-menu-item').removeClass('current-menu-item');
    $(this).addClass('current-menu-item');
    //$('#go_contact').last().addClass('current-menu-item');
       
    $('html, body').animate({
        scrollTop: (16005)
    }, 700);
    return false;
})

$('#go-sum').click(function(){

	removeOrengeTopLineFromMenu();
    $(this).addClass('current-menu-item');
       
    $('html, body').animate({
        scrollTop: (1058)
    }, 700);
    return false;
})
$('#go-sum-footer').click(function(){

    removeOrengeTopLineFromMenu();
    $(this).addClass('current-menu-item');
       
    $('html, body').animate({
        scrollTop: (1058)
    }, 700);
    return false;
})

$('#go-pub').click(function(){

	removeOrengeTopLineFromMenu();
    $(this).addClass('current-menu-item');
       
    $('html, body').animate({
        scrollTop: (3474)
    }, 700);
    return false;
})
$('#go-pub-footer').click(function(){

    removeOrengeTopLineFromMenu();
    $(this).addClass('current-menu-item');
       
    $('html, body').animate({
        scrollTop: (3474)
    }, 700);
    return false;
})

$('#go-advert').click(function(){

    removeOrengeTopLineFromMenu();
    $(this).addClass('current-menu-item');
       
    $('html, body').animate({
        scrollTop: (6686)
    }, 700);
    return false;
})
$('#go-advert-footer').click(function(){

    removeOrengeTopLineFromMenu();
    $(this).addClass('current-menu-item');
       
    $('html, body').animate({
        scrollTop: (6686)
    }, 700);
    return false;
})

$('#go-about').click(function(){

	removeOrengeTopLineFromMenu();
    $(this).addClass('current-menu-item');
       
    $('html, body').animate({
        scrollTop: (10466)
    }, 700);
    return false;
})
$('#go-about-footer').click(function(){

    removeOrengeTopLineFromMenu();
    $(this).addClass('current-menu-item');
       
    $('html, body').animate({
        scrollTop: (10466)
    }, 700);
    return false;
})

 } else {

 	$('.nav-menu li a').click(function(){
    $('html, body').animate({
        scrollTop: $( $.attr(this, 'href') ).offset().top -50
    }, 500);
    return false;
    });

    $('.panel-plan .button').click(function() {
	$('html, body').animate({
       scrollTop: $( "#mobile-contact-us" ).offset().top -50
    }, 500);
    return false;

})

 }


 

/*-----------------------------------------------------------------------------------

Site Navigation
 
-----------------------------------------------------------------------------------*/

var nav = document.getElementById( 'site-navigation' ), button, menu;
	if ( ! nav )
		return;
	button = nav.getElementsByTagName( 'h3' )[0];
	menu   = nav.getElementsByTagName( 'ul' )[0];
	if ( ! button )
		return;


	button.onclick = function() {
		if ( -1 == menu.className.indexOf( 'nav-menu' ) )
			menu.className = 'nav-menu';

		if ( -1 != button.className.indexOf( 'toggled-on' ) ) {
			button.className = button.className.replace( ' toggled-on', '' );
			menu.className = menu.className.replace( ' toggled-on', '' );
		} else {
			button.className += ' toggled-on';
			menu.className += ' toggled-on';
		}
	};





$(".iphone-banner-container").hide();





});
});

