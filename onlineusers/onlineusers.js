$(document).ready(AddUser);

function AddUser() 
{
	var container = document.getElementById("new_user_container_web");

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
			for(i = 1; i < user_array.length; i++ ) {
				var user_name = user_array[i];
				console.log(user_name);
				
				var html_string = ' \
			<div class="row"> \
                                <div class="col-sm-2 col-sm-offset-1"> \
                                        <img align=left src="../img/default.png" style="width:60px;height:60px" alt="Warcraft main picture"></img> \
                                </div> \
                                <div class="col-sm-4"> \
                                        <h3>' + user_name + '</h3> \
                                </div> \
                                <div class="col-sm-5"> \
                                        <img align=left src="../img/maps/plus.jpg" style="width:60px;height:60px" alt="Add Friend picture"></img> \
                                </div> \
                        </div> \
			<br>'
				container.insertAdjacentHTML('beforeend', html_string);
			}
		}
	}
	hr.send();
}
