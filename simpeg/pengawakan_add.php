<?
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base-operasional/SuratPerintahPegawai.php");
include_once("../WEB-INF/classes/base-operasional/PegawaiKapal.php");

$surat_perintah_pegawai = new SuratPerintahPegawai();
$pegawai_kapal = new PegawaiKapal();
$reqMode = httpFilterGet("reqMode");
$reqId = httpFilterGet("reqId");
$reqUsulanKapalId = httpFilterGet("reqUsulanKapalId");
$reqUsulanKapalKruId = httpFilterGet("reqUsulanKapalKruId");
$reqUsulanKruJabatanId = httpFilterGet("reqUsulanKruJabatanId");


$surat_perintah_pegawai->selectByParams(array("SURAT_PERINTAH_PEGAWAI_ID" => $reqId));
$surat_perintah_pegawai->firstRow();
$tempNama = $surat_perintah_pegawai->getField("NAMA");
$tempKapalAsal = $surat_perintah_pegawai->getField("KAPAL_AWAL");	
$tempJabatanAsal = $surat_perintah_pegawai->getField("JABATAN_AWAL");	
$tempKapalBaru = $surat_perintah_pegawai->getField("KAPAL_AKHIR");	
$tempJabatanBaru = $surat_perintah_pegawai->getField("JABATAN_AKHIR");	
$tempTanggalMasuk = dateToPageCheck($surat_perintah_pegawai->getField("TANGGAL_MASUK"));	
$tempValidasi = $surat_perintah_pegawai->getField("STATUS_VALIDASI");
$tempPegawaiId = $surat_perintah_pegawai->getField("PEGAWAI_ID");
$tempKapalIdAsal = $surat_perintah_pegawai->getField("KAPAL_ID_AWAL");

$pegawai_kapal->selectByParamsPosisiTerakhir(array("C.KAPAL_KRU_ID" => $surat_perintah_pegawai->getField("KAPAL_KRU_ID")));
$pegawai_kapal->firstRow();

if($pegawai_kapal->getField("PEGAWAI_KAPAL_ID") == "")
{}
else
	$pesan = "Posisi ".$pegawai_kapal->getField("JABATAN")." diisi oleh ".$pegawai_kapal->getField("NAMA").", posisi otomatis akan di off-hire.";

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	<title>Form Validation - jQuery EasyUI Demo</title>
    <link rel="stylesheet" type="text/css" href="../WEB-INF/lib/easyui/themes/default/easyui.css">
    <script type="text/javascript" src="../WEB-INF/js/jquery-1.6.1.min.js"></script>
    <script type="text/javascript" src="../WEB-INF/lib/easyui/jquery.easyui.min.js"></script>
    <script type="text/javascript" src="../WEB-INF/lib/easyui/kalender-easyui.js"></script>
	<script type="text/javascript">
		
		$(function(){
			$('#ff').form({
				url:'../json-simpeg/pengawakan_add.php',
				onSubmit:function(){
					if($("#reqPersetujuan") == "")
					{
						alert("Pilih persetujuan");
						return false;
					}
					return $(this).form('validate');
				},
				success:function(data){
					$.messager.alert('Info', data, 'info');
					$('#rst_form').click();
					top.frames['mainFrame'].location.reload();
					<? if($reqMode == "update") { ?> window.parent.divwin.close(); <? } ?>					
				}
			});
		});
	</script>
    
    <link href="../WEB-INF/css/begron.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" type="text/css" href="../WEB-INF/css/admin.css">
<!-- POPUP WINDOW -->
<link rel="stylesheet" href="../WEB-INF/lib/DHTMLWindow/windowfiles/dhtmlwindow.css" type="text/css" />
<script type="text/javascript" src="../WEB-INF/lib/DHTMLWindow/windowfiles/dhtmlwindow.js"></script>

<script language="JavaScript">
		
	if(<?=$tempValidasi?> == "0")
	{}
	else
	{
		alert("Data sudah divalidasi.");
		window.parent.divwin.close();	
	}
	function OpenDHTML(opAddress, opCaption, opWidth, opHeight)
	{
		//var left = (screen.width/2)-(opWidth/2); 
		var wLeft = window.screenLeft ? window.screenLeft : window.screenX;
		var wTop = window.screenTop ? window.screenTop : window.screenY;
	
		var left = wLeft + (window.innerWidth / 2) - (opWidth / 2);
		var top = wTop + (window.innerHeight / 2) - (opHeight / 2);	
		
		divwin=dhtmlwindow.open('divbox', 'iframe', opAddress, opCaption, 'width='+opWidth+'px,height='+opHeight+'px,left='+left+',top='+top+',resize=1,scrolling=1,midle=1'); return false;
	}

			  
	$('#btnSetuju').on('click', function () {
		if(confirm("<?=$pesan?> Setujui usulan pengawakan?"))
		{
			$("#reqPersetujuan").val("1");	
			$("#btnSubmit").click();
		}
	});
	
	
	$('#btnTolak').on('click', function () {
		if(confirm("<?=$pesan?> Tolak usulan pengawakan?"))
		{
			$("#reqPersetujuan").val("2");	
			$("#btnSubmit").click();
		}
	});			  
</script>
</head>
<body>
<div id="begron"><img src="../WEB-INF/images/bg-kanan.jpg" width="100%" height="100%" alt="Smile"></div>
<div id="wadah">

    <div id="judul-halaman">
                <span><img src="../WEB-INF/images/panah-judul.png">Validasi Usulan Pengawakan</span>
    </div>
    <form id="ff" method="post" novalidate>
    <table>
        <tr>
            <td>Nama</td>
            <td>
                <input name="reqNama" id="reqNama" class="easyui-validatebox" required <? if($reqMode == "insert") { ?> readonly <? } ?> title="Nama harus diisi" size="48" type="text" value="<?=$tempNama?>" />                
            </td>
        </tr>
        <tr>
            <td valign="top">Asal</td>
            <td>
            	<table>
                <tr>               
                <td>Kapal</td><td><input name="reqKapalAsal" id="reqKapalAsal"  readonly style="background-color:#E3E3E3" class="easyui-validatebox" size="40" type="text" value="<?=$tempKapalAsal?>" /></td>
                </tr>
                <tr>
                <td>Jabatan</td><td><input name="reqJabatanAsal" id="reqJabatanAsal" readonly style="background-color:#E3E3E3" class="easyui-validatebox" size="40" type="text" value="<?=$tempJabatanAsal?>" /></td>
                </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td valign="top">Penempatan Baru</td>
            <td>
            	<table>
                <tr>               
                <td>Kapal</td><td><input name="reqKapalBaru" id="reqKapalBaru"  readonly style="background-color:#E3E3E3" class="easyui-validatebox" size="40" type="text" value="<?=$tempKapalBaru?>" /></td>
                </tr>
                <tr>
                <td>Jabatan</td><td><input name="reqJabatanBaru" id="reqJabatanBaru" readonly style="background-color:#E3E3E3" class="easyui-validatebox" size="40" type="text" value="<?=$tempJabatanBaru?>" /></td>
                </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td>Tanggal Masuk</td>
            <td>
                <input id="reqTanggalMasuk" name="reqTanggalMasuk" class="easyui-validatebox" readonly style="background-color:#E3E3E3" value="<?=$tempTanggalMasuk?>">
            </td>
        </tr>
    </table>    
        <div>
            <input type="hidden" name="reqId" value="<?=$reqId?>">
            <input type="hidden" name="reqPegawaiKapalId" value="<?=$pegawai_kapal->getField("PEGAWAI_KAPAL_ID")?>">         
            <input type="hidden" name="reqKapalKruId" value="<?=$pegawai_kapal->getField("KAPAL_KRU_ID")?>">            
            <input type="hidden" name="reqKapalId" value="<?=$pegawai_kapal->getField("KAPAL_ID")?>">      
            <input type="hidden" name="reqKapalIdAsal" value="<?=$tempKapalIdAsal?>">                  
            <input type="hidden" name="reqMode" value="<?=$reqMode?>">
            <input type="hidden" name="reqPegawaiId" value="<?=$tempPegawaiId?>">
            <input type="hidden" name="reqPersetujuan" id="reqPersetujuan">
            <input type="button" name="btnSetuju" id="btnSetuju" value="Setuju">
            <input type="button" name="btnTolak" id="btnTolak" value="Tolak">
            <input type="submit" name="btnSubmit" id="btnSubmit" value="Submit" style="display:none">
        </div>
    </form>
</div>
</body>
</html>