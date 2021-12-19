<?
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base/DataSekolah.php");

$sekolah = new DataSekolah();

/* LOGIN CHECK */
if ($userLogin->checkUserLogin()) 
{ 
	$userLogin->retrieveUserInfo();
}
ini_set("memory_limit","500M");
ini_set('max_execution_time', 520);

$sekolah->selectByParams(array(), -1, -1, "", "");     		
$kolom = ['SEKOLAH_ID','NAMA','TELPON','ALAMAT','FAX','REKOMENDASI_N','REKOMENDASI_T','SERTIFIKAT','TGL_SERTIFIKAT','APPROCAL_DESC','KOTA'];
/* Output */
$data = array();
$jumlah=0;
while($sekolah->nextRow()){
	$jumlah++;
	$row = array();
	for ( $i=0 ; $i<count($kolom) ; $i++ ){
		$row[] = $sekolah->getField($kolom[$i]);
	}
	$data['hasil'][] = $row;
}
echo '({"TOTAL":"'.$jumlah.'","results":'.json_encode($data['hasil']).'})';
?>
