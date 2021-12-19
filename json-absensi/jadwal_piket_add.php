<?
/* INCLUDE FILE */
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/classes/base-absensi/DaftarJagaPiket.php");

$reqMode= httpFilterPost("reqMode");
$reqPeriodeEntri= $_POST["reqPeriodeEntri"];
$reqPeriodeEntri = substr($reqPeriodeEntri, 3);
$days=cal_days_in_month(CAL_GREGORIAN,substr($reqPeriodeEntri,0,2),substr($reqPeriodeEntri,2));  

$reqTotalEntri= $_POST["reqTotalEntri"];

$user_login = new UserLogin();
$reqPktId= $_POST["reqPktId"];

$reqPegawaiId= $_POST["pegawaiId"];
$reqDepartemenId= $_POST["reqDepartemenId"];
$reqShift = "";

$set = new DaftarJagaPiket();
$set->setField("DEPARTEMEN_ID", $reqDepartemenId);
$set->setField("PERIODE", $reqPeriodeEntri);
$set->delete(); 
unset($set);

$reqTotalEntri += 1;
//$strku = '';
for ($i=0; $i<$reqTotalEntri; $i++) {
	//$strku .= "i awal " . $i;
	for($j=1; $j<=$days;$j++){
		$str_tanggal = '0' . $j;
		$str_tanggal = substr($str_tanggal, -2);
		$shift1 = $_POST["shift1_tgl" . $j . "_row" . $i];
		$shift2 = $_POST["shift2_tgl" . $j . "_row" . $i];
		$shift3 = $_POST["shift3_tgl" . $j . "_row" . $i];
		$reqShift = "";

		if ( $shift1 == "" && $shift2 == "" && $shift3 == "" ) continue;

		if ($shift1 <> "") {
			$reqShift = "1";
			$tgl = $shift1;
		}
		if ($shift2 <> "") {
			$reqShift = $reqShift . ",2";
			$tgl = $shift2;
		}
		if ($shift3 <> "") {
			$reqShift = $reqShift . ",3";
			$tgl = $shift3;
		}
		
		$pkt = new DaftarJagaPiket();
		//$pkt->setField("PIKET_ID", $reqPktId[$i]);
		$pkt->setField("DEPARTEMEN_ID", $reqDepartemenId);
		$pkt->setField("PEGAWAI_ID", $reqPegawaiId[$i]);
		$pkt->setField('TANGGAL', $str_tanggal. '-' .$reqPeriodeEntri);
		$pkt->setField('SHIFT', $reqShift);
		$pkt->setField('LAST_CREATE_USER', $user_login->nama);
		$pkt->setField('LAST_CREATE_DATE', OCI_SYSDATE);
		$pkt->insert();
		//$strku .= $pkt->insert(); 
		unset($pkt);
	}
}
//echo $strku;
echo "Data berhasil disimpan.";	
?>