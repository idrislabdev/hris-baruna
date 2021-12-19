<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Untitled Document</title>
<!--Make sure your page contains a valid doctype at the very top-->

<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>

<link rel="stylesheet" type="text/css" href="drilldownmenu.css" />

<script type="text/javascript" src="drilldownmenu.js">

/***********************************************
* Drill Down Menu script- (c) Dynamic Drive DHTML code library (www.dynamicdrive.com)
* This notice MUST stay intact for legal use
* Visit Dynamic Drive at http://www.dynamicdrive.com/ for this script and 100s more
***********************************************/

</script>

<script type="text/javascript">

var mymenu=new drilldownmenu({
	menuid: 'drillmenu1',
	menuheight: 'auto',
	breadcrumbid: 'drillcrumb',
	persist: {enable: true, overrideselectedul: true}
})

</script>
</head>

<body>
<div id="drillcrumb"></div>

<div id="drillmenu1" class="drillmenu">
<ul>
<li><a href="http://www.dynamicdrive.com">Dynamic Drive</a></li>
<li><a href="http://www.codingforums.com/">Coding Forums</a><a href="#">Activities 1.www</a></li>
<li><a href="#">Activities</a>
  <ul>
  <li><a href="#">Activities 1</a></li>
  <li><a href="#">Activities 2</a></li>
  <li><a href="#">Activities 3</a></li>
  <li><a href="#">Water Sports</a>
    <ul>
    <li><a href="#">Water Sports 1</a></li>
    <li><a href="#">Water Sports 2</a></li>
    <li><a href="#">Water Rafting</a>
			<ul>
    	<li><a href="#">Water Rafting 1</a></li>
    	<li><a href="#">Water Rafting 2</a></li>
    	<li><a href="#">Water Rafting 3</a></li>
    	<li><a href="#">Water Rafting 4</a></li>
    	<li><a href="#">Water Rafting 5</a></li>
			</ul>
    </li>
    <li><a href="#">Water Sports 3</a></li>
    </ul>
  </li>
  <li><a href="#">Activities 4</a></li>
  <li><a href="#">Activities 5</a></li>
  <li><a href="#">Activities 6</a></li>
  <li><a href="#">Activities 7</a></li>
  <li><a href="#">Activities 8</a></li>
  </ul>
</li>
<li><a href="#">Entertainment</a>
  <ul>
  <li><a href="#">Entertainment 1</a></li>
  <li><a href="#">Entertainment 2</a></li>
  <li><a href="#">Entertainment 3</a></li>
  <li><a href="#">Entertainment 4</a></li>
  <li><a href="#">Entertainment 5</a></li>
  <li><a href="#">Entertainment 6</a></li>
  <li><a href="#">Entertainment 7</a></li>
  <li><a href="#">Entertainment 8</a></li>
  <li><a href="#">Entertainment 9</a></li>
  <li><a href="#">Entertainment 10</a></li>
  </ul>
</li>
<li><a href="http://www.javascriptkit.com">JavaScript Kit</a></li>
<li><a href="#">Traveling</a>
  <ul>
  <li><a href="#">Traveling 1</a></li>
  <li><a href="#">Traveling 2</a></li>
  <li><a href="#">Traveling 3</a></li>
  <li><a href="#">North America</a>
    <ul>
    <li><a href="#">North America 1</a></li>
    <li><a href="#">North America 2</a></li>
    <li><a href="#">British Comlumbia</a>
			<ul>
    	<li><a href="#">British Comlumbia 1</a></li>
    	<li><a href="#">British Comlumbia 2</a></li>
    	<li><a href="#">British Comlumbia 3</a></li>
    	<li><a href="#">British Comlumbia 4</a></li>
    	<li><a href="#">British Comlumbia 5</a></li>
			</ul>
    </li>
    <li><a href="#">North America 3</a></li>
    <li><a href="#">North America 4</a></li>
    <li><a href="#">North America 5</a></li>
    </ul>
  </li>
  </ul>
</li>
<li><a href="http://www.dynamicdrive.com/style/">CSS Library</a></li>
</ul>
<br style="clear: left" />
</div>

<a href="#" rel="drillback-drillmenu1"><img src="backbutton.jpg" style="border-width:0; margin:10px 0 10px 17px" /></a>
</body>
</html>