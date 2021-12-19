<?
/* INCLUDE FILE */
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/SafrValutaKursPajak.php");
include_once("../WEB-INF/classes/utils/FileHandler.php");


$file = new FileHandler();
$safr_valuta_kurs_pajak = new SafrValutaKursPajak();

$FILE_DIR = "../keuangan/uploads/";

$reqId = httpFilterPost("reqId");
$reqMode = httpFilterPost("reqMode");
$reqValutaId = httpFilterPost("reqValutaId");
$reqNomorSurat 		 = httpFilterPost("reqNomorSurat");
$reqTanggalMulai = httpFilterPost("reqTanggalMulai");
$reqTanggalSelesai = httpFilterPost("reqTanggalSelesai");
$reqNilai= httpFilterPost("reqNilai");
$reqStatus= httpFilterPost("reqStatus");
$reqLinkFile = $_FILES["reqLinkFile"];

if($reqMode == "insert")
{
	
	$safr_valuta_kurs_pajak->setField('KD_CABANG', "96");
	$safr_valuta_kurs_pajak->setField('NOMOR_SURAT', $reqNomorSurat);
	$safr_valuta_kurs_pajak->setField('JENIS_TABLE', "R");
	$safr_valuta_kurs_pajak->setField('ID_TABLE', "RVALUTA");
	$safr_valuta_kurs_pajak->setField('KODE_VALUTA', $reqValutaId);
	$safr_valuta_kurs_pajak->setField('TGL_MULAI_RATE', dateToDBCheck($reqTanggalMulai));
	$safr_valuta_kurs_pajak->setField('TGL_AKHIR_RATE', dateToDBCheck($reqTanggalSelesai));
	$safr_valuta_kurs_pajak->setField('NILAI_RATE', dotToNo($reqNilai));
	$safr_valuta_kurs_pajak->setField('KET_KETENTUAN_RATE', "");
	$safr_valuta_kurs_pajak->setField('TGL_KETENTUAN_RATE', dateToDBCheck(""));
	$safr_valuta_kurs_pajak->setField('KD_AKTIF', "A");	
	$safr_valuta_kurs_pajak->setField("LAST_UPDATE_DATE", OCI_SYSDATE);
	$safr_valuta_kurs_pajak->setField("LAST_UPDATED_BY", $userLogin->nama);
	$safr_valuta_kurs_pajak->setField('PROGRAM_NAME', "KBB_R_KURS_PAJAK_IMAIS");
	
		
	if($safr_valuta_kurs_pajak->insert())
	{
		
		if($reqLinkFile['tmp_name'])
		{
		
			$renameFile = $reqTanggalMulai.'~'.formatTextToDb($file->getFileName('reqLinkFile'));
		
			if($file->uploadToDir('reqLinkFile', $FILE_DIR, $renameFile))
			{
				$insertLinkFile = $file->uploadedFileName;
				$set_file = new SafrValutaKursPajak();
				$set_file->setField("TGL_MULAI_RATE", dateToDBCheck($reqTanggalMulai));
				$set_file->setField('FILE_NAMA', $insertLinkFile);
				$set_file->updateFileNama();
			}
		}			
				
		echo "-Data berhasil disimpan.";
	}
	else
		echo "-Data gagal disimpan.";
	
}
else
{
	
	$safr_valuta_kurs_pajak->setField('KD_CABANG', "96");
	$safr_valuta_kurs_pajak->setField('NOMOR_SURAT', $reqNomorSurat);
	$safr_valuta_kurs_pajak->setField('JENIS_TABLE', "R");
	$safr_valuta_kurs_pajak->setField('ID_TABLE', "RVALUTA");
	$safr_valuta_kurs_pajak->setField('KODE_VALUTA', $reqValutaId);
	$safr_valuta_kurs_pajak->setField('TGL_MULAI_RATE', dateToDBCheck($reqTanggalMulai));
	$safr_valuta_kurs_pajak->setField('TGL_AKHIR_RATE', dateToDBCheck($reqTanggalSelesai));
	$safr_valuta_kurs_pajak->setField('NILAI_RATE', dotToNo($reqNilai));
	$safr_valuta_kurs_pajak->setField('KET_KETENTUAN_RATE', "");
	$safr_valuta_kurs_pajak->setField('TGL_KETENTUAN_RATE', dateToDBCheck(""));
	$safr_valuta_kurs_pajak->setField('KD_AKTIF', "A");	
	$safr_valuta_kurs_pajak->setField("LAST_UPDATE_DATE", OCI_SYSDATE);
	$safr_valuta_kurs_pajak->setField("LAST_UPDATED_BY", $userLogin->nama);
	$safr_valuta_kurs_pajak->setField('PROGRAM_NAME', "KBB_R_KURS_PAJAK_IMAIS");
			
	if($safr_valuta_kurs_pajak->update())
	{
		
		if($reqLinkFile['tmp_name'])
		{
			$renameFile = $reqTanggalMulai.'~'.formatTextToDb($file->getFileName('reqLinkFile'));
		
			if($file->uploadToDir('reqLinkFile', $FILE_DIR, $renameFile))
			{
				$insertLinkFile = $file->uploadedFileName;
				$set_file = new SafrValutaKursPajak();
				$set_file->setField("TGL_MULAI_RATE", dateToDBCheck($reqTanggalMulai));
				$set_file->setField('FILE_NAMA', $insertLinkFile);
				$set_file->updateFileNama();
			}
		}			
				
		echo "-Data berhasil disimpan.";
	}
	else
		echo "-Data gagal disimpan.";
	
}
?>