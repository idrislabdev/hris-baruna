<?
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base-gaji/GajiPeriodeCapegPKWT.php");
include_once("../WEB-INF/classes/base-gaji/GajiPeriode.php");
include_once("../WEB-INF/classes/base-gaji/ProsesGajiLock.php");



$gaji_periode_capeg_pkwt = new GajiPeriodeCapegPKWT();
$gaji_periode = new GajiPeriode();
$proses_gaji_lock = new ProsesGajiLock();

$userLogin = new UserLogin();


$reqMode = httpFilterGet("reqMode");
$reqId = httpFilterGet("reqId");

$reqBayarAwal = $gaji_periode->getPeriodeMax(array());
$reqBayarAkhir = $gaji_periode_capeg_pkwt->getPeriodeMax(array());

$lock_proses = $proses_gaji_lock->getProsesGajiLock(array("PERIODE" => $reqBayarAwal, "JENIS_PROSES" => "GAJI_PERBANTUAN_ORGANIK"));
//echo $lock_proses->query; exit;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	<title>Kalkulasi penghasilan</title>
    <link rel="stylesheet" type="text/css" href="../WEB-INF/lib/easyui/themes/default/easyui.css">
    <script type="text/javascript" src="../WEB-INF/js/jquery-1.6.1.min.js"></script>
    <script type="text/javascript" src="../WEB-INF/lib/easyui/jquery.easyui.min.js"></script>
    <script type="text/javascript" src="js/globalfunction.js"></script>
	<script type="text/javascript">
		$(function(){
			$('#ff').form({
				url:'../json-gaji/kalkulasi_penghasilan.php',
				onSubmit:function(){
					var win = $.messager.progress({
						title:'Please waiting',
						msg:'Kalkulasi penghasilan sedang diproses...'
					});					
					return $(this).form('validate');
				},
				success:function(data){
					//alert(data);
					$.messager.progress('close');
					$.messager.alert('Info', data, 'info');
					$('#rst_form').click();
					//top.frames['mainFrame'].location.reload();
					<? if($reqMode == "update") { ?> window.parent.divwin.close(); <? } ?>					
				}
			});
		});
		
		$('#btnKirimJurnal').on('click', function () {
			  	  //if(confirm('Kirim jurnal dan kunci proses bulan terpilih?'))
				  //{
					window.parent.OpenDHTML('proses_gaji_set_lock.php?reqJenisProses=GAJI_PERBANTUAN_ORGANIK&reqPeriode=<?=$reqBayarAwal?>', 'Office Management - Aplikasi Penghasilan', '600', '300');							    
					/*
					$.messager.prompt('Kirim Jurnal SIUK ', 'Masukkan Nota Dinas :', function(r){
						if (r){
						    //newWindow = window.open('rekapitulasi_absensi_per_tanggal_cetak.php?reqBulan='+$("#reqBulan").val()+'&reqTahun='+ $("#reqTahun").val()+'&reqHari='+r, 'Cetak');
						    //newWindow.focus();
							$.getJSON("../json-gaji/proses_gaji_set_lock.php?reqJenisProses=GAJI_PERBANTUAN_ORGANIK&reqPeriode="+ $("#reqPeriode").val()+"&reqNotaDinas=" + r,
							function(data){
							});	
							alert('Proses di bulan terpilih telah di kunci.');
						}
					});*/
				  //}
				  //$('.toggle').css({"display":"none"});
			  });			  

	</script>
    <link href="../WEB-INF/css/begron.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" type="text/css" href="../WEB-INF/css/admin.css">
</head>
<body onLoad="setValue();">
<div id="begron"><img src="../WEB-INF/images/bg-kanan.jpg" width="100%" height="100%" alt="Smile"></div>
<div id="wadah">

    <div id="judul-halaman">
		<span><img src="../WEB-INF/images/panah-judul.png"> Kalkulasi Penghasilan</span>
    </div>
    <div id="konten">
		<?
        if($lock_proses == 1)
        {
        ?>
            <div style="margin-top:20px; margin-left:20px;">
            &nbsp;<a href="#" style="text-decoration:blink; color:red"><strong>Perhatian :</strong></a> Kalkulasi gaji periode <?=getNamePeriode($reqBayarAwal)?> dan <?=getNamePeriode($reqBayarAkhir)?> telah terkunci. 
            </div>	
        <?
        }
        else
        {
        ?>
        <form id="ff" method="post" novalidate>
        <table>
            <tr>
                <td>Gaji Perbantuan Periode <?=getNamePeriode($reqBayarAwal)?></td>
                <td>
                    <input type="checkbox" id="reqGajiPerbantuan" name="reqGajiPerbantuan" value="1" <? if($tempGajiPerbantuan == 1) echo "checked"; ?>>
                </td>
            </tr>
    
            <tr>
                <td>Gaji Dewan Direksi, Komisaris Periode <?=getNamePeriode($reqBayarAwal)?></td>
                <td>
                    <input type="checkbox" id="reqGajiDewanDireksi" name="reqGajiDewanDireksi" value="1" <? if($tempGajiDewanDireksi == 1) echo "checked"; ?>>
                </td>
            </tr>
    
            <tr>
                <td>Gaji Organik Periode <?=getNamePeriode($reqBayarAkhir)?></td>
                <td>
                    <input type="checkbox" id="reqGajiOrganik" name="reqGajiOrganik" value="1" <? if($tempGajiPerbantuan == 1) echo "checked"; ?>>
                </td>
            </tr>
    
            <tr>
                <td>Gaji PTTPK Periode <?=getNamePeriode($reqBayarAkhir)?></td>
                <td>
                    <input type="checkbox" id="reqGajiPttpk" name="reqGajiPttpk" value="1" <? if($tempGajiPttpk == 1) echo "checked"; ?>>
                </td>
            </tr>     
            <tr>
                <td>Gaji PKWT Periode <?=getNamePeriode($reqBayarAkhir)?></td>
                <td>
                    <input type="checkbox" id="reqGajiPkwt" name="reqGajiPkwt" value="1" <? if($tempGajiPkwt == 1) echo "checked"; ?>>
                </td>
            </tr>
            <tr>
                <td>Gaji PKWT Khusus Periode <?=getNamePeriode($reqBayarAkhir)?></td>
                <td>
                    <input type="checkbox" id="reqGajiPkwtKhusus" name="reqGajiPkwtKhusus" value="1" <? if($tempGajiPkwtKhusus == 1) echo "checked"; ?>>
                </td>
            </tr>                  
        </table>
            <div>
                <input type="hidden" name="reqBayarAwal" value="<?=$reqBayarAwal?>">
                <input type="hidden" name="reqBayarAkhir" value="<?=$reqBayarAkhir?>">
                <input type="submit" <? /*if ($userLogin->pegawaiId<>1456) echo "disabled" */ ?> value="Proses">
            </div>
        </form>
    </div>
    <div id="judul-halaman">
		<span><img src="../WEB-INF/images/panah-judul.png"> Kirim Jurnal</span>
    </div>
    
    <div id="konten">
        <form id="ff" method="post" novalidate>
        <table>
            <?php /*?><tr>
                <td>Gaji Perbantuan, Organik Periode <?=getNamePeriode($reqBayarAwal)?></td>
                <td>
                    <input type="checkbox" id="reqGajiPerbantuan" name="reqGajiPerbantuan" value="1" <? if($tempGajiPerbantuan == 1) echo "checked"; ?>>
                </td>
            </tr><?php */?>
        </table>
            <div>
               <input type="button" id="btnKirimJurnal" class="toggle" value="Kirim Jurnal">
            </div>
        </form>
    </div>
    <?
	}
	?>
</div>
</body>
</html>