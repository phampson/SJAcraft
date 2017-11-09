console.log(location.href+'#'+location.hash+'?'+location.search);
	function signUpError(form) {

		var email = document.getElementById("email").value;
		var user = document.getElementById("username").value;
		var pass = document.getElementById("password").value;
		var maxLength = 80;

		// check if blank
		if((email == "") || (user == "") || (pass == "")) {
   			displayAlert(0);
			return false;
		}

		// check for max length
		if((email.length > maxLength) || (user.length > maxLength) || (pass.length > maxLength)) {
			displayAlert(4);
			return false;
		}

		// check for newline, space, "|"
		for(var i = 0; i < email.length; i++) {
   			if((email[i] == ' ') || (email[i] == '\n') || (email[i] == '|')) {
				displayAlert(1);	
				return false
			}
  		}	
		for(var i = 0; i < user.length; i++) {
			if((user[i] == ' ') || (user[i] == '\n') || (user[i] == '|')) {
                                displayAlert(2);
                                return false
                        }
                }
		for(var i = 0; i < pass.length; i++) {
			if((pass[i] == ' ') || (pass[i] == '\n') || (pass[i] == '|')) {
                                displayAlert(3);
                                return false
                        }
                }
		
		return true;
	}

	// code 0: field not completed
	// code 1: email invalid char
	// code 2: user invalid char
	// code 3: pass invalid char
	// code 4: larger than maxLength
	function displayAlert(code) {
		if(code == 0) {
			var myAlert = '#alertRequired';
		} else if(code == 1) {
			var myAlert = '#alertEmail';
		} else if(code == 2) {
			var myAlert = '#alertUser';
		} else if(code == 3) {
			var myAlert = '#alertPass';
		} else if(code == 4) {
			var myAlert = '#alertMax';
		} else {
			var myAlert = '#alertGeneral';
		}

		$(myAlert).show('fade');
		setTimeout(function () {
			$(myAlert).hide('fade');
		}, 3000);
	}

	 $('#form').submit(function (e) {
        if (!signUpError(this)) e.preventDefault();
    });
