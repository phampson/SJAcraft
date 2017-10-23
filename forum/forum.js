function on() {
    document.getElementById("overlay").style.display = "block";
    document.getElementById("postContainer").style.display = "block";
}

function off() {
    document.getElementById("overlay").style.display = "none";
    document.getElementById("postContainer").style.display = "none";
}

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
