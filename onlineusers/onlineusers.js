$(document).ready(AddUsers(1));
//$(document).ready(AddUsers(2));

// returns JSON array of logged in users 
// type 1: game
// type 2: web
function Get(input)
{
	jQuery.extend({
		GetUser: function(type) 
		{	
			var result = null;
			$.ajax({
			method: "POST",
			url: "online.php",
			async : false,
			data: { user_type: type },
			dataType: "json",
			success: function(data) {
		            result = data;
		        }
			});
			 return result;
		}
	});
	var tem= $.GetUser(input);
	return tem;
}
//console.log(tem);

function AddUsers(type) 
{
	if(type == 1) {
		var container = document.getElementById("new_user_container_game");
	}
	else {
		var container = document.getElementById("new_user_container_web");
	}

	// request	
	var users = Get(type);

	// add users
	console.log("Hello");
	console.log(users);
	for(var i in users) {
		console.log(users[i]);
		var html_string = ' \
		<div class="row"> \
			<div class="col-sm-2 col-sm-offset-1"> \
				<img align=left src="../img/default.png" style="width:60px;height:60px" alt="Warcraft main picture"></img> \
			</div> \
			<div class="col-sm-4"> \
				<h3>' + users[i] + '</h3> \
			</div> \
			<div class="col-sm-5"> \
				<img align=left src="../img/maps/plus.jpg" style="width:60px;height:60px" alt="Add Friend picture"></img> \
			</div> \
		</div> \
		<br>'

		container.insertAdjacentHTML('beforeend', html_string);
	}
}
