console.log(location.href+'#'+location.hash+'?'+location.search);
	function signUpError(form) {

		var email = document.getElementById("email").value;
		var user = document.getElementById("username").value;
		var pass = document.getElementById("password").value;

		if (email == "") {
   			displayAlert();
			return false;
		}
		else if(user == "") {
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
        if (!signUpError(this)) e.preventDefault();
    });

	 // function displayAlert {
	 // 	 $('#myAlert').show('fade');
	 // 	 setTimeout(function () {
  //               $('#myAlert').hide('fade');
  //           }, 2000);
	 // }

