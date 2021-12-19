<?
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base-absensi/AbsensiManual.php");

$absensi_manual = new AbsensiManual();
$reqId = httpFilterGet("reqId");
$tempDepartemen = $userLogin->idDepartemen;

if($reqId == "")
{
	$reqMode = "insert";	
}
else
{
	$reqMode = "update";	
	$absensi_manual->selectByParamsMonitoring(array('ABSENSI_MANUAL_ID'=>$reqId), -1, -1);
//	echo $absensi_manual->query;
	$absensi_manual->firstRow();

	$tempPegawaiId= $absensi_manual->getField('PEGAWAI_ID');
	$tempNRP= $absensi_manual->getField('NRP');
	$tempNama= $absensi_manual->getField('NAMA');
	$tempStatus= $absensi_manual->getField('STATUS');
	$tempJam= $absensi_manual->getField('JAM');
	$tempBukti= $absensi_manual->getField('BUKTI');
	$tempKeterangan= $absensi_manual->getField('KETERANGAN');
	
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	<title>Form Validation - jQuery EasyUI Demo</title>

    
    <link rel="stylesheet" type="text/css" href="../WEB-INF/lib/easyui/themes/default/easyui.css">
    <script type="text/javascript" src="../WEB-INF/js/jquery-1.6.1.min.js"></script>
    <script type="text/javascript" src="../WEB-INF/lib/easyui/jquery.easyui.min.js"></script>
	<script type="text/javascript" src="../WEB-INF/lib/colorpicker/js/jquery/jquery.js"></script>
	     <script type="text/javascript" src="../WEB-INF/lib/easyui/kalender-easyui.js"></script>
    <!--warna-->
	<script src="../WEB-INF/lib/colorpicker/jquery.colourPicker.js" type="text/javascript"></script>
	<link href="../WEB-INF/lib/colorpicker/jquery.colourPicker.css" rel="stylesheet" type="text/css">
    <!--warna-->   
	<script type="text/javascript">
		
		$(function(){
			$('#ff').form({
				url:'../json-absensi/absensi_manual_add.php',
				onSubmit:function(){
					return $(this).form('validate');
				},
				success:function(data){
					$.messager.alert('Info', data, 'info');
				}
					// $('#rst_form').click();
					// $('#cc').combotree('setValue', '<?=$tempDepartemen?>');
					// top.frames['mainFrame'].location.reload();
					// <? if($reqMode == "update") { ?> window.parent.divwin.close(); <? } ?>					
								
			});

		});
		</script>
        
         <link rel="stylesheet" href="../WEB-INF/lib/DHTMLWindow/windowfiles/dhtmlwindow.css" type="text/css" />
    <script type="text/javascript" src="../WEB-INF/lib/DHTMLWindow/windowfiles/dhtmlwindow.js"></script>
	<!-- <script>
	
		function OptionSet(id, nrp,nama, jabatan, lama_cuti)
		{
			alert(nrp);return false;
			document.getElementById('reqNRP').value = nrp;
			document.getElementById('reqNama').value = nama;
			//document.getElementById('reqJabatan').value = jabatan;
			document.getElementById('reqPegawaiId').value = id;		
			//document.getElementById('reqCutiDiambil').value = lama_cuti;			
		}
		
		function OpenDHTML(opAddress, opCaption, opWidth, opHeight)
		{
			var left = (screen.width/2)-(opWidth/2);
			//var left=50;
			
			divwin=dhtmlwindow.open('divbox', 'iframe', opAddress, opCaption, 'width='+opWidth+'px,height='+opHeight+'px,left='+left+',top=20,resize=1,scrolling=1,midle=1'); return false;
		}
		
		function openPencarianUser()
		{
			OpenDHTML('../simpeg/pegawai_pencarian.php', 'Pencarian User', 900, 700);	
		}
		
	</script> -->
    <link href="../WEB-INF/css/begron.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" type="text/css" title="blue" href="../WEB-INF/css/admin.css">
    <!--script language="javascript" type="text/javascript" src="../WEB-INF/lib/tiny_mce/tiny_mce.js"></script>
    <script language="javascript" type="text/javascript" src="../jslib/configTextEditorAdm.js"></script--> 

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
<!-- 
<body onLoad="setValue('<?=$tempIjinId?>','<?=$tempKeterangan?>');"> -->
<body>
<div id="begron"><img src="../WEB-INF/images/bg-kanan.jpg" width="100%" height="100%" alt="Smile"></div>
<div id="wadah">
    <div id="judul-halaman">
                <span><img src="../WEB-INF/images/panah-judul.png"> Tambah Data Absensi Manual</span>
    </div>
    <form id="ff" method="post" novalidate>
    <table>
        <tr>           
             <td>Nama</td>
			 <td><input type="hidden" name="reqPegawaiId" id="reqPegawaiId" value="<?=$tempPegawaiId?>"/>
				<input name="reqNRP" id="reqNRP" class="easyui-validatebox" required style="width:80px" type="hidden" value="<?=$tempNRP?>" />
				<input name="reqNama" id="reqNama" class="easyui-validatebox" readonly style="width:200px" type="text" value="<?=$tempNama?>" />
                &nbsp;&nbsp;
                <img src="../WEB-INF/images/group.png" onClick="openPencarianUser()">
			</td>			
        </tr>
        <tr>           
             <td>Jenis Absen</td>
			 <td>
                  <select name="reqStatus" id="reqStatus">
                  <option value="I" <? if("I" == $tempIjinId) echo "selected"; ?>>DATANG</option>
                  <option value="O" <? if("O" == $tempIjinId) echo "selected"; ?>>PULANG</option>
                  </select>
			</td>
        </tr>             
        <tr>
            <td>Jam</td>
            <td>
				<input id="dd" name="reqJam" class="easyui-datetimebox" value="<?=dateTimeToPageCheck($tempJam)?>" data-options="validType:'datetimebox'" ></input>                
            </td>
        </tr>
         <tr>           
             <td>Bukti</td>
			 <td>
                  <select name="reqBukti" id="reqBukti">
                  <option value="CCTV" <? if("CCTV" == $tempIjinId) echo "selected"; ?>>CCTV</option>
                  <option value="MANAGER" <? if("MANAGER" == $tempIjinId) echo "selected"; ?>>MANAGER</option>
                  </select>
			</td>
        </tr> 
        <tr>
            <td>Keterangan</td>
            <td>
            <textarea name="reqKeterangan" cols="40" rows="3"><?=$tempKeterangan?></textarea>
            </td>
        </tr>
    </table>
        <div>
            <input type="hidden" name="reqId" value="<?=$reqId?>">
            <input type="hidden" name="reqMode" value="<?=$reqMode?>">
            <input type="submit" value="Submit">
            <input type="reset" id="rst_form">
        </div>
    </form>
</div>
</body>
</html>