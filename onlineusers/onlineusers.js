//$(document).ready(AddUser);
function GetUser(type)
{
//type 1 is game logged
//type 2 is web logged
	$.ajax({
		method: "POST",
		url: "online.php",
		data: { user_type: type },
		success: function(data) {
			var obj = jQuery.parseJSON(data);
			console.log(obj);
		}
	});
}
GetUser(1);

function AddUser() 
{
	var container = document.getElementById("new_user_container_web");

	// request	
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
