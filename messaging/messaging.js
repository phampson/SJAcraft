function unhide(clickedButton, divID) {
var item = document.getElementById(divID);
if (item) {
    if(item.className=='hidden'){
        item.className = 'unhidden' ;
        clickedButton.value = 'hide'
    }else{
        item.className = 'hidden';
        clickedButton.value = 'unhide'
    }
}}

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