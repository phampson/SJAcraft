<?php
$i = rand(0,1);
if ($i == 0) {
    $img = "http://drawyourprofessor.com/Chris-Nitta-1491603955.png";
} else {
    $img = "http://drawyourprofessor.com/Chris-Nitta-1480399322.png";
}

echo "
<font face='arial' size='300%'>
    403/404 ERROR:
</font>

<br>

<font face='arial' size='250%'>
YOUR EYES ARE PEEKING IN PLACES THEY SHOULDN'T BE.
</font>

<br>

<center>
    <img src='$img'>
</center>";

?>
