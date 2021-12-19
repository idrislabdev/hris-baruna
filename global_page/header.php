<?
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/classes/utils/UserLogin.php");

$reqModul = httpFilterGet("reqModul");

?>
<div class="area-pojok">
	<?
    if($reqModul == "")
	{}
	else
	{
	?>
    <div id="sidebar-button"><button class="sidebar"></button></div>
    <?
	}
	
	if($reqModul == "")
		//$reqModul = "Office Management System (OMS)";	
		$reqModul = "Human Resources Information System (HRIS)";

	?>
    <div class="main-menu"><a href="../main/index.php"><img src="../WEB-INF/images/icon-main-menu.png"></a></div>
</div>
<div class="judul-aplikasi">
	<span><?=$reqModul?></span>
</div>

<ul id="cbp-tm-menu" class="cbp-tm-menu" style="z-index:9;">
    <li>
        <div class="profil">
            <a><i class="fa fa-user"></i></a> 
            <span style="margin-left:5px;"><?=$userLogin->nama?></span> 
            <!--<img src="../WEB-INF/images/icon-down.png" style="margin-left:10px; margin-right:20px; vertical-align:middle">-->
            <i class="fa fa-caret-down"></i>
        </div>
        <ul class="cbp-tm-submenu" style="background:#eaedf2;">
            <div style="margin-bottom:-54px;">&nbsp;</div>
            <li class="my-profile-list">
                <a href="#">
                <span class="notifikasi-icon"><!--<img src="../WEB-INF/images/icon-my-lockscreen.png">--></span>
                <span class="my-profile-text">Login as : <?=$userLogin->level?></span>
                <span class="my-profile-ket">&nbsp;</span>
                </a>
            </li>
            <li class="my-profile-list">
                <a href="#">
                <span class="notifikasi-icon"><!--<img src="../WEB-INF/images/icon-my-profile.png">--></span>
                <span class="my-profile-text">My Profile</span>
                <span class="my-profile-ket">&nbsp;</span>
                </a>
            </li>
            <li>
                <a href="#">
                <span class="notifikasi-icon"><i class="fa fa-sign-out"></i></span>
                <span class="my-profile-text" onClick="document.location.href='../main/login.php?reqMode=submitLogout'">Log Out</span>
                <span class="my-profile-ket">&nbsp;</span>
                </a>
            </li>
            
        </ul>
    </li>
    
</ul>