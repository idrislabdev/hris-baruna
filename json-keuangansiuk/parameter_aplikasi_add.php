<?
/* INCLUDE FILE */
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/KbbrRuleModul.php");

$kbbr_rule_modul = new KbbrRuleModul();

$reqId = httpFilterPost("reqId");
$reqMode = httpFilterPost("reqMode");
$reqRowId= $_POST["reqRowId"];
$reqKodeAktif = $_POST["reqKodeAktif"];
$reqStatus = $_POST["reqStatus"];
$reqArrayIndex= $_POST["reqArrayIndex"];

$set_loop= $reqArrayIndex;			  
if($reqMode == "insert")
{
	for($i=0;$i<=$set_loop;$i++)
	{
		if($reqRowId[$i] == "" || $reqId == "")
		{}
		else
		{
		$index = $i;
		$kbbr_rule_modul = new KbbrRuleModul();
		$kbbr_rule_modul->setField("KD_RULE", $reqRowId[$index]);
		$kbbr_rule_modul->setField("STATUS", setNULL($reqStatus[$index]));
		$kbbr_rule_modul->setField("KD_AKTIF", setNULL($reqKodeAktif[$index]));
		$kbbr_rule_modul->setField("KD_SUBSIS", $reqId);
		$kbbr_rule_modul->setField("LAST_UPDATED_BY ", $userLogin->nama);
		$kbbr_rule_modul->setField("LAST_UPDATE_DATE", OCI_SYSDATE);	
		$kbbr_rule_modul->setField("PROGRAM_NAME", "KBB_R_RULE_IMAIS");			
		
		$kbbr_rule_modul->update();
		if($i == 0)
			//$temp= $kbbr_rule_modul->query;
		unset($kbbr_rule_modul);
		}
	}
	//echo $temp;
	echo "Data berhasil disimpan.";
}

?>