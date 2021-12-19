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
$reqKategoriSekolah= httpFilterPost("reqKategoriSekolah");
$reqBosBopda= httpFilterPost("reqBosBopda");


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
$rekening_buku_pusat->setField("GRUP_LEVEL1", $tempGroupLevel1);
$rekening_buku_pusat->setField("GRUP_LEVEL2", $tempGroupLevel2);
$rekening_buku_pusat->setField("GRUP_LEVEL3", $reqKategoriSekolah);
$rekening_buku_pusat->setField("GRUP_LEVEL4", $reqBosBopda);
$rekening_buku_pusat->setField("COA_ID", $tempCoaId."E");
$rekening_buku_pusat->setField("KD_AKTIF", "A");

$rekening_buku_pusat->setField("KD_CABANG", "96");
$rekening_buku_pusat->setField("TIPE_REKENING", "E");
$rekening_buku_pusat->setField("KD_BUKU_BESAR", $reqKodeBukuBesar);
$rekening_buku_pusat->setField("NM_BUKU_BESAR", $reqNamaBukuBesar);
$rekening_buku_pusat->setField("POLA_ENTRY", "3");
$rekening_buku_pusat->setField("GRUP_DTL_KODE", $reqGroupDtlKode);
$rekening_buku_pusat->setField("KODE_VALUTA", setNULL($reqKodeValuta));
$rekening_buku_pusat->setField("PROGRAM_NAME", "KBB_M_BUKU_PUSAT_IMAIS");
$rekening_buku_pusat->setField("LAST_UPDATED_BY", $userLogin->nama);
$rekening_buku_pusat->setField("LAST_UPDATE_DATE", OCI_SYSDATE);


if($reqMode == "insert")
{
	if($rekening_buku_pusat->insert())
		echo "Data berhasil disimpan.";
		//echo $rekening_buku_pusat->query;
}
else
{
	$rekening_buku_pusat->setField("KD_BUKU_BESAR_ID", $reqId);
		
	if($rekening_buku_pusat->update())
		echo "Data berhasil disimpan.";
			//echo $rekening_buku_pusat->query;
}
?>