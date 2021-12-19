<?
/* INCLUDE FILE */
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/KpttNotaD.php");
include_once("../WEB-INF/classes/utils/UserLogin.php");

$kptt_nota_d = new KpttNotaD();

$reqId = httpFilterPost("reqId");
$reqMode = httpFilterPost("reqMode");
$reqKlasTrans= $_POST["reqKlasTrans"];
$reqPajak= $_POST["reqPajak"];
$reqLbr= $_POST["reqLbr"];
$reqNilaiJasa= $_POST["reqNilaiJasa"];
$reqNilaiPajak= $_POST["reqNilaiPajak"];
$reqJumlah= $_POST["reqJumlah"];



if($reqMode == "insert")
{
	for($i=0; $i<count($reqKlasTrans); $i++)
	{
		if($reqPajak[$i] == "Y")
			$reqPajakId = 1;
		else
			$reqPajakId = 0;
		
		$kptt_nota_d = new KpttNotaD();
		$kptt_nota_d->setField('KD_CABANG', "96");
		$kptt_nota_d->setField('KD_SUBSIS', "KPT");
		$kptt_nota_d->setField('JEN_JURNAL', "JKM");
		$kptt_nota_d->setField('TIPE_TRANS', "JKM-KPT-03");
		$kptt_nota_d->setField('NO_NOTA', $reqId);
		$kptt_nota_d->setField('LINE_SEQ', $i+1);
		$kptt_nota_d->setField('KLAS_TRANS', $reqKlasTrans[$i]);
		$kptt_nota_d->setField('KWANTITAS', $reqLbr[$i]);
		$kptt_nota_d->setField('SATUAN', "");
		$kptt_nota_d->setField('HARGA_SATUAN', dotToNo($reqJumlah[$i]));
		$kptt_nota_d->setField('TGL_VALUTA', "(SELECT TGL_VALUTA FROM SIUK.KPTT_NOTA X WHERE X.NO_NOTA = '".$reqId."')");	
		$kptt_nota_d->setField('KD_VALUTA', "(SELECT KD_VALUTA FROM SIUK.KPTT_NOTA X WHERE X.NO_NOTA = '".$reqId."')");
		$kptt_nota_d->setField('KURS_VALUTA', "(SELECT KURS_VALUTA FROM SIUK.KPTT_NOTA X WHERE X.NO_NOTA = '".$reqId."')");
		$kptt_nota_d->setField('JML_VAL_TRANS', dotToNo($reqNilaiJasa[$i]));
		$kptt_nota_d->setField('STATUS_KENA_PAJAK', $reqPajakId);
		$kptt_nota_d->setField('JML_VAL_PAJAK', dotToNo($reqNilaiPajak[$i]));
		$kptt_nota_d->setField('JML_RP_TRANS', dotToNo($reqNilaiJasa[$i]));
		$kptt_nota_d->setField('JML_RP_PAJAK', dotToNo($reqNilaiPajak[$i]));
		$kptt_nota_d->setField('JML_RP_SLSH_KURS', "");
		$kptt_nota_d->setField('TANDA_TRANS', "+");
		$kptt_nota_d->setField('KD_BUKU_BESAR', "(SELECT KD_BUKU_BESAR1 FROM SIUK.KBBR_TIPE_TRANS_D X WHERE X.TIPE_TRANS = 'JKM-KPT-03' AND KLAS_TRANS = '".$reqKlasTrans[$i]."')");
		$kptt_nota_d->setField('KD_SUB_BANTU', "(SELECT KD_KUSTO FROM SIUK.KPTT_NOTA X WHERE X.NO_NOTA = '".$reqId."')");	
		$kptt_nota_d->setField('KD_BUKU_PUSAT', "000.00.00");
		$kptt_nota_d->setField('KD_D_K', "(SELECT KD_DK FROM SIUK.KBBR_TIPE_TRANS_D X WHERE X.TIPE_TRANS = 'JKM-KPT-03' AND KLAS_TRANS = '".$reqKlasTrans[$i]."')");
		$kptt_nota_d->setField('PREV_NO_NOTA', "");
		$kptt_nota_d->setField('KET_TAMBAHAN', "");
		$kptt_nota_d->setField('STATUS_PROSES', "1");	
		$kptt_nota_d->setField('FLAG_JURNAL', "");
		$kptt_nota_d->setField('NO_REF1', "");
		$kptt_nota_d->setField('NO_REF2', "");
		$kptt_nota_d->setField('NO_REF3', "");
		$kptt_nota_d->setField('LAST_UPDATE_DATE', OCI_SYSDATE);
		$kptt_nota_d->setField('LAST_UPDATED_BY', substr($userLogin->nama, 0, 29));
		$kptt_nota_d->setField('PROGRAM_NAME', "IMAIS");
		$kptt_nota_d->setField('KD_TERMINAL', "");
		$kptt_nota_d->setField('NL_TARIF', "");
		$kptt_nota_d->insert();
		unset($kptt_nota_d);
		
	}
	echo $reqId."-Data berhasil disimpan.";
}
else
{		
	//if($kptt_nota_d->update())
	//	echo "Data berhasil disimpan.";
			
}
?>