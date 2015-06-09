$(document).ready(function()
{
		$("#reg_user").click(function(){
	
			username = $("#username").val() || "";
			password = $("#password").val() || "";
			email = $("#email").val() || "";
			department = $("#department").val() || "";
			entity = $("#entity").val() || "";
		
			if (username.length<6 || username == "username")
		    	{
		    		$('#username').removeClass('valid_sty').addClass('error_sty');
		    		return false;
		    	}else{ $('#username').removeClass('error_sty'); }

			if (password.length<6 || password == "password")
		    	{
		    		$('#password').removeClass('valid_sty').addClass('error_sty');
		    		return false;
		    	}else{ $('#password').removeClass('error_sty'); }

			if (email.length<6 || email == "email")
		    	{
		    		$('#email').removeClass('valid_sty').addClass('error_sty');
		    		return false;
		    	}else{ $('#email').removeClass('error_sty'); }

			if (department < 1)
		    	{
		    		$('#department').removeClass('valid_sty').addClass('error_sty');
		    		return false;
		    	}else{ $('#department').removeClass('error_sty'); }

			if (entity < 1)
		    	{
		    		$('#entity').removeClass('valid_sty').addClass('error_sty');
		    		return false;
		    	}else{ $('#entity').removeClass('error_sty'); }
			return true;
		});

		$("#us_login").click(function()
		{
					email = $("#authemail").val() || "";
					password = $("#authpassword").val() || "";
		
					if (email.length<6 || email == "email")
				    	{
				    		$('#authemail').removeClass('valid_sty').addClass('error_sty');
				    		return false;
				    	}else{ $('#authemail').removeClass('error_sty'); }

					if (password.length<6 || password == "password")
				    	{
				    		$('#authpassword').removeClass('valid_sty').addClass('error_sty');
				    		return false;
				    	}else{ $('#authpassword').removeClass('error_sty'); }
					return true;
		});
});
