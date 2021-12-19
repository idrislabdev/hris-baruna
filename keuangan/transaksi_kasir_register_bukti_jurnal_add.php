<?
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/KbbtJurBb.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/KbbtJurBbD.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/SafrValuta.php");

$kbbt_jur_bb_tmp = new KbbtJurBb();
$kbbt_jur_bb_d_tmp = new KbbtJurBbD();
$safr_valuta = new SafrValuta();

$reqId = httpFilterGet("reqId");
$reqRowId = httpFilterGet("reqRowId");
$reqMode = httpFilterGet("reqMode");
$tempDepartemen = $userLogin->idDepartemen;

if($reqId == "")
{
	$tempKursValuta = 1;
	$tempTahun = date("Y");
	$tempBulan = "";	
	$tempTanggalTransaksi = date("d-m-Y");
	$tempTanggalPosting = date("d-m-Y");
}
else
{
	$kbbt_jur_bb_tmp->selectByParams(array("NO_NOTA"=>$reqId), -1, -1);
	$kbbt_jur_bb_tmp->firstRow();
	
	$tempNoBukti = $kbbt_jur_bb_tmp->getField("NO_NOTA");
	$tempBuktiPendukung = $kbbt_jur_bb_tmp->getField("NO_REF3");
	$tempTanggalTransaksi = dateToPageCheck($kbbt_jur_bb_tmp->getField("TGL_TRANS"));
	$tempPerusahaan = $kbbt_jur_bb_tmp->getField("NM_AGEN_PERUSH");
	$tempAlamat = $kbbt_jur_bb_tmp->getField("ALMT_AGEN_PERUSH");
	$tempValutaNama = $kbbt_jur_bb_tmp->getField("KD_VALUTA");
	$tempKursValuta = numberToIna($kbbt_jur_bb_tmp->getField("KURS_VALUTA"));
	$tempNoFakturPajak = $kbbt_jur_bb_tmp->getField("NO_CEK_NOTA");
	$tempKeteranganJurnal = $kbbt_jur_bb_tmp->getField("KET_TAMBAH");
	$tempNoPosting = $kbbt_jur_bb_tmp->getField("NO_POSTING");
	$tempTanggalPosting = dateToPageCheck($kbbt_jur_bb_tmp->getField("TGL_POSTING"));
	$tempTahun = $kbbt_jur_bb_tmp->getField("THN_BUKU");
	$tempBulan = $kbbt_jur_bb_tmp->getField("BLN_BUKU");
	$tempKusto = $kbbt_jur_bb_tmp->getField("KD_KUSTO");
}
$safr_valuta->selectByParams(array("KD_AKTIF" => "A"));
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	<title>Form Validation - jQuery EasyUI Demo</title>
	<link href="../WEB-INF/lib/easyui/themes/default/easyui.css" rel="stylesheet" type="text/css">
    <link href="../WEB-INF/css/begron.css" rel="stylesheet" type="text/css">
    <link href="../WEB-INF/css/admin.css" rel="stylesheet" type="text/css">
    <link href="../WEB-INF/lib/treeTable/doc/stylesheets/master2.css" rel="stylesheet" type="text/css" />
    <link href="../WEB-INF/lib/treeTable/src/stylesheets/jquery.treeTable.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="js/jquery-1.6.1.min.js"></script>
    <script type="text/javascript" src="../WEB-INF/lib/easyui/jquery.easyui.min.js"></script>    
    <script type="text/javascript" src="../WEB-INF/lib/easyui/kalender.js"></script>
    <script type="text/javascript" src="js/globalfunction.js"></script>
    <script type="text/javascript" src="js/entri_transaksi_kasir_register_bukti_jurnal.js"></script>
    <link rel="stylesheet" href="../WEB-INF/lib/DHTMLWindow/windowfiles/dhtmlwindow.css" type="text/css" />
    <script type="text/javascript" src="../WEB-INF/lib/DHTMLWindow/windowfiles/dhtmlwindow.js"></script>    
	<script type="text/javascript">
		function setValue(){
			$('#reqTanggalTransaksi').datebox('setValue', '<?=$tempTanggalTransaksi?>');	
		}		
		/* KBBT_JUR_BB */
		$(function(){
			$('#ff').form({
				url:'../json-keuangansiuk/transaksi_kasir_register_bukti_jurnal_add.php',
				onSubmit:function(){
					return $(this).form('validate');
				},
				success:function(data){
					//data = data.split("-");					
					alert(data);
					document.location.href = 'transaksi_kasir_register_bukti_jurnal_add.php';
				}
			});
			
		});
		
		$(function(){
			$("#reqNoDokumen").keypress(function(event) { 
			   getData(event);
			});		  
		});			
		
		function OptionSet(id, nama,alamat, npwp, badan_usaha){
		document.getElementById('reqKusto').value = id;
		document.getElementById('reqPerusahaan').value = nama;
		document.getElementById('reqAlamat').value = alamat;
		}	
			
		function OpenDHTMLPopup(opAddress, opCaption, opWidth, opHeight)
		{
			var left = (screen.width/2)-(opWidth/2);
			var top = (screen.height/2)-(opHeight/2) - 100;
			
			//opWidth = iecompattest().clientWidth - 200;
			//opHeight = iecompattest().clientHeight - 40;
			divwin=dhtmlwindow.open('divbox', 'iframe', opAddress, opCaption, 'width='+opWidth+'px,height='+opHeight+'px,left='+left+'px,top='+top+'px,resize=1,scrolling=1,midle=1'); return false;
		}			
	</script>
    
    
</head>
     
</head>
<body onLoad="setValue();">
<div id="begron"><img src="../WEB-INF/images/bg-kanan.jpg" width="100%" height="100%" alt="Smile"></div>
<div id="wadah">

    <div id="judul-halaman">
                <span><img src="../WEB-INF/images/panah-judul.png"> Register Jurnal JKM/JKK</span>
    </div>
    <form id="ff" method="post" novalidate>
    <table style="margin-left:17px;">
    	<thead>
    	<tr>
        	<td colspan="2">
            	<input type="radio" name="reqJurnal" onClick="document.getElementById('reqKodeJurnal').value='JKM'" checked> JKM
                <input name="reqNoJKM" style="width:150px" type="hidden" value="<?=$tempNoJKM?>" />
                &nbsp;&nbsp;&nbsp;
                <input type="radio" name="reqJurnal" onClick="document.getElementById('reqKodeJurnal').value='JKK'"> JKK
                <input name="reqNoJKK" style="width:150px" type="hidden" value="<?=$tempNoJKK?>" />
            </td>
            <td>Valuta</td>
			<td>
                <select name="reqValutaNama" id="reqValutaNama">
                <?
                while($safr_valuta->nextRow())
				{
				?>
                	<option value="<?=$safr_valuta->getField("KODE_VALUTA")?>" <? if($safr_valuta->getField("KODE_VALUTA") == $tempValutaNama) { ?> selected <? } ?>><?=$safr_valuta->getField("KODE_VALUTA")?></option>
                <?
				}
				?>
                </select>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            </td>
        </tr>
        <tr>           
             <td>No Dokumen</td>
			 <td>
				<input name="reqNoDokumen" id="reqNoDokumen" class="easyui-validatebox" style="width:170px" type="text" value="<?=$tempNoDokumen?>" />
                &nbsp;&nbsp;&nbsp
				<input type="hidden" name="reqKodeJurnal" id="reqKodeJurnal" value="JKM">
				<input type="hidden" name="reqNoNota" id="reqNoNota" value="">
				<input type="hidden" name="reqKdSubsis" id="reqKdSubsis" value="">
			</td>
            <td>Kurs&nbsp;Valuta</td>
            <td>
                <input name="reqKursValuta" id="reqKursValuta" class="easyui-validatebox" style="width:50px" type="text" value="<?=$tempKursValuta?>" readonly />
            </td>
        </tr>
        <tr>
        	 <td>Tanggal Transaksi</td>
			 <td>
             	<input id="reqTanggalTransaksi" name="reqTanggalTransaksi" class="easyui-datebox" data-options="validType:'date'" value="<?=$tempTanggalTransaksi?>" />
   			</td>
            <td rowspan="3">Keterangan</td>
            <td rowspan="3">
            	<textarea name="reqKeterangan" cols="50" rows="3" id="reqKeterangan"><?=$tempKeterangan?></textarea>
            </td>
        </tr>
        <tr>           
             <td>Kepada</td>
			 <td>
				<input name="reqPerusahaan" id="reqPerusahaan" class="easyui-validatebox" style="width:295px" type="text" value="<?=$tempPerusahaan?>" onKeyDown="openPopup('PELANGGAN');" />
                &nbsp;&nbsp;&nbsp;&nbsp;
			</td>
        </tr>
        <tr>           
             <td>Alamat Agen Perusahaan</td>
			 <td>
             	<input name="reqAlamat" id="reqAlamat" class="easyui-validatebox" style="width:370px" type="text" value="<?=$tempAlamat?>"  />
			</td>
        </tr>
        <tr>
        	<td>Tanggal Posting</td>
            <td colspan="3"><input id="reqTanggalPosting" name="reqTanggalPosting" class="easyui-datebox" data-options="validType:'date'" value="<?=$tempTanggalPosting?>" /></td>
        </tr>
        <tr>
        	<td colspan="4">
            <div>
                <input type="hidden" name="reqId" value="<?=$reqId?>">
                <input type="hidden" name="reqMode" value="<?=$reqMode?>">
                <input type="submit" id="btnSubmit" value="Register">
            </div>           
            </td>
        </tr>        
        </thead>
    </table>
 
    <table class="example" id="dataTableRowDinamis">
    <!--<table class="example altrowstable" id="alternatecolor" >-->
        <thead class="altrowstable">
          <tr>
              <th style="width:5%">No</th>
              <th style="width:25%">Kd Buku&nbsp;Besar</th>
              <th style="width:25%">Kartu Tambah</th>
              <th style="width:25%">Kd Buku Pusat</th>
              <th style="width:10%">Saldo Debet</th>
              <th style="width:10%">Saldo Kredit</th>
          </tr>
        </thead>
        <tbody class="example altrowstable" id="alternatecolor"> 
          <?
          $i = 1;
          $checkbox_index = 0;
          
          $kbbt_jur_bb_d_tmp->selectByParams(array("NO_NOTA"=>$reqId), -1, -1, "", " ORDER BY NO_SEQ ASC ");
          while($kbbt_jur_bb_d_tmp->nextRow())
          {
          ?>
              <tr id="node-<?=$i?>">
                  <td>
                  	<input type="text" name="reqNoUrut[]" class="easyui-validatebox" value="<?=$i?>" />
                  </td>
                  <td>
                    <input type="text" name="reqBukuBesar[]" class="easyui-validatebox" value="<?=$kbbt_jur_bb_d_tmp->getField("KD_BUKU_BESAR")?>" />
                  </td>
                  <td>
                    <input type="text" name="reqKartu[]" class="easyui-validatebox" value="<?=$kbbt_jur_bb_d_tmp->getField("KD_SUB_BANTU")?>" />
                  </td>
                  <td>
                    <input type="text" name="reqBukuPusat[]" class="easyui-validatebox" value="<?=$kbbt_jur_bb_d_tmp->getField("KD_BUKU_PUSAT")?>" />
                  </td>
                  <td>
                    <input type="text" name="reqDebet[]" id="reqDebet" style="text-align:right;" OnFocus="FormatAngka('reqDebet')" OnKeyUp="FormatUang('reqDebet'); hitungDebetTotal('dataTableRowDinamis');setTimeout(setCheckBalance, 1000);" OnBlur="FormatUang('reqDebet')" value="<?=numberToIna($kbbt_jur_bb_d_tmp->getField('SALDO_VAL_DEBET'))?>">
                  </td>
                  <td>
                    <input type="text" name="reqKredit[]" id="reqKredit" style="text-align:right;" OnFocus="FormatAngka('reqKredit')" OnKeyUp="FormatUang('reqKredit'); hitungKreditTotal('dataTableRowDinamis');setTimeout(setCheckBalance, 1000);" OnBlur="FormatUang('reqKredit')" value="<?=numberToIna($kbbt_jur_bb_d_tmp->getField('SALDO_VAL_KREDIT'))?>">
                  </td>
              </tr>
			  <?
                $i++;
                $checkbox_index++;
                $temp_jml_debet += $kbbt_jur_bb_d_tmp->getField('SALDO_VAL_DEBET');
                $temp_jml_kredit += $kbbt_jur_bb_d_tmp->getField('SALDO_VAL_KREDIT');
              }
              ?>
        </tbody>
        
        <tfoot class="altrowstable">
        	<tr style="background:#f1f4fc">
            	<td colspan="4"></td>
            	<td class=""><input type="text" id="reqJumlahDebet" name="reqJumlahDebet" style="text-align:right;" readonly value="<?=numberToIna($temp_jml_debet)?>" /></td>
            	<td class=""><input type="text" id="reqJumlahKredit" name="reqJumlahKredit" style="text-align:right;" readonly value="<?=numberToIna($temp_jml_kredit)?>" /></td>
            </tr>
        </tfoot>
    </table>        
    </form>
</div>
</body>
</html>