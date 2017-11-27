console.log(location.href+'#'+location.hash+'?'+location.search);
function Get(name, pass)
{
	jQuery.extend({
		GetUser: function(name, pass) 
		{	
			var result = null;
			$.ajax({
			method: "POST",
			url: "login.php",
			async : false,
			data: { username: name, password: pass },
			dataType: "json",
			success: function(data) {
		            result = data;
		        }
			});
			return result;
		}
	});
	var tem= $.GetUser(name, pass);
	return tem;
}

	function loginError(form) {
		//console.log("sss1");
		var user = document.getElementById("username").value;
		var pass = document.getElementById("password").value;
		var res = Get(user,pass);
		if(res.message=="success")
		{
		window.location.href = '../profile/profile.php';
		return false;
		}

		if(user == "") {
			displayAlert("empty username");
			return false;
		}
		else if(pass == "") {
			displayAlert("empty password");
			return false;
		}
		if(res!=null)		
		{//console.log(res.message);
		//console.log("sss2");
		displayAlert(res.message);}
		return false;
	}

	function displayAlert(text1) {
		 $('#myAlert').text(text1);
		 $('#myAlert').show('fade');
            setTimeout(function () {
                $('#myAlert').hide('fade');
            }, 3000);

	}

	 $('#form1').submit(function (e) {
	 	console.log("aa");
        if (!loginError(this)) e.preventDefault();
    });

