<?php
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/ReportPrint.php");

$tinggi = 155;
$set= new ReportPrint();

$reqNoBukti= httpFilterGet("reqNoBukti");
$reqPejabat= httpFilterGet("reqPejabat");
$reqParam1= httpFilterGet("reqParam1");
$reqParam2= httpFilterGet("reqParam2");
$reqParam3= httpFilterGet("reqParam3");
$reqParam4= httpFilterGet("reqParam4");

$arrPejabat = explode('-', $reqPejabat);
$pejabat = $arrPejabat[0];
$jabatan = $arrPejabat[1];

$arrNoBukti= explode(",", $reqNoBukti);
$tempStatementNoBukti="";
$panjangArrNoBukti= count($arrNoBukti);

if($panjangArrNoBukti == 1)
{
	$tempStatementNoBukti= "'".$arrNoBukti[0]."'";
}
else
{
	for($x=0; $x < $panjangArrNoBukti; $x++)
	{
		if($tempStatementNoBukti == "")
			$separator="";
		else
			$separator=",";
		
		$tempStatementNoBukti.= $separator."'".$arrNoBukti[$x]."'";
	}
}

$statement= " AND A.NO_NOTA IN (".$tempStatementNoBukti.")";

$index_set= 0;
$set->selectByParamsJKM(array(), -1, -1,$statement);
//echo $set->query;
while($set->nextRow())
{
	//NO_NOTA, TGL_TRANS, JML_VAL_TRANS, JML_RP_TRANS, NM_AGEN_PERUSH, ALMT_AGEN_PERUSH, KETERANGAN_UTAMA, 
	//BUKTI_PENDUKUNG, NOMOR, KD_BUKU_BESAR, KD_SUB_BANTU, KD_BUKU_PUSAT, NM_BUKU_BESAR_WITH_PARENT,
	//NM_BUKU_BESAR, NM_SUB_BANTU, NM_BUKU_PUSAT,
	//KETERANGAN_DETIL, SALDO_VAL_DEBET, SALDO_VAL_KREDIT, SALDO_RP_DEBET, SALDO_RP_KREDIT, KD_VALUTA
	
	$arrData[$index_set]["NO_NOTA"]= $set->getField("NO_NOTA");
	$arrData[$index_set]["TGL_TRANS"]= $set->getField("TGL_TRANS");
	$arrData[$index_set]["JML_VAL_TRANS"]= $set->getField("JML_VAL_TRANS");
	$arrData[$index_set]["JML_RP_TRANS"]= $set->getField("JML_RP_TRANS");
	$arrData[$index_set]["NM_AGEN_PERUSH"]= $set->getField("NM_AGEN_PERUSH");
	$arrData[$index_set]["ALMT_AGEN_PERUSH"]= $set->getField("ALMT_AGEN_PERUSH");
	$arrData[$index_set]["KETERANGAN_UTAMA"]= $set->getField("KETERANGAN_UTAMA");
	$arrData[$index_set]["BUKTI_PENDUKUNG"]= $set->getField("BUKTI_PENDUKUNG");
	$arrData[$index_set]["NOMOR"]= $set->getField("NOMOR");
	$arrData[$index_set]["KD_BUKU_BESAR"]= $set->getField("KD_BUKU_BESAR");
	$arrData[$index_set]["KD_SUB_BANTU"]= $set->getField("KD_SUB_BANTU");
	$arrData[$index_set]["KD_BUKU_PUSAT"]= $set->getField("KD_BUKU_PUSAT");
	$arrData[$index_set]["NM_BUKU_BESAR_WITH_PARENT"]= $set->getField("NM_BUKU_BESAR_WITH_PARENT");
	$arrData[$index_set]["NM_BUKU_BESAR"]= $set->getField("NM_BUKU_BESAR");
	$arrData[$index_set]["NM_SUB_BANTU"]= $set->getField("NM_SUB_BANTU");
	$arrData[$index_set]["NM_BUKU_PUSAT"]= $set->getField("NM_BUKU_PUSAT");
	$arrData[$index_set]["KETERANGAN_DETIL"]= $set->getField("KETERANGAN_DETIL");
	$arrData[$index_set]["SALDO_VAL_DEBET"]= $set->getField("SALDO_VAL_DEBET");
	$arrData[$index_set]["SALDO_VAL_KREDIT"]= $set->getField("SALDO_VAL_KREDIT");
	$arrData[$index_set]["SALDO_RP_DEBET"]= $set->getField("SALDO_RP_DEBET");
	$arrData[$index_set]["SALDO_RP_KREDIT"]= $set->getField("SALDO_RP_KREDIT");
	$arrData[$index_set]["KD_VALUTA"]= $set->getField("KD_VALUTA");
	$index_set++;
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<!--<html xmlns="http://www.w3.org/1999/xhtml">-->
<html moznomarginboxes mozdisallowselectionprint>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Untitled Document</title>
<link rel="stylesheet" href="cetak/test5.css" type="text/css" />
<script src="../WEB-INF/lib/media/js/jquery-1.4.4.min.js" type="text/javascript"></script>
<script type="text/javascript" src="../WEB-INF/lib/printModul/printFungsi.js"></script>
<script type="text/javascript" charset="utf-8">
	var nomor_halaman= 1;
   function print() {
         if (qz != null) {
            // Searches for default printer
            qz.findPrinter();
         }
         if (qz != null) {
            // total lebar = 96
			
			var header=headerHalaman=headerDetil=isiValue=tempIsiValue="";
			var rowHeader=rowHeaderDetil=rowPaper=nomor_halaman=1;
			<?
			$temp_checkbox_index=0;
			$tempKondisiNoBukti="";
			for($checkbox_index=0;$checkbox_index<count($arrData);$checkbox_index++)
			{
			?>
			// buat header
			header="   PT. PELINDO MARINE SERVICE                           REPORT ID.    : KBB_BKT_JKK_ENTRY.PR\n";
			header+="   ------------------------                             TGL.PROSES    : <?=dateToPageCheck($arrData[$checkbox_index]["TGL_TRANS"])?>\n";
			header+="                                                        HALAMAN       : ";
			headerHalaman+="                             BUKTI PENERIMAAN KAS-BANK\n";
			headerHalaman+="                            =============================\n";
			headerHalaman+="   NO BUKTI  : <?=$arrData[$checkbox_index]["NO_NOTA"]?>                                         TANGGAL  : <?=dateToPageCheck($arrData[$checkbox_index]["TGL_TRANS"])?>\n";
			headerHalaman+=" |=============================================================================================|\n";
			rowHeader=7;
			
			// buat header Detil
			var temp= " | 1. Pemegang Kas harap menerimakan uang sebesar ";
			headerDetil=fillStringCompletor(temp,"37"," ",":");
			temp+= "Rp. <?=numberToIna($arrData[$checkbox_index]["JML_RP_TRANS"])?>";
			headerDetil=fillStringCompletor(temp,"95"," ","|")+"\n";rowHeaderDetil++;

			temp= " | 2. Terbilang";
			temp=fillStringCompletor(temp,"21"," ",":");
			temp+= "<?=terbilang($arrData[$checkbox_index]["JML_RP_TRANS"])." Rupiah"?>";
			temp=fillStringCompletor(temp,"95"," ","");
			var result = splitIntoLines(temp, 95);

			for (var i = 0; i < result.length; i++)
			{
				if(i == 0)
				{
					temp= " "+fillStringCompletor(result[i], "94"," ","|");
					var panjangTemp= panjangString(temp);
					//alert(temp+'--'+panjangTemp);
					headerDetil+=temp+"\n";
					//alert(" "+fillStringCompletor(result[i], "94"," ","|"));
				}
				else
				{
					temp=fillStringCompletor(" |","39"," "," ");
					temp=fillStringCompletor(temp+result[i], "95"," ","|");
					var panjangTemp= panjangString(temp);
					//alert(temp+'--'+panjangTemp);
					headerDetil+=temp+"\n";
				}
				rowHeaderDetil++;
			}
			
			temp= " | 3. Kepada";
			temp=fillStringCompletor(temp,"21"," ",":");
			temp+= "<?=$arrData[$checkbox_index]["NM_AGEN_PERUSH"]?>";
			temp=fillStringCompletor(temp,"95"," ","|");
			var panjangTemp= panjangString(temp);
			//alert(temp+'--'+panjangTemp);
			headerDetil+=temp+"\n";rowHeaderDetil++;
			//alert(temp);
			
			temp= " | 4. Alamat";
			temp=fillStringCompletor(temp,"21"," ",":");
			temp+= "<?=$arrData[$checkbox_index]["ALMT_AGEN_PERUSH"]?>";
			temp=fillStringCompletor(temp,"95"," ","|");
			var panjangTemp= panjangString(temp);
			//alert(temp+'--'+panjangTemp);
			headerDetil+=temp+"\n";rowHeaderDetil++;
			
			temp= " | 5. Uraian";
			temp=fillStringCompletor(temp,"21"," ",":");
			temp+= "<?=$arrData[$checkbox_index]["KETERANGAN_UTAMA"]?>";
			temp=fillStringCompletor(temp,"95"," ","");
			var result = splitIntoLines(temp, 95);

			for (var i = 0; i < result.length; i++)
			{
				if(i == 0)
				{
					temp= " "+fillStringCompletor(result[i], "94"," ","|");
					var panjangTemp= panjangString(temp);
					//alert(temp+'--'+panjangTemp);
					headerDetil+=temp+"\n";
				}
				else
				{
					temp=fillStringCompletor(" |","39"," "," ");
					temp=fillStringCompletor(temp+result[i], "95"," ","|");
					var panjangTemp= panjangString(temp);
					//alert(temp+'--'+panjangTemp);
					headerDetil+=temp+"\n";
				}
				rowHeaderDetil++;
			}
			
			temp= " | 6. Bukti Pendukung";
			temp=fillStringCompletor(temp,"21"," ",":");
			temp+= "<?=$arrData[$checkbox_index]["BUKTI_PENDUKUNG"]?>";
			temp=fillStringCompletor(temp,"68"," ","");
			tempDetil= temp+"Tanggal, <?=dateToPageCheck($arrData[$checkbox_index]["TGL_TRANS"])?>";
			temp=fillStringCompletor(tempDetil,"95"," ","|");
			var panjangTemp= panjangString(temp);
			//alert(temp+'--'+panjangTemp);
			//alert(temp);
			headerDetil+=temp+"\n";rowHeaderDetil++;
			
			temp= " |";
			temp=fillStringCompletor(temp,"95","-","|");
			var panjangTemp= panjangString(temp);
			//alert(temp+'--'+panjangTemp);
			headerDetil+=temp+"\n";rowHeaderDetil++;
			
			temp= " |";
			temp=fillStringCompletor(temp,"35"," ","");
			temp+="KODE DAN NAMA REKENING";
			temp=fillStringCompletor(temp,"95"," ","|");
			var panjangTemp= panjangString(temp);
			//alert(temp+'--'+panjangTemp);
			headerDetil+=temp+"\n";rowHeaderDetil++;
			
			temp= " |";
			temp=fillStringCompletor(temp,"95","-","|");
			var panjangTemp= panjangString(temp);
			//alert(temp+'--'+panjangTemp);
			headerDetil+=temp+"\n";rowHeaderDetil++;
			
			temp= " |";
			temp=fillStringCompletor(temp,"4"," ","");
			temp+="NO";
			temp=fillStringCompletor(temp,"9"," ","");
			temp+="MUTASI JURNAL";
			temp=fillStringCompletor(temp,"48"," ","");
			temp+=" ";
			temp=fillStringCompletor(temp,"50"," ","");
			temp+="DEBET";
			temp=fillStringCompletor(temp,"65"," ","");
			temp=fillStringCompletor(temp,"80"," ","");
			temp+="KREDIT";
			temp=fillStringCompletor(temp,"95"," ","|");
			var panjangTemp= panjangString(temp);
			//alert(temp+'--'+panjangTemp);
			headerDetil+=temp+"\n";rowHeaderDetil++;
			
			rowPaper= rowHeader+rowHeaderDetil;
			isiValue+= header+nomor_halaman+"\n"+headerHalaman+headerDetil;
			
			//buat isi detil
			//NO_NOTA, TGL_TRANS, JML_VAL_TRANS, JML_RP_TRANS, NM_AGEN_PERUSH, ALMT_AGEN_PERUSH, KETERANGAN_UTAMA, 
			//BUKTI_PENDUKUNG, NOMOR, KD_BUKU_BESAR, KD_SUB_BANTU, KD_BUKU_PUSAT, NM_BUKU_BESAR_WITH_PARENT,
			//NM_BUKU_BESAR, NM_SUB_BANTU, NM_BUKU_PUSAT,
			//KETERANGAN_DETIL, SALDO_VAL_DEBET, SALDO_VAL_KREDIT, SALDO_RP_DEBET, SALDO_RP_KREDIT, KD_VALUTA
			<?
			if($temp_checkbox_index == 1)
			{
				$temp_checkbox_index=0;
				$checkbox_index--;
			}
			
			for($checkbox_index=$checkbox_index;$checkbox_index<count($arrData);$checkbox_index++)
			{
				if($tempKondisiNoBukti == $arrData[$checkbox_index]["NO_NOTA"] || $tempKondisiNoBukti == "")
				{
			?>
				if(rowPaper == 60)
				{
					temp= " |";
					temp=fillStringCompletor(temp,"95","-","|");
					var panjangTemp= panjangString(temp);
					//alert(temp+'--'+panjangTemp);
					isiValue+=temp+"\n";
					
					nomor_halaman++;
					//alert(nomor_halaman);
					rowPaper=rowHeaderDetil=1;
					isiValue+="\f";
					//isiValue+= header;
					isiValue+= header+nomor_halaman+"\n"+headerHalaman;
				}
			<?
				$tempNoNota= $arrData[$checkbox_index]["NO_NOTA"];
				$tempTanggalTrans= $arrData[$checkbox_index]["TGL_TRANS"];
				$tempJumlahValTrans= $arrData[$checkbox_index]["JML_VAL_TRANS"];
				$tempJumlahRpTrans= $arrData[$checkbox_index]["JML_RP_TRANS"];
				$tempNamaAgenPerusahaan= $arrData[$checkbox_index]["NM_AGEN_PERUSH"];
				$tempAlamatAgenPerusahaan= $arrData[$checkbox_index]["ALMT_AGEN_PERUSH"];
				$tempKeteranganUtama= $arrData[$checkbox_index]["KETERANGAN_UTAMA"];
				$tempBuktiPendukung= $arrData[$checkbox_index]["BUKTI_PENDUKUNG"];
				$tempNomor= $arrData[$checkbox_index]["NOMOR"];
				$tempKdBukuBesar= $arrData[$checkbox_index]["KD_BUKU_BESAR"];
				$tempKdSubBantu= $arrData[$checkbox_index]["KD_SUB_BANTU"];
				$tempKdBukuPusat= $arrData[$checkbox_index]["KD_BUKU_PUSAT"];
				$tempNamaBukuBesarParent= $arrData[$checkbox_index]["NM_BUKU_BESAR_WITH_PARENT"];
				$tempNamaBukuBesar= $arrData[$checkbox_index]["NM_BUKU_BESAR"];
				$tempNamaSubBantu= $arrData[$checkbox_index]["NM_SUB_BANTU"];
				$tempNamaBukuPusat= $arrData[$checkbox_index]["NM_BUKU_PUSAT"];
				$tempKeteranganDetil= $arrData[$checkbox_index]["KETERANGAN_DETIL"];
				$tempSaldoValDebet= $arrData[$checkbox_index]["SALDO_VAL_DEBET"];
				$tempSaldoValKredit= $arrData[$checkbox_index]["SALDO_VAL_KREDIT"];
				$tempSaldoRpDebet= $arrData[$checkbox_index]["SALDO_RP_DEBET"];
				$tempSaldoRpKredit= $arrData[$checkbox_index]["SALDO_RP_KREDIT"];
				$tempKdValuta= $arrData[$checkbox_index]["KD_VALUTA"];
				
				if($tempSaldoRpDebet == 0)
				{
			?>
				temp= " |";
				temp=fillStringCompletor(temp,"4"," ","");
				temp+="<?=$tempNomor?>";
				temp=fillStringCompletor(temp,"9"," ","");
				temp+="<?=$tempKdBukuBesar?>";
				temp=fillStringCompletor(temp,"21"," ","");
				temp+="<?=$tempKdSubBantu?>";
				temp=fillStringCompletor(temp,"29"," ","");
				temp+="<?=$tempKdBukuPusat?>";
				temp=fillStringCompletor(temp,"44"," ","");
				temp+="RP";
				temp=fillStringCompletor(temp,"50"," ","");
				temp+=" ";
				temp=fillStringCompletor(temp,"65"," ","");
				temp=fillStringCompletor(temp,"80"," ","");
				temp+="<?=numberToIna($arrData[$checkbox_index]["SALDO_RP_KREDIT"])?>";
				temp=fillStringCompletor(temp,"95"," ","|");
				var panjangTemp= panjangString(temp);
				//alert(temp+'--'+panjangTemp);
			<?
				}
				else
				{
			?>	
				temp= " |";
				temp=fillStringCompletor(temp,"4"," ","");
				temp+="<?=$tempNomor?>";
				temp=fillStringCompletor(temp,"9"," ","");
				temp+="<?=$tempKdBukuBesar?>";
				temp=fillStringCompletor(temp,"21"," ","");
				temp+="<?=$tempKdSubBantu?>";
				temp=fillStringCompletor(temp,"29"," ","");
				temp+="<?=$tempKdBukuPusat?>";
				temp=fillStringCompletor(temp,"44"," ","");
				temp+="RP";
				temp=fillStringCompletor(temp,"50"," ","");
				temp+="<?=numberToIna($arrData[$checkbox_index]["SALDO_RP_DEBET"])?>";
				temp=fillStringCompletor(temp,"65"," ","");
				temp=fillStringCompletor(temp,"80"," ","");
				temp+="";
				temp=fillStringCompletor(temp,"95"," ","|");
				var panjangTemp= panjangString(temp);
				//alert(temp+'--'+panjangTemp);
			<?
				}
			?>
				isiValue+=temp+"\n";
				rowPaper++;
				
				temp= " |";
				temp=fillStringCompletor(temp,"9"," ","");
				temp+= "<?=$tempNamaBukuBesar?>";
				temp=fillStringCompletor(temp,"95"," ","");
				var result = splitIntoLines(temp, 35);
				for (var i = 0; i < result.length; i++)
				{
					if(rowPaper == 60)
					{
						temp= " |";
						temp=fillStringCompletor(temp,"95","-","|");
						var panjangTemp= panjangString(temp);
						//alert(temp+'--'+panjangTemp);
						isiValue+=temp+"\n";
				
						nomor_halaman++;
						//alert(nomor_halaman);
						rowPaper=rowHeaderDetil=1;
						isiValue+="\f";
						//isiValue+= header;
						isiValue+= header+nomor_halaman+"\n"+headerHalaman;
					}
				
					if(i == 0)
					{
						temp= " "+fillStringCompletor(result[i], "94"," ","|");
						var panjangTemp= panjangString(temp);
						//alert(temp+'--'+panjangTemp);
					}
					else
					{
						temp=fillStringCompletor(" |","9"," ","");
						temp=fillStringCompletor(temp+result[i], "35"," ","");
						temp=fillStringCompletor(temp,"95"," ","|");
						var panjangTemp= panjangString(temp);
						//alert(temp+'--'+panjangTemp);
					}
					
					isiValue+=temp+"\n";
					rowPaper++;
				}
				
			<?
				}
				else
				{
					$temp_checkbox_index=1;
					break;
				}
				$tempKondisiNoBukti= $arrData[$checkbox_index]["NO_NOTA"];
			}
			?>
			
			<?
			$tempJumlahTransIndex= $checkbox_index;
			if($tempJumlahTransIndex == 0){}
			else
				$tempJumlahTransIndex= $checkbox_index-1;
            ?>
			
			temp= " |";
			temp=fillStringCompletor(temp,"95"," ","|");
			var panjangTemp= panjangString(temp);
			//alert(temp+'--'+panjangTemp);
			isiValue+=temp+"\n";
			rowPaper++;
			
			temp= " |";
			temp=fillStringCompletor(temp,"29"," ","");
			temp+="JUMLAH MUTASI";
			temp=fillStringCompletor(temp,"44"," ","");
			temp+="RP";
			temp=fillStringCompletor(temp,"50"," ","");
			temp+="<?=numberToIna($arrData[$tempJumlahTransIndex]["JML_RP_TRANS"])?>";
			temp=fillStringCompletor(temp,"65"," ","");
			temp=fillStringCompletor(temp,"80"," ","");
			temp+="<?=numberToIna($arrData[$tempJumlahTransIndex]["JML_RP_TRANS"])?>";
			temp=fillStringCompletor(temp,"95"," ","|");
			var panjangTemp= panjangString(temp);
			//alert(temp+'--'+panjangTemp);
			isiValue+=temp+"\n";
			rowPaper++;
			
			
			//buat footer: 30 line
			var tempFooter= rowPaper+30;
			//alert(tempFooter+'--'+rowPaper);
			if(tempFooter >= 60)
			{
				temp= " |";
				temp=fillStringCompletor(temp,"95","-","|");
				var panjangTemp= panjangString(temp);
				//alert(temp+'--'+panjangTemp);
				isiValue+=temp+"\n";
			
				nomor_halaman++;
				//alert(nomor_halaman);
				rowPaper=rowHeaderDetil=1;
				isiValue+="\f";
			}
			
			temp= " |";
			temp=fillStringCompletor(temp,"95","-","|");
			var panjangTemp= panjangString(temp);
			//alert(temp+'--'+panjangTemp);
			isiValue+=temp+"\n";
			
			temp= " |";
			temp=fillStringCompletor(temp,"18"," ","");
			temp+="TELAH DIPERIKSA";
			temp=fillStringCompletor(temp,"47"," ","|");
			temp=fillStringCompletor(temp,"68"," ","");
			temp+="SURABAYA, <?=dateToPageCheck($arrData[$tempJumlahTransIndex]["TGL_TRANS"])?>";
			temp=fillStringCompletor(temp,"95"," ","|");
			var panjangTemp= panjangString(temp);
			//alert(temp+'--'+panjangTemp);
			isiValue+=temp+"\n";
			
			temp= " |";
			temp=fillStringCompletor(temp,"47","-","|");
			temp=fillStringCompletor(temp,"95"," ","|");
			var panjangTemp= panjangString(temp);
			//alert(temp+'--'+panjangTemp);
			isiValue+=temp+"\n";
			
			temp= " |";
			temp=fillStringCompletor(temp,"8"," ","");
			temp+="PEJABAT";
			temp=fillStringCompletor(temp,"25"," ","|");
			temp+="  PARAF";
			temp=fillStringCompletor(temp,"35"," ","|");
			temp+=" TANGGAL";
			temp=fillStringCompletor(temp,"47"," ","|");
			temp=fillStringCompletor(temp,"74"," ","");
			temp+="<?=$jabatan?>";
			temp=fillStringCompletor(temp,"95"," ","|");
			var panjangTemp= panjangString(temp);
			//alert(temp+'--'+panjangTemp);
			isiValue+=temp+"\n";
			
			temp= " |";
			temp=fillStringCompletor(temp,"25","-","|");
			temp=fillStringCompletor(temp,"35","-","|");
			temp=fillStringCompletor(temp,"47","-","|");
			temp=fillStringCompletor(temp,"95"," ","|");
			var panjangTemp= panjangString(temp);
			//alert(temp+'--'+panjangTemp);
			isiValue+=temp+"\n";
			
			temp= " |";
			temp=fillStringCompletor(temp,"3"," ","");
			temp+="STAF VALIDASI";
			temp=fillStringCompletor(temp,"25"," ","|");
			temp=fillStringCompletor(temp,"35"," ","|");
			temp=fillStringCompletor(temp,"47"," ","|");
			temp=fillStringCompletor(temp,"74"," ","");
			temp=fillStringCompletor(temp,"95"," ","|");
			var panjangTemp= panjangString(temp);
			//alert(temp+'--'+panjangTemp);
			isiValue+=temp+"\n";
			
			temp= " |";
			temp=fillStringCompletor(temp,"25"," ","|");
			temp=fillStringCompletor(temp,"35"," ","|");
			temp=fillStringCompletor(temp,"47"," ","|");
			temp=fillStringCompletor(temp,"95"," ","|");
			var panjangTemp= panjangString(temp);
			//alert(temp+'--'+panjangTemp);
			isiValue+=temp+"\n";
			
			temp= " |";
			temp=fillStringCompletor(temp,"25","-","|");
			temp=fillStringCompletor(temp,"35","-","|");
			temp=fillStringCompletor(temp,"47","-","|");
			temp=fillStringCompletor(temp,"95"," ","|");
			var panjangTemp= panjangString(temp);
			//alert(temp+'--'+panjangTemp);
			isiValue+=temp+"\n";
			
			temp= " |";
			temp=fillStringCompletor(temp,"3"," ","");
			temp+="<?=$reqParam1?>";
			temp=fillStringCompletor(temp,"25"," ","|");
			temp=fillStringCompletor(temp,"35"," ","|");
			temp=fillStringCompletor(temp,"47"," ","|");
			temp=fillStringCompletor(temp,"74"," ","");
			temp+="<?=$pejabat?>";
			var panjangPenandatangan= panjangString("<?=$pejabat?>");
			temp=fillStringCompletor(temp,"95"," ","|");
			var panjangTemp= panjangString(temp);
			//alert(temp+'--'+panjangTemp);
			isiValue+=temp+"\n";
			
			temp= " |";
			temp=fillStringCompletor(temp,"25"," ","|");
			temp=fillStringCompletor(temp,"35"," ","|");
			temp=fillStringCompletor(temp,"47"," ","|");
			temp=fillStringCompletor(temp,"74"," ","");
			panjangPenandatangan= 95-panjangPenandatangan-1;
			temp=fillStringCompletor(temp,panjangPenandatangan,"-","");
			temp=fillStringCompletor(temp,"95"," ","|");
			var panjangTemp= panjangString(temp);
			//alert(temp+'--'+panjangTemp);
			isiValue+=temp+"\n";
			
			temp= " |";
			temp=fillStringCompletor(temp,"25","-","|");
			temp=fillStringCompletor(temp,"35","-","|");
			temp=fillStringCompletor(temp,"47","-","|");
			temp=fillStringCompletor(temp,"95","-","|");
			var panjangTemp= panjangString(temp);
			//alert(temp+'--'+panjangTemp);
			isiValue+=temp+"\n";
			
			temp= " |";
			temp=fillStringCompletor(temp,"3"," ","");
			temp+="<?=$reqParam2?>";
			temp=fillStringCompletor(temp,"25"," ","|");
			temp=fillStringCompletor(temp,"35"," ","|");
			temp=fillStringCompletor(temp,"47"," ","|");
			temp=fillStringCompletor(temp,"62"," ","");
			temp+="UANG TELAH DITERIMA OLEH";
			temp=fillStringCompletor(temp,"95"," ","|");
			var panjangTemp= panjangString(temp);
			//alert(temp+'--'+panjangTemp);
			isiValue+=temp+"\n";
			
			temp= " |";
			temp=fillStringCompletor(temp,"25"," ","|");
			temp=fillStringCompletor(temp,"35"," ","|");
			temp=fillStringCompletor(temp,"47"," ","|");
			temp=fillStringCompletor(temp,"95"," ","|");
			var panjangTemp= panjangString(temp);
			//alert(temp+'--'+panjangTemp);
			isiValue+=temp+"\n";
			
			temp= " |";
			temp=fillStringCompletor(temp,"25","-","|");
			temp=fillStringCompletor(temp,"35","-","|");
			temp=fillStringCompletor(temp,"47","-","|");
			temp=fillStringCompletor(temp,"95"," ","|");
			var panjangTemp= panjangString(temp);
			//alert(temp+'--'+panjangTemp);
			isiValue+=temp+"\n";
			
			temp= " |";
			temp=fillStringCompletor(temp,"3"," ","");
			temp+="<?=$reqParam3?>";
			temp=fillStringCompletor(temp,"25"," ","|");
			temp=fillStringCompletor(temp,"35"," ","|");
			temp=fillStringCompletor(temp,"47"," ","|");
			temp=fillStringCompletor(temp,"74"," ","");
			temp=fillStringCompletor(temp,"95"," ","|");
			var panjangTemp= panjangString(temp);
			//alert(temp+'--'+panjangTemp);
			isiValue+=temp+"\n";
			
			temp= " |";
			temp=fillStringCompletor(temp,"25"," ","|");
			temp=fillStringCompletor(temp,"35"," ","|");
			temp=fillStringCompletor(temp,"47"," ","|");
			temp=fillStringCompletor(temp,"95"," ","|");
			var panjangTemp= panjangString(temp);
			//alert(temp+'--'+panjangTemp);
			isiValue+=temp+"\n";
			
			temp= " |";
			temp=fillStringCompletor(temp,"25","-","|");
			temp=fillStringCompletor(temp,"35","-","|");
			temp=fillStringCompletor(temp,"47","-","|");
			temp=fillStringCompletor(temp,"95"," ","|");
			var panjangTemp= panjangString(temp);
			//alert(temp+'--'+panjangTemp);
			isiValue+=temp+"\n";
			
			temp= " |";
			temp=fillStringCompletor(temp,"3"," ","");
			temp+="<?=$reqParam4?>";
			temp=fillStringCompletor(temp,"25"," ","|");
			temp=fillStringCompletor(temp,"35"," ","|");
			temp=fillStringCompletor(temp,"47"," ","|");
			temp=fillStringCompletor(temp,"62"," ","");
			temp+="------------------------";
			temp=fillStringCompletor(temp,"95"," ","|");
			var panjangTemp= panjangString(temp);
			//alert(temp+'--'+panjangTemp);
			isiValue+=temp+"\n";
			
			temp= " |";
			temp=fillStringCompletor(temp,"25"," ","|");
			temp=fillStringCompletor(temp,"35"," ","|");
			temp=fillStringCompletor(temp,"47"," ","|");
			temp=fillStringCompletor(temp,"70"," ","");
			temp+="Nama Terang";
			temp=fillStringCompletor(temp,"95"," ","|");
			var panjangTemp= panjangString(temp);
			//alert(temp+'--'+panjangTemp);
			isiValue+=temp+"\n";
			
			temp= " |";
			temp=fillStringCompletor(temp,"25","-","|");
			temp=fillStringCompletor(temp,"35","-","|");
			temp=fillStringCompletor(temp,"47","-","|");
			temp=fillStringCompletor(temp,"95","-","|");
			var panjangTemp= panjangString(temp);
			//alert(temp+'--'+panjangTemp);
			isiValue+=temp+"\n";
			
			temp= " |";
			temp=fillStringCompletor(temp,"35"," "," ");
			temp+=" K E T E R A N G A N";
			temp=fillStringCompletor(temp,"95"," ","|");
			var panjangTemp= panjangString(temp);
			//alert(temp+'--'+panjangTemp);
			isiValue+=temp+"\n";
			
			temp= " |";
			temp=fillStringCompletor(temp,"95","-","|");
			var panjangTemp= panjangString(temp);
			//alert(temp+'--'+panjangTemp);
			isiValue+=temp+"\n";
			
			temp= " |";
			temp=fillStringCompletor(temp,"3"," ","");
			temp+="a. Nomor Posting";
			temp=fillStringCompletor(temp,"25"," ",":");
			temp=fillStringCompletor(temp,"58"," ","");
			temp+="c. Paraf Petugas Posting";
			temp=fillStringCompletor(temp,"95"," ","|");
			var panjangTemp= panjangString(temp);
			//alert(temp+'--'+panjangTemp);
			isiValue+=temp+"\n";
			
			temp= " |";
			temp=fillStringCompletor(temp,"58"," ","");
			temp+="   ---------------------";
			temp=fillStringCompletor(temp,"95"," ","|");
			var panjangTemp= panjangString(temp);
			//alert(temp+'--'+panjangTemp);
			isiValue+=temp+"\n";
			
			temp= " |";
			temp=fillStringCompletor(temp,"3"," ","");
			temp+="b. Tanggal Posting";
			temp=fillStringCompletor(temp,"25"," ",":");
			temp=fillStringCompletor(temp,"95"," ","|");
			var panjangTemp= panjangString(temp);
			//alert(temp+'--'+panjangTemp);
			isiValue+=temp+"\n";
			
			temp= " |";
			temp=fillStringCompletor(temp,"95"," ","|");
			var panjangTemp= panjangString(temp);
			//alert(temp+'--'+panjangTemp);
			isiValue+=temp+"\n";
			
			temp= " |";
			temp=fillStringCompletor(temp,"95"," ","|");
			var panjangTemp= panjangString(temp);
			//alert(temp+'--'+panjangTemp);
			isiValue+=temp+"\n";
			
			temp= " |";
			temp=fillStringCompletor(temp,"95"," ","|");
			var panjangTemp= panjangString(temp);
			//alert(temp+'--'+panjangTemp);
			isiValue+=temp+"\n";
			
			temp= " -";
			temp=fillStringCompletor(temp,"95","-","-");
			var panjangTemp= panjangString(temp);
			//alert(temp+'--'+panjangTemp);
			isiValue+=temp+"\n";
			
			temp= " -";
			temp=fillStringCompletor(temp,"95","-","-");
			var panjangTemp= panjangString(temp);
			//alert(temp+'--'+panjangTemp);
			isiValue+=temp+"\n";
			
			<?
				if($panjangArrNoBukti == 1){}
				else
				{
			?>
				if(tempFooter >= 60 && <?=$temp_checkbox_index?> == 1)
				{
				rowPaper=rowHeaderDetil=1;
				isiValue+="\f";
				}
			<?
				}
				
				$tempKondisiNoBukti= $arrData[$checkbox_index]["NO_NOTA"];
			}
			?>
			//alert(isiValue);
			
			qz.Append(isiValue);
			qz.append("\f");
			
			qz.setPaperSize("9.5in", "11.0in");  // US Letter
            qz.setAutoSize(true);
            qz.print(); // send commands to printer
	 }
	 
         // *Note:  monitorPrinting() still works but is too complicated and
         // outdated.  Instead create a JavaScript  function called 
         // "jzebraDonePrinting()" and handle your next steps there.
	 //monitorPrinting();
         
         /**
           *  PHP PRINTING:
           *  // Uses the php `"echo"` function in conjunction with qz-print `"append"` function
           *  // This assumes you have already assigned a value to `"$commands"` with php
           *  qz.append(<?php echo $commands; ?>);
           */
           
         /**
           *  SPECIAL ASCII ENCODING
           *  //qz.setEncoding("UTF-8");
           *  qz.setEncoding("Cp1252"); 
           *  qz.append("\xDA");
           *  qz.append(String.fromCharCode(218));
           *  qz.append(chr(218));
           */
         
      }
	  
	   $(document).ready( function () {
		   $('#btnCetak').live('click', function () {
			   print();
				//newWindow = window.open('jurnal_penerimaan_kas_bank_print.php?reqNoBukti=<?=$reqNoBukti?>&reqPejabat=<?=$reqPejabat?>&reqParam1=<?=$reqParam1?>&reqParam2=<?=$reqParam2?>&reqParam3=<?=$reqParam3?>&reqParam4=<?=$reqParam4?>', 'Cetak');
	//			newWindow.focus();
	//			setTimeout(window.newWindow.close(), 1000);
				//window.newWindow.close();		
		  });  
		});
</script>

<script type="text/javascript" src="../WEB-INF/lib/printModul/jquery-1.7.1.js"></script>
<script type="text/javascript" src="../WEB-INF/lib/printModul/html2canvas.js"></script>
<script type="text/javascript" src="../WEB-INF/lib/printModul/jquery.plugin.html2canvas.js"></script>
</head>

<body>
<input type="button" id="btnCetak" value="Cetak">
<?
$temp_checkbox_index=0;
$tempKondisiNoBukti="";
for($checkbox_index=0;$checkbox_index<count($arrData);$checkbox_index++)
{
?>
<div id="laporan-wrapper" class="dash-bawah">
    <div id="header">
        <div id="laporan-header">
            <div id="laporan-header-atas" class="dash-bawah">
                <div id="laporan-header-kiri">
                    <div><span class="dash-bawah" style="display:inline; padding-bottom:20px;">PT. PELINDO MARINE SERVICE</span></div>
                    <div><br /><br /><br /><span>NO BUKTI : <?=$arrData[$checkbox_index]["NO_NOTA"]?></span></div>
                </div>
                <div id="laporan-header-tengah">
                    <div><br /><br /><span class="dash-bawah" style="display:inline;">BUKTI PENERIMAAN KAS-BANK</span></div>
                    <div><span style="padding-top:7px;">TANGGAL : <?=dateToPageCheck($arrData[$checkbox_index]["TGL_TRANS"])?></span></div>
                </div>
                <div id="laporan-header-kanan">
                    <div id="laporan-pojok" style="text-align:left;">
                        <div id="laporan-pojok-row">
                            <div>TANGGAL PROSES</div>
                            <div>:</div>
                            <div><?=dateToPageCheck($arrData[$checkbox_index]["TGL_TRANS"])?></div>
                        </div>
                        <div id="laporan-pojok-row">
                            <div>HALAMAN</div>
                            <div>:</div>
                            <div>1</div>
                        </div>
                    </div>
                    <div style="position:absolute; bottom:0; right:0;"><span>OPERATOR : <?=date("H:i:s")?><!--18:55:03--></span></div>
                </div>
            </div>
            <div style="float:left; width:100%; border-bottom:1px dashed #000; margin-top:-7px;"></div>
        </div>
    </div>
    
    
    <!--<div id="main" style="position:relative;">--> <!-- FIREFOX OK -->
    <div id="main" style="position:relative;">
    	<div style="clear:both"></div>
        <!--<div style="float:left; margin-top:-8px;" class="dash-keliling">-->
        <div style="float:left; border:0px solid #C66;">
            <!-- URAIAN -->
            <div id="laporan-uraian">
                <div style="float:left; width:100%;"><span>1. Pemegang Kas harap menerimakan uang sebesar : Rp. <?=numberToIna($arrData[$checkbox_index]["JML_RP_TRANS"])?></span></div>
                <div id="laporan-uraian-row">
                    <div><span>2. Terbilang</span></div>
                    <div><span>:</span></div>
                    <div><span><?=terbilang($arrData[$checkbox_index]["JML_RP_TRANS"])?></span></div>
                </div>
                <div id="laporan-uraian-row">
                    <div><span>3. Dari</span></div>
                    <div><span>:</span></div>
                    <div><span><?=$arrData[$checkbox_index]["NM_AGEN_PERUSH"]?></span></div>
                </div>
                <div id="laporan-uraian-row">
                    <div><span>4. Alamat</span></div>
                    <div><span>:</span></div>
                    <div><span><?=$arrData[$checkbox_index]["ALMT_AGEN_PERUSH"]?></span></div>
                </div>
                <div id="laporan-uraian-row">
                    <div><span>5. Uraian</span></div>
                    <div><span>:</span></div>
                    <div><span><?=$arrData[$checkbox_index]["KETERANGAN_UTAMA"]?></span></div>
                </div>
                <div id="laporan-uraian-row">
                    <div><span>6. Bukti Pendukung</span></div>
                    <div><span>:</span></div>
                    <div><span><?=$arrData[$checkbox_index]["BUKTI_PENDUKUNG"]?></span></div>
                    
                    <div style="float:right; margin-top:-14px; padding-bottom:10px;"><span>Tanggal, <?=dateToPageCheck($arrData[$checkbox_index]["TGL_TRANS"])?></span></div>
                </div>
            </div>
        </div>
        <!---->
        
        <div id="laporan-isi-area" class="dash-kiri dash-kanan">
            <div id="laporan-isi-judul" class="dash-bawah dash-atas"><span>KODE DAN NAMA REKENING</span></div>
            
            <div style="clear:both"></div>
            <div style="display: table;">
                <div id="tabel" style="display: table-row;">            
                    <div style="display: table-cell;"><span>&nbsp;NO.</span></div>
                    <div style="display: table-cell;"><span>MUTASI JURNAL :</span></div>
                    <div style="display: table-cell;"><span>&nbsp;</span></div>
                    <div style="display: table-cell;"><span>DEBET</span></div>
                    <div style="display: table-cell;"><span>KREDIT</span></div>
                </div>
            </div>
            
            <div style="display: table;">
                <?
				if($temp_checkbox_index == 1)
				{
					$temp_checkbox_index=0;
					$checkbox_index--;
				}
				
				for($checkbox_index=$checkbox_index;$checkbox_index<count($arrData);$checkbox_index++)
				{
					if($tempKondisiNoBukti == $arrData[$checkbox_index]["NO_NOTA"] || $tempKondisiNoBukti == "")
					{
					$tempNoNota= $arrData[$checkbox_index]["NO_NOTA"];
					$tempTanggalTrans= $arrData[$checkbox_index]["TGL_TRANS"];
					$tempJumlahValTrans= $arrData[$checkbox_index]["JML_VAL_TRANS"];
					$tempJumlahRpTrans= $arrData[$checkbox_index]["JML_RP_TRANS"];
					$tempNamaAgenPerusahaan= $arrData[$checkbox_index]["NM_AGEN_PERUSH"];
					$tempAlamatAgenPerusahaan= $arrData[$checkbox_index]["ALMT_AGEN_PERUSH"];
					$tempKeteranganUtama= $arrData[$checkbox_index]["KETERANGAN_UTAMA"];
					$tempBuktiPendukung= $arrData[$checkbox_index]["BUKTI_PENDUKUNG"];
					$tempNomor= $arrData[$checkbox_index]["NOMOR"];
					$tempKdBukuBesar= $arrData[$checkbox_index]["KD_BUKU_BESAR"];
					$tempKdSubBantu= $arrData[$checkbox_index]["KD_SUB_BANTU"];
					$tempKdBukuPusat= $arrData[$checkbox_index]["KD_BUKU_PUSAT"];
					$tempNamaBukuBesarParent= $arrData[$checkbox_index]["NM_BUKU_BESAR_WITH_PARENT"];
					$tempNamaBukuBesar= $arrData[$checkbox_index]["NM_BUKU_BESAR"];
					$tempNamaSubBantu= $arrData[$checkbox_index]["NM_SUB_BANTU"];
					$tempNamaBukuPusat= $arrData[$checkbox_index]["NM_BUKU_PUSAT"];
					$tempKeteranganDetil= $arrData[$checkbox_index]["KETERANGAN_DETIL"];
					$tempSaldoValDebet= $arrData[$checkbox_index]["SALDO_VAL_DEBET"];
					$tempSaldoValKredit= $arrData[$checkbox_index]["SALDO_VAL_KREDIT"];
					$tempSaldoRpDebet= $arrData[$checkbox_index]["SALDO_RP_DEBET"];
					$tempSaldoRpKredit= $arrData[$checkbox_index]["SALDO_RP_KREDIT"];
					$tempKdValuta= $arrData[$checkbox_index]["KD_VALUTA"];
                ?>
                <div id="tabel" style="display: table-row;">            
                    <div style="display: table-cell;"><span><?=$tempNomor?></span></div>
                    <div style="display: table-cell;"><span><?=$tempKdBukuBesar?> <?=$tempKdSubBantu?> <?=$tempKdBukuPusat?><br /><?=$tempNamaBukuBesar?></span></div>
                    <div style="display: table-cell;"><span>Rp</span></div>
                    <?
                    if($tempSaldoRpDebet == 0)
				    {
					?>
                    <div style="display: table-cell;"><span>&nbsp;</span></div>
                    <div style="display: table-cell;"><span><?=numberToIna($tempSaldoRpKredit)?></span></div>
                    <?
					}
					else
					{
                    ?>
                    <div style="display: table-cell;"><span><?=numberToIna($tempSaldoRpDebet)?></span></div>
                    <div style="display: table-cell;"><span>&nbsp;</span></div>
                    <?
					}
					?>
                </div>
                <?
					}
					else
					{
						$temp_checkbox_index=1;
						break;
					}
					$tempKondisiNoBukti= $arrData[$checkbox_index]["NO_NOTA"];
                }
                ?>
            </div>
            
            <?
			$tempJumlahTransIndex= $checkbox_index;
			if($tempJumlahTransIndex == 0){}
			else
				$tempJumlahTransIndex= $checkbox_index-1;
            ?>
            <div style="display: table;">
            	<div id="tabel" style="display: table-row;">            
                    <div style="display: table-cell;">&nbsp;</div>
                </div>
                <div id="tabel" style="display: table-row;">
                    <div style="display: table-cell; width:358px; text-align:right;"><span>JUMLAH MUTASI</span></div>
                    <div style="display: table-cell; width:50px;"><span>Rp</span></div>
                    <div style="display: table-cell; width:200px;"><span><?=numberToIna($arrData[$tempJumlahTransIndex]["JML_RP_TRANS"])?></span></div>
                    <div style="display: table-cell; width:200px;"><span><?=numberToIna($arrData[$tempJumlahTransIndex]["JML_RP_TRANS"])?></span></div>
                </div>
            </div>
    
        </div>
    </div>
    
    <div id="footer-line" style="border-bottom:1px solid #000;">
        <span style="border-bottom:1px dashed #000; border-left:1px dashed #000; border-right:1px dashed #000;">&nbsp;</span>
    </div>
    <div id="footer">
        <div id="laporan-footer">
            <div id="laporan-periksa" class="dash-kanan dash-kiri dash-bawah">
                <div id="laporan-periksa-kiri">
                    <div id="laporan-diperiksa-row" class="dash-kanan dash-bawah" style="text-align:center;">
                        <span>TELAH DIPERIKSA</span>
                    </div>
                    <div id="laporan-diperiksa-row" class="dash-kanan dash-bawah">
                        <div class="dash-kanan "><span>PEJABAT</span></div>
                        <div class="dash-kanan "><span>PARAF</span></div>
                        <div><span>TANGGAL</span></div>
                    </div>
                    <div id="laporan-diperiksa-row" class="dash-kanan dash-bawah">
                        <div class="dash-kanan"><span>STAFF VALIDASI</span></div>
                        <div class="dash-kanan">&nbsp;</div>
                        <div>&nbsp;</div>
                    </div>
                    <div id="laporan-diperiksa-row" class="dash-kanan ">
                        <div class="dash-kanan "><span><?=$reqParam1?></span></div>
                        <div class="dash-kanan ">&nbsp;</div>
                        <div>&nbsp;</div>
                    </div>
                    <!--<div id="laporan-diperiksa-row" class="dash-kanan dash-bawah">
                        <div class="dash-kanan "><span>ASMAN TREASURY</span></div>
                        <div class="dash-kanan ">&nbsp;</div>
                        <div>&nbsp;</div>
                    </div>
                    <div id="laporan-diperiksa-row" class="dash-kanan dash-bawah">
                        <div class="dash-kanan "><span>&nbsp;</span></div>
                        <div class="dash-kanan "><span>&nbsp;</span></div>
                        <div><span>&nbsp;</span></div>
                    </div>
                    <div id="laporan-diperiksa-row" class="dash-kanan ">
                        <div class="dash-kanan "><span>&nbsp;</span></div>
                        <div class="dash-kanan "><span>&nbsp;</span></div>
                        <div><span>&nbsp;</span></div>
                    </div>-->
                    
                </div>
                <div id="laporan-periksa-kanan">
                    <div id="laporan-periksa-manager" class="">
                        <span>
                        SURABAYA, <?=dateToPageCheck($arrData[$tempJumlahTransIndex]["TGL_TRANS"])?><br />
                        <?=$jabatan?><br /><br /><br /><br /><br /></span>
                        <div><span class="dash-bawah" style="display:inline;"><?=$pejabat?></span></div>
                        <br />
                    </div>
                    <!--<div id="laporan-periksa-penerima">
                        <span>Uang Telah Diterima Oleh :<br /><br /><br /><br /><br /></span>
                        <div><span class="dash-atas" style="display:inline;">Nama Terang</span></div>
                    </div>-->
                </div>
                
                <div style="clear:both;"></div>
            </div>
            
            <div id="laporan-periksa" class="dash-kanan dash-kiri">
            	<div id="laporan-periksa-kiri">
                    <div id="laporan-diperiksa-row" class="dash-kanan dash-bawah">
                        <div class="dash-kanan "><span><?=$reqParam2?></span></div>
                        <div class="dash-kanan ">&nbsp;</div>
                        <div>&nbsp;</div>
                    </div>
                    <div id="laporan-diperiksa-row" class="dash-kanan dash-bawah">
                        <div class="dash-kanan "><span><?=$reqParam3?></span></div>
                        <div class="dash-kanan "><span>&nbsp;</span></div>
                        <div><span>&nbsp;</span></div>
                    </div>
                    <div id="laporan-diperiksa-row" class="dash-kanan ">
                        <div class="dash-kanan "><span><?=$reqParam4?></span></div>
                        <div class="dash-kanan "><span>&nbsp;</span></div>
                        <div><span>&nbsp;</span></div>
                    </div>
                    
                </div>
                <div id="laporan-periksa-kanan">
                    <div id="laporan-periksa-penerima">
                        <span>Uang Telah Diterima Oleh :<br /><br /><br /><br /><br /></span>
                        <div><span class="dash-atas" style="display:inline;">Nama Terang</span></div>
                    </div>
                </div>
                
            </div>
            
            <div style="clear:both;"></div>
            <div id="laporan-keterangan" class=" dash-kiri dash-kanan dash-bawah" style="">
                <div id="laporan-keterangan-judul" class="dash-atas dash-bawah"><span>KETERANGAN</span></div>
                <div id="laporan-keterangan-kiri">
                    <span>
                    a. Nomor Posting : <br /><br />
                    b. Tanggal Posting : <br />
                    </span>
                </div>
                <div id="laporan-keterangan-kanan">
                    <div><span class="dash-bawah" style="display:inline;">c. Paraf Petugas Posting</span></div>
                    <div style="height:100px;"></div>
                </div>
            </div>
            
            
        </div>
    </div>
</div>
<?
	if($panjangArrNoBukti == 1){}
	else
	{
?>
	<br/>
	<div style="clear:both"></div>
<?
	}
	
	$tempKondisiNoBukti= $arrData[$checkbox_index]["NO_NOTA"];
	
	$index_tes++;
}
?>
<applet id="qz" name="QZ Print Plugin" code="qz.PrintApplet.class" width="55" height="55">
  <param name="jnlp_href" value="../WEB-INF/lib/printModul/qz-print_jnlp.jnlp">
      <param name="cache_option" value="plugin">
</applet>
</body>
</html>