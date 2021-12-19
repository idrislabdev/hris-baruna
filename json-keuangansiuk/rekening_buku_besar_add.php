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
$reqGrupLevel5= httpFilterPost("reqGrupLevel5");
$reqGrupLevel3= httpFilterPost("reqGrupLevel3");

/*GRUP_LEVEL1, GRUP_LEVEL2, GRUP_LEVEL3, 
GRUP_LEVEL4, GRUP_LEVEL5, KD_BUKU_PUSAT, 
KD_POSTING_BB, KD_POSTING_SUB, , 
COA_ID, KET_TAMBAHAN, KD_AKTIF, 
PROGRAM_NAME*/

$arrKodeBukuBesar= explode(".",$reqKodeBukuBesar);

$tempGroupLevel1= $arrKodeBukuBesar[0].".00.00.00";
if($arrKodeBukuBesar[1] > 0)
	$tempGroupLevel2= $arrKodeBukuBesar[0].".".$arrKodeBukuBesar[1].".00.00";
else
	$tempGroupLevel2= "";

$tempCoaId= $arrKodeBukuBesar[0].$reqTipeRekening;
//GRUP_LEVEL3, GRUP_LEVEL4, GRUP_LEVEL5
$rekening_buku_besar->setField("GRUP_LEVEL1", $tempGroupLevel1);
//$rekening_buku_besar->setField("GRUP_LEVEL2", $tempGroupLevel2);
$rekening_buku_besar->setField("COA_ID", $tempCoaId);
$rekening_buku_besar->setField("KD_AKTIF", "A");

$rekening_buku_besar->setField("KD_CABANG", "96");
$rekening_buku_besar->setField("TIPE_REKENING", $reqTipeRekening);
$rekening_buku_besar->setField("KD_BUKU_BESAR", $reqKodeBukuBesar);
$rekening_buku_besar->setField("NM_BUKU_BESAR", $reqNamaBukuBesar);
$rekening_buku_besar->setField("POLA_ENTRY", $reqPolaEntry);
$rekening_buku_besar->setField("GRUP_DTL_KODE", $reqGroupDtlKode);
$rekening_buku_besar->setField("KODE_VALUTA", setNULL($reqKodeValuta));
$rekening_buku_besar->setField("PROGRAM_NAME", "KBB_M_BUKU_BESAR_IMAIS");
$rekening_buku_besar->setField("GRUP_LEVEL5", $reqGrupLevel5);
$rekening_buku_besar->setField("GRUP_LEVEL3", $reqGrupLevel3);

if($reqMode == "insert")
{
	$rekening_buku_besar->setField("LAST_UPDATE_BY", $userLogin->nama);
	$rekening_buku_besar->setField("LAST_UPDATE_DATE", OCI_SYSDATE); 
	
	if($rekening_buku_besar->insert())
		echo "Data berhasil disimpan.";
		 //echo $rekening_buku_besar->query;
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