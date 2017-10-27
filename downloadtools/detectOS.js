$(document).ready(function (){
		findOS();
	});
var operatingSystem = "Unknown";
var appVer = "";
var mobileOS = "";
var isMobileOS = false;
function findOS() 
{
    isMobile();
    if (isMobileOS) {
        operatingSystem = mobileOS;
    } else {
        appVer = navigator.appVersion;
        switch(appVer != "") {
            case (appVer.indexOf("Win")!=-1):
                //operatingSystem = "Windows";
		operatingSystem = 0;
                break;
            case (appVer.indexOf("Mac")!=-1):
                //operatingSystem = "MacOS";
		operatingSystem = 1;
                break;
            case (appVer.indexOf("X11")!=-1):
                //operatingSystem = "UNIX";
		operatingSystem = 2;                
		break;
            case (appVer.indexOf("Linux")!=-1):
                //operatingSystem = "Linux";
		operatingSystem = 3;
                break;      
        }       
    }
	switch(operatingSystem != -9) {
		case(operatingSystem == 0): // Windows
			document.getElementById("downloadButton").innerHTML = '<a href="game_files/ECS160Linux-master.zip" download="Windows"><img border="0" src="../img/dldbtn.png"></img></a>';
			break;
		case(operatingSystem == 1): // Mac
			document.getElementById("downloadButton").innerHTML = '<a href="game_files/ECS160Linux-master.zip" download="Mac"><img border="0" src="../img/dldbtn.png"></img></a>';
			break;
		case(operatingSystem == 2): // UNIX
			document.getElementById("downloadButton").innerHTML = '<a href="game_files/ECS160Linux-master.zip" download="Linux"><img border="0" src="../img/dldbtn.png"></img></a>';
			break;
		case(operatingSystem == 3): // Linux
			document.getElementById("downloadButton").innerHTML = '<a href="game_files/ECS160Linux-master.zip" download="Linux"><img border="0" src="../img/dldbtn.png"></img></a>';
			break;
		case(operatingSystem == 4): // Android
			document.getElementById("downloadButton").innerHTML = '<a href="game_files/ECS160Linux-master.zip" download="Android"><img border="0" src="../img/dldbtn.png"></img></a>';
			break;
		case(operatingSystem == 5): // iOS
			document.getElementById("downloadButton").innerHTML = '<a href="game_files/ECS160Linux-master.zip" download="iOS"><img border="0" src="../img/dldbtn.png"></img></a>';
			break;
	}
}
function isMobile()
{
    if(navigator.userAgent.match(/Android/i)) {
        isMobileOS = true;
        mobileOS = "4";
    } else if (navigator.userAgent.match(/iPhone|iPad|iPod/i)) {
        isMobileOS = true;
        mobileOS = "5";
    }
}
