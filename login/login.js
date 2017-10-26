console.log(location.href+'#'+location.hash+'?'+location.search);

	function loginError(form) {

		var user = document.getElementById("username").value;
		var pass = document.getElementById("password").value;


		if(user == "") {
			displayAlert();
			return false;
		}
		else if(pass == "") {
			displayAlert();
			return false;
		}
		
		return true;
	}

	function displayAlert() {
		 $('#myAlert').show('fade');
            setTimeout(function () {
                $('#myAlert').hide('fade');
            }, 3000);

	}

	 $('#form').submit(function (e) {
        if (!loginError(this)) e.preventDefault();
    });
