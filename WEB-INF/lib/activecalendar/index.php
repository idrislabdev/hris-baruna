
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
<link rel="stylesheet" href="activecalendar.css" type="text/css" />
</head>
<?php
require_once("activecalendar.php");

extract($_GET);
$cal = new activeCalendar($yearID,$monthID,$dayID);

$cal->enableMonthNav($myurl);
$cal->setEventContent("2007","1","24","meeting","http://www.google.com");
$cal->setEventContent("2007","1","12","birthday","http://www.google.com");
$cal->setEvent("2007","1","20","red","myevent.html");
echo $cal->showMonth();





?>
<body>
</body>
</html>