<?
/* INCLUDE FILE */
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/KbbrBukuPusat.php");

$rekening_buku_pusat = new KbbrBukuPusat();

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

$rekening_buku_pusat->setField("KD_CABANG", "11");
$rekening_buku_pusat->setField("TIPE_REKENING", $reqTipeRekening);
$rekening_buku_pusat->setField("KD_BUKU_BESAR", $reqKodeBukuBesar);
$rekening_buku_pusat->setField("NM_BUKU_BESAR", $reqNamaBukuBesar);
$rekening_buku_pusat->setField("POLA_ENTRY", $reqPolaEntry);
$rekening_buku_pusat->setField("GRUP_DTL_KODE", $reqGroupDtlKode);
$rekening_buku_pusat->setField("KODE_VALUTA", setNULL($reqKodeValuta));


if($reqMode == "insert")
{
	$rekening_buku_pusat->setField("LAST_UPDATE_BY", $userLogin->nama);
	$rekening_buku_pusat->setField("LAST_UPDATE_DATE", OCI_SYSDATE);
		
	if($rekening_buku_pusat->insert())
		echo "Data berhasil disimpan.";
}
else
{
	$rekening_buku_pusat->setField("KD_BUKU_BESAR_ID", $reqId);
	$rekening_buku_pusat->setField("LAST_UPDATE_BY", $userLogin->nama);
	$rekening_buku_pusat->setField("LAST_UPDATE_DATE", OCI_SYSDATE);
		
	if($rekening_buku_pusat->update())
		echo "Data berhasil disimpan.";
			
}
?>