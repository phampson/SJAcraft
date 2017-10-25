
	alert("HELLO2");
	var container = document.getElementById("new_user_container");

	// request
	var hr = new XMLHttpRequest();
	hr.open("POST", "online.php", true);
	hr.setRequestHeader("content-type", "application/x-www-form-urlencoded");
	hr.onreadystatechange = function()
	{
		if(hr.readyState == 4 && hr.status == 200) {
			var rec = hr.responseText;
			console.log("predict return: " + rec);
		
			var user_array = rec.split(",");
			// Add User
			for(i = 1; i < user_array.length(); i++ ) {
				var user_name = user_array[i];
				console.log(user_name);
				//container.insertHTML(user_name);
			}
		}
	}
	hr.send();
