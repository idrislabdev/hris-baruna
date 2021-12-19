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

$statement= " AND A.NO_NOTA IN ('".$reqNoBukti."')";

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
<html>
   <!-- License:  LGPL 2.1 or QZ INDUSTRIES SOURCE CODE LICENSE -->
   <head><title>QZ Print Plugin</title>  
   <script type="text/javascript" src="../WEB-INF/lib/printModul/printFungsi.js"></script>  
   <script type="text/javascript">
       function print() {
         if (qz != null) {
            // Searches for default printer
            qz.findPrinter();
         }
         if (qz != null) {
            
			var header=headerDetil=isiValue="";
			var rowHeader=rowHeaderDetil=rowPaper=1;
			// buat header
			header="   PT. PELINDO MARINE SERVICE                           REPORT ID.    : KBB_BKT_JKK_ENTRY.PR\n";rowHeader++;
			header+="   ------------------------                             TGL.PROSES    : <?=dateToPageCheck($arrData[0]["TGL_TRANS"])?>\n";rowHeader++;
			header+="                                                        HALAMAN       : "+rowPaper+"\n";rowHeader++;
			header+="                             BUKTI PENERIMAAN KAS-BANK\n";rowHeader++;
			header+="                            =============================\n";rowHeader++;
			header+="   NO SIUK  : <?=$reqNoBukti?>                                         TANGGAL  : <?=dateToPageCheck($arrData[0]["TGL_TRANS"])?>\n";rowHeader++;
			header+=" |==========================================================================================   |\n";rowHeader++;
			headerDetil=generateZero(" | 1. Pemegang Kas Harap membayarkan uang sebesar        :Rp. <?=numberToIna($arrData[0]["JML_RP_TRANS"])?>","96"," ","|")+"\n";rowHeaderDetil++;
			var result = splitIntoLines('   2. Terbilang        : <?=terbilang($arrData[0]["JML_RP_TRANS"])." Rupiah"?>  ', 48);
			for (var i = 0; i < result.length; i++)
			{
				if(i == 0)
					headerDetil+=result[i]+"\n";
				else
					headerDetil+="                         "+result[i]+"\n";
				
				rowHeaderDetil++;
			}
			headerDetil+=generateZero(" | 3. Kepada           : <?=$arrData[0]["NM_AGEN_PERUSH"]?>","96"," ","|")+"\n";rowHeaderDetil++;
			headerDetil+=generateZero(" | 4. Alamat           : <?=$arrData[0]["ALMT_AGEN_PERUSH"]?>","96"," ","|")+"\n";rowHeaderDetil++;
			var result = splitIntoLines('   5. Uraian           : <?=$arrData[0]["KETERANGAN_UTAMA"]?>', 48);
			for (var i = 0; i < result.length; i++)
			{
				if(i == 0)
					headerDetil+=result[i]+"\n";
				else
					headerDetil+="                         "+result[i]+"\n";
				
				rowHeaderDetil++;
			}
			headerDetil+=generateZero(" | 6. Bukti Pendukung  : <?=$arrData[0]["BUKTI_PENDUKUNG"]?>                        Tanggal, <?=dateToPageCheck($arrData[0]["TGL_TRANS"])?>","96"," ","|")+"\n";rowHeaderDetil++;
			headerDetil+=" |------------------------------------------------------------------------------------------   |\n";rowHeaderDetil++;
			headerDetil+=" |                                   KODE DAN NAMA REKENING                                    |\n";rowHeaderDetil++;
			headerDetil+="  ------------------------------------------------------------------------------------------\n";rowHeaderDetil++;
			headerDetil+="   NO. MUTASI JURNAL                                                 DEBET               KREDIT\n";rowHeaderDetil++;

			rowPaper= rowHeader+rowHeaderDetil;
			isiValue= header+headerDetil;
			
			//buat isi detil
			//NO_NOTA, TGL_TRANS, JML_VAL_TRANS, JML_RP_TRANS, NM_AGEN_PERUSH, ALMT_AGEN_PERUSH, KETERANGAN_UTAMA, 
			//BUKTI_PENDUKUNG, NOMOR, KD_BUKU_BESAR, KD_SUB_BANTU, KD_BUKU_PUSAT, NM_BUKU_BESAR_WITH_PARENT,
			//NM_BUKU_BESAR, NM_SUB_BANTU, NM_BUKU_PUSAT,
			//KETERANGAN_DETIL, SALDO_VAL_DEBET, SALDO_VAL_KREDIT, SALDO_RP_DEBET, SALDO_RP_KREDIT, KD_VALUTA
			<?
			for($checkbox_index=0;$checkbox_index<count($arrData);$checkbox_index++)
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
				
				if($tempSaldoRpDebet == 0)
				{
			?>
				if(rowPaper == 60)
				{
					rowPaper=1;
					isiValue+="\f";
					isiValue+= header;
				}
				
				isiValue+="   <?=$tempNomor?> <?=$tempKdBukuBesar?>   <?=$tempKdSubBantu?>   <?=$tempKdBukuPusat?>              Rp                                 <?=numberToIna($arrData[0]["SALDO_RP_KREDIT"])?>\n";				
			<?
				}
				else
				{
			?>	
				isiValue+="   <?=$tempNomor?> <?=$tempKdBukuBesar?>   <?=$tempKdSubBantu?>   <?=$tempKdBukuPusat?>              Rp                <?=numberToIna($arrData[0]["SALDO_RP_DEBET"])?>\n";
			<?
				}
			?>
				rowPaper++;
				
				var result = splitIntoLines('<?=$tempNamaBukuBesar?>', 48);
				var str = "";
				for (var i = 0; i < result.length; i++)
				{
					if(rowPaper == 60)
					{
						rowPaper=1;
						isiValue+="\f";
						isiValue+= header;
					}
					
					isiValue+="       "+result[i]+"  \n"; 
					rowPaper++;
				}

				
			<?
			}
			?>
			
			isiValue+=" |                                                                                             |\n"; 
			isiValue+=" |                           JUMLAH MUTASI  :     Rp            <?=numberToIna($arrData[0]["JML_RP_TRANS"])?>           <?=numberToIna($arrData[0]["JML_RP_TRANS"])?>|\n"; 
			isiValue+=" |------------------------------------------------------------------------------------------   |\n"; 
			isiValue+=" |                   TELAH DIPERIKSA           |                  SURABAYA, <?=dateToPageCheck($arrData[0]["TGL_TRANS"])?>         |\n"; 
			isiValue+=" |----------------------------------||---------|                                               |\n"; 
			isiValue+=" |     PEJABAT         ||  PARAF    | TANGGAL  |                     DIREKTUR UTAMA            |\n"; 
			isiValue+=" |---------------------||-----------||---------|                                               |\n"; 
			isiValue+=" |                     ||           |          |                                               |\n"; 
			isiValue+=" | STAFF VALIDASI      ||           |          |                                               |\n"; 
			isiValue+=" |---------------------||-----------||---------|                                               |\n"; 
			isiValue+=" | <?=$reqParam1?>         ||           |          |                  <?=$reqPejabat?>         |\n"; 
			isiValue+=" |                     ||           |          |               --------------------------      |\n"; 
			isiValue+=" |---------------------|---------------------------------------Uang Telah Diterima Oleh :---   |\n"; 
			isiValue+=" | <?=$reqParam2?>                                                                             |\n"; 
			isiValue+=" |                                                                                             |\n"; 
			isiValue+=" |---------------------------------------------                                                |\n"; 
			isiValue+=" | <?=$reqParam3?>                                                                             |\n";
			isiValue+=" |---------------------------------------------                                                |\n";
			isiValue+=" |                                                                                             |\n"; 
			isiValue+=" | <?=$reqParam4?>                                                                             |\n";  
			isiValue+=" |                                                            ---------Nama Terang--------     |\n"; 
			isiValue+=" |------------------------------------------------------------------------------------------   |\n"; 
			isiValue+="                                       K E T E R A N G A N\n"; 
			isiValue+="  ------------------------------------------------------------------------------------------\n"; 
			isiValue+="   a. Nomor Posting     :                                    c. Paraf Petugas Posting\n"; 
			isiValue+="                                                                -------------------\n"; 
			isiValue+="   b. Tanggal Posting   :\n"; 
			isiValue+="  ==========================================================================================\n";
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
	  
	  function tes()
	  {
		  alert('s');
	  }
	  
	  function setPrint()
	  {
		  alert('s');
		  //setInterval("print()",1000);
		  //setTimeout(tes(), 1000);
	  }
   </script>
   <script type="text/javascript" src="../WEB-INF/lib/printModul/jquery-1.7.1.js"></script>
   <script type="text/javascript" src="../WEB-INF/lib/printModul/html2canvas.js"></script>
   <script type="text/javascript" src="../WEB-INF/lib/printModul/jquery.plugin.html2canvas.js"></script>
   </head>
   <body id="content" bgcolor="#FFF380" onLoad="setPrint();">
   <h1 id="title">QZ Print Plugin</h1><br />
   <table border="1px" cellpadding="5px" cellspacing="0px"><tr>
   
   <td valign="top"><h2>All Printers</h2>
   <input type=button onClick="findPrinter()" value="Detect Printer"><br />
   <input type=button onClick="findPrinters()" value="List All Printers"><br />
   <input type=button onClick="useDefaultPrinter()" value="Use Default Printer"><br /><br />
   <applet id="qz" name="QZ Print Plugin" code="qz.PrintApplet.class" width="55" height="55">
	  <param name="jnlp_href" value="../WEB-INF/lib/printModul/qz-print_jnlp.jnlp">
          <param name="cache_option" value="plugin">
   </applet><br />
   
   </td><td valign="top"><h2>Raw Printers Only</h2>
   <a href="http://code.google.com/p/jzebra/wiki/WhatIsRawPrinting" target="new">What is Raw Printing?</a><br />
   <input type=button onClick="print()" value="Print" /><br />     
   <input type=button onClick="print64()" value="Print Base64" /><br />
   <input type=button onClick="printPages()" value="Print Spooling Every 2" /><br />
   <input type=button onClick="printXML()" value="Print XML" /><br />
   <input type=button onClick="printHex()" value="Print Hex" /><br />
   Print File:<br />
      <input type=button onClick="printFile('coba.txt')" value="ZPL" />&nbsp;
	  <input type=button onClick="printFile('fgl_sample.txt')" value="FGL" />&nbsp;
	  <input type=button onClick="printFile('epl_sample.txt')" value="EPL" /><br />    
   <input type=button onClick="printESCPImage()" value="Print ESC/POS Image" /><br />	  
   <input type=button onClick="printZPLImage()" value="Print ZPL Image" /><br />
   <input type=button onClick="printToFile()" value="Print To File" /><br />
   <input type=button onClick="printToHost()" value="Print To Host" /><br />
   <input type=button onClick="useAlternatePrinting()" value="Use Alternate Printing" /><br />
   
   </td><td valign="top"><h2>PostScript Printers Only</h2>
   <a href="http://code.google.com/p/jzebra/wiki/WhatIsPostScriptPrinting" target="new">What is PostScript Printing?</a><br />
   <input type=button onClick="printHTML()" value="Print HTML" /><br />
   <input type=button onClick="printPDFFile()" value="Print PDF" /><br />
   <input type=button onClick="printImage(false)" value="Print PostScript Image" /><br />
   <input type=button onClick="printImage(true)" value="Print Scaled PostScript Image" /><br />
   <input type=button onClick="printPage()" value="Print Current Page" /><br />
   <input type=button onClick="logFeatures()" value="Log Printer Features on Print" /><br />
   
   </td><td valign="top"><h2>Serial</h2>
   <input type=button id="list_ports" onClick="listSerialPorts()" value="List Serial Ports" /><br />
   <input type=text id="port_name" size="8" />
   <input type=button id="open_port"  onClick="openSerialPort()" value="Open Port" /><br />
   <input type=button id="send_data" onClick="sendSerialData()" value="Send Port Cmd" /><br />
   <input type=button id="close_port"  onClick="closeSerialPort()" value="Close Port" /><br />
   <hr /><h2>Misc</h2>
   <input type=button onClick="allowMultiple()" value="Allow Multiple Applets" /><br /></td></tr></table>
   </body><canvas id="hidden_screenshot" style="display:none;" />
</html>