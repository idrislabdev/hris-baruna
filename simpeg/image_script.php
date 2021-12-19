<?
/* INCLUDE FILE */
include_once("../WEB-INF/classes/utils/UserLogin.php");

include_once("../WEB-INF/classes/utils/FileHandler.php");
include_once("../WEB-INF/functions/default.func.php");
ini_set("memory_limit","100M");

/* create objects */
$file = new FileHandler();

/* LOGIN CHECK */
if ($userLogin->checkUserLogin()) 
{ 
	$userLogin->retrieveUserInfo();
}

$reqPegawaiId = httpFilterRequest("reqPegawaiId");  
$reqMode = httpFilterRequest("reqMode");  

if($reqMode == 'pegawai'){
	include_once("../WEB-INF/classes/base-simpeg/Pegawai.php");
	$pegawai = new Pegawai();
	$pegawai->selectByParamsFoto(array("A.PEGAWAI_ID" => $reqPegawaiId));
	$pegawai->firstRow();
	$data= $pegawai->getField("FOTO"); 
	$jk = $pegawai->getField("JENIS_KELAMIN");
}
elseif($reqMode == 'pegawai_pekerjaan'){
	include_once("../WEB-INF/classes/base-simpeg/Pegawai.php");
	$pegawai = new Pegawai();
	$pegawai->selectByParamsFoto(array("A.PEGAWAI_ID" => $reqPegawaiId));
	$pegawai->firstRow();
	$data= $pegawai->getField("FOTO"); 
	$jk = $pegawai->getField("JENIS_KELAMIN");
}


// Do all your db stuff here, grab the blob file. Probably from a $_GET paramater

if($data == "")
{
	if($jk == "P")
		$image = imagecreatefromjpeg("../WEB-INF/images/P.jpg");
	else
		$image = imagecreatefromjpeg("../WEB-INF/images/L.jpg");
		
	imagepng($image);
}
else
	$image = $data;



header("Content-type: image/jpeg"); // or gif, etc...
echo $image;
die();
?>