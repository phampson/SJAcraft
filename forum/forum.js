// Get all posts from database
//$(document).ready(dumpAllPosts());

// Turn on overlay when 'Start New Discussion' is clicked
function on() {
    document.getElementById("overlay").style.display = "block";
    document.getElementById("postContainer").style.display = "block";
}

// Turn off overlay when exit button is clicked
function off() {
    document.getElementById("overlay").style.display = "none";
    document.getElementById("postContainer").style.display = "none";
}

// Display Posts when tab is clicked
function openCategory(evt, cityName) {
      var i, tabcontent, tablinks;
      tabcontent = document.getElementsByClassName("tabcontent");
      for (i = 0; i < tabcontent.length; i++) {
          tabcontent[i].style.display = "none";
      }
      tablinks = document.getElementsByClassName("tablinks");
      for (i = 0; i < tablinks.length; i++) {
          tablinks[i].className = tablinks[i].className.replace(" active", "");
      }
      document.getElementById(cityName).style.display = "block";
      evt.currentTarget.className += " active";
}


// Dump all posts from database
function dumpAllPosts() {

    $.ajax({
        url: 'getPosts.php',
        type: 'GET',
        success: function(data) {
            var obj = jQuery.parseJSON(data);
            getCategories(obj);
        }
    });
}

// Insert data into html
function getCategories(data) {

    for (var i = 0; i < data.length; i++) {
        // console.log("element: ", data[i]);
	
	 switch  (data[i][5]) {
                case 'beginner': 
                	container = document.getElementById("Beginners");
			break;
                case 'strategies': 
                	container = document.getElementById("Strategies");
			break;
                case 'maps': 
                	container = document.getElementById("Maps");
			break;
                case 'gameUpdates': 
                	container = document.getElementById("Game_Updates");
			break;
                case 'general': 
                	container = document.getElementById("General");
			break;
	}  

		getAvatarPath(data[i], container);

	}
	
}

// Search database for avatar_path of a user using their username
function getAvatarPath(post, container) {

	$.ajax({
		method: "POST",
		url: "getAvatarPath.php",
		data: { post_user: post[1] },
		success: function(data) {
			var obj = jQuery.parseJSON(data);
			getUsername(post, obj[0], container);
		}
	});

}

// Format the new post's html and add it to container
function getUsername(post, path, container)
{

    $.ajax({
		method: "POST",
		url: "getUsername.php",
		data: { id: post[1] },
		success: function(data) {
            var obj = jQuery.parseJSON(data);
            console.log("obj: " + obj);
            formatHTMLString(post, path, container, obj);
        }
     });
}

function formatHTMLString(data, path, container, username) {
	postId = data[0];	
	user_id = data[1];
	header = data[2];
	content = data[3];
	date = data[4];
	
 			var html_string = ' \
             	<a href="comments.php?postId=' + postId + '"> \
            		<div class="jumbotron div2"> \
              			<div class="col-sm-1"> <img align=left src="../profile/' + path + ' " alt= "' + path + ' " style="width:100px;height:100px;"> <p> ' + username +' </p></div> \
              			<div class = "col-xs-9 col-xs-offset-1"><h3> ' + header + '</h3></div> \
              			<div class = "col-xs-4 col-xs-offset-1"><p> ' + content + ' </p></div> \
              			<div class = "col-xs-9 col-xs-offset-1"><footer><font color="white"> ' + date +' </font></footer></div> \
            		</div> \
          	            </a> '

		    container.insertAdjacentHTML('beforeend', html_string); 
}

// Search feature
function search(form)
{
    searchText = form.searchText.value;

    $.ajax({
		method: "POST",
		url: "search.php",
		data: { searchText: searchText },
		success: function(data) {
            var obj = jQuery.parseJSON(data);
            printSearchResults(obj);
		}
	});
}

function printSearchResults(data)
{
    document.getElementById("overlay").style.display = "none";
    document.getElementById("postContainer").style.display = "none";
    document.getElementById("searchBar").style.display = "none";
    document.getElementById("tabContainer").style.display = "none";

    var container = document.getElementById("searchResults");
    
    // ADD: Style the below html string
    var htmlString = '\
                     <p style="background-color:white; text-align:center"> Search Results </p> \
                     <button onClick="window.location.reload();"> Back </button>'
    container.insertAdjacentHTML('beforeend', htmlString);

    for (var i = 0; i < data.length; i++) {
        getAvatarPath(data[i], container); 
    }
}
