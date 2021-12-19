<?
/* INCLUDE FILE */
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base-anggaran/AnggaranKasKecil.php");
include_once("../WEB-INF/classes/utils/UserLogin.php");

$kas_kecil = new AnggaranKasKecil();

$reqId= httpFilterPost("reqId");
$reqMode= httpFilterPost("reqMode");
$reqTahun= httpFilterPost("reqTahun");
$reqJumlah= $_POST["reqJumlah"];
$reqPuspel= $_POST["reqPuspel"];

if($reqMode == "insert")
{
	$kas_kecil->setField("TAHUN", $reqTahun);
	
	if($kas_kecil->delete())
	{
		for($i=0;$i<count($reqPuspel);$i++)
		{
			if($reqPuspel[$i] == ""){}
			else
			{
			$set= new AnggaranKasKecil();
			
			$set->setField("TAHUN", $reqTahun);
			$set->setField("JUMLAH", dotToNo($reqJumlah[$i]));
			$set->setField("PUSPEL", $reqPuspel[$i]);
			$set->insert();
			unset($set);
			}
		}
	}
	echo "Data berhasil disimpan.";	
}
?>