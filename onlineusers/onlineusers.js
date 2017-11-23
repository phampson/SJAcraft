/* Display logged in users for Web in page load */
$(document).ready(AddUsers(2));

/* Display logged in users when selection changes */ 
$('#order-by').change(function() {
    document.getElementById('new_user_container').innerHTML = "";
    var dropdown = document.getElementById("order-by");
    var val = dropdown.options[dropdown.selectedIndex].value // "W" or "G"
    if(val == "W") {
        AddUsers(2);
    } else {
        AddUsers(1);
    }
});

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

/*
*This is a copy of the above function to try and get 
*the user's id into an array
*/
function GetId(input)
{
	jQuery.extend({
		GetUser: function(type) 
		{	
			var result = null;
			$.ajax({
			method: "POST",
			url: "onlineId.php",
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


/*
*This is a copy of the above function to try and get 
*the user's Avatar path into an array. It ain't no airbender
*/
function GetAvatar(input)
{
	jQuery.extend({
		GetUser: function(type) 
		{	
			var result = null;
			$.ajax({
			method: "POST",
			url: "onlineAvatar.php",
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

function AddUsers(type) 
{
	var container = document.getElementById("new_user_container");

	// request	
	var users = Get(type);
        // array of user IDs 
	var users_id = GetId(type);
        // array of user's avatar image pathway
	var users_avatar = GetAvatar(type);

	// add users
	console.log(users);
	for(var i in users) {
		console.log(users[i]);
		var html_string = ' \
		<div class="row"> \
			<div class="div2 col-xs-12 col-sm-10 col-sm-offset-1"> \
				<img align=left src="../profile/' + users_avatar[i] +  '" style="width:60px;height:60px" alt="Warcraft main picture"></img> \
                        	<a href="../profile/profile.php?id=' + users_id[i] + '"><h3> ' + users[i] + '</h3></a> \
			</div> \
		</div> \
		<br>';

		container.insertAdjacentHTML('beforeend', html_string);
	}
}
