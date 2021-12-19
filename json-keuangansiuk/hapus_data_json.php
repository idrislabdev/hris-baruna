<?
/* INCLUDE FILE */
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/classes/utils/Validate.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/KpttNota.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/KpttNotaD.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/KpttNotaNonJurnal.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/KpttNotaNonJurnalD.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/KbbtJurBb.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/KbbtJurBbD.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/KbbtJurBbTmp.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/KbbtJurBbDTmp.php");

/* create objects */

/* LOGIN CHECK */

$reqId = httpFilterGet("reqId");
$reqSource= httpFilterGet("reqSource");
$reqPrevNotaUpdate = httpFilterGet("reqPrevNotaUpdate");

if($reqSource == "PENJUALAN_TUNAI")
{
	$kptt_nota_d = new KpttNotaD();
	$kptt_nota_d->setField("NO_NOTA", $reqId);
	$kptt_nota_d->delete();

	$kptt_nota = new KpttNota();
	$kptt_nota->setField("NO_NOTA", $reqId);
	$kptt_nota->delete();	

	$kbbt_jur_bb_d = new KbbtJurBbD();
	$kbbt_jur_bb_d->setField("NO_NOTA", $reqId);
	$kbbt_jur_bb_d->delete();	
	
	$kbbt_jur_bb = new KbbtJurBb();
	$kbbt_jur_bb->setField("NO_NOTA", $reqId);
	$kbbt_jur_bb->delete();		
	
	$arrFinal = array("HASIL" => 1);
	echo json_encode($arrFinal);	
}
else if($reqSource == "PENJUALAN_NON_TUNAI")
{
	$kptt_nota_d = new KpttNotaD();
	$kptt_nota_d->setField("NO_NOTA", $reqId);
	$kptt_nota_d->delete();

	$kptt_nota = new KpttNota();
	$kptt_nota->setField("NO_NOTA", $reqId);
	$kptt_nota->delete();	

	$kbbt_jur_bb_d = new KbbtJurBbD();
	$kbbt_jur_bb_d->setField("NO_NOTA", $reqId);
	$kbbt_jur_bb_d->delete();	
	
	$kbbt_jur_bb = new KbbtJurBb();
	$kbbt_jur_bb->setField("NO_NOTA", $reqId);
	$kbbt_jur_bb->delete();		
	
	$arrFinal = array("HASIL" => 1);
	echo json_encode($arrFinal);		
}
else if($reqSource == "PELUNASAN_KAS_BANK")
{
	$kptt_nota_d = new KpttNotaD();
	$kptt_nota_d->setField("NO_NOTA", $reqId);
	$kptt_nota_d->delete();

	$kptt_nota = new KpttNota();
	$kptt_nota->setField("NO_NOTA", $reqId);
	$kptt_nota->delete();	

	$kbbt_jur_bb_d = new KbbtJurBbD();
	$kbbt_jur_bb_d->setField("NO_NOTA", $reqId);
	$kbbt_jur_bb_d->delete();	
	
	$kbbt_jur_bb = new KbbtJurBb();
	$kbbt_jur_bb->setField("NO_NOTA", $reqId);
	$kbbt_jur_bb->delete();		
	
	$arrFinal = array("HASIL" => 1);
	echo json_encode($arrFinal);		
}

else if($reqSource == "PELUNASAN_KAS_TUNAI")
{
	$kptt_nota_d = new KpttNotaD();
	$kptt_nota_d->setField("NO_NOTA", $reqId);
	$kptt_nota_d->delete();

	$kptt_nota = new KpttNota();
	$kptt_nota->setField("NO_NOTA", $reqId);
	$kptt_nota->delete();	

	$kbbt_jur_bb_d = new KbbtJurBbD();
	$kbbt_jur_bb_d->setField("NO_NOTA", $reqId);
	$kbbt_jur_bb_d->delete();	
	
	$kbbt_jur_bb = new KbbtJurBb();
	$kbbt_jur_bb->setField("NO_NOTA", $reqId);
	$kbbt_jur_bb->delete();		
	
	include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/KpttNotaSpp.php");
	$kptt_nota = new KpttNotaSpp();
	$kptt_nota->setField("NO_NOTA", $reqId);
	$kptt_nota->batalkan();	

	$arrFinal = array("HASIL" => 1);
	echo json_encode($arrFinal);		
}

else if($reqSource == "KONPENSASI_SISA_UPER")
{
	$kptt_nota_d = new KpttNotaD();
	$kptt_nota_d->setField("NO_NOTA", $reqId);
	$kptt_nota_d->delete();

	$kptt_nota = new KpttNota();
	$kptt_nota->setField("NO_NOTA", $reqId);
	$kptt_nota->delete();	

	$kbbt_jur_bb_d = new KbbtJurBbD();
	$kbbt_jur_bb_d->setField("NO_NOTA", $reqId);
	$kbbt_jur_bb_d->delete();	
	
	$kbbt_jur_bb = new KbbtJurBb();
	$kbbt_jur_bb->setField("NO_NOTA", $reqId);
	$kbbt_jur_bb->delete();		
	
	$arrFinal = array("HASIL" => 1);
	echo json_encode($arrFinal);		
}
else if($reqSource == "PEMBATALAN_SUDAH_CETAK")
{
	$kptt_nota_d = new KpttNotaD();
	$kptt_nota_d->setField("NO_NOTA", $reqId);
	$kptt_nota_d->delete();

	$kptt_nota = new KpttNota();
	$kptt_nota->setField("NO_NOTA", $reqId);
	$kptt_nota->delete();	

	$kbbt_jur_bb_d = new KbbtJurBbD();
	$kbbt_jur_bb_d->setField("NO_NOTA", $reqId);
	$kbbt_jur_bb_d->delete();	
	
	$kbbt_jur_bb = new KbbtJurBb();
	$kbbt_jur_bb->setField("NO_NOTA", $reqId);
	$kbbt_jur_bb->delete();		
	
	$arrFinal = array("HASIL" => 1);
	echo json_encode($arrFinal);		
}
else if($reqSource == "PEMBATALAN_PELUNASAN")
{
	$kptt_nota_d = new KpttNotaD();
	$kptt_nota_d->setField("NO_NOTA", $reqId);
	$kptt_nota_d->delete();

	$kptt_nota = new KpttNota();
	$kptt_nota->setField("NO_NOTA", $reqId);
	$kptt_nota->delete();

	$kbbt_jur_bb_d = new KbbtJurBbD();
	$kbbt_jur_bb_d->setField("NO_NOTA", $reqId);
	$kbbt_jur_bb_d->delete();	
	
	$kbbt_jur_bb = new KbbtJurBb();
	$kbbt_jur_bb->setField("NO_NOTA", $reqId);
	$kbbt_jur_bb->delete();		
	
	$kptt_nota_update = new KpttNota();
	$kptt_nota_update->setField("NO_NOTA", $reqPrevNotaUpdate);
	$kptt_nota_update->updatePembatalanPelunasanDelete();
	
	$arrFinal = array("HASIL" => 1);
	echo json_encode($arrFinal);		
}
else if($reqSource == "PEMBATALAN_KOMPENSASI")
{
	$kptt_nota_d = new KpttNotaD();
	$kptt_nota_d->setField("NO_NOTA", $reqId);
	$kptt_nota_d->delete();

	$kptt_nota = new KpttNota();
	$kptt_nota->setField("NO_NOTA", $reqId);
	$kptt_nota->delete();	

	$kbbt_jur_bb_d = new KbbtJurBbD();
	$kbbt_jur_bb_d->setField("NO_NOTA", $reqId);
	$kbbt_jur_bb_d->delete();	
	
	$kbbt_jur_bb = new KbbtJurBb();
	$kbbt_jur_bb->setField("NO_NOTA", $reqId);
	$kbbt_jur_bb->delete();		
	
	$arrFinal = array("HASIL" => 1);
	echo json_encode($arrFinal);		
}
else if($reqSource == "JURNAL_PENERIMAAN_KAS_BANK")
{
	$kbbt_jur_bb_d = new KbbtJurBbD();
	$kbbt_jur_bb_d->setField("NO_NOTA", $reqId);
	$kbbt_jur_bb_d->delete();	
	
	$kbbt_jur_bb = new KbbtJurBb();
	$kbbt_jur_bb->setField("NO_NOTA", $reqId);
	$kbbt_jur_bb->delete();		
	
	$kbbt_jur_bb_d_tmp = new KbbtJurBbDTmp();
	$kbbt_jur_bb_d_tmp->setField("NO_NOTA", $reqId);
	$kbbt_jur_bb_d_tmp->delete();	
	
	$kbbt_jur_bb_tmp = new KbbtJurBbTmp();
	$kbbt_jur_bb_tmp->setField("NO_NOTA", $reqId);
	$kbbt_jur_bb_tmp->delete();		
	
	$arrFinal = array("HASIL" => 1);
	echo json_encode($arrFinal);		
}
else if($reqSource == "JURNAL_PENGELUARAN_KAS_BANK")
{
	$kbbt_jur_bb_d = new KbbtJurBbD();
	$kbbt_jur_bb_d->setField("NO_NOTA", $reqId);
	$kbbt_jur_bb_d->delete();	
	
	$kbbt_jur_bb = new KbbtJurBb();
	$kbbt_jur_bb->setField("NO_NOTA", $reqId);
	$kbbt_jur_bb->delete();		
	
	$kbbt_jur_bb_d_tmp = new KbbtJurBbDTmp();
	$kbbt_jur_bb_d_tmp->setField("NO_NOTA", $reqId);
	$kbbt_jur_bb_d_tmp->delete();	
	
	$kbbt_jur_bb_tmp = new KbbtJurBbTmp();
	$kbbt_jur_bb_tmp->setField("NO_NOTA", $reqId);
	$kbbt_jur_bb_tmp->delete();		
	
	$arrFinal = array("HASIL" => 1);
	echo json_encode($arrFinal);		
}
else if($reqSource == "JURNAL_RUPA_RUPA")
{
	$kbbt_jur_bb_d = new KbbtJurBbD();
	$kbbt_jur_bb_d->setField("NO_NOTA", $reqId);
	$kbbt_jur_bb_d->delete();	
	
	$kbbt_jur_bb = new KbbtJurBb();
	$kbbt_jur_bb->setField("NO_NOTA", $reqId);
	$kbbt_jur_bb->delete();		
	
	$kbbt_jur_bb_d_tmp = new KbbtJurBbDTmp();
	$kbbt_jur_bb_d_tmp->setField("NO_NOTA", $reqId);
	$kbbt_jur_bb_d_tmp->delete();	
	
	$kbbt_jur_bb_tmp = new KbbtJurBbTmp();
	$kbbt_jur_bb_tmp->setField("NO_NOTA", $reqId);
	$kbbt_jur_bb_tmp->delete();		
	
	$arrFinal = array("HASIL" => 1);
	echo json_encode($arrFinal);		
}
else if($reqSource == "JURNAL_PEMINDAHBUKUAN")
{
	$kbbt_jur_bb_d = new KbbtJurBbD();
	$kbbt_jur_bb_d->setField("NO_NOTA", $reqId);
	$kbbt_jur_bb_d->delete();	
	
	$kbbt_jur_bb = new KbbtJurBb();
	$kbbt_jur_bb->setField("NO_NOTA", $reqId);
	$kbbt_jur_bb->delete();		
	
	$kbbt_jur_bb_d_tmp = new KbbtJurBbDTmp();
	$kbbt_jur_bb_d_tmp->setField("NO_NOTA", $reqId);
	$kbbt_jur_bb_d_tmp->delete();	
	
	$kbbt_jur_bb_tmp = new KbbtJurBbTmp();
	$kbbt_jur_bb_tmp->setField("NO_NOTA", $reqId);
	$kbbt_jur_bb_tmp->delete();		
	
	$arrFinal = array("HASIL" => 1);
	echo json_encode($arrFinal);		
}
else if($reqSource == "PROSES_AJP")
{
	$kbbt_jur_bb_d = new KbbtJurBbD();
	$kbbt_jur_bb_d->setField("NO_NOTA", $reqId);
	$kbbt_jur_bb_d->delete();	
	
	$kbbt_jur_bb = new KbbtJurBb();
	$kbbt_jur_bb->setField("NO_NOTA", $reqId);
	$kbbt_jur_bb->delete();		
	
	$kbbt_jur_bb_d_tmp = new KbbtJurBbDTmp();
	$kbbt_jur_bb_d_tmp->setField("NO_NOTA", $reqId);
	$kbbt_jur_bb_d_tmp->delete();	
	
	$kbbt_jur_bb_tmp = new KbbtJurBbTmp();
	$kbbt_jur_bb_tmp->setField("NO_NOTA", $reqId);
	$kbbt_jur_bb_tmp->delete();		
	
	$arrFinal = array("HASIL" => 1);
	echo json_encode($arrFinal);		
}
else if($reqSource == "PROSES_AJT")
{
	$kbbt_jur_bb_d = new KbbtJurBbD();
	$kbbt_jur_bb_d->setField("NO_NOTA", $reqId);
	$kbbt_jur_bb_d->delete();	
	
	$kbbt_jur_bb = new KbbtJurBb();
	$kbbt_jur_bb->setField("NO_NOTA", $reqId);
	$kbbt_jur_bb->delete();		
	
	$kbbt_jur_bb_d_tmp = new KbbtJurBbDTmp();
	$kbbt_jur_bb_d_tmp->setField("NO_NOTA", $reqId);
	$kbbt_jur_bb_d_tmp->delete();	
	
	$kbbt_jur_bb_tmp = new KbbtJurBbTmp();
	$kbbt_jur_bb_tmp->setField("NO_NOTA", $reqId);
	$kbbt_jur_bb_tmp->delete();		
	
	$arrFinal = array("HASIL" => 1);
	echo json_encode($arrFinal);		
}
else if($reqSource == "JURNAL_JRR_AUDIT")
{
	$kbbt_jur_bb_d = new KbbtJurBbD();
	$kbbt_jur_bb_d->setField("NO_NOTA", $reqId);
	$kbbt_jur_bb_d->delete();	
	
	$kbbt_jur_bb = new KbbtJurBb();
	$kbbt_jur_bb->setField("NO_NOTA", $reqId);
	$kbbt_jur_bb->delete();		
	
	$kbbt_jur_bb_d_tmp = new KbbtJurBbDTmp();
	$kbbt_jur_bb_d_tmp->setField("NO_NOTA", $reqId);
	$kbbt_jur_bb_d_tmp->delete();	
	
	$kbbt_jur_bb_tmp = new KbbtJurBbTmp();
	$kbbt_jur_bb_tmp->setField("NO_NOTA", $reqId);
	$kbbt_jur_bb_tmp->delete();		
	
	$arrFinal = array("HASIL" => 1);
	echo json_encode($arrFinal);		
}
else if($reqSource == "JURNAL_JRR_TUTUP")
{
	$kbbt_jur_bb_d = new KbbtJurBbD();
	$kbbt_jur_bb_d->setField("NO_NOTA", $reqId);
	$kbbt_jur_bb_d->delete();	
	
	$kbbt_jur_bb = new KbbtJurBb();
	$kbbt_jur_bb->setField("NO_NOTA", $reqId);
	$kbbt_jur_bb->delete();		
	
	$kbbt_jur_bb_d_tmp = new KbbtJurBbDTmp();
	$kbbt_jur_bb_d_tmp->setField("NO_NOTA", $reqId);
	$kbbt_jur_bb_d_tmp->delete();	
	
	$kbbt_jur_bb_tmp = new KbbtJurBbTmp();
	$kbbt_jur_bb_tmp->setField("NO_NOTA", $reqId);
	$kbbt_jur_bb_tmp->delete();		
	
	$arrFinal = array("HASIL" => 1);
	echo json_encode($arrFinal);		
}
else if(strtoupper($reqSource) == "PENJUALAN_LAIN") {
	
	$kptt_nota_d = new KpttNotaNonJurnalD();
	$kptt_nota_d->setField("NO_NOTA", $reqId);
	$kptt_nota_d->delete();

	$kptt_nota = new KpttNotaNonJurnal();
	$kptt_nota->setField("NO_NOTA", $reqId);
	$kptt_nota->delete();	
	
	$arrFinal = array("HASIL" => 1, "A" => $kptt_nota->query, "B" => $kptt_nota_d->query);
	echo json_encode($arrFinal);		
}

$kbbt_jur_bb = new KbbtJurBb();
$kbbt_jur_bb->setField("NO_NOTA", $reqId);
$kbbt_jur_bb->insertLogHapus();

?>