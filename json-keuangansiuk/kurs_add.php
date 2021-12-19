<?
/* INCLUDE FILE */
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/SafrValutaKurs.php");


$safr_valuta_kurs = new SafrValutaKurs();

$reqId = httpFilterPost("reqId");
$reqMode = httpFilterPost("reqMode");
$reqValutaId = httpFilterPost("reqValutaId");
$reqTanggalMulai = httpFilterPost("reqTanggalMulai");
$reqTanggalSelesai = httpFilterPost("reqTanggalSelesai");
$reqNilai= httpFilterPost("reqNilai");
$reqStatus= httpFilterPost("reqStatus");

if($reqMode == "insert")
{
	$safr_valuta_kurs->setField('KD_CABANG', "96");
	$safr_valuta_kurs->setField('JENIS_TABLE', "R");
	$safr_valuta_kurs->setField('ID_TABLE', "RVALUTA");
	$safr_valuta_kurs->setField('KODE_VALUTA', $reqValutaId);	
	$safr_valuta_kurs->setField('TGL_MULAI_RATE', dateToDBCheck($reqTanggalMulai));
	$safr_valuta_kurs->setField('TGL_AKHIR_RATE', dateToDBCheck($reqTanggalSelesai));
	$safr_valuta_kurs->setField('NILAI_RATE', dotToNo($reqNilai));
	$safr_valuta_kurs->setField('KET_KETENTUAN_RATE', "");
	$safr_valuta_kurs->setField('TGL_KETENTUAN_RATE', dateToDBCheck(""));
	$safr_valuta_kurs->setField('KD_AKTIF', "A");	
	$safr_valuta_kurs->setField("LAST_UPDATED_BY", $userLogin->nama);
	$safr_valuta_kurs->setField("LAST_UPDATE_DATE", OCI_SYSDATE);
	$safr_valuta_kurs->setField('PROGRAM_NAME', "KBB_R_KURS_IMAIS");
		
	if($safr_valuta_kurs->insert())
		//echo "Data berhasil disimpan.";
		echo "-Data berhasil disimpan.";
	//echo $safr_valuta_kurs->query;
}
else
{
	$safr_valuta_kurs->setField('KD_CABANG', "96");
	$safr_valuta_kurs->setField('JENIS_TABLE', "R");
	$safr_valuta_kurs->setField('ID_TABLE', "RVALUTA");
	$safr_valuta_kurs->setField('KODE_VALUTA', $reqValutaId);	
	$safr_valuta_kurs->setField('TGL_MULAI_RATE', dateToDBCheck($reqTanggalMulai));
	$safr_valuta_kurs->setField('TGL_AKHIR_RATE', dateToDBCheck($reqTanggalSelesai));
	$safr_valuta_kurs->setField('NILAI_RATE', dotToNo($reqNilai));
	$safr_valuta_kurs->setField('KET_KETENTUAN_RATE', "");
	$safr_valuta_kurs->setField('TGL_KETENTUAN_RATE', dateToDBCheck(""));
	$safr_valuta_kurs->setField('KD_AKTIF', "A");	
	$safr_valuta_kurs->setField("LAST_UPDATED_BY", $userLogin->nama);
	$safr_valuta_kurs->setField("LAST_UPDATE_DATE", OCI_SYSDATE);
	$safr_valuta_kurs->setField('PROGRAM_NAME', "KBB_R_KURS_IMAIS");
			
	if($safr_valuta_kurs->update())
		//echo "Data berhasil disimpan.";
		echo "-Data berhasil disimpan.";
	
	//echo $safr_valuta_kurs->query;
	
}
?>