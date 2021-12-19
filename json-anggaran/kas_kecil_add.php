<?
/* INCLUDE FILE */
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base-anggaran/AnggaranKasKecil.php");
include_once("../WEB-INF/classes/base-anggaran/AnggaranKasKecilBantu.php");
include_once("../WEB-INF/classes/utils/UserLogin.php");

$kas_kecil = new AnggaranKasKecil();

$reqId= httpFilterPost("reqId");
$reqMode= httpFilterPost("reqMode");
$reqTahun= httpFilterPost("reqTahun");
$reqJumlah= httpFilterPost("reqJumlah");
$reqPuspel= httpFilterPost("reqPuspel");
$reqTempPuspel = httpFilterPost("reqTempPuspel");

$reqKartu= $_POST["reqKartu"];
$reqBantuJumlah= $_POST["reqBantuJumlah"];
$reqPegawai = $_POST["reqPegawai"];

$kas_kecil->setField("TAHUN", $reqTahun);
$kas_kecil->setField("JUMLAH", dotToNo($reqJumlah));

if($reqMode == "insert")
{
	
	$kas_kecil->setField("PUSPEL", $reqPuspel);
	if($kas_kecil->insert())
	{
		$set = new AnggaranKasKecilBantu();
		$set->setField("TAHUN", $reqTahun);
		$set->setField("PUSPEL", $reqPuspel);
		$set->delete();
		unset($set);
		
		for($i=0; $i<count($reqKartu); $i++)
		{			   
			$set = new AnggaranKasKecilBantu();
			$set->setField("TAHUN", $reqTahun);
			$set->setField("PUSPEL", $reqPuspel);
			$set->setField('KODE_SUB_BANTU', $reqKartu[$i]);
			$set->setField('PEGAWAI_ID', $reqPegawai[$i]);
			$set->setField('JUMLAH', dotToNo($reqBantuJumlah[$i]));
			$set->insert();
			unset($set);
		}
	}
	
	echo "Data berhasil disimpan.";	
}
else
{
	$kas_kecil->setField("PUSPEL", $reqPuspel);
	$kas_kecil->setField("PUSPEL_TEMP", $reqTempPuspel);
	if($kas_kecil->update())
	{
		$set = new AnggaranKasKecilBantu();
		$set->setField("TAHUN", $reqTahun);
		$set->setField("PUSPEL", $reqTempPuspel);
		$set->delete();
		//echo $set->query;
		unset($set);
		
		for($i=0; $i<count($reqKartu); $i++)
		{			   
			$set = new AnggaranKasKecilBantu();
			$set->setField("TAHUN", $reqTahun);
			$set->setField("PUSPEL", $reqPuspel);
			$set->setField('KODE_SUB_BANTU', $reqKartu[$i]);
			$set->setField('PEGAWAI_ID', $reqPegawai[$i]);
			$set->setField('JUMLAH', dotToNo($reqBantuJumlah[$i]));
			$set->insert();
			unset($set);
		}
	}
	//echo $kas_kecil->query;
	echo "Data berhasil disimpan.";	
}
?>