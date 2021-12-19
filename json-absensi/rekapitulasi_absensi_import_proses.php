<?php
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base-absensi/AbsensiImport.php");
include_once("../WEB-INF/classes/utils/UserLogin.php");

ini_set("memory_limit","500M");
ini_set('max_execution_time', 520);
//$reqLinkFile= $_FILES['reqLinkFile'];
$reqMesin = httpFilterPost("reqMesin");
//$data = file_get_contents("tes.dat"); //read the file
$data = file_get_contents($_FILES['reqLinkFile']['tmp_name']); //read the file

$convert = explode("\n", $data); //create array separate by new line

$set= new AbsensiImport();
$set->setField("STATUS", 0);
$set->setField("USER_LOGIN_ID", $userLogin->UID);
$set->delete();
unset($set);

for ($i=0;$i<count($convert);$i++) 
{
	$data= explode("	", $convert[$i]);
	
	$reqFinggerId= $data[0];
	$reqJam= $data[1];
	$reqStatus= $data[2];
	
	if($reqStatus == 0)
		$reqStatus = "O";
	else
		$reqStatus = "I";
	
	
	if($reqFinggerId == ""){}
	else
	{
		$reqJam= datetimeToPage($reqJam, "date")." ".datetimeToPage($reqJam,"");
		$set= new AbsensiImport();
		$set->setField("FINGER_ID", $reqFinggerId);
		$set->setField("JAM", dateTimeToDBCheck($reqJam));
		$set->setField("STATUS", $reqStatus);
		$set->setField("USER_LOGIN_ID", $userLogin->UID);
		$set->setField("LAST_CREATE_USER", $userLogin->nama);
		$set->setField("LAST_CREATE_DATE", OCI_SYSDATE);
		$set->setField("MESIN_ID", $reqMesin);
		$set->insert();
		//echo $set->query;
		unset($set);
	}
}
echo "Data berhasil diproses.";
?>