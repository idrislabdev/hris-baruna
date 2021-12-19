<?
/* INCLUDE FILE */
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/KbbrBukuBesar.php");


$rekening_buku_besar = new KbbrBukuBesar();

$reqId = httpFilterPost("reqId");
$reqMode = httpFilterPost("reqMode");
$reqTipeRekening= httpFilterPost("reqTipeRekening");
$reqKodeBukuBesar= httpFilterPost("reqKodeBukuBesar");
$reqNamaBukuBesar= httpFilterPost("reqNamaBukuBesar");
$reqPolaEntry= httpFilterPost("reqPolaEntry");
$reqGroupDtlKode= httpFilterPost("reqGroupDtlKode");
$reqKodeValuta= httpFilterPost("reqKodeValuta");

/*GRUP_LEVEL1, GRUP_LEVEL2, GRUP_LEVEL3, 
GRUP_LEVEL4, GRUP_LEVEL5, KD_BUKU_PUSAT, 
KD_POSTING_BB, KD_POSTING_SUB, , 
COA_ID, KET_TAMBAHAN, KD_AKTIF, 
PROGRAM_NAME*/

$rekening_buku_besar->setField("KD_CABANG", "96");
$rekening_buku_besar->setField("TIPE_REKENING", $reqTipeRekening);
$rekening_buku_besar->setField("KD_BUKU_BESAR", $reqKodeBukuBesar);
$rekening_buku_besar->setField("NM_BUKU_BESAR", $reqNamaBukuBesar);
$rekening_buku_besar->setField("POLA_ENTRY", $reqPolaEntry);
$rekening_buku_besar->setField("GRUP_DTL_KODE", $reqGroupDtlKode);
$rekening_buku_besar->setField("KODE_VALUTA", setNULL($reqKodeValuta));
$rekening_buku_besar->setField("PROGRAM_NAME", "KBB_M_BUKU_BESAR_IMAIS");

if($reqMode == "insert")
{
	$rekening_buku_besar->setField("LAST_UPDATE_BY", $userLogin->nama);
	$rekening_buku_besar->setField("LAST_UPDATE_DATE", OCI_SYSDATE); 
	
	if($rekening_buku_besar->insert())
		echo "Data berhasil disimpan.";
		 
}
else
{
	$rekening_buku_besar->setField("KD_BUKU_BESAR_ID", $reqId);
	$rekening_buku_besar->setField("LAST_UPDATE_BY", $userLogin->nama);
	$rekening_buku_besar->setField("LAST_UPDATE_DATE", OCI_SYSDATE);
		
	if($rekening_buku_besar->update())
		echo "Data berhasil disimpan.";
			
}
?>