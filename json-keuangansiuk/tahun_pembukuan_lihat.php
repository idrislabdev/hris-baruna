<?
/* INCLUDE FILE */
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/KbbrThnBukuD.php");


$reqId = httpFilterPost("reqId");
$reqNama = httpFilterPost("reqNama");
$reqPeriode = httpFilterPost("reqPeriode");
$reqRowId= $_POST["reqRowId"];
$reqStatus= $_POST["reqStatus"];

$reqArrayIndex= $_POST["reqArrayIndex"];
$set_loop= $reqArrayIndex;

for($i=0;$i<=$set_loop;$i++)
{
	$index = $i;
	if($reqRowId[$i] == "")
	{
		$tahun_pembukuan_detil = new KbbrThnBukuD();
		$tahun_pembukuan_detil->setField("THN_BUKU", getTahunPeriode($reqPeriode));
		$tahun_pembukuan_detil->setField("BLN_BUKU", getBulanPeriode($reqPeriode));
		
		$bulan = getBulanPeriode($reqPeriode);
		$tahun = getTahunPeriode($reqPeriode);

		$tahun_pembukuan_detil->setField("NM_BLN_BUKU", $reqNama);
		
		$reqTanggalAwal= date("01-m-Y",strtotime($reqPeriode));
		$reqTanggalAkhir= date("t-m-Y",strtotime($reqPeriode));
		
		$tahun_pembukuan_detil->setField("TGL_AWAL", dateToDBCheck($reqTanggalAwal));
		$tahun_pembukuan_detil->setField("TGL_AKHIR", dateToDBCheck($reqTanggalAkhir));
		
		$tahun_pembukuan_detil->setField("STATUS_CLOSING", "O");
		$tahun_pembukuan_detil->setField("LAST_UPDATED_BY", $userLogin->nama);
		$tahun_pembukuan_detil->setField("LAST_UPDATE_DATE", OCI_SYSDATE);
		$tahun_pembukuan_detil->setField("KD_CABANG", "96");
		$tahun_pembukuan_detil->setField("PROGRAM_NAME", "KBB_R_THN_BUKU");
		
		$tahun_pembukuan_detil->insert();
		unset($tahun_pembukuan_detil);
	}
	else
	{
		if($reqStatus[$index] == "C" || $reqStatus[$index] == ""){}
		else
		{
			$tahun_pembukuan_detil = new KbbrThnBukuD();
			$tahun_pembukuan_detil->setField("THN_BUKU", getTahunPeriode($reqRowId[$index]));
			$tahun_pembukuan_detil->setField("BLN_BUKU", getBulanPeriode($reqRowId[$index]));
			
			$tahun_pembukuan_detil->setField("STATUS_CLOSING", $reqStatus[$index]);
			$tahun_pembukuan_detil->setField("LAST_UPDATED_BY", $userLogin->nama);
			$tahun_pembukuan_detil->setField("LAST_UPDATE_DATE", OCI_SYSDATE);
			
			$tahun_pembukuan_detil->update();
			unset($tahun_pembukuan_detil);
		}
	}
}
echo "Data berhasil disimpan.";
//echo $temp;//"Data berhasil disimpan.";
?>