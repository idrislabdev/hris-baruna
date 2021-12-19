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
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/NoFakturPajak.php");

$kptt_nota = new KpttNota();
$safr_valuta = new SafrValuta();
$kptt_nota_d = new KpttNotaD();
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
	$tempKursPajak = 1;
	$tempTahun = date("Y");
	$tempBulan = "";
	$tempTanggalTransaksi = date("d-m-Y");
	$tempTanggalValutaPajak = date("d-m-Y");
	$tempTanggalValuta = date("d-m-Y");
	$tempMaterai = 0;
	$tempFakturPajak = $no_faktur_pajak->getLastFakturPajak($tempTanggalTransaksi);
	$tempSegmen = "JPJ-KPT-01";
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
	$tempBank = $kptt_nota->getField("BANK");
	$tempBankBB = $kptt_nota->getField("KD_BB_BANK");
	$tempBadanUsaha = $kptt_nota->getField("BADAN_USAHA");
	$tempTanggalTransaksi = dateToPageCheck($kptt_nota->getField("TGL_TRANS"));
	$tempTanggalValutaPajak = dateToPageCheck($kptt_nota->getField("TGL_VAL_PAJAK"));
	//$tempPersenPajak = $kptt_nota->getField("PPN1_PERSEN");
	$tempJumlahTagihan = $kptt_nota->getField("JML_TAGIHAN");
	$tempJumlahUpper = $kptt_nota->getField("JML_WD_UPPER");
	$tempKursValuta = numberToIna($kptt_nota->getField("KURS_VALUTA"));
	$tempKursPajak = numberToIna($kptt_nota->getField("KURS_VAL_PAJAK"));
	$tempKeterangan = $kptt_nota->getField("KET_TAMBAHAN");
	$tempValutaNama = $kptt_nota->getField("KD_VALUTA");
	$tempTahun = $kptt_nota->getField("THN_BUKU");
	$tempBulan = $kptt_nota->getField("BLN_BUKU");
	$tempTanggalPosting = dateToPageCheck($kptt_nota->getField("TGL_POSTING"));
	$tempNoPosting = $kptt_nota->getField("NO_POSTING");
	$tempKdBbKusto = $kptt_nota->getField("KD_BB_KUSTO");
	$tempFakturPajak = $kptt_nota->getField("FAKTUR_PAJAK");
	$tempFakturPajakPrefix = $kptt_nota->getField("FAKTUR_PAJAK_PREFIX");
	$tempTanggalFakturPajak = dateToPageCheck($kptt_nota->getField("TGL_FAKTUR_PAJAK"));
	$reqDepartemenId = $kptt_nota->getField("DEPARTEMEN_ID");
	$reqDepartemenKelasId = $kptt_nota->getField("DEPARTEMEN_KELAS_ID");
	$reqDepartemenKelas = $kptt_nota->getField("DEPARTEMEN_KELAS");
	
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
    <script type="text/javascript" src="js/entri_tabel_nota_non_pembayaran.js"></script>
    <link rel="stylesheet" href="../WEB-INF/lib/DHTMLWindow/windowfiles/dhtmlwindow.css" type="text/css" />
    <script type="text/javascript" src="../WEB-INF/lib/DHTMLWindow/windowfiles/dhtmlwindow.js"></script>    
	<script type="text/javascript">
		function setValue(){
			$('#reqTanggalTransaksi').datebox('setValue', '<?=$tempTanggalTransaksi?>');
			$('#reqSegmen').next().find('input').focus();	
		}		
		/* KBBT_JUR_BB */
		$(function(){
			

			
			$('#ff').find('input, textarea, select').attr('disabled','disabled');
			$('.easyui-combobox').combobox({disabled: true});
			$('.easyui-datebox').datebox({disabled: true});
			
			$('#ff').form({
				url:'../json-keuangansiuk/penjualan_pembayaran_add.php',
				onSubmit:function(){
					$('#reqFakturPajak').combobox('setValue', $('#reqFakturPajak').combobox('getText'));
					if($('#reqBadanUsaha').val() == '')
					{
						$.messager.alert('Info', 'Isi badan usaha pelanggan terlebih dahulu kemudian pilih ulang pelanggan.', 'info');	
						return false;
					}
					else
						return $(this).form('validate');
				},
				success:function(data){
					//alert(data); return;
					data = data.split("-");					
					$.messager.alert('Info', data[1], 'info');	
					document.location.href = 'penjualan_pembayaran_add.php?reqId='+data[0];
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
								if(confirm("Kurs Valuta belum dientri, tambahkan kurs?"))
								{
									OpenDHTMLPopup('kurs_add_popup.php', 'Tambah Kurs', 950, 600);									
								}	
							}
							else
							{
								$("#reqKursValuta").val(data.NILAI_RATE);
								$("#reqTanggalValuta").val(data.TGL_MULAI_RATE);
								$("#reqKursPajak").val(data.NILAI_RATE);
								$("#reqTanggalValutaPajak").val(data.TGL_MULAI_RATE);								
								  /*$.getJSON("../json-keuangansiuk/get_valuta_kurs_json.php?reqValutaKursId="+$("#reqValutaNama").val()+ "&reqTanggalTransaksi="+$('#reqTanggalTransaksi').datebox('getValue'),
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
								  });	*/								
							}
					  });
				  
				   }
				   
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
					$('#reqFakturPajak').combobox('reload','../json-keuangansiuk/faktur_pajak_aktif_combo_json.php?reqTanggal='+dat); 
				    $('#reqTanggalValutaPajak').val(dat); 
				    $('#reqTanggalValuta').val(dat);
				    /*$('#reqBulan').val((m < 10 ? '0' + m : m));
				    $('#reqTahun').val(y);*/
					$('#reqTanggalFakturPajak').datebox('setValue', dat);
					<?
					if($reqMode == "insert")
					{
					?>
						$.getJSON('../json-keuangansiuk/faktur_pajak_aktif_json.php?reqTanggal='+dat,
						function(data){
							$('#reqFakturPajak').combobox('setValue', data.NOMOR);
						});						
					<?
					}
					?>
					
					
				}
			});	
						
		});	

		function checkPajak()
		{
			$.getJSON("../json-keuangansiuk/get_valuta_kurs_json.php?reqValutaKursId="+$("#reqValutaNama").val()+ "&reqTanggalTransaksi="+$('#reqTanggalTransaksi').datebox('getValue'),
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
			$('#reqDepartemenKelas').keyup(function (e) {
				if(e.which == 120)
				{
					if(tipe == "PELANGGAN")
					{					
						OpenDHTMLPopup('departemen_kelas_pencarian.php', 'Pencarian Kelas', 950, 600);
					}
					return false;
				}
			});
		
		}
		
		
		function OptionSetKelas(anSelectedDepId, anSelectedDepKelasId, anSelectedNama, anSelectedJumlah){
			document.getElementById('reqDepartemenId').value = anSelectedDepId;
			document.getElementById('reqDepartemenKelasId').value = anSelectedDepKelasId;
			document.getElementById('reqDepartemenKelas').value = anSelectedNama;
			document.getElementById('reqKeterangan').value = 'PIUTANG SPP ' + anSelectedNama + ' <?=strtoupper(getNamePeriode(date("mY")))?>';
			
			$("#alternatecolor").html("");
			
			$.get("penjualan_pembayaran_add_template.php?reqId="+anSelectedDepKelasId, function (data) {
				$("#alternatecolor").append(data);
				hitungSemua(0);
			});			
						
			
			$("#reqDepartemenKelas").focus();
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
			  			  
				$('#reqSegmen').combobox('textbox').bind('mousedown',function(e){
					tabindex=1;
				});

				$('#reqPelanggan').combobox('textbox').bind('mousedown',function(e){
					tabindex=3;
				});

				$('#reqBank').combobox('textbox').bind('mousedown',function(e){
					tabindex=11;
				});
				
				$('#reqFakturPajak').combobox('textbox').bind('mousedown',function(e){
					tabindex=8;
				});

				$('#reqKlasTrans0').combobox('textbox').bind('mousedown',function(e){
					tabindex=13;
				});

				$('#reqPajak0').combobox('textbox').bind('mousedown',function(e){
					tabindex=14;
				});

				$('#reqTanggalTransaksi').datebox('textbox').bind('mousedown',function(e){
					tabindex=4;
				});

				$('#reqTanggalFakturPajak').datebox('textbox').bind('mousedown',function(e){
					tabindex=9;
				});
				
				
		});
		
		function setComboBoxUpper(newValue, reqNmComboBox)
		{
			//var temp= $('#'+reqNmComboBox).combobox('getValue');
			var temp= forceupper($('#'+reqNmComboBox), "combobox");
			//temp= temp.toUpperCase();
			//$('#'+reqNmComboBox).combobox('setValue', temp)
		}
		
		function setBulan(date)
		{
			var y = date.getFullYear();
			var m = date.getMonth() + 1;
			var d = date.getDate();
			
			var dat = (d < 10 ? '0' + d : d) + '-' + (m < 10 ? '0' + m : m) + '-' + y;
			$('#reqFakturPajak').combobox('reload','../json-keuangansiuk/faktur_pajak_aktif_combo_json.php?reqTanggal='+dat); 
			$('#reqTanggalValutaPajak').val(dat); 
			$('#reqTanggalValuta').val(dat);
			/*$('#reqBulan').val((m < 10 ? '0' + m : m));
			$('#reqTahun').val(y);*/
			$('#reqTanggalFakturPajak').datebox('setValue', dat);
			<?
			if($reqMode == "insert")
			{
			?>
				$.getJSON('../json-keuangansiuk/faktur_pajak_aktif_json.php?reqTanggal='+dat,
				function(data){
					$('#reqFakturPajak').combobox('setValue', data.NOMOR);
				});						
			<?
			}
			?>
		}


		function OptionSetPPKB(id, no_pel, nama, badan_usaha){
			document.getElementById('reqNoRef3').value = id;		
			document.getElementById('reqNoPelanggan').value = no_pel;
			document.getElementById('reqPelanggan').value = nama;
			document.getElementById('reqBadanUsaha').value = badan_usaha;
			getDataJPJ();
		}	
		
	</script>
    
    
</head>
<body onLoad="setValue();">
<div id="begron"><img src="../WEB-INF/images/bg-kanan.jpg" width="100%" height="100%" alt="Smile"></div>
<div id="wadah">

    <div id="judul-halaman">
                <span><img src="../WEB-INF/images/panah-judul.png"> Tambah Data Transaksi Penagihan SPP Siswa</span>
    </div>
    <form id="ff" method="post" novalidate>
    <table style="margin-left:17px;">
    	<thead>
        <tr>           
             <td>No PPKB</td>
			 <td>
				<input name="reqNoPPKB" id="reqNoPPKB" class="easyui-validatebox" readonly style="width:170px; background-color:#f0f0f0" type="text" value="<?=$tempNoPPKB?>"/>
                &nbsp;&nbsp;
                <div style="display:none">
            	Segmen
                <input id="reqSegmen" name="reqSegmen" value="JPJ-KPT-01" class="easyui-combobox" data-options="
                required: true,
                filter: function(q, row) { return row['text'].toLowerCase().indexOf(q.toLowerCase()) != -1; },
                valueField: 'id', textField: 'text',
                url: '../json-keuangansiuk/segmen_combo_json.php',
                onChange:function(newValue,oldValue)
                {
                    //setComboBoxUpper(newValue, 'reqSegmen');
                },
                onSelect:function(rec){
                	var value = rec.id;
                    setSegmenJenisJasaPhp(value);
                }
                "
                validType="exists['#reqSegmen']"
                value="<?=$tempSegmen?>" tabindex="1" onMouseDown="tabindex=1"/>
                </div>
			</td>
            <td>Tanggal Valuta</td>
			 <td>
             	<input id="reqTanggalValuta" name="reqTanggalValuta" style="width:109px; background-color:#f0f0f0" readonly value="<?=$tempTanggalValuta?>" />
                <input name="reqNoBukti" class="easyui-validatebox" readonly style="width:290px; background-color:#f0f0f0" type="text" value="<?=$tempNoBukti?>" />
			</td>
        </tr>
        <tr>           
             <td>No Ref</td>
			 <td>
				<input name="reqNoRef" id="reqNoRef" readonly class="easyui-validatebox" style="width:170px; background-color:#f0f0f0" type="text" value="<?=$tempNoRef?>" />
                &nbsp;&nbsp;
            	No Ref 2
                <input name="reqNoRefLain" id="reqNoRefLain" class="easyui-validatebox" style="width:144px" type="text" value="<?=$tempNoRefLain?>" tabindex="2" onMouseDown="tabindex=2"/>
			</td>
            <!-- <td>Nama Kapal</td>
			 <td>
             	<input id="reqKodeKapal" name="reqKodeKapal" class="easyui-validatebox" style="width:109px" value="<?=$tempKodeKapal?>" tabindex="10" onMouseDown="tabindex=10"/>
                <input name="reqKapal" class="easyui-validatebox" readonly style="width:290px" type="text" value="<?=$tempKapal?>"  />
			</td> -->
        </tr>
        <tr>  
        	<td>Kelas</td>
			<td>  
                <input type="hidden" name="reqDepartemenId" id="reqDepartemenId" class="easyui-validatebox" style="width:150px" type="text" value="<?=$reqDepartemenId?>" tabindex="3"   onKeyDown="openPopup('PELANGGAN');" />
                <input type="hidden" name="reqDepartemenKelasId" id="reqDepartemenKelasId" class="easyui-validatebox" style="width:150px" type="text" value="<?=$reqDepartemenKelasId?>" tabindex="3"  />
                <input name="reqDepartemenKelas" id="reqDepartemenKelas" class="easyui-validatebox" style="width:70%;" type="text" readonly value="<?=$reqDepartemenKelas?>" onKeyDown="openPopup('PELANGGAN');" />&nbsp;<span style="color:#ff0000;" ></span>
			</td>         
             <!-- <td>Pelanggan</td>
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
                      tabindex="3" onMouseDown="tabindex=3" /> 	         
                <input name="reqBadanUsaha" id="reqBadanUsaha" type="text" style="width:90px; background-color:#f0f0f0" value="<?=$tempBadanUsaha?>" readonly>      
			</td> -->
            <td>Kode Bank</td>
			 <td>
                <input name="reqBank" id="reqBank" class="easyui-combobox" style="width:295px" type="text" value="<?=$tempBank?>"  data-options="
                filter: function(q, row) { return row['text'].toLowerCase().indexOf(q.toLowerCase()) != -1; },
                valueField: 'id', textField: 'text',
                url: '../json-keuangansiuk/bank_combo_json.php?reqKdValuta=IDR',
                onChange:function(newValue,oldValue)
                {
                    //setComboBoxUpper(newValue, 'reqBank');
                },
                onSelect:function(rec){ 
                    $('#reqKodeBank').val(rec.MBANK_KODE);
                    $('#reqBankBB').val(rec.MBANK_KODE_BB);
                }
                "
                  tabindex="11" onMouseDown="tabindex=11" /> 		                                              
             	<input id="reqKodeBank" name="reqKodeBank" class="easyui-validatebox" style="width:109px" type="hidden" value="<?=$tempKodeBank?>"/>
                <input name="reqBankBB" id="reqBankBB" class="easyui-validatebox" readonly style="width:290px" type="hidden" value="<?=$tempBankBB?>" />
			</td>
        </tr>

        <tr>
        	<td>Tanggal Transaksi</td>
			 <td>
             	<input id="reqTanggalTransaksi" name="reqTanggalTransaksi" class="easyui-datebox" data-options="validType:'date',
                onSelect:function(date){
                	setBulan(date);
                }" value="<?=$tempTanggalTransaksi?>" tabindex="4" onMouseDown="tabindex=4"/>
                &nbsp;&nbsp;
                Tanggal Val Pajak
                <input id="reqTanggalValutaPajak" name="reqTanggalValutaPajak" style="width:114px; background-color:#f0f0f0" readonly value="<?=$tempTanggalValutaPajak?>" />
			</td>
            <td>Jumlah Tagihan</td>
			 <td>
             	<input id="reqJumlahTagihan"  readonly name="reqJumlahTagihan" class="easyui-validatebox" style="width:145px; background-color:#f0f0f0" OnFocus="FormatAngka('reqJumlahTagihan')" OnKeyUp="FormatUang('reqJumlahTagihan')" OnBlur="FormatUang('reqJumlahTagihan')" value="<?=numberToIna($tempJumlahTagihan)?>" />
                &nbsp; &nbsp;
                Jumlah Upper
                <input id="reqJumlahUpper" name="reqJumlahUpper" class="easyui-validatebox" readonly style="width:152px; background-color:#f0f0f0" OnFocus="FormatAngka('reqJumlahUpper')" OnKeyUp="FormatUang('reqJumlahUpper')" OnBlur="FormatUang('reqJumlahUpper')" value="<?=numberToIna($tempJumlahUpper)?>" />
			</td>
        </tr>
        <tr>
            <td>Kurs&nbsp;Valuta</td>
			<td>
            	<input name="reqKursValuta" id="reqKursValuta" class="easyui-validatebox"  style="width:110px; background-color:#f0f0f0" type="text" value="<?=$tempKursValuta?>" readonly />
                &nbsp;&nbsp;
                Kurs Pajak&nbsp;&nbsp;&nbsp;
                <input name="reqKursPajak" id="reqKursPajak" class="easyui-validatebox" maxlength="3" style="width:104px; background-color:#f0f0f0" type="text" value="<?=$tempKursPajak?>" readonly />
			</td>
            <td>Keterangan Tambahan</td>
            <td>
				<input name="reqKeterangan" id="reqKeterangan" class="easyui-validatebox" style="width:408px" type="text" value="<?=$tempKeterangan?>" tabindex="12" onMouseDown="tabindex=12"/>
            </td>
        </tr>
        <tr>
            <td>Kode Valuta</td>
			<td>
            	<select name="reqValutaNama" id="reqValutaNama" tabindex="5" onFocus="tabindex=5">
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
	            <select name="reqMateraiPilih" id="reqMateraiPilih" tabindex="6" onFocus="tabindex=6" onChange="$('#reqPpnMaterai').val(this.value)">
                <option value="T">Tidak</option>
            	<option value="Y">Ya</option>
           		</select>
                <input name="reqMaterai" id="reqMaterai" class="easyui-validatebox" style="width:74px; background-color:#f0f0f0" type="text" value="<?=$tempMaterai?>" readonly />
			</td>
            <td>Tanggal Posting</td>
            <td>
            	<input name="reqTanggalPosting" readonly style="width:145px; background-color:#f0f0f0" value="<?=$tempTanggalPosting?>" />
                &nbsp;&nbsp;
                No&nbsp;Posting
				<input name="reqNoPosting" class="easyui-validatebox" readonly style="width:174px; background-color:#f0f0f0" type="text" value="<?=$tempNoPosting?>" />
            </td>
        </tr>
        <tr style="display:none">
        	<td>Faktur Pajak</td>
            <td colspan="3">
            <input id="reqFakturPajakPrefix" name="reqFakturPajakPrefix" class="easyui-validatebox" data-options="validType:'minLength[3]'" maxlength="3" style="width:30px" value="<?=$tempFakturPajakPrefix?>" tabindex="7" onMouseDown="tabindex=7" />.
            <input id="reqFakturPajak" class="easyui-combobox" name="reqFakturPajak" data-options="valueField:'id',textField:'text', url:'../json-keuangansiuk/faktur_pajak_aktif_combo_json.php?reqTanggal=<?=$tempTanggalTransaksi?>&reqFakturPajak=<?=$tempFakturPajak?>'" style="width:139px;" value="<?=$tempFakturPajak?>" tabindex="8" onMouseDown="tabindex=8"/>&nbsp;
            Tgl. Faktur <input id="reqTanggalFakturPajak" name="reqTanggalFakturPajak" class="easyui-datebox" data-options="validType:'date'" value="<?=$tempTanggalFakturPajak?>" tabindex="9" onMouseDown="tabindex=9"/></td>
        </tr>
        </thead>
    </table>
  <?
        if($reqMode == "update")
        {
        ?>
        <button type="button" onClick="OpenDHTMLPopup('jurnal_lihat.php?reqId=<?=$reqId?>', 'Rincian Jurnal', 900, 600)">Rincian Jurnal</button>
        <?
		/*
		<input type="button" value="Screen" id="btnScreen">
        <input type="button" value="Cetak Nota" id="btnCetakNota">    
        <input type="button" name="btnClose" id="btnClose" value="Close" onClick="window.parent.divwin.close();">    
		*/
		?>
        <?
        }
        ?>
    <table class="example" id="dataTableRowDinamis">
    <!--<table class="example altrowstable" id="alternatecolor" >-->
        <thead class="altrowstable">
          <tr>
              <th style="width:5%">
                No
                <a style="cursor:pointer" title="Tambah"></a>
              </th>
              <th style="width:10%">Kartu</th>
              <th style="width:20%">Siswa</th>
              <th style="width:10%">Jumlah Transaksi</th>
              <th>Keterangan Tambahan</th>
          </tr>
        </thead>
        <tbody class="example altrowstable" id="alternatecolor"> 
			  <?
              $i = 1;
              $checkbox_index = 0;
         	  $last_tab = 12;       
              $kptt_nota_d->selectByParamsJpjPembayaran(array("NO_NOTA"=>$reqId), -1, -1, "", " ORDER BY LINE_SEQ ASC ");
              while($kptt_nota_d->nextRow())
              {
              ?>
              <tr id="node-<?=$i?>">
                  <td>
                  	<input type="text" name="reqNoUrut[]" class="easyui-validatebox" value="<?=$i?>" />
                  </td>
              <td>
			    <input id="reqKodeKartu<?=$checkbox_index?>" value="<?=$kptt_nota_d->getField("MPLG_KODE")?>" name="reqKodeKartu[]" style="width:90%"  readonly />
              	<input type="hidden" id="reqKlasTrans<?=$checkbox_index?>" name="reqKlasTrans[]"
                value="<?=$kptt_nota_d->getField("KLAS_TRANS")?>" tabindex="<? $last_tab++; echo $last_tab ?>" />
              </td>
              <td>
                <input id="reqNamaKartu<?=$checkbox_index?>" value="<?=$kptt_nota_d->getField("MPLG_NAMA")?>" name="reqNamaKartu[]" style="width:90%"  readonly />
			  	<input type="hidden" name="reqPajak[]" id="reqPajak<?=$checkbox_index?>" 
                value="<?=$kptt_nota_d->getField("STATUS_KENA_PAJAK")?>" />
              	<?php /*?><input type="text" name="reqPajak[]" id="reqPajak<?=$checkbox_index?>" class="easyui-validatebox" value="<?=$kptt_nota_d->getField("STATUS_KENA_PAJAK")?>" readonly /><?php */?>
              </td>
              <td>
              	<input type="text" name="reqNilaiJasa[]"  id="reqNilaiJasa<?=$checkbox_index?>" style="text-align:right" OnFocus="FormatAngka('reqNilaiJasa<?=$checkbox_index?>')" OnKeyUp="FormatUang('reqNilaiJasa<?=$checkbox_index?>'); hitungSemua('<?=$checkbox_index?>');" OnBlur="FormatUang('reqNilaiJasa<?=$checkbox_index?>')" value="<?=numberToIna($kptt_nota_d->getField('JML_VAL_TRANS'))?>" tabindex="<? $last_tab++; echo $last_tab ?>">                
              </td>
              <td>
              	<input type="text" name="reqKeteranganTambah[]" id="reqKeteranganTambah<?=$checkbox_index?>" style="width:98%;" class="easyui-validatebox" <?php /*?>readonly<?php */?> value="<?=$kptt_nota_d->getField("KET_TAMBAHAN")?>" tabindex="<? $last_tab++; echo $last_tab ?>" />
              </td>
              </tr>
			  <?
                $i++;
                $checkbox_index++;
                $temp_jml_trans += dotToNo($kptt_nota_d->getField('JML_VAL_TRANS'));
                $temp_jml_pajak += dotToNo($kptt_nota_d->getField('JML_VAL_PAJAK'));
              }
              ?>
        </tbody>
        
        <tfoot class="altrowstable">
        	<tr style="background:#f1f4fc">
            	<td colspan="3">&nbsp;</td>
            	<td><input type="text" id="reqJumlahTrans" name="reqJumlahTrans" style="text-align:right; background-color:#f0f0f0" readonly value="<?=numberToIna($temp_jml_trans)?>" />
                	</td>
            	<td style="text-align:right">Jumlah Pajak <input type="text" id="reqJumlahPajak" name="reqJumlahPajak" style="text-align:right; background-color:#f0f0f0" readonly value="<?=numberToIna(dotToComma($temp_jml_pajak))?>" />&nbsp;
                    </td>
            </tr>
        </tfoot>
    </table>
    <div>
        <input type="hidden" name="reqPersenPajak" id="reqPersenPajak" class="easyui-numberbox" maxlength="3" style="width:30px" value="<?=(int)$tempPersenPajak?>" />
        <input type="hidden" name="reqId" value="<?=$reqId?>">
        <input type="hidden" name="reqMode" value="<?=$reqMode?>">
        <input type="hidden" name="reqPpnMaterai" id="reqPpnMaterai" value="<?=$ppn_materai?>">
       
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


$('input[id^="reqKeteranganTambah"]').keydown(function(e) {
	if(e.which==13)
	{
		addRow();		
	}
});

$("#reqNoRefLain, #reqKodeKapal, #reqKeterangan, #reqFakturPajakPrefix").keyup(function(e) {
	forceupper(this)
	//var temp= this.value.toUpperCase();
	//$(this).val(temp);
});

</script>
</body>
</html>