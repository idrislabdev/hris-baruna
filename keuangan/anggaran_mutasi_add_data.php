<?
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base-anggaran/AnggaranMutasi.php");

$anggaran_mutasi = new AnggaranMutasi();

$reqId = httpFilterGet("reqId");
$reqRowId = httpFilterGet("reqRowId");
$reqPeriode= httpFilterGet("reqPeriode");
$reqMode = httpFilterGet("reqMode");

if($reqId == "")
{
	$reqMode = "insert";
}
else
{
	$reqMode = "update";
	$anggaran_mutasi->selectByParams(array("ANGGARAN_MUTASI_ID"=>$reqId), -1, -1);
	$anggaran_mutasi->firstRow();
	
	$tempIdAnggaran = $anggaran_mutasi->getField("ANGGARAN_ID");
	$tempBukuPusat = $anggaran_mutasi->getField("KD_BUKU_PUSAT");
	$tempBukuBesar = $anggaran_mutasi->getField("KD_BUKU_BESAR");
	$tempTanggal = dateToPageCheck($anggaran_mutasi->getField("TANGGAL"));
	$tempJumlah = $anggaran_mutasi->getField("JUMLAH");
	$tempProsentasePph = $anggaran_mutasi->getField("");
	$tempPph = $anggaran_mutasi->getField("PPH");
	$tempStatusVerifikasi = $anggaran_mutasi->getField("STATUS_VERIFIKASI");    
}

$tempProsentasePph= 10;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	<title>Form Validation - jQuery EasyUI Demo</title>

    
    <link href="../WEB-INF/lib/easyui/themes/default/easyui.css" rel="stylesheet" type="text/css">
    <script type="text/javascript" src="js/jquery-1.6.1.min.js"></script>
    <script type="text/javascript" src="../WEB-INF/lib/easyui/jquery.easyui.min.js"></script>
    <script type="text/javascript" src="js/globalfunction.js"></script>
    <script type="text/javascript" src="../WEB-INF/lib/easyui/kalender.js"></script>
    
	<script type="text/javascript">
		function setValue(){
			//parent.frames["mainFrameDetilPop"].document.getElementById("reqId").value = '<?=$tempNoBukti?>';
		}
		
		function setJumlah(value)
		{
			var pph=0;
			$("#reqJumlah").val(FormatCurrency(value));
			
			//pph= value - (value * ( parseFloat($("#reqProsentasePph").val()) / 100));
			pph= value * ( parseFloat($("#reqProsentasePph").val()) / 100);
			$("#reqPph").val(FormatCurrency(pph));
		}
		
		var mutasi_id="";
		$(function(){
			$('#ff').form({
				url:'../json-anggaran/anggaran_mutasi_add_data.php',
				onSubmit:function(){
					return $(this).form('validate');
				},
				success:function(data){
					data = data.split("-");
					//$.messager.alert('Info', data, 'info');
					mutasi_id = data[0];
					setTimeout(setId, 10);
				}
			});
			
		});
		
		function setId()
		{
			<?
			if($reqId == "")
			{
			?>
			parent.frames["mainFrameDetilPop"].document.getElementById("reqId").value = mutasi_id;
			<?
			}
			?>
			document.location.href = 'anggaran_mutasi_add_data.php?reqId=<?=$reqId?>&reqPeriode=<?=$reqPeriode?>';
			setTimeout(reloadSubmit, 50);
		}
		
		function reloadSubmit()
		{
			parent.frames["mainFrameDetilPop"].document.getElementById("btnSubmit").click();
			top.frames['mainFrame'].location.reload();
		}
		
	</script>
    <link href="../WEB-INF/css/begron.css" rel="stylesheet" type="text/css">
    <link href="../WEB-INF/css/admin.css" rel="stylesheet" type="text/css">
    <!--<script language="javascript" type="text/javascript" src="../WEB-INF/lib/tiny_mce/tiny_mce.js"></script>
    <script language="javascript" type="text/javascript" src="../jslib/configTextEditorAdm.js"></script> -->
    <!-- POPUP WINDOW -->
    <link rel="stylesheet" href="../WEB-INF/lib/DHTMLWindow/windowfiles/dhtmlwindow.css" type="text/css" />
    <script type="text/javascript" src="../WEB-INF/lib/DHTMLWindow/windowfiles/dhtmlwindow.js"></script>
	<script>
		function OpenDHTML(opAddress, opCaption, opWidth, opHeight)
		{
			//var left = (screen.width/2)-(opWidth/2);
			var left=50;
			
			divwin=dhtmlwindow.open('divbox', 'iframe', opAddress, opCaption, 'width='+opWidth+'px,height='+opHeight+'px,left='+left+',top=20,resize=1,scrolling=1,midle=1'); return false;
		}
		    
		function openPencarianAnggaran()
		{
			parent.OpenDHTML('anggaran_pencarian.php', 'Pencarian Anggaran', 900, 600);	
		}
		
		function OptionSet(id, bukupusat, bukubesar){
			document.getElementById('reqIdAnggaran').value = id;
			document.getElementById('reqBukuPusat').value = bukupusat;
			document.getElementById('reqBukuBesar').value = bukubesar;		
		}

    </script>

<style type="text/css">
div.message{
background: transparent url(msg_arrow.gif) no-repeat scroll bottom left;
padding-bottom: 5px;
}

div.error{
background-color:#F3E6E6;
border-color: #924949;
/*border-style: solid solid solid none;*/
border-style: solid solid solid solid;
border-width: 1px;
padding: 5px;
}
</style>
</head>
     
</head>
<body onLoad="setTimeout(setValue, 2000);">
<div id="begron"><img src="../WEB-INF/images/bg-kanan.jpg" width="100%" height="100%" alt="Smile"></div>
<div id="wadah">

    <div id="judul-halaman">
                <span><img src="../WEB-INF/images/panah-judul.png"> Data Pengguaan Anggaran</span>
    </div>
    <form id="ff" method="post" novalidate>
    <table>
        <tr>           
             <td>Buku Pusat</td>
			 <td>
				<input type="hidden" id="reqIdAnggaran" name="reqIdAnggaran" size="30" type="text" value="<?=$tempIdAnggaran?>" />
                <input id="reqBukuPusat" name="reqBukuPusat" class="easyui-validatebox" required size="50" type="text" value="<?=$tempBukuPusat?>" />&nbsp;&nbsp;
                <img src="../WEB-INF/images/group.png" onClick="openPencarianAnggaran()">
			</td>
        </tr>
        <tr>
            <td>Buku&nbsp;Besar</td>
            <td>
            	<input id="reqBukuBesar" name="reqBukuBesar" size="50" type="text" value="<?=$tempBukuBesar?>" />
            </td>
        <tr>        
             <td>Tanggal</td>
			 <td>
             	<input id="reqTanggal" name="reqTanggal" class="easyui-datebox" data-options="validType:'date'" value="<?=$tempTanggal?>" />
			</td>
        </tr>
        <tr>           
             <td>Jumlah</td>
			 <td>
				<input name="reqJumlah" type="text" id="reqJumlah" readonly class="easyui-validatebox" size="20" value="<?=numberToIna($tempJumlah)?>" />
                &nbsp;&nbsp;&nbsp;&nbsp;
                Prosentase
                <input type="text" name="reqProsentasePph" id="reqProsentasePph" size="5" value="<?=$tempProsentasePph?>" />
                PPH
                &nbsp;&nbsp;&nbsp;&nbsp;
                <input name="reqPph" type="text" id="reqPph" readonly class="easyui-validatebox" size="20" value="<?=numberToIna($tempPph)?>" />
			</td>
        </tr>
        <?php /*?><tr>           
             <td>Status Verifikasi</td>
			 <td>
             
				<input name="reqStatusVerifikasi" class="easyui-validatebox" type="checkbox" value="<?=$tempStatusVerifikasi?>" />
			</td>            
		</tr><?php */?>
    </table>
        <div>
            <input type="hidden" name="reqId" value="<?=$reqId?>">
            <input type="hidden" name="reqPeriode" value="<?=$reqPeriode?>">
            <input type="hidden" name="reqMode" value="<?=$reqMode?>">
            <input type="submit" value="Submit">
            <input type="reset" id="rst_form">
        </div>
    </form>
</div>
</body>
</html>