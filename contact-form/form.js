
$(document).ready(function (){
//Javascript validations

	$('#contact').validate({
		rules:{
			cname:{
				required: true,
				minlength: 2
			},
			email:{
				required: true,
				email: true
			},
			phone:{
				required: false,
				number: true
			},
			message:{
				required: true,
				minlength: 2
			},

		},
		
		messages:{
			cname:{
				required: "Please enter your name",
				minlength: "your name must consist of at least 2 characters"
			},
			email:{
				required: "Please enter your email",
				email: "Invalid email"
			},
			message:{
				required: "Please enter your message",
				minlength: "your message must consist of at least 2 characters"
			}
			
		},
		
		//submit form using ajax
		 submitHandler: function(form) {    var $form = $( this ),
          url = $form.attr( 'action' );
			$(form).ajaxSubmit({
				type:"POST",
                data: $(form).serialize(),
				url: url,
				success: function(data) { 
				var formData = $(form).serialize();
					//console.log(formData);
                    $('#contact :input').attr('disabled', 'disabled');
                    $('#contact').fadeTo( "slow", 0.15, function() {
                        $(this).find(':input').attr('disabled', 'disabled');
                        $(this).find('label').css('cursor','default');
                        $('div#success').fadeIn();
                    });
					console.log(data);
                },
				error: function() {
                    $('#contact').fadeTo( "slow", 0.15, function() {
                        $('#error').fadeIn();
                    });
                }
				
			 });
		 }
	});
	
});