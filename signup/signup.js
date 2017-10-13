function myWelcome() {
	var email = document.getElementById("email").value;
	var user = document.getElementById("user").value;
	var pass = document.getElementById("pass").value;

	if(email == "") {
		alert("Please enter email");
	}
	else if(user == "") {
		alert("Please enter username");
	}
	else if(pass == "") {
		alert("Please enter password");
	}
	else {
		alert("Welcome " + user + "!");
	}
}