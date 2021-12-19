<?
/* INCLUDE FILE */
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base-simpeg/PegawaiSertifikat.php");
include_once("../WEB-INF/classes/base-simpeg/Pegawai.php");
include_once("../WEB-INF/classes/utils/UserLogin.php");

include "../operasional/excel/excel_reader2.php";

$data = new Spreadsheet_Excel_Reader($_FILES['reqLinkFile']['tmp_name']);
$pegawai_sertifikat = new PegawaiSertifikat();
$pegawai = new Pegawai();

$reqId = httpFilterPost("reqId");
//$reqPeriode = httpFilterPost("reqPeriode");
//$reqLokasi = httpFilterPost("reqLokasi");

$bulan = substr($reqPeriode, 0,2);
$tahun = substr($reqPeriode, 2,4);
$date=$tahun.'-'.$bulan;
$reqTanggalAwal= dateToPageCheck($tahun.'-'.$bulan.'-01');
$reqTanggalAkhir= dateToPageCheck(date("Y-m-t",strtotime($date)));

$baris = $data->rowcount($sheet_index=0);

//$check = $pegawai_sertifikat->getCountByParamsKapalProduksi(array("PERIODE" => $reqPeriode, "PEGAWAI_ID" => $reqId));
//unset($pegawai_sertifikat);

// import data excel mulai baris ke-4 (karena baris pertama adalah nama kolom)
for ($i=2; $i<=$baris; $i++)
{

//$tempPegawaiId=$data->val($i, 1);
//$reqPerjenjanganId = $data->val($i, 2);
//$reqTotalJamOps = setTime($data->raw($i, '6'), $data->val($i, 6));
//$reqHari = $data->val($i, 21);

		$reqNRP = $data->val($i, 1);	
		$reqPegawaiSertifikatId = $data->val($i, 2);
		$reqTanggalTerbit = $data->val($i, 3);
		$reqTanggalKadaluarsa = $data->val($i, 4);
		$reqGroupKapal = $data->val($i, 5);
		$reqKeterangan = $data->val($i, 6);

		$pegawai = new Pegawai();
		$pegawai->selectByParams(array("NRP" => $reqNRP));
		$pegawai->firstRow();
		$reqId = $pegawai->getField("PEGAWAI_ID");

		$pegawai_sertifikat = new PegawaiSertifikat();
		$pegawai_sertifikat->setField("NAMA", $reqPegawaiSertifikatId);
		$pegawai_sertifikat->setField("TANGGAL_TERBIT", dateToDBCheck($reqTanggalTerbit));
		$pegawai_sertifikat->setField("TANGGAL_KADALUARSA", dateToDBCheck($reqTanggalKadaluarsa));
		$pegawai_sertifikat->setField("GROUP_SERTIFIKAT", $reqGroupKapal);
		$pegawai_sertifikat->setField("KETERANGAN", $reqKeterangan);
		$pegawai_sertifikat->setField("PEGAWAI_ID", $reqId);
		
		$pegawai_sertifikat->setField("LAST_CREATE_USER", $userLogin->nama);
		$pegawai_sertifikat->setField("LAST_CREATE_DATE", OCI_SYSDATE);	
	
	
	if($reqPegawaiSertifikatId==""){}
	else
	{
		$pegawai_sertifikat->insert();
		//echo $pegawai_sertifikat->query;
	}
	/*if($i==1)
		$temp= $pegawai_sertifikat->query;*/
	unset($pegawai_sertifikat);
	unset($pegawai);
	
}

echo "Data berhasil disimpan.";
//echo $temp;

?>