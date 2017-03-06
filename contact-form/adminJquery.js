
jQuery(document).ready(function($) {

		$("#contactDetails").dialog({ 
			autoOpen: false,
			resizable: true,
			modal: true,
			width:'auto'
			
	   
	   });
	   
	   $(".viewContact").click(function () {
					var name = $(this).data("record-name");
					var email = $(this).data("record-email");
					var phone = $(this).data("record-phone");
					
					$("#contactDetails").dialog('open');
					$("#dialog-name").html(name);
					$("#dialog-email").html(email);
					$("#dialog-phone").html(phone);

					return false;
        });
		
		$("#contactDelete").dialog({ 
			autoOpen: false,
			resizable: true,
			modal: true,
			width:'auto'
			
	   
	   });
	   
	   $(".deleteContact").click(function () {
					var id = $(this).data("record-id");
					var name = $(this).data("record-name");
					
		$("#contactDelete").dialog('option', 'buttons', {
            "Confirm" : function() {
                window.location.href = theHREF;
            },
            "Cancel" : function() {
                $(this).dialog("close");
            }
        });

        $("#contactDelete").dialog("open");
		 $("#contactDelete").html("Are you sure you want to delete conact <strong>" + name + "</strong>");
        });

});