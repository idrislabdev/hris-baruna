<?
/* INCLUDE FILE */
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/KpttNotaD.php");

$reqId = httpFilterPost("reqId");
$reqValutaNama= httpFilterPost("reqValutaNama");
$reqKursValuta= httpFilterPost("reqKursValuta");

$reqMode = httpFilterPost("reqMode");
$reqNoSeq= $_POST["reqNoSeq"];
$reqNoNota= $_POST["reqNoNota"];
$reqSumberBayar= $_POST["reqSumberBayar"];
$reqKartu= $_POST["reqKartu"];
$reqNoRef1= $_POST["reqNoRef1"];
$reqTanggalTransaksi= $_POST["reqTanggalTransaksi"];
$reqJumlah= $_POST["reqJumlah"];
$reqSisaTagihan= $_POST["reqSisaTagihan"];
$reqJumlahDibayar= $_POST["reqJumlahDibayar"];

if($reqMode == "insert")
{
	for($i=0; $i<count($reqNoRef1); $i++)
	{			   
		$kptt_nota_d = new KpttNotaD();
		$kptt_nota_d->setField('KD_CABANG', "96");
		$kptt_nota_d->setField('NO_NOTA', $reqId);
		$kptt_nota_d->setField('NO_SEQ', $reqNoSeq[$i]);
		$kptt_nota_d->setField('NO_SEQ', $i+1);
		$kptt_nota_d->setField('KD_SUBSIS', "KBB");
		$kptt_nota_d->setField('KD_JURNAL', "JKM");
		$kptt_nota_d->setField('TIPE_TRANS', "JKM-KBB-01");
		$kptt_nota_d->setField('KLAS_TRANS', "");
		$kptt_nota_d->setField('KD_BUKU_BESAR', $reqBukuBesar[$i]);
		$kptt_nota_d->setField('KD_SUB_BANTU', $reqKartu[$i]);
		$kptt_nota_d->setField('KD_BUKU_PUSAT', $reqBukuPusat[$i]);
		$reqKodeValuta="IDR";
		$kptt_nota_d->setField('KD_VALUTA', $reqKodeValuta);
		$kptt_nota_d->setField('TGL_VALUTA', "TRUNC(SYSDATE)");
		$reqKursValuta="1";
		$kptt_nota_d->setField('KURS_VALUTA', $reqKursValuta);
		
		$kptt_nota_d->setField('SALDO_VAL_DEBET', dotToNo($reqDebet[$i]));
		$kptt_nota_d->setField('SALDO_VAL_KREDIT', dotToNo($reqKredit[$i]));
		$kptt_nota_d->setField('SALDO_RP_DEBET', dotToNo($reqDebet[$i]));
		$kptt_nota_d->setField('SALDO_RP_KREDIT', dotToNo($reqKredit[$i]));
		$kptt_nota_d->setField('KET_TAMBAH', dotToNo($reqKeterangan[$i]));
		$kptt_nota_d->setField('TANDA_TRANS', "+");
		$kptt_nota_d->setField('KD_AKTIF', "");
		$kptt_nota_d->setField('PREV_NO_NOTA', "");
		$kptt_nota_d->setField('REF_NOTA_JUAL_BELI', "");
		$kptt_nota_d->setField('BAYAR_VIA', "");
		$kptt_nota_d->setField('STATUS_KENA_PAJAK', "");
		$kptt_nota_d->setField('LAST_UPDATE_DATE', "TRUNC(SYSDATE)");
		$kptt_nota_d->setField('LAST_UPDATED_BY', substr($userLogin->nama, 0, 29));
		$kptt_nota_d->setField('PROGRAM_NAME', "IMAIS");
		$kptt_nota_d->insert();
		unset($kptt_nota_d);
	}
	
	/*$set= new KpttNotaD();
	$set->setField("NO_NOTA", $reqId);
	$set->callPKpttNotaDToTmp();*/
	echo $reqId."-Data berhasil disimpan.";
	//echo "-Data berhasil disimpan.";
}
else
{		
	$set= new KpttNotaD();
	$set->setField("NO_NOTA", $reqId);
	$set->delete();
	unset($set);
	
	for($i=0; $i<count($reqNoRef1); $i++)
	{ 
		$kptt_nota_d = new KpttNotaD();
		$kptt_nota_d->setField('KD_CABANG', "96");
		$kptt_nota_d->setField('KD_SUBSIS', "KPT");
		$kptt_nota_d->setField('JEN_JURNAL', "JRR");
		$kptt_nota_d->setField('TIPE_TRANS', "JRR-KPT-04");
		$kptt_nota_d->setField('NO_NOTA', $reqId);
		$kptt_nota_d->setField('LINE_SEQ', $i+1);
		$kptt_nota_d->setField('KLAS_TRANS', "");
		$kptt_nota_d->setField('KWANTITAS', "");
		$kptt_nota_d->setField('SATUAN', "");
		$kptt_nota_d->setField('HARGA_SATUAN', "");
		$kptt_nota_d->setField('TGL_VALUTA', "TRUNC(SYSDATE)");
		$kptt_nota_d->setField('KD_VALUTA', setNULL($reqValutaNama));
		$kptt_nota_d->setField('KURS_VALUTA', setNULL($reqKursValuta));
		$kptt_nota_d->setField('JML_VAL_TRANS', "");
		$kptt_nota_d->setField('STATUS_KENA_PAJAK', "");
		$kptt_nota_d->setField('JML_VAL_PAJAK', "");
		$kptt_nota_d->setField('JML_RP_TRANS', "");
		$kptt_nota_d->setField('JML_RP_PAJAK', "");
		$kptt_nota_d->setField('JML_RP_SLSH_KURS', "");
		$kptt_nota_d->setField('TANDA_TRANS', "+");
		$kptt_nota_d->setField('KD_BUKU_BESAR', setNULL(""));
		$kptt_nota_d->setField('KD_SUB_BANTU', setNULL(""));
		$kptt_nota_d->setField('KD_BUKU_PUSAT', "");
		$kptt_nota_d->setField('KD_D_K', setNULL(""));
		$kptt_nota_d->setField('PREV_NO_NOTA', "");
		$kptt_nota_d->setField('KET_TAMBAHAN', "");
		$kptt_nota_d->setField('STATUS_PROSES', "");
		$kptt_nota_d->setField('FLAG_JURNAL', "");
		$kptt_nota_d->setField('NO_REF1', $reqNoRef1[$i]);
		$kptt_nota_d->setField('NO_REF2', "");
		$kptt_nota_d->setField('NO_REF3', $reqNoNota[$i]);
		$kptt_nota_d->setField('LAST_UPDATE_DATE', "TRUNC(SYSDATE)");
		$kptt_nota_d->setField('LAST_UPDATED_BY', substr($userLogin->nama, 0, 29));
		$kptt_nota_d->setField('PROGRAM_NAME', "IMAIS");
		$kptt_nota_d->setField('KD_TERMINAL', "");
		$kptt_nota_d->setField('NL_TARIF', "");
		
		/*
		$kptt_nota_d->setField('SALDO_VAL_DEBET', dotToNo($reqDebet[$i]));
		*/
		$kptt_nota_d->insert();
		
		if($i==0)
			$temp=$kptt_nota_d->query;
		unset($kptt_nota_d);
	}
	
	/*$set= new KpttNotaD();
	$set->setField("NO_NOTA", $reqId);
	$set->callPKpttNotaDToTmp();*/
	echo $reqId."#Data berhasil disimpan.";
	//echo $reqId."#".$temp;
}
?>