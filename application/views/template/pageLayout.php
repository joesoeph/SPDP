<?=doctype()?>

<html lang="en">
<head>
    <title> <?=$Title?> </title>
    <?php

    echo $Meta;
    echo $Css;

    if (! empty($AddCss)) {
        foreach ($AddCss as $Val) {
            echo link_css($Val);
        }
    }

    if (! empty($AddJsHeader)) {
        foreach ($AddJsHeader as $Val) {
            echo link_js($Val);
        }
    }
?>
<script type="text/javascript">
var timer = 0;
function set_interval() {
// the interval 'timer' is set as soon as the page loads
timer = setInterval("auto_logout()", 10000);
// the figure '10000' above indicates how many milliseconds the timer be set to.
// Eg: to set it to 5 mins, calculate 5min = 5x60 = 300 sec = 300,000 millisec.
// So set it to 300000
}

function reset_interval() {
//resets the timer. The timer is reset on each of the below events:
// 1. mousemove   2. mouseclick   3. key press 4. scroliing
//first step: clear the existing timer

if (timer != 0) {
  clearInterval(timer);
  timer = 0;
  // second step: implement the timer again
  timer = setInterval("auto_logout()", 10000);
  // completed the reset of the timer
}
}

function auto_logout() {
// this function will redirect the user to the logout script
window.location = "your_logout_script.php";
}

// Add the following attributes into your BODY tag
onload="set_interval()"
onmousemove="reset_interval()"
onclick="reset_interval()"
onkeypress="reset_interval()"
onscroll="reset_interval()"
</script>
<?php
echo "</head>\n";
echo "<body>\n";

if ($Content) echo $Content;

if (! empty($AddJsFooter)) {
    foreach ($AddJsFooter as $RowJsFooter) {
        echo link_js($RowJsFooter);
    }
}
?>

</body>
</html>
