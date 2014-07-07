<html><head>
		<link type="text/css" rel="stylesheet" href="anmeldung.css">
		<title>Browsercheck</title>
		</head>
<?php

/**
 * @author Carsten Elsner
 * @copyright 2008
 */


// echo $_SERVER['HTTP_USER_AGENT'];
// echo "<br>";
// echo "<br>";
$version=$_SERVER['HTTP_USER_AGENT'];

// Browser Check
// OPERA
if( eregi("(opera) ([0-9]{1,2}.[0-9]{1,3}){0,1}",$version,$regs) || eregi("(opera/)([0-9]{1,2}.[0-9]{1,3}){0,1}",$version,$regs))
{
$browser = "Opera $regs[2]";
echo "Sie benutzen $browser!";
}

// MS INTERNET EXPLORER
else if( eregi("(msie) ([0-9]{1,2}.[0-9]{1,3})",$version,$regs) )
{
$browser = "MS Internet Explorer";
echo ("Sie benutzen $browser!");

}

// FIREFOX 
else if( eregi("(Firefox/)([0-9]{1,2}.[0-9]{1,3}.[0-9]{0,3}.[0-9]{0,3})",$version,$regs) )
{
$browser = "Firefox $regs[2]";
$teilstring = substr($regs[2],0,1);
if ($teilstring >= "2"){
echo ("Sie benutzen $browser!");
}
}

// SEAMONKEY 
else if( eregi("(SeaMonkey/)([0-9]{1,2}.[0-9]{1,3}.[0-9]{0,3})",$version,$regs) )
{
$browser = "Seamonkey $regs[2]";
$teilstring = substr($regs[2],0,1);
if ($teilstring >= "1"){
echo ("Sie benutzen $browser!");
}
 } 
 
// Safari
else if( eregi("(Safari)",$version,$regs) )
{
$browser = "Safari";
echo ("Sie benutzen $browser!");

}

// MOZILLA
else if( eregi("(mozilla)/(.*)rv:([0-9]{1,2}.[0-9]{1,3}.[0-9]{0,3})",$version,$regs) )
{
$browser = "Mozilla";

echo ("Sie benutzen $browser!");
}


// else if( eregi("w3m",$version) )
// {
// $browser = "w3m";
// }

else
{
$browser = "?";
}

// echo ("Sie benutzen $browser");


?>
</html>