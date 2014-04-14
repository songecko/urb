function facebookLogin()
{
	FB.login(function(response)
	{
		if (response.authResponse) {
			window.location = "http://ganoconlg.com/facebook-login";
		}
	}, {scope: 'basic_info, email, user_birthday, publish_actions'});
};

var sending = false;
$(document).ready(function()
{
	$('.boton1').mouseenter(function() 
	{
		$(this).addClass('hover');
	}).mouseleave(function() 
	{
		$(this).removeClass('hover');
	});
	
	//Facebook
	/*$.ajaxSetup({ cache: true });
	$.getScript('//connect.facebook.net/es_LA/all.js', function()
	{
		FB.init({
			appId: '1452880464948036',
	        status     : true,
	        xfbml      : true
	    });     
		FB.Event.subscribe('auth.statusChange', function(response) 
		{
		    if (response.status === 'connected') {
		      fillForm();
		    } else {
		      facebookLogin();
		    }
		});
	});
	  
	$('.facebookButton').click(function()
	{
		facebookLogin();
	});
	
	//Form	
	$("section#form form").validate(
	{
		onkeyup: false,
		onclick: false,
		onfocusout: false,
		errorPlacement: function(error, element) 
		{
		},
		highlight: function(element, errorClass, validClass) 
		{
		    $(element).addClass(errorClass).removeClass(validClass);
		},
		unhighlight: function(element, errorClass, validClass) 
		{
		    $(element).removeClass(errorClass).addClass(validClass);
		},
		invalidHandler: function(event, validator)
		{
			alert("Debes completar todos los campos obligatorios");
		},
		submitHandler: function(form)
		{
			if(!sending)
			{				
				sending = true;
				
				$.ajax({
	                type: "POST",
	                url: 'http://ganoconlg.com/register',
	                data: $(form).serialize(),
	                success: function(data, textStatus, jqXHR)
	                {
	                	$(form).trigger("reset");
	                	window.location = "http://ganoconlg.com/thanks";
	                	sending = false;
	                }
				});
			}
		}
	});*/
});