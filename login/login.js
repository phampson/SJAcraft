console.log(location.href+'#'+location.hash+'?'+location.search);
	function loginError(form) {

		var user = document.getElementById("username").value;
		var pass = document.getElementById("password").value;


		if(user == "") {
			alert("Please enter username or email");
			return false;
		}
		else if(pass == "") {
			alert("Please enter password");
			return false;
		}
		
		return true;
	}

	 $('#form').submit(function (e) {
        if (!loginError(this)) e.preventDefault();
    });