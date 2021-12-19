<?
/* INCLUDE FILE */
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base-anggaran/AnggaranAkses.php");
include_once("../WEB-INF/classes/utils/UserLogin.php");

$anggaran_akses = new AnggaranAkses();

$reqId = httpFilterPost("reqId");
$reqMode = httpFilterPost("reqMode");
$reqTahun = httpFilterPost("reqTahun");

$reqKdBukuPusat = $_POST["reqKdBukuPusat"];
$reqKdBukuBesar = $_POST["reqKdBukuBesar"];

$anggaran_akses->setField("DEPARTEMEN_ID", $reqId);
$anggaran_akses->delete();


for($i=0;$i<count($reqKdBukuPusat);$i++)
{
	if($reqKdBukuPusat[$i] == "")
	{}
	else
	{
		$arrKdBukuBesar = explode(",", $reqKdBukuBesar[$i]);
		for($j=0;$j<count($arrKdBukuBesar);$j++)
		{
			$arrBukuBesar = explode("-", $arrKdBukuBesar[$j]);
			$anggaran_akses = new AnggaranAkses();
			$anggaran_akses->setField("DEPARTEMEN_ID", $reqId);
			$anggaran_akses->setField("KD_BUKU_PUSAT", $reqKdBukuPusat[$i]);
			$anggaran_akses->setField("KD_BUKU_BESAR", trim($arrBukuBesar[0]));
			$anggaran_akses->setField("TAHUN", $reqTahun);
			$anggaran_akses->insert();
			unset($anggaran_akses);
		}
	}
}

echo "Data berhasil disimpan.";

?>