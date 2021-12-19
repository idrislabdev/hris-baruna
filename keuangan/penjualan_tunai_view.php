<?
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/KpttNota.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/SafrValuta.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/KpttNotaD.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/KbbrTipeTransD.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/KbbrGeneralRefD.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/KbbrRuleModul.php");

$kptt_nota = new KpttNota();
$safr_valuta = new SafrValuta();
$kptt_nota_d = new KpttNotaD();
$kbbr_tipe_trans_d = new KbbrTipeTransD();
$kbbr_general_ref_d = new KbbrGeneralRefD();
$kbbr_rule_modul = new KbbrRuleModul();

$reqId = httpFilterGet("reqId");
$reqMode = httpFilterGet("reqMode");

if($reqId == "")
{
	$reqMode = "insert";	
	$tempKursValuta = 1;
	$tempTahun = date("Y");
	$tempBulan = "";
	$tempPersenPajak = $kbbr_general_ref_d->getSetting(array("ID_REF_FILE" => "JKK_NOTA", "ID_REF_DATA" => "POT1"));
	$tempTanggalTransaksi = date("d-m-Y");
	$tempMaterai = 0;
}
else
{
	$reqMode = "update";	
	$kptt_nota->selectByParams(array("A.NO_NOTA"=>$reqId), -1, -1);
	$kptt_nota->firstRow();
	
	$tempNoBukti = $kptt_nota->getField("NO_NOTA");
	$tempNoNota = $kptt_nota->getField("NO_REF3");
	$tempNoBuktiLain = $kptt_nota->getField("NO_REF1");
	//$tempNoBukuBesarKas = $kptt_nota->getField("KD_BANK");
	//$tempBukuBesarKas = $kptt_nota->getField("BANK");
	$tempNoPelanggan = $kptt_nota->getField("KD_KUSTO");
	$tempKeterangan = $kptt_nota->getField("KET_TAMBAHAN");
	$tempPelanggan = $kptt_nota->getField("MPLG_NAMA");
	$tempAlamat = $kptt_nota->getField("MPLG_ALAMAT");
	$tempNPWP = $kptt_nota->getField("MPLG_NPWP");
	$tempPersenPajak = $kptt_nota->getField("PPN1_PERSEN");
	$tempTanggalTransaksi = dateToPageCheck($kptt_nota->getField("TGL_TRANS"));
	$tempTahun = $kptt_nota->getField("THN_BUKU");
	$tempBulan = $kptt_nota->getField("BLN_BUKU");
	$tempValutaNama = $kptt_nota->getField("KD_VALUTA");
	$tempMaterai = $kptt_nota->getField("METERAI");
	$tempBadanUsaha = $kptt_nota->getField("BADAN_USAHA");
	$tempKursValuta = numberToIna($kptt_nota->getField("KURS_VALUTA"));
	$tempJumlahDiBayar = $kptt_nota->getField("JUMLAH");
	
}

$safr_valuta->selectByParams(array("KD_AKTIF" => "A"));

$kbbr_tipe_trans_d->selectByParams(array("TIPE_TRANS" => "JKM-KPT-03", "KD_AKTIF" => "A"));
while($kbbr_tipe_trans_d->nextRow())
{
	$arrTipeTrans["KLAS_TRANS"][] = $kbbr_tipe_trans_d->getField("KLAS_TRANS");
	$arrTipeTrans["KETK_TRANS"][] = $kbbr_tipe_trans_d->getField("KETK_TRANS");		
}

$ppn_materai = $kbbr_rule_modul->getStatus(array("KD_RULE" => "PPNMETERAI"));

$disabled="disabled";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	<title>penjualan tunai view</title>
	<link href="../WEB-INF/lib/easyui/themes/default/easyui.css" rel="stylesheet" type="text/css">
    <link href="../WEB-INF/css/begron.css" rel="stylesheet" type="text/css">
    <link href="../WEB-INF/css/admin.css" rel="stylesheet" type="text/css">
    <link href="../WEB-INF/lib/treeTable/doc/stylesheets/master2.css" rel="stylesheet" type="text/css" />
    <link href="../WEB-INF/lib/treeTable/src/stylesheets/jquery.treeTable.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="js/jquery-1.6.1.min.js"></script>
    <script type="text/javascript" src="../WEB-INF/lib/easyui/jquery.easyui.min.js"></script>    
    <script type="text/javascript" src="../WEB-INF/lib/easyui/kalender.js"></script>
    <script type="text/javascript" src="js/globalfunction.js"></script>
    <script type="text/javascript" src="js/entri_tabel_nota.js"></script>
    <link rel="stylesheet" href="../WEB-INF/lib/DHTMLWindow/windowfiles/dhtmlwindow.css" type="text/css" />
    <script type="text/javascript" src="../WEB-INF/lib/DHTMLWindow/windowfiles/dhtmlwindow.js"></script>    
	<script type="text/javascript">
		function setValue(){
			$('#reqTanggalTransaksi').datebox('setValue', '<?=$tempTanggalTransaksi?>');	
		}		
		/* KBBT_JUR_BB */
		$(function(){
			$('#ff').form({
				url:'../json-keuangansiuk/penjualan_tunai_add.php',
				onSubmit:function(){
					return $(this).form('validate');
				},
				success:function(data){
					data = data.split("-");					
					$.messager.alert('Info', data[1], 'info');	
					//document.location.href = 'penjualan_tunai_add.php?reqId='+data[0];
					//top.frames['mainFrame'].location.reload();
				}
			});
			
		});
		
		$(function(){
		$("#reqValutaNama").change(function() { 
		
		   if($("#reqValutaNama").val() == "IDR")
				$("#reqKursValuta").val('1');
		   else
		   {
			  $.getJSON("../json-keuangansiuk/get_valuta_kurs_json.php?reqValutaKursId="+$("#reqValutaNama").val()+ "&reqTanggalTransaksi="+$('#reqTanggalTransaksi').datebox('getValue'),
			  function(data){
				$("#reqKursValuta").val(data.NILAI_RATE);
			  });
		   }
		});		  
		});	
		
		function openPopup(tipe)
		{
		
		var isCtrl = false;$('#reqNoPelanggan').keyup(function (e) {
			if(e.which == 120)
			{
				if(tipe == "PELANGGAN")
				{					
					OpenDHTMLPopup('pelanggan_pencarian.php', 'Pencarian Pelanggan', 950, 600);
				}
				return false;
			}
		});
		
		}
		function OptionSet(id, nama,alamat, npwp, badan_usaha){
		document.getElementById('reqNoPelanggan').value = id;
		document.getElementById('reqPelanggan').value = nama;
		document.getElementById('reqAlamat').value = alamat;
		document.getElementById('reqNPWP').value = npwp;
		document.getElementById('reqBadanUsaha').value = badan_usaha;
		}	
			
		function OpenDHTMLPopup(opAddress, opCaption, opWidth, opHeight)
		{
			var left = (screen.width/2)-(opWidth/2);
			var top = (screen.height/2)-(opHeight/2) - 100;
			
			divwin=dhtmlwindow.open('divbox', 'iframe', opAddress, opCaption, 'width='+opWidth+'px,height='+opHeight+'px,left='+left+'px,top='+top+'px,resize=1,scrolling=1,midle=1'); return false;
		}		

	</script>
    
    
</head>
     
</head>
<body onLoad="setValue();">
<div id="begron"><img src="../WEB-INF/images/bg-kanan.jpg" width="100%" height="100%" alt="Smile"></div>
<div id="wadah">

    <div id="judul-halaman">
                <span><img src="../WEB-INF/images/panah-judul.png"> Tambah Data Penjualan Tunai (JKM)</span>
    </div>
    <form id="ff" method="post" novalidate>
    <table style="margin-left:17px;">
    	<thead>
    	<tr>
        	<td colspan="4" align="right">
            No Bukti JKM
            &nbsp;&nbsp;&nbsp;
            <input name="reqNoBukti" class="easyui-validatebox" style="width:170px" type="text" <?=$disabled?> value="<?=$tempNoBukti?>" />
            </td>
        </tr>
        <tr>           
             <td>No Nota</td>
			 <td>
				<input name="reqNoNota" id="reqNoNota" class="easyui-validatebox" type="text" <?=$disabled?> style="width:149px;" value="<?=$tempNoNota?>" onKeyUp="document.getElementById('reqNoBuktiLain').value = document.getElementById('reqNoNota').value" />
                &nbsp;&nbsp;
            	No Bukti Lain
				<input name="reqNoBuktiLain" id="reqNoBuktiLain" class="easyui-validatebox" type="text" <?=$disabled?> style="width:149px;" value="<?=$tempNoBuktiLain?>" />
			</td>
            <td>B. Besar Kas</td>
			 <td>
				<input name="reqNoBukuBesarKas" id="reqNoBukuBesarKas" class="easyui-validatebox" style="width:70px" type="text" <?=$disabled?> value="<?=$tempNoBukuBesarKas?>" />
                <input name="reqBukuBesarKas" id="reqBukuBesarKas" class="easyui-validatebox" style="width:320px" type="text" <?=$disabled?> value="<?=$tempBukuBesarKas?>" />
			</td>
        </tr>
        <tr>           
             <td>Pelanggan</td>
			 <td>
				<input name="reqNoPelanggan" id="reqNoPelanggan" class="easyui-validatebox" style="width:50px" type="text" <?=$disabled?> value="<?=$tempNoPelanggan?>" onKeyDown="openPopup('PELANGGAN');" />                
				<input name="reqPelanggan" id="reqPelanggan" class="easyui-validatebox" style="width:350px" type="text" <?=$disabled?> value="<?=$tempPelanggan?>" />
			</td>
            <td rowspan="4" valign="top">Keterangan</td>
            <td rowspan="4">
            	<textarea name="reqKeterangan" rows="5" cols="48" <?=$disabled?> ><?=$tempKeterangan?></textarea>
            </td>
        </tr>
        <tr>           
             <td>Alamat</td>
			 <td>
             	<input name="reqAlamat" id="reqAlamat" class="easyui-validatebox" style="width:415px" type="text" <?=$disabled?> value="<?=$tempAlamat?>" />
                <input name="reqBadanUsaha" id="reqBadanUsaha" type="hidden" value="<?=$tempBadanUsaha?>">
			</td>
        </tr>
        <tr>           
             <td>NPWP</td>
			 <td>
				<input name="reqNPWP" id="reqNPWP" class="easyui-validatebox" style="width:308px" type="text" <?=$disabled?> value="<?=$tempNPWP?>" />
                &nbsp;&nbsp;
                %Pajak
                <input name="reqPersenPajak" id="reqPersenPajak" class="easyui-numberbox" maxlength="3" style="width:30px" type="text" <?=$disabled?> value="<?=$tempPersenPajak?>" />
			</td>
        </tr>
        <tr>
        	<td>Tanggal Transaksi</td>
			 <td>
             	<input id="reqTanggalTransaksi" name="reqTanggalTransaksi" class="easyui-datebox" data-options="validType:'date'" <?=$disabled?> value="<?=$tempTanggalTransaksi?>" />
                &nbsp;&nbsp;
                Tahun Buku
                <input id="reqTahun" name="reqTahun" class="easyui-validatebox" data-options="validType:'minLength[4]'" <?=$disabled?> maxlength="4" style="width:60px" value="<?=$tempTahun?>" />
                <input id="reqBulan" name="reqBulan" class="easyui-validatebox" data-options="validType:'minLength[2]'" <?=$disabled?> maxlength="2" style="width:20px" value="<?=$tempBulan?>" />
			</td>
        </tr>
        <tr>
            <td>Valuta</td>
			<td>
            	<select name="reqValutaNama" id="reqValutaNama" <?=$disabled?>>
                <?
                while($safr_valuta->nextRow())
				{
				?>
                	<option value="<?=$safr_valuta->getField("KODE_VALUTA")?>" <? if($safr_valuta->getField("KODE_VALUTA") == $tempValutaNama) { ?> selected <? } ?>><?=$safr_valuta->getField("KODE_VALUTA")?></option>
                <?
				}
				?>
                </select>
                &nbsp;&nbsp;
                Kurs
                <input name="reqKursValuta" id="reqKursValuta" class="easyui-validatebox" style="width:74px" type="text" <?=$disabled?> value="<?=$tempKursValuta?>" />
                &nbsp;&nbsp;
                Materai
               <select name="reqMateraiPilih" id="reqMateraiPilih" <?=$disabled?>>
            	<option value="1" <? if($tempMaterai >= 0) echo "selected";?>>Ya</option>
                <option value="0" <? if($tempMaterai == "") "selected";?>>Tidak</option>
           		</select>
                <input name="reqMaterai" id="reqMaterai" class="easyui-validatebox" style="width:74px" type="text" <?=$disabled?> value="<?=$tempMaterai?>" />
			</td>
            <td>Jumlah Di bayar</td>
            <td>
            	<input id="reqJumlahDiBayar" name="reqJumlahDiBayar" class="easyui-validatebox" style="width:140px" <?=$disabled?> OnFocus="FormatAngka('reqJumlahDiBayar')" OnKeyUp="FormatUang('reqJumlahDiBayar')" OnBlur="FormatUang('reqJumlahDiBayar')" value="<?=numberToIna($tempJumlahDiBayar)?>" />
		    </td>
        </tr>
        <tr>
        	<td colspan="4">
            <div>
                <input type="hidden" name="reqId" value="<?=$reqId?>">
                <input type="hidden" name="reqMode" value="<?=$reqMode?>">
                <input type="hidden" name="reqPpnMaterai" id="reqPpnMaterai" value="<?=$ppn_materai?>">
                <?
                if($reqMode == "update")
				{
				?>
                <input type="button" value="Rincian Jurnal" onClick="OpenDHTMLPopup('penjualan_tunai_add_jurnal.php?reqId=<?=$reqId?>', 'Rincian Jurnal', 900, 600)">
            	<?
				}
				?>
            </div>           
            </td>
        </tr>
        </thead>
    </table>
 
    <table class="example" id="dataTableRowDinamis">
    <!--<table class="example altrowstable" id="alternatecolor" >-->
        <thead class="altrowstable">
          <tr>
              <th style="width:5%">
                No
              </th>
              <th>Jenis Jasa</th>
              <th>Pajak?</th>
              <th>Lbr(Pas)</th>
              <th>Nilai Jasa</th>
              <th>Nilai Pajak</th>
              <th>Jumlah</th>
              <th>Aksi</th>
          </tr>
        </thead>
        <tbody class="example altrowstable" id="alternatecolor"> 
			  <?
              $i = 1;
              $checkbox_index = 0;
              
              $kptt_nota_d->selectByParams(array("NO_NOTA"=>$reqId), -1, -1, "", " ORDER BY LINE_SEQ ASC ");
              while($kptt_nota_d->nextRow())
              {
              ?>
              <tr id="node-<?=$i?>">
                  <td>
                  	<input type="text" name="reqNoUrut[]" class="easyui-validatebox" value="<?=$i?>" <?=$disabled?> />
                  </td>
                  <td>
                    <select name="reqKlasTrans[]" id="reqKlasTrans<?=$checkbox_index?>" onChange="ambilReferensiKlasTrans('<?=$checkbox_index?>')" <?=$disabled?>>
                    <?
                    for($j=0;$j<count($arrTipeTrans["KLAS_TRANS"]);$j++)
                    {
                    ?>
                        <option value="<?=$arrTipeTrans["KLAS_TRANS"][$j]?>" <? if($kptt_nota_d->getField("KLAS_TRANS") == $arrTipeTrans["KLAS_TRANS"][$j]) { ?> selected <? } ?>><?=$arrTipeTrans["KETK_TRANS"][$j]?></option>
                    <?
                    }
                    ?>
                    </select>
                  </td>
                  <td>
                    <input type="text" name="reqPajak[]" id="reqPajak<?=$checkbox_index?>" <?=$disabled?> class="easyui-validatebox" value="<?=$kptt_nota_d->getField("STATUS_KENA_PAJAK")?>" />
                  </td>
                  <td>
                    <input type="text" name="reqLbr[]" class="easyui-validatebox" <?=$disabled?> value="" />
                  </td>
                  <td>
                    <input type="text" name="reqNilaiJasa[]" <?=$disabled?> style="text-align:right;" id="reqNilaiJasa<?=$checkbox_index?>"  OnFocus="FormatAngka('reqNilaiJasa<?=$checkbox_index?>')" OnKeyUp="FormatUang('reqNilaiJasa<?=$checkbox_index?>'); hitungSemua('<?=$checkbox_index?>');" OnBlur="FormatUang('reqNilaiJasa<?=$checkbox_index?>')" value="<?=numberToIna($kptt_nota_d->getField('JML_VAL_TRANS'))?>">
                  </td>
                  <td>
                    <input type="text" name="reqNilaiPajak[]" <?=$disabled?> style="text-align:right;" id="reqNilaiPajak<?=$checkbox_index?>" <?=$disabled?> OnFocus="FormatAngka('reqNilaiPajak<?=$checkbox_index?>')" OnKeyUp="FormatUang('reqNilaiPajak<?=$checkbox_index?>')" OnBlur="FormatUang('reqNilaiPajak<?=$checkbox_index?>')" value="<?=numberToIna($kptt_nota_d->getField('JML_VAL_PAJAK'))?>">
                  </td>
                  <td>
                    <input type="text" name="reqJumlah[]" <?=$disabled?> style="text-align:right;" id="reqJumlah<?=$checkbox_index?>" OnFocus="FormatAngka('reqJumlah<?=$checkbox_index?>')" OnKeyUp="FormatUang('reqJumlah<?=$checkbox_index?>')" OnBlur="FormatUang('reqJumlah<?=$checkbox_index?>')" value="<?=numberToIna($kptt_nota_d->getField('JUMLAH_TOTAL'))?>">
                  </td>
                  <td align="center">
                  <label>
                  <input type="hidden" name="reqKdBukuBesar[]" id="reqKdBukuBesar<?=$checkbox_index?>" value="<?=$kptt_nota_d->getField("KD_BUKU_BESAR")?>"><input type="hidden" name="reqDK[]" id="reqDK<?=$checkbox_index?>" value="<?=$kptt_nota_d->getField("KD_D_K")?>">
                  </label>
                  </td>
              </tr>
			  <?
                $i++;
                $checkbox_index++;
                $temp_jml_trans += $kptt_nota_d->getField('JML_VAL_TRANS');
                $temp_jml_pajak += $kptt_nota_d->getField('JML_VAL_PAJAK');
              }
              ?>
        </tbody>
        
        <tfoot class="altrowstable">
        	<tr style="background:#f1f4fc">
            	<td colspan="4">&nbsp;</td>
            	<td><input type="text" id="reqJumlahTrans" name="reqJumlahTrans" style="text-align:right;" <?=$disabled?> value="<?=numberToIna($temp_jml_trans)?>" /></td>
            	<td class=""><input type="text" id="reqJumlahPajak" name="reqJumlahPajak" style="text-align:right;" <?=$disabled?> value="<?=numberToIna($temp_jml_pajak)?>" /></td>
            	<td class=""></td>
            	<td>&nbsp;</td>
            </tr>
        </tfoot>
    </table>        
    </form>
</div>
</body>
</html>