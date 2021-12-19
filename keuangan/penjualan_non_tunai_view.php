<?
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/KpttNota.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/SafrValuta.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/KpttNotaD.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/KbbrTipeTrans.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/KbbrTipeTransD.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/KbbrGeneralRefD.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/KbbrRuleModul.php");

$kptt_nota = new KpttNota();
$safr_valuta = new SafrValuta();
$kptt_nota_d = new KpttNotaD();
$kbbr_tipe_trans = new KbbrTipeTrans();
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
	$tempTanggalTransaksi = date("d-m-Y");
	$tempMaterai = 0;
}
else
{
	$reqMode = "update";	
	$kptt_nota->selectByParams(array("A.NO_NOTA"=>$reqId), -1, -1);
	$kptt_nota->firstRow();
	
	$tempMaterai = $kptt_nota->getField("METERAI");
	$tempMateraiPilih = $kptt_nota->getField("METERAI_PILIH");		
	$tempNoPPKB = $kptt_nota->getField("NO_REF3");
	$tempTipeTrans = $kptt_nota->getField("TIPE_TRANS");
	$tempSegmen = $kptt_nota->getField("TIPE_TRANS");
	$tempTanggalValuta = dateToPageCheck($kptt_nota->getField("TGL_VALUTA"));
	$tempNoBukti = $kptt_nota->getField("NO_NOTA");
	$tempNoRef = $kptt_nota->getField("NO_REF1");
	$tempNoRefLain = $kptt_nota->getField("NO_REF2");
	$tempKodeKapal = $kptt_nota->getField("");
	$tempKapal = $kptt_nota->getField("");
	$tempNoPelanggan = $kptt_nota->getField("KD_KUSTO");
	$tempPelanggan = $kptt_nota->getField("MPLG_NAMA");
	$tempKodeBank = $kptt_nota->getField("KD_BANK");
	$tempBank = $kptt_nota->getField("REK_BANK");
	$tempBadanUsaha = $kptt_nota->getField("BADAN_USAHA");
	$tempTanggalTransaksi = dateToPageCheck($kptt_nota->getField("TGL_TRANS"));
	$tempTanggalValutaPajak = dateToPageCheck($kptt_nota->getField("TGL_VAL_PAJAK"));
	//$tempPersenPajak = $kptt_nota->getField("PPN1_PERSEN");
	$tempJumlahTagihan = $kptt_nota->getField("JML_TAGIHAN");
	$tempJumlahUpper = $kptt_nota->getField("JML_WD_UPPER");
	$tempKursValuta = numberToIna($kptt_nota->getField("KURS_VALUTA"));
	$tempKursPajak = $kptt_nota->getField("KURS_VAL_PAJAK");
	$tempKeterangan = $kptt_nota->getField("KET_TAMBAHAN");
	$tempValutaNama = $kptt_nota->getField("KD_VALUTA");
	$tempTahun = $kptt_nota->getField("THN_BUKU");
	$tempBulan = $kptt_nota->getField("BLN_BUKU");
	$tempTanggalPosting = dateToPageCheck($kptt_nota->getField("TGL_POSTING"));
	$tempNoPosting = $kptt_nota->getField("NO_POSTING");
	$tempKdBbKusto = $kptt_nota->getField("KD_BB_KUSTO");
	
	if($tempKursPajak == "")
		$tempKursPajak = 1;
}

$safr_valuta->selectByParams(array("KD_AKTIF" => "A"));
$ppn_materai = $kbbr_rule_modul->getStatus(array("KD_RULE" => "PPNMETERAI"));

$kbbr_tipe_trans->selectByParams(array("A.KD_JURNAL"=>"JPJ", "A.KD_SUBSIS"=>"KPT", "AUTO_MANUAL"=>"M", "KD_AKTIF"=>"A"),-1,-1,"", "ORDER BY TIPE_TRANS ASC");
$arrTipeTrans["TIPE_TRANS"][] = "";
$arrTipeTrans["AKRONIM_DESC"][] = "";		
while($kbbr_tipe_trans->nextRow())
{
	$arrTipeTrans["TIPE_TRANS"][] = $kbbr_tipe_trans->getField("TIPE_TRANS");
	$arrTipeTrans["AKRONIM_DESC"][] = $kbbr_tipe_trans->getField("AKRONIM_DESC");		
}

$kbbr_tipe_trans_d->selectByParams(array("TIPE_TRANS" => $tempTipeTrans, "KD_AKTIF" => "A"));
while($kbbr_tipe_trans_d->nextRow())
{
	$arrTipeTransD["KLAS_TRANS"][] = $kbbr_tipe_trans_d->getField("KLAS_TRANS");
	$arrTipeTransD["KETK_TRANS"][] = $kbbr_tipe_trans_d->getField("KETK_TRANS");		
}

$tempPersenPajak = $kbbr_general_ref_d->getSetting(array("ID_REF_FILE" => "JKK_NOTA", "ID_REF_DATA" => "POT1"));
$disabled="disabled";
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
    <script type="text/javascript" src="js/entri_tabel_nota_non_tunai.js"></script>
    <link rel="stylesheet" href="../WEB-INF/lib/DHTMLWindow/windowfiles/dhtmlwindow.css" type="text/css" />
    <script type="text/javascript" src="../WEB-INF/lib/DHTMLWindow/windowfiles/dhtmlwindow.js"></script>    
	<script type="text/javascript">
		function setValue(){
			$('#reqTanggalTransaksi').datebox('setValue', '<?=$tempTanggalTransaksi?>');	
		}		
		/* KBBT_JUR_BB */
		$(function(){
			$('#ff').form({
				url:'../json-keuangansiuk/penjualan_non_tunai_add.php',
				onSubmit:function(){
					return $(this).form('validate');
				},
				success:function(data){
					data = data.split("-");					
					$.messager.alert('Info', data[1], 'info');	
					document.location.href = 'penjualan_non_tunai_add.php?reqId='+data[0];
					top.frames['mainFrame'].location.reload();
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
		//document.getElementById('reqAlamat').value = alamat;
		//document.getElementById('reqNPWP').value = npwp;
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
                <span><img src="../WEB-INF/images/panah-judul.png"> Tambah Data Penjualan Non Tunai (JPJ)</span>
    </div>
    <form id="ff" method="post" novalidate>
    <table style="margin-left:17px;">
    	<thead>
        <tr>           
             <td>No PPKB</td>
			 <td>
				<input name="reqNoPPKB" id="reqNoPPKB" class="easyui-validatebox" <?=$disabled?> style="width:170px" type="text" value="<?=$tempNoPPKB?>" />
                &nbsp;&nbsp;
            	Segmen
                <select name="reqSegmen" id="reqSegmen" <?=$disabled?>>
                	<?
					for($j=0;$j<count($arrTipeTrans["TIPE_TRANS"]);$j++)
					{
                    ?>
                		<option value="<?=$arrTipeTrans["TIPE_TRANS"][$j]?>" <? if($tempSegmen == $arrTipeTrans["TIPE_TRANS"][$j]) { ?> selected <? } ?>><?=$arrTipeTrans["AKRONIM_DESC"][$j]?></option>
                    <?
					}
                    ?>
                </select>
			</td>
            <td>Tanggal Valuta</td>
			 <td>
             	<input id="reqTanggalValuta" name="reqTanggalValuta" style="width:109px" <?=$disabled?> value="<?=$tempTanggalValuta?>" />
                <input name="reqNoBukti" class="easyui-validatebox" <?=$disabled?> style="width:290px" type="text" value="<?=$tempNoBukti?>" />
			</td>
        </tr>
        <tr>           
             <td>No Ref</td>
			 <td>
				<input name="reqNoRef" id="reqNoRef" <?=$disabled?> class="easyui-validatebox" style="width:170px" type="text" value="<?=$tempNoRef?>" />
                &nbsp;&nbsp;
            	No Ref 2
                <input name="reqNoRefLain" class="easyui-validatebox" <?=$disabled?> style="width:111px" type="text" value="<?=$tempNoRefLain?>" />
			</td>
            <td>Nama Kapal</td>
			 <td>
             	<input id="reqKodeKapal" name="reqKodeKapal" <?=$disabled?> class="easyui-validatebox" style="width:109px" value="<?=$tempKodeKapal?>" />
                <input name="reqKapal" class="easyui-validatebox" <?=$disabled?> style="width:290px" type="text" value="<?=$tempKapal?>" />
			</td>
        </tr>
        <tr>           
             <td>Pelanggan</td>
			 <td>
				<input name="reqNoPelanggan" id="reqNoPelanggan" class="easyui-validatebox" <?=$disabled?> style="width:50px" type="text" value="<?=$tempNoPelanggan?>"  onKeyDown="openPopup('PELANGGAN');"/>           
				<input name="reqPelanggan" id="reqPelanggan" <?=$disabled?> class="easyui-validatebox" style="width:300px" type="text" value="<?=$tempPelanggan?>" />  
                <input name="reqBadanUsaha" id="reqBadanUsaha" type="hidden" value="<?=$tempBadanUsaha?>">      
			</td>
            <td>Kode Bank</td>
			 <td>
             	<input id="reqKodeBank" name="reqKodeBank" <?=$disabled?> class="easyui-validatebox" style="width:109px" value="<?=$tempKodeBank?>" />
                <input name="reqBank" id="reqBank" class="easyui-validatebox" <?=$disabled?> style="width:290px" type="text" value="<?=$tempBank?>" />
			</td>
        </tr>
        <tr>
        	<td>Tanggal Transaksi</td>
			 <td>
             	<input id="reqTanggalTransaksi" name="reqTanggalTransaksi" <?=$disabled?> class="easyui-datebox" data-options="validType:'date'" value="<?=$tempTanggalTransaksi?>" />
                &nbsp;&nbsp;
                Tanggal Val Pajak
                <input id="reqTanggalValutaPajak" name="reqTanggalValutaPajak" <?=$disabled?> class="easyui-datebox" data-options="validType:'date'" value="<?=$tempTanggalValutaPajak?>" />
			</td>
            <td>Jumlah Tagihan</td>
			 <td>
             	<input id="reqJumlahTagihan" name="reqJumlahTagihan" class="easyui-validatebox" <?=$disabled?> style="width:145px" OnFocus="FormatAngka('reqJumlahTagihan')" OnKeyUp="FormatUang('reqJumlahTagihan')" OnBlur="FormatUang('reqJumlahTagihan')" value="<?=numberToIna($tempJumlahTagihan)?>" />
                &nbsp; &nbsp;
                Jumlah Upper
                <input id="reqJumlahUpper" name="reqJumlahUpper" class="easyui-validatebox" <?=$disabled?> style="width:145px" OnFocus="FormatAngka('reqJumlahUpper')" OnKeyUp="FormatUang('reqJumlahUpper')" OnBlur="FormatUang('reqJumlahUpper')" value="<?=numberToIna($tempJumlahUpper)?>" />
			</td>
        </tr>
        <tr>
            <td>Kurs&nbsp;Valuta</td>
			<td>
            	<input name="reqKursValuta" id="reqKursValuta" class="easyui-validatebox" <?=$disabled?> style="width:110px" type="text" value="<?=$tempKursValuta?>" />
                &nbsp;&nbsp;
                Kurs Pajak&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <input name="reqKursPajak" id="reqKursPajak" class="easyui-validatebox" <?=$disabled?> maxlength="3" style="width:110px" type="text" value="<?=$tempKursPajak?>" />
			</td>
            <td>Keterangan Tambahan</td>
            <td>
				<input name="reqKeterangan" class="easyui-validatebox" <?=$disabled?> style="width:410px" type="text" value="<?=$tempKeterangan?>" />
            </td>
        </tr>
        <tr>
            <td>Kode Valuta</td>
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
                Tahun
                <input id="reqTahun" name="reqTahun" class="easyui-validatebox" data-options="validType:'minLength[4]'" maxlength="4" style="width:40px" value="<?=$tempTahun?>" <?=$disabled?> />
                <input id="reqBulan" name="reqBulan" class="easyui-validatebox" data-options="validType:'minLength[2]'" maxlength="2" style="width:20px" value="<?=$tempBulan?>" <?=$disabled?> />
                &nbsp;&nbsp;
                Materai
	            <select name="reqMateraiPilih" id="reqMateraiPilih" <?=$disabled?>>
            	<option value="1">Ya</option>
                <option value="0">Tidak</option>
           		</select>
                <input name="reqMaterai" id="reqMaterai" class="easyui-validatebox" style="width:74px" type="hidden" value="<?=$tempMaterai?>" <?=$disabled?> />
			</td>
            <td>Tanggal Posting</td>
            <td>
            	<input name="reqTanggalPosting" readonly style="width:145px;" value="<?=$tempTanggalPosting?>" <?=$disabled?> />
                &nbsp;&nbsp;
                No&nbsp;Posting
				<input name="reqNoPosting" class="easyui-validatebox" <?=$disabled?> style="width:170px" type="text" value="<?=$tempNoPosting?>" />
            </td>
        </tr>
        <tr>
        	<td colspan="4">
            <div>
            	<input type="hidden" name="reqPersenPajak" id="reqPersenPajak" class="easyui-numberbox" maxlength="3" style="width:30px" value="<?=(int)$tempPersenPajak?>" />
                <input type="hidden" name="reqId" value="<?=$reqId?>">
                <input type="hidden" name="reqMode" value="<?=$reqMode?>">
                <input type="hidden" name="reqPpnMaterai" id="reqPpnMaterai" value="<?=$ppn_materai?>">
                <?
                if($reqMode == "update")
				{
				?>
                <input type="button" value="Rincian Jurnal" onClick="OpenDHTMLPopup('jurnal_lihat.php?reqId=<?=$reqId?>', 'Rincian Jurnal', 900, 600)">
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
              <th style="width:20%">Jenis Jasa</th>
              <th style="width:10%">PPN</th>
              <th style="width:10%">Jumlah Transaksi</th>
              <th>Keterangan Tambahan</th>
              <th style="width:5%">Aksi</th>
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
                for($j=0;$j<count($arrTipeTransD["KLAS_TRANS"]);$j++)
				{
				?>
                	<option value="<?=$arrTipeTransD["KLAS_TRANS"][$j]?>" <? if($kptt_nota_d->getField("KLAS_TRANS") == $arrTipeTransD["KLAS_TRANS"][$j]) { ?> selected <? } ?>><?=$arrTipeTransD["KETK_TRANS"][$j]?></option>
                <?
				}
				?>
                </select>
              </td>
              <td>
              	<input type="text" name="reqPajak[]" id="reqPajak<?=$checkbox_index?>" class="easyui-validatebox" <?=$disabled?> value="<?=$kptt_nota_d->getField("STATUS_KENA_PAJAK")?>" />
              </td>
              <td>
              	<input type="text" name="reqNilaiJasa[]"  id="reqNilaiJasa<?=$checkbox_index?>" <?=$disabled?> style="text-align:right" OnFocus="FormatAngka('reqNilaiJasa<?=$checkbox_index?>')" OnKeyUp="FormatUang('reqNilaiJasa<?=$checkbox_index?>'); hitungSemua('<?=$checkbox_index?>');" OnBlur="FormatUang('reqNilaiJasa<?=$checkbox_index?>')" value="<?=numberToIna($kptt_nota_d->getField('JML_VAL_TRANS'))?>">                
              </td>
              <td>
              	<input type="text" name="reqKeteranganTambah[]" style="width:98%;" class="easyui-validatebox" <?=$disabled?> value="<?=$kptt_nota_d->getField("KET_TAMBAHAN")?>" />
              </td>
              <td align="center">
              <label>
              <input type="hidden" name="reqJumlah[]" style="text-align:right;" id="reqJumlah<?=$checkbox_index?>" <?=$disabled?> OnFocus="FormatAngka('reqJumlah<?=$checkbox_index?>')" OnKeyUp="FormatUang('reqJumlah<?=$checkbox_index?>')" OnBlur="FormatUang('reqJumlah<?=$checkbox_index?>')" value="<?=numberToIna($kptt_nota_d->getField('JUMLAH_TOTAL'))?>">
              <input type="hidden" name="reqNilaiPajak[]"  id="reqNilaiPajak<?=$checkbox_index?>" <?=$disabled?> value="<?=numberToIna($kptt_nota_d->getField('JML_VAL_PAJAK'))?>">
              <input type="hidden" name="reqKdBukuBesar[]" id="reqKdBukuBesar<?=$checkbox_index?>" <?=$disabled?> value="<?=$kptt_nota_d->getField("KD_BUKU_BESAR")?>"><input type="hidden" name="reqDK[]" id="reqDK<?=$checkbox_index?>" value="<?=$kptt_nota_d->getField("KD_D_K")?>">
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
            	<td colspan="3">&nbsp;</td>
            	<td><input type="text" id="reqJumlahTrans" name="reqJumlahTrans" style="text-align:right;" <?=$disabled?> value="<?=numberToIna($temp_jml_trans)?>" />
                	</td>
            	<td style="text-align:right">Jumlah Pajak <input type="text" id="reqJumlahPajak" name="reqJumlahPajak" style="text-align:right;" <?=$disabled?> value="<?=numberToIna($temp_jml_pajak)?>" />&nbsp;
                    </td>
            	<td>&nbsp;</td>
            </tr>
        </tfoot>
    </table>        
    </form>
</div>
</body>
</html>