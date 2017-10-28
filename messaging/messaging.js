function unhide(clickedButton, divID) {
var item = document.getElementById(divID);
var ab = document.getElementById('username').innerText;
console.log(ab);
ab = "ab";
console.log(ab);
if (item) {
    if(item.className=='hidden'){
        item.className = 'unhidden' ;
        clickedButton.value = 'hide'
    }else{
        item.className = 'hidden';
        clickedButton.value = 'unhide'
    }
}
$.post("../messaging/messaging.php", {usrnm:ab});
console.log("cool");
}

function hide(clickedButton, divID) {
var item = document.getElementById(divID);
if (item) {
    if(item.className=='unhidden'){
        item.className = 'hidden' ;
        clickedButton.value = 'hide'
    }else{
        item.className = 'uhidden';
        clickedButton.value = 'hide'
    }
}}
