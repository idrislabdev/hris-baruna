<?
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/utils/UserLogin.php");

/* PARAMETERS */
$reqMode = httpFilterRequest("reqMode");
$reqUser = httpFilterPost("reqUser");
$reqPasswd = httpFilterPost("reqPasswd");
/* ACTIONS BY reqMode */
if($reqMode == "submitLogin" && $reqUser != "" && $reqPasswd != "") 
{
	$userLogin->resetLogin();
	if ($userLogin->verifyUserLogin($reqUser, $reqPasswd)) 
	{		
		header("location:index.php");
		exit;			
	}
	else
	{
		echo '<script language="javascript">';
		echo 'alert("Username atau password anda masih salah.");';
		echo 'top.location.href = "login.php";';
		echo '</script>';		
		exit;		
	}
}
else if ($reqMode == "submitLogout")
{
	$userLogin->resetLogin();
	$userLogin->emptyUsrSessions();
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Login :: Office Management System</title>
<link rel="stylesheet" href="../WEB-INF/css/gaya.css" type="text/css" />


<!-- BG FULLSCREEN -->
<link rel="stylesheet" type="text/css" href="../WEB-INF/lib/vegas/jquery.vegas.min.css" />
<!--<link rel="stylesheet" type="text/css" href="/css/styles.css">-->
<script type="text/javascript" src="../WEB-INF/lib/vegas/jquery-1.11.1.min.js"></script>
<script type="text/javascript" src="../WEB-INF/lib/vegas/jquery.vegas.min.js"></script>
<!--<script type="text/javascript" src="/js/global.js"></script>-->
<script>
$( function() {
	$.vegas( 'slideshow', {
		delay: 8000,
		backgrounds: [
			{ src: '../WEB-INF/images/bg.jpg', fade: 4000 },
			{ src: '../WEB-INF/images/bg2.jpg', fade: 4000 },
			{ src: '../WEB-INF/images/bg3.jpg', fade: 4000 }
			/*{ src: 'images/background6.jpg', fade: 4000 },
			{ src: 'images/background7.jpg', fade: 4000 },
			{ src: 'images/background8.jpg', fade: 4000 }*/
			//{ src: 'images/background2.jpg', fade: 4000 },
			//{ src: 'images/background1.jpg', fade: 4000 }
		]
	} )( 'overlay' );

	$( '.documentation' ).click( function() {
		$( 'ul ul' ).slideToggle();
		return false;
	});
	
	$( '.credits, .contact' ).click( function() {
		$( '#overlay, #credits' ).fadeIn();
		return false;
	});

	$( '#overlay a, #credits a' ).click( function(e) {
		e.stopPropagation();
	});

	$( '#overlay, #credits, #download' ).click( function() {
		$( '#overlay, #credits, #download' ).fadeOut();
		return false;
	});
	
	$( '.mailto' ).click( function() {
		var a = $( this ).attr( 'href' );
		e = a.replace( '#', '' ).replace( '|', '@' ) + '.com';
		document.location = 'ma' + 'il' + 'to:' + e + "?subject=[Vegas] I'd like to hire you!";
		e.preventDefault;
		return false;
	});
	
	$("#superheader h6").click(function(e) {
		var $$ = $( this ),
			$menu = $('#superheader ul');
		
		e.stopPropagation();
		
		if ( $menu.is(':visible') ) {
			$menu.hide();
			$$.removeClass( 'open' );
		} else {
			$menu.show();
			$$.addClass( 'open' );
			$('body').one('click', function() {
				$('#superheader ul').hide();
			});
		}
	});
	$( "#superheader li" ).click( function( e ) {
		document.location = $( this ).find( 'a' ).attr( 'href' );
	});
		
	$( '.download' ).click( function() {
		$( '#overlay, #download' ).show();	  
	});
} );
</script>

<!-- LIVE DATE -->
<script>

/*
Live Date Script- 
© Dynamic Drive (www.dynamicdrive.com)
For full source code, installation instructions, 100's more DHTML scripts, and Terms Of Use,
visit http://www.dynamicdrive.com
*/

var dayarray = new Array("Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu")
var montharray = new Array("Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember")

function getthedate() {
    var mydate = new Date()
    var year = mydate.getYear()
    if (year < 1000)
        year += 1900
    var day = mydate.getDay()
    var month = mydate.getMonth()
    var daym = mydate.getDate()
    if (daym < 10)
        daym = "0" + daym
    var hours = mydate.getHours()
    var minutes = mydate.getMinutes()
    var seconds = mydate.getSeconds()
    var dn = "AM"
    if (hours >= 12)
        dn = "PM"
    if (hours > 12) {
        hours = hours - 12
    }
    if (hours == 0)
        hours = 12
    if (minutes <= 9)
        minutes = "0" + minutes
    if (seconds <= 9)
        seconds = "0" + seconds
    
	    //change font size here
    var cdate = "<small><font color='000000' face='Arial'><b>" + dayarray[day] + ", " + montharray[month] + " " + daym + ", " + year + " " + hours + ":" + minutes + ":" + seconds + " " + dn + "</b></font></small>"
	var cjam = hours + ":" + minutes
	var chari = dayarray[day] + ", " + daym + " " + montharray[month] + " " + year
	
    if (document.all)
        //document.all.clock.innerHTML = cdate,
		document.all.jam.innerHTML = cjam,
		document.all.hari.innerHTML = chari
    else if (document.getElementById)
        //document.getElementById("clock").innerHTML = cdate,
		document.getElementById("jam").innerHTML = cjam,
		document.getElementById("hari").innerHTML = chari
    else
        //document.write(cdate),
		document.write(cjam),
		document.write(chari)
}
if (!document.all && !document.getElementById)
    getthedate()

function goforit() {
    if (document.all || document.getElementById)
        setInterval("getthedate()", 1000)
}

</script>
<style>
.login-area
{
    width: 100%;
	height:100%;
    
    text-align: center;
	position:relative;
}

.login-inner
{
	width:300px;
	position:absolute;
    display: inline-block;
    
    
	top:20%;
	/*left:40%;*/
	left:-webkit-calc(50% - 150px);
	left:-moz-calc(50% - 150px);
	left:calc(50% - 150px);
	
	background:rgba(255, 255, 255, 0.25);
	padding:18px 0;
	
	
}
.login-inner img{
	margin-bottom: 10px;
}
.login-inner input[type = text],
.login-inner input[type = password]{
	*width:228px;
	width: calc(100% - 36px);
	padding:7px 10px;
	/*border:1px solid #0075b6;*/
	*border:1px solid #005ba0/*e85f32*/;
	color:#333;
	margin-bottom:10px;
	margin-left: 18px;
	margin-right: 18px;
	
	border-bottom: 2px solid #005ba0;
	border-width: 0px 0px 2px 0px;
	box-sizing: border-box;
}
.login-inner input[type = submit]{
	*width:250px;
	width: calc(100% - 36px);
	padding:7px 10px;
	color:#FFF;
	margin-left: 18px;
	margin-right: 18px;
		
	/* fallback */ 
	*background-color: #e85f32; background: url(images/linear_bg_2.png); background-repeat: repeat-x; 	
	/* Safari 4-5, Chrome 1-9 */
	*background: -webkit-gradient(linear, 0% 0%, 0% 100%, from(#e85f32), to(#d75429)); 	
	/* Safari 5.1, Chrome 10+ */ 
	*background: -webkit-linear-gradient(top, #e85f32, #d75429); 	
	/* Firefox 3.6+ */
	*background: -moz-linear-gradient(top, #e85f32, #d75429); 	
	/* IE 10 */
	*background: -ms-linear-gradient(top, #e85f32, #d75429); 	
	/* Opera 11.10+ */
	*background: -o-linear-gradient(top, #e85f32, #d75429);
	
	background: #005ba0;
	box-sizing: border-box;
}

.judul-aplikasi-login{ /*height:50px; line-height:50px; margin-left:17px; */ position:absolute; right:50px; bottom:70px; color:#FFF; text-align:right; }

.judul-aplikasi-login span:nth-child(1){
	font-family: 'Raleway Regular';
	font-size:40px;
	/*color:#0075b6;*/
	color:#86d4ff;
	text-transform:uppercase; 
}
.judul-aplikasi-login span:nth-child(2){
	font-family: 'Raleway ExtraLight';
	font-size:40px;
	text-transform:uppercase; 
}


</style>

</head>

<body onLoad="goforit()">

<div class="login-area">

    <div class="login-inner">
    	<div><img src="../WEB-INF/images/logo.png" /></div>
    	<form method="post" action="">
            <div>
            <input name="reqUser" id="a" type="text" placeholder="Username..." />
            </div>
            <div>
            <input name="reqPasswd" id="s" type="password" placeholder="Password" />
            </div>
            <div>
            <input type="hidden" name="reqMode" value="submitLogin"/>
            <input type="submit" value="LOGIN" />            
            </div>
        </form>
    </div>
    
</div>

<div id="footer-waktu">
    <div id="footer-waktu-jam"><span id="jam"></span></div>
    <div id="footer-waktu-tgl"><span id="hari"></span></div>
</div>
<div class="judul-aplikasi-login">
	<span>HRIS</span>.<span></span><br />
    Copyright &copy; 2018 Yayasan Barunawati Biru Surabaya. All Right Reserved.
</div>
</body>
</html>