<?
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/KpttNotaNonJurnal.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/SafrValuta.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/KpttNotaNonJurnalD.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/KbbrTipeTrans.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/KbbrTipeTransD.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/KbbrGeneralRefD.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/KbbrRuleModul.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/NoFakturPajak.php");
$kptt_nota_non_jurnal = new KpttNotaNonJurnal();
$safr_valuta = new SafrValuta();
$kptt_nota_non_jurnal_d = new KpttNotaNonJurnalD();
$kbbr_tipe_trans = new KbbrTipeTrans();
$kbbr_tipe_trans_d = new KbbrTipeTransD();
$kbbr_general_ref_d = new KbbrGeneralRefD();
$kbbr_rule_modul = new KbbrRuleModul();
$no_faktur_pajak = new NoFakturPajak();
$reqId = httpFilterGet("reqId");
$reqMode = httpFilterGet("reqMode");

if($reqId == "")
{
	$reqMode = "insert";	
	$tempKursValuta = 1;
	$tempTahun = date("Y");
	$tempBulan = "";
	$tempTanggalTransaksi = date("d-m-Y");
	$tempTanggalValutaPajak = date("d-m-Y");
	$tempTanggalValuta = date("d-m-Y");
	$tempMaterai = 0;
	$tempFakturPajak = $no_faktur_pajak->getLastFakturPajak($tempTanggalTransaksi);
	$tempPemakaian = "Pemakaian Kapal Bulan ".getNamePeriode(date("mY"));
}
else
{
	$reqMode = "update";	
	$kptt_nota_non_jurnal->selectByParams(array("A.NO_NOTA"=>$reqId), -1, -1);
	$kptt_nota_non_jurnal->firstRow();
	
	$tempMaterai = $kptt_nota_non_jurnal->getField("METERAI");
	$tempMateraiPilih = $kptt_nota_non_jurnal->getField("METERAI_PILIH");		
	$tempNoPPKB = $kptt_nota_non_jurnal->getField("NO_REF3");
	$tempTipeTrans = $kptt_nota_non_jurnal->getField("TIPE_TRANS");
	$tempSegmen = $kptt_nota_non_jurnal->getField("TIPE_TRANS");
	$tempTanggalValuta = dateToPageCheck($kptt_nota_non_jurnal->getField("TGL_VALUTA"));
	$tempNoBukti = $kptt_nota_non_jurnal->getField("NO_NOTA");
	$tempNoRef = $kptt_nota_non_jurnal->getField("NO_REF1");
	$tempNoRefLain = $kptt_nota_non_jurnal->getField("NO_REF2");
	$tempKodeKapal = $kptt_nota_non_jurnal->getField("");
	$tempKapal = $kptt_nota_non_jurnal->getField("");
	$tempNoPelanggan = $kptt_nota_non_jurnal->getField("KD_KUSTO");
	$tempPelanggan = $kptt_nota_non_jurnal->getField("MPLG_NAMA");
	$tempKodeBank = $kptt_nota_non_jurnal->getField("KD_BANK");
	$tempBank = $kptt_nota_non_jurnal->getField("BANK");
	$tempBankBB = $kptt_nota_non_jurnal->getField("KD_BB_BANK");
	$tempBadanUsaha = $kptt_nota_non_jurnal->getField("BADAN_USAHA");
	$tempTanggalTransaksi = dateToPageCheck($kptt_nota_non_jurnal->getField("TGL_TRANS"));
	$tempTanggalValutaPajak = dateToPageCheck($kptt_nota_non_jurnal->getField("TGL_VAL_PAJAK"));
	//$tempPersenPajak = $kptt_nota_non_jurnal->getField("PPN1_PERSEN");
	$tempJumlahTagihan = $kptt_nota_non_jurnal->getField("JML_TAGIHAN");
	$tempJumlahUpper = $kptt_nota_non_jurnal->getField("JML_WD_UPPER");
	$tempKursValuta = numberToIna($kptt_nota_non_jurnal->getField("KURS_VALUTA"));
	$tempKursPajak = numberToIna($kptt_nota_non_jurnal->getField("KURS_VAL_PAJAK"));
	$tempKeterangan = $kptt_nota_non_jurnal->getField("KET_TAMBAHAN");
	$tempValutaNama = $kptt_nota_non_jurnal->getField("KD_VALUTA");
	$tempTahun = $kptt_nota_non_jurnal->getField("THN_BUKU");
	$tempBulan = $kptt_nota_non_jurnal->getField("BLN_BUKU");
	$tempTanggalPosting = dateToPageCheck($kptt_nota_non_jurnal->getField("TGL_POSTING"));
	$tempNoPosting = $kptt_nota_non_jurnal->getField("NO_POSTING");
	$tempKdBbKusto = $kptt_nota_non_jurnal->getField("KD_BB_KUSTO");
	$tempFakturPajak = $kptt_nota_non_jurnal->getField("FAKTUR_PAJAK");
	$tempFakturPajakPrefix = $kptt_nota_non_jurnal->getField("FAKTUR_PAJAK_PREFIX");
	$tempTanggalFakturPajak = dateToPageCheck($kptt_nota_non_jurnal->getField("TGL_FAKTUR_PAJAK"));
	
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
    <script type="text/javascript" src="../WEB-INF/lib/easyui/upperfunction.js"></script>
    <script type="text/javascript" src="../WEB-INF/lib/easyui/global-tab-easyui.js"></script>
    <script type="text/javascript" src="js/entri_tabel_nota_lain.js"></script>
    <link rel="stylesheet" href="../WEB-INF/lib/DHTMLWindow/windowfiles/dhtmlwindow.css" type="text/css" />
    <script type="text/javascript" src="../WEB-INF/lib/DHTMLWindow/windowfiles/dhtmlwindow.js"></script>    
	<script type="text/javascript">
		function setValue(){
			$('#reqTanggalTransaksi').datebox('setValue', '<?=$tempTanggalTransaksi?>');
			$('#reqPelanggan').next().find('input').focus();	
		}		
		/* KBBT_JUR_BB */
		$(function(){
			$('#ff').form({
				url:'../json-keuangansiuk/penjualan_lain_add.php',
				onSubmit:function(){
					return $(this).form('validate');
				},
				success:function(data){
					//alert(data);
					data = data.split("@");					
					$.messager.alert('Info', data[1], 'info');	
					document.location.href = 'penjualan_lain_add.php?reqId='+data[0];
					top.frames['mainFrame'].location.reload();
				}
			});
			
		});
		
		$(function(){
			  $("#reqValutaNama").change(function() { 
			
				   if($("#reqValutaNama").val() == "IDR")
				   {
						$("#reqKursValuta").val('1');
						$("#reqKursPajak").val('1');		
						$('#reqBank').combobox('reload', '../json-keuangansiuk/bank_combo_json.php?reqKdValuta=IDR');								
				   }
				   else
				   {
					  $('#reqBank').combobox('reload', '../json-keuangansiuk/bank_combo_json.php?reqKdValuta=USD');	
					  $.getJSON("../json-keuangansiuk/get_valuta_kurs_json.php?reqValutaKursId="+$("#reqValutaNama").val()+ "&reqTanggalTransaksi="+$('#reqTanggalTransaksi').datebox('getValue'),
					  function(data){
							if(data.NILAI_RATE == "")
							{
								if(confirm("Kurs&nbsp;Valuta belum dientri, tambahkan kurs?"))
								{
									OpenDHTMLPopup('kurs_add_popup.php', 'Tambah Kurs', 950, 600);									
								}	
							}
							else
							{
								$("#reqKursValuta").val(data.NILAI_RATE);
								$("#reqTanggalValuta").val(data.TGL_MULAI_RATE);
								  $.getJSON("../json-keuangansiuk/get_valuta_kurs_pajak_json.php?reqValutaKursId="+$("#reqValutaNama").val()+ "&reqTanggalTransaksi="+$('#reqTanggalTransaksi').datebox('getValue'),
								  function(data){
										if(data.NILAI_RATE == "")
										{
											if(confirm("Kurs pajak belum dientri, tambahkan kurs?"))
											{
												OpenDHTMLPopup('kurs_pajak_add_popup.php', 'Tambah Kurs Pajak', 950, 600);
											}	
										}				
										else	
										{				  
											$("#reqKursPajak").val(data.NILAI_RATE);
											$("#reqTanggalValutaPajak").val(data.TGL_MULAI_RATE);
										}
								  });									
							}
					  });
				  
				   }
				   
			  });		  

			  $('#btnCetakNota').on('click', function () {
					var win = $.messager.progress({
						title:'Please waiting',
						msg:'Loading data...'
					});
				  $.getJSON('../json-keuangansiuk/proses_cetak_nota_penjualan_cetak.php?reqId=<?=$reqId?>',
					function(data){
					  $.messager.progress('close');
					  newWindow = window.open('penjualan_lain_cetak_nota_rpt.php?reqId=<?=$reqId?>', 'Cetak');
				  	  newWindow.focus();					
					  
					  document.location.href = 'penjualan_lain_add.php?reqId=<?=$reqId?>';		
	
				  });	
				  
			  });
			  
			  $('#btnScreen').on('click', function () {
				  newWindow = window.open('penjualan_lain_cetak_nota_rpt.php?reqId=<?=$reqId?>', 'Cetak');
				  newWindow.focus();		
			  });

			$("#reqKodeBank").keydown(function(event) { 
				if(event.keyCode == 120)
				{
					OpenDHTMLPopup('bank_pencarian.php?reqKdValuta='+$("#reqValutaNama").val(), 'Pencarian Bank', 950, 600);
					
					return false;
				}						  
			 });

			$('#reqTanggalTransaksi').datebox({
				onSelect: function(date){
					var y = date.getFullYear();
					var m = date.getMonth() + 1;
					var d = date.getDate();
					var dat = (d < 10 ? '0' + d : d) + '-' + (m < 10 ? '0' + m : m) + '-' + y;
					$('#reqTanggalValuta').val(dat);					
										
				}
			});	
						
		});	

		function checkPajak()
		{
			$.getJSON("../json-keuangansiuk/get_valuta_kurs_pajak_json.php?reqValutaKursId="+$("#reqValutaNama").val()+ "&reqTanggalTransaksi="+$('#reqTanggalTransaksi').datebox('getValue'),
			function(data){
				  if(data.NILAI_RATE == "")
				  {
					  if(confirm("Kurs pajak belum dientri, tambahkan kurs?"))
					  {
						  OpenDHTMLPopup('kurs_pajak_add_popup.php', 'Tambah Kurs Pajak', 950, 600);
					  }	
				  }				
				  else	
				  {				  
					  $("#reqKursPajak").val(data.NILAI_RATE);
					  $("#reqTanggalValutaPajak").val(data.TGL_MULAI_RATE);
				  }
			});				
		}
		
		function OptionSetBank(bb, kode, nama){
			document.getElementById('reqKodeBank').value = kode;
			document.getElementById('reqBank').value = nama;
			document.getElementById('reqBankBB').value = bb;
			$("#reqKodeBank").focus();
			
		}	
				
		function openPopup(tipe)
		{
		
		var isCtrl = false;
		$('#reqNoPelanggan').keyup(function (e) {
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
		$("#reqNoPelanggan").focus();
		}	
			
		function OpenDHTMLPopup(opAddress, opCaption, opWidth, opHeight)
		{
			var left = (screen.width/2)-(opWidth/2);
			var top = (screen.height/2)-(opHeight/2) - 100;
			
			divwin=dhtmlwindow.open('divbox', 'iframe', opAddress, opCaption, 'width='+opWidth+'px,height='+opHeight+'px,left='+left+'px,top='+top+'px,resize=1,scrolling=1,midle=1'); return false;
		}	
			
		$(function(){
			  			  
				$('#reqPelanggan').combobox('textbox').bind('mousedown',function(e){
					tabindex=1;
				});
				
				$('#reqBank').combobox('textbox').bind('mousedown',function(e){
					tabindex=9;
				});
				
				$('#reqFakturPajak').combobox('textbox').bind('mousedown',function(e){
					tabindex=6;
				}); 
				
				$('#reqTanggalTransaksi').datebox('textbox').bind('mousedown',function(e){
					tabindex=2;
				});
				
				$('#reqTanggalFakturPajak').datebox('textbox').bind('mousedown',function(e){
					tabindex=7;
				});
 
		});
		
		function setComboBoxUpper(newValue, reqNmComboBox)
		{
			//var temp= $('#'+reqNmComboBox).combobox('getValue');
			var temp= forceupper($('#'+reqNmComboBox), "combobox");
			//temp= temp.toUpperCase();
			//$('#'+reqNmComboBox).combobox('setValue', temp)
		}
	</script>
    
    
</head>
<body onLoad="setValue();">
<div id="begron"><img src="../WEB-INF/images/bg-kanan.jpg" width="100%" height="100%" alt="Smile"></div>
<div id="wadah">

    <div id="judul-halaman">
                <span><img src="../WEB-INF/images/panah-judul.png"> Tambah Data Transaksi Lain</span>
    </div>
    <form id="ff" method="post" novalidate>
    <table style="margin-left:17px;">
    	<thead>        
        <tr>           
             <td>No PPKB</td>
			 <td>
				<input name="reqNoPPKB" id="reqNoPPKB" class="easyui-validatebox" readonly style="width:170px; background-color:#f0f0f0" type="text" value="<?=$tempNoPPKB?>"/>
                
			</td>
            <td>Tanggal Valuta</td>
			 <td>
             	<input id="reqTanggalValuta" name="reqTanggalValuta" style="width:109px; background-color:#f0f0f0" readonly value="<?=$tempTanggalValuta?>" />
			</td>
        </tr>
        <tr>           
             <td>Pelanggan</td>
			 <td>
				<input name="reqNoPelanggan" id="reqNoPelanggan" class="easyui-validatebox" style="width:50px" type="hidden" value="<?=$tempNoPelanggan?>"  onKeyDown="openPopup('PELANGGAN');"/>           
				<input name="reqPelanggan" id="reqPelanggan" class="easyui-combobox" style="width:295px" type="text" value="<?=$tempNoPelanggan?>"  data-options="
                    required: true,
                    filter: function(q, row) { return row['text'].toLowerCase().indexOf(q.toLowerCase()) != -1; },
                    valueField: 'id', textField: 'text',
                    url: '../json-keuangansiuk/pelanggan_by_id_combo_json.php',
                    onChange:function(newValue,oldValue)
                    {
                        //setComboBoxUpper(newValue, 'reqPelanggan');
                    },
                    onSelect:function(rec){ 
                    	$('#reqNoPelanggan').val(rec.MPLG_KODE);
                    	$('#reqBadanUsaha').val(rec.MPLG_BADAN_USAHA);
                    }
                    "
                      tabindex="1" onMouseDown="tabindex=1" /> 	         
                <input name="reqBadanUsaha" id="reqBadanUsaha" type="hidden" value="<?=$tempBadanUsaha?>">      
			</td>
            <td>Kurs&nbsp;Valuta</td>
			<td>
            	<input name="reqKursValuta" id="reqKursValuta" class="easyui-validatebox"  style="width:110px; background-color:#f0f0f0" type="text" value="<?=$tempKursValuta?>" readonly />
                &nbsp;&nbsp;			
            </td>
        </tr>
        <tr>
        	<td>Tanggal Transaksi</td>
			 <td>
             	<input id="reqTanggalTransaksi" name="reqTanggalTransaksi" class="easyui-datebox" data-options="validType:'date'" value="<?=$tempTanggalTransaksi?>" tabindex="2" onMouseDown="tabindex=2"/>
                &nbsp;&nbsp;
                Tanggal Val Pajak
                <input id="reqTanggalValutaPajak" name="reqTanggalValutaPajak" style="width:114px; background-color:#f0f0f0" readonly value="<?=$tempTanggalValutaPajak?>" />
			</td>
            <td>Jumlah Tagihan</td>
			 <td>
             	<input id="reqJumlahTagihan"  readonly name="reqJumlahTagihan" class="easyui-validatebox" style="width:145px; background-color:#f0f0f0" OnFocus="FormatAngka('reqJumlahTagihan')" OnKeyUp="FormatUang('reqJumlahTagihan')" OnBlur="FormatUang('reqJumlahTagihan')" value="<?=numberToIna($tempJumlahTagihan)?>" />
			</td>
        </tr>
        <tr>
            <td>Kode Valuta</td>
			<td>
            	<select name="reqValutaNama" id="reqValutaNama" tabindex="3" onFocus="tabindex=3">
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
                <input id="reqTahun" name="reqTahun" class="easyui-validatebox" data-options="validType:'minLength[4]'" maxlength="4" style="width:40px; background-color:#f0f0f0" value="<?=$tempTahun?>" readonly />
                <input id="reqBulan" name="reqBulan" class="easyui-validatebox" data-options="validType:'minLength[2]'" maxlength="2" style="width:20px; background-color:#f0f0f0" value="<?=$tempBulan?>" readonly />
                &nbsp;&nbsp;
                Materai
	            <select name="reqMateraiPilih" id="reqMateraiPilih" tabindex="4" onFocus="tabindex=4">
            	<option value="1" <? if ($tempMaterai>0) echo "selected";?>>Ya</option>
                <option value="0" <? if ($tempMaterai==0) echo "selected";?>>Tidak</option>
           		</select>
                <input name="reqMaterai" id="reqMaterai" class="easyui-validatebox" style="width:74px" type="hidden" value="<?=$tempMaterai?>" readonly />
			</td>
            <td>Keterangan Tambahan</td>
            <td>
				<input name="reqKeterangan" id="reqKeterangan" class="easyui-validatebox" style="width:408px" type="text" value="<?=$tempKeterangan?>" tabindex="10" onMouseDown="tabindex=10"/>
            </td>
        </tr>
        <tr>
        	<td>Faktur Pajak</td>
            <td colspan="3">
            <input id="reqFakturPajakPrefix" name="reqFakturPajakPrefix" class="easyui-validatebox" data-options="validType:'minLength[3]'" maxlength="3" style="width:30px" value="<?=$tempFakturPajakPrefix?>" tabindex="7" onMouseDown="tabindex=7" />.
            <input id="reqFakturPajak" class="easyui-combobox" name="reqFakturPajak" data-options="valueField:'id',textField:'text', url:'../json-keuangansiuk/faktur_pajak_aktif_combo_json.php?reqTanggal=<?=$tempTanggalTransaksi?>&reqFakturPajak=<?=$tempFakturPajak?>'" style="width:139px;" value="<?=$tempFakturPajak?>" tabindex="8" onMouseDown="tabindex=8"/>&nbsp;
            <?php /*?><input name="reqFakturPajak" id="reqFakturPajak" class="easyui-validatebox" type="text" style="width:159px;" value="<?=$tempFakturPajak?>" tabindex="7" onMouseDown="tabindex=7"/>&nbsp; <?php */?>
            Tgl. Faktur <input id="reqTanggalFakturPajak" name="reqTanggalFakturPajak" class="easyui-datebox" data-options="validType:'date'" value="<?=$tempTanggalFakturPajak?>" tabindex="9" onMouseDown="tabindex=9"/></td>
        </tr>
        <tr>
        	<td>No JKM </td>
        	<td colspan="3">
        		<input name="reqNoRefLain" id="reqNoRefLain" class="easyui-validatebox" style="width:175px" value="<?=$tempNoRefLain; ?>"  />
        	(Kalau diisi dianggap sudah dibayar)</td>
        </tr>
        </thead>
    </table>
		
    <table class="example" id="dataTableRowDinamis">
        <thead class="altrowstable">
          <tr>
              <th style="width:2%">
                No
                <a style="cursor:pointer" title="Tambah" onclick="addRow()"><img src="../WEB-INF/images/tree-add.png" width="16" height="16" border="0" /></a>
              </th>
              <th style="width:76%">Keterangan</th>
              <th style="width:10%">PPN</th>
              <th style="width:20%">Jumlah Transaksi</th>
              <th style="width:2%">Aksi</th>
          </tr>
        </thead>
		<tbody>
        <?
		$i=0;
        $last_tab = 10;       
		$tempJumlahTrans = 0;
        $kptt_nota_non_jurnal_d->selectByParams(array("NO_NOTA" => $reqId));
		while($kptt_nota_non_jurnal_d->nextRow())
		{
		?>
            <tr>
                <td><input type="text" name="reqNoUrut[]" id="reqNoUrut<?=$i?>" readonly class="easyui-validatebox" style="width:60px;" value="<?=($i+1)?>" /></td>
                <td><input type="text" name="reqKetTambah[]" id="reqKetTambah<?=$i?>" style="width:99%;" class="easyui-validatebox" value="<?=$kptt_nota_non_jurnal_d->getField("KET_TAMBAHAN")?>" tabindex="<? $last_tab++; echo $last_tab ?>" /></td>
                <td>
              	<input type="text" name="reqPajak[]" id="reqPajak<?=$i?>" class="easyui-combobox" data-options="
                required: true,
                filter: function(q, row) { return row['text'].toLowerCase().indexOf(q.toLowerCase()) != -1; },
                valueField: 'id', textField: 'text',
                url: '../json-keuangansiuk/pengenaan_pajak_combo_json.php',
                onSelect:function(rec){
                    hitungSemua('<?=$i?>');
                }
                "
                value="<?=$kptt_nota_non_jurnal_d->getField("STATUS_KENA_PAJAK")?>" tabindex="14" onMouseDown="tabindex=14" />
               </td>
                <td><input type="text" name="reqJumlah[]"  id="reqJumlah<?=$i?>" style="width:98%; text-align:right" OnFocus="FormatAngka('reqJumlah<?=$i?>')" OnKeyUp="FormatUang('reqJumlah<?=$i?>'); hitungSemua('');" OnBlur="FormatUang('reqJumlah<?=$i?>')"  value="<?=numberToIna($kptt_nota_non_jurnal_d->getField("JML_VAL_TRANS"))?>" tabindex="<? $last_tab++; echo $last_tab ?>"></td>
                <td align="center">
                	<a style="cursor:pointer" onclick="deleteRowDrawTablePhp('dataTableRowDinamis', this)"><img src="../WEB-INF/images/delete-icon.png" width="15" height="15" border="0" /></a>
                </td>
            </tr>
        <?
			$i++;
			$tempJumlahTrans += $kptt_nota_non_jurnal_d->getField("JML_VAL_TRANS");
				
		}
		if($i==0)
		{
		?>
            <tr>
                <td><input type="text" name="reqNoUrut[]" id="reqNoUrut<?=$i?>" readonly class="easyui-validatebox" style="width:60px;" value="<?=($i+1)?>" /></td>
                <td><input type="text" name="reqKetTambah[]" id="reqKetTambah<?=$i?>" style="width:99%;" class="easyui-validatebox" value=""  tabindex="11" onMouseDown="tabindex=11" /></td>
                <td>
              	<input type="text" name="reqPajak[]" id="reqPajak<?=$i?>" class="easyui-combobox" data-options="
                required: true,
                filter: function(q, row) { return row['text'].toLowerCase().indexOf(q.toLowerCase()) != -1; },
                valueField: 'id', textField: 'text',
                url: '../json-keuangansiuk/pengenaan_pajak_combo_json.php',
                onSelect:function(rec){
                    hitungSemua('<?=$checkbox_index?>');
                }
                "
                value="" tabindex="14" onMouseDown="tabindex=14" />
               </td>
                <td><input type="text" name="reqJumlah[]"  id="reqJumlah<?=$i?>" style="width:98%; text-align:right" OnFocus="FormatAngka('reqJumlah<?=$i?>')" OnKeyUp="FormatUang('reqJumlah<?=$i?>'); hitungSemua('');" OnBlur="FormatUang('reqJumlah<?=$i?>')" value="0" tabindex="13" onMouseDown="tabindex=13"></td>
                <td align="center">
                	<a style="cursor:pointer" onclick="deleteRowDrawTablePhp('dataTableRowDinamis', this)"><img src="../WEB-INF/images/delete-icon.png" width="15" height="15" border="0" /></a>
                </td>
            </tr>        
        <?
		}
		?>
        </tbody>        
        <tfoot class="altrowstable">
        	<tr style="background:#f1f4fc">
            	<td colspan="3">&nbsp;</td>
            	<td>
                	<input type="text" id="reqJumlahTrans" name="reqJumlahTrans" style="width:98%; text-align:right; background-color:#f0f0f0" readonly value="<?=numberToIna($tempJumlahTrans)?>" />                
                </td>
                <td></td>
            </tr>      
        </tfoot>        
	</table> 
    <div>
        <input type="hidden" name="reqPersenPajak" id="reqPersenPajak" class="easyui-numberbox" maxlength="3" style="width:30px" value="<?=(int)$tempPersenPajak?>" />
        <input type="hidden" name="reqId" value="<?=$reqId?>">
        <input type="hidden" name="reqMode" value="<?=$reqMode?>">
        <input type="hidden" name="reqPpnMaterai" id="reqPpnMaterai" value="<?=$ppn_materai?>">
        <input type="submit" value="Submit">
        <input type="reset" id="rst_form">
        <input type="button" name="btnClose" id="btnClose" value="Close" onClick="window.parent.divwin.close();">
    </div>
    </form>
</div>
<script>
<?
if($reqMode == "update")
{
?>
tabindex = <?=$last_tab?>;
<?
}
?>


$('input[id^="reqJumlah"]').keydown(function(e) {
	if(e.which==13)
	{
		addRow();		
	}
});

$("#reqKeterangan").keyup(function(e) {
	forceupper(this)
	//var temp= this.value.toUpperCase();
	//$(this).val(temp);
});

</script>
</body>
</html>