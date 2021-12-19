<?
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/classes/base-gaji/DaftarRekeningBank.php");
include_once("../WEB-INF/classes/base-simpeg/Bank.php");
include_once("../WEB-INF/classes/base-operasional/Kapal.php");

$rekbank = new DaftarRekeningBank();
$bank = new Bank();
$kapal = new Kapal();
ini_set('memory_limit', '1024M');

$reqMode = httpFilterGet("reqMode");
$jenis = httpFilterGet("jenis");
$refid = httpFilterGet("refid");
$tempRefId = 0;
$FILTER = "AND A.KAPAL_ID NOT IN (SELECT REF_ID FROM IMASYS_GAJI.DAFTAR_REKENING WHERE JENIS_REKENING = 'UANG_MAKAN_KAPAL')";
if($reqMode == "update")
{
	$rekbank->selectByParams(array("JENIS_REKENING" => $jenis,"REF_ID" => $refid));
	$rekbank->firstRow();
	
	$tempJenisRekening = $rekbank->getField('JENIS_REKENING');
	$tempRefId = $rekbank->getField("REF_ID");
	$tempRefNama = $rekbank->getField("NAMA_REFERENSI");
	$tempBankId = $rekbank->getField("BANK_ID");
	$tempNamaRekening = $rekbank->getField("NAMA_REKENING");
	$tempNoRekening = $rekbank->getField("NO_REKENING");
	$FILTER = "";
}

$bank->selectByParams();
$allRecord = $kapal->getCountByParams(array()," ");
$kapal->selectByParams(array(), $allRecord,-1, " " , " ORDER BY a.nama ");

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	<title>Form Validation - jQuery EasyUI Demo</title>
    <link rel="stylesheet" type="text/css" href="../WEB-INF/lib/easyui/themes/default/easyui.css">
    <script type="text/javascript" src="../WEB-INF/js/jquery-1.6.1.min.js"></script>
    <script type="text/javascript" src="../WEB-INF/lib/easyui/jquery.easyui.min.js"></script>
    <script type="text/javascript" src="../simpeg/js/globalfunction.js"></script>
    <!-- POPUP WINDOW -->
    <link rel="stylesheet" href="../WEB-INF/lib/DHTMLWindow/windowfiles/dhtmlwindow.css" type="text/css" />
    <script type="text/javascript" src="../WEB-INF/lib/DHTMLWindow/windowfiles/dhtmlwindow.js"></script>
	<script type="text/javascript">
		$(function(){
			$('#ff').form({
				url:'../json-gaji/daftar_rekening_bank_add.php',
				onSubmit:function(){
					return $(this).form('validate');
				},
				success:function(data){
					$.messager.alert('Info', data, 'info');
					$('#rst_form').click();
					top.frames['mainFrame'].location.reload();
					<? if($reqMode == "update") { ?> window.parent.divwin.close(); <? } ?>					
				}
			});
			$( document ).ready(function() {
  			// Handler for .ready() called.
			if (<?=$tempRefId?> == 0 ) {
			$('#reqRefId').val($("#reqRefKapal").val());
			}
			
			if($("#reqJenisRekening").val() == "UANG_MAKAN_KAPAL") {
				 $('#reqRefId').val($("#reqRefKapal").val());
				$('#reqOpenPegawai').hide(); 
				$('#reqNamaRef').hide();
				$('#reqRefKapal').show();
				
			 } else {
				 $('#reqNamaRef').show();
				 $('#reqOpenPegawai').show(); 
				 $('#reqRefKapal').hide();
			 }
			
			});
			
			$("#reqRefKapal").change(function() {
				document.getElementById('reqRefId').value = $("#reqRefKapal").val();
			//	$("#reqRefId").val() = $("#reqRefKapal").val();
			} );
			
			$("#reqJenisRekening").change(function() {
				//
			 if($("#reqJenisRekening").val() == "UANG_MAKAN_KAPAL") {
				 $('#reqRefId').val($("#reqRefKapal").val());
				$('#reqOpenPegawai').hide(); 
				$('#reqNamaRef').hide();
				$('#reqRefKapal').show();
				
			 } else {
				 $('#reqRefId').val("");
				 $('#reqNamaRef').show();
				 $('#reqNamaRef').val("");
				 $('#reqOpenPegawai').show(); 
				 $('#reqRefKapal').hide();
			 }
			} );
			
		});
		
			function OpenDHTML(opAddress, opCaption, opWidth, opHeight)
		{
			var left = (screen.width/2)-(opWidth/2);
			//var left=50;
			
			divwin=dhtmlwindow.open('divbox', 'iframe', opAddress, opCaption, 'width='+opWidth+'px,height='+opHeight+'px,left='+left+',top=20,resize=1,scrolling=1,midle=1'); return false;
		}
		    
		function openPencarianUser()
		{
			OpenDHTML('pegawai_pencarian.php', 'Pencarian User', 900, 700);	
		}
		
		function OptionSet(id, nrp,nama, jabatan, lama_cuti){
			document.getElementById('reqRefId').value = id;
			document.getElementById('reqNamaRef').value = nama;
			//document.getElementById('reqCutiDiambil').value = lama_cuti;			
		}
		
		
	</script>
    <link href="../WEB-INF/css/begron.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" type="text/css" href="../WEB-INF/css/admin.css">
</head>
<body onLoad="setValue();">
<div id="begron"><img src="../WEB-INF/images/bg-kanan.jpg" width="100%" height="100%" alt="Smile"></div>
<div id="wadah">

    <div id="judul-halaman">
                <span><img src="../WEB-INF/images/panah-judul.png"> Tambah Data Premi</span>
    </div>
    <form id="ff" method="post" novalidate>
    <table>
        <tr>
            <td>Jenis Rekening</td>
            <td>
            	<select id="reqJenisRekening" name="reqJenisRekening">
                	<option value="UANG_MAKAN_KAPAL" <? if("UANG_MAKAN_KAPAL" == $tempJenisRekening) echo 'selected';?>>UANG MAKAN KAPAL</option>
                    <option value="UANG_TRANSPORT" <? if("UANG_TRANSPORT" == $tempJenisRekening) echo 'selected';?>>UANG TRANSPORT</option>
                    <option value="UANG_INSENTIF" <? if("UANG_INSENTIF" == $tempJenisRekening) echo 'selected';?>>UANG INSENTIF</option>
                    <option value="UANG_PREMI" <? if("UANG_PREMI" == $tempJenisRekening) echo 'selected';?>>UANG PREMI</option>
                </select>
            </td>
        </tr>
        <tr>
            <td>Ref Id</td>
            <td>
            <input type="hidden" name="reqRefId" value="<?=$tempRefId?>" id="reqRefId" readonly />
            <input name="reqNamaRef" id="reqNamaRef" class="easyui-validatebox" required="true" <? if ($tempRefId <> 0) echo "value='".$tempRefNama."'" ?>" readonly style="width:300px;"  type="text" />
            	<select id="reqRefKapal" name="reqRefKapal">
                	<? while($kapal->nextRow()){?>
                	<option value="<?=$kapal->getField('KAPAL_ID')?>" <? if($kapal->getField('KAPAL_ID') == $tempRefId) echo 'selected';?>><?=$kapal->getField('NAMA')?></option>
                    <? }?>
                </select> <img id="reqOpenPegawai" name="reqOpenPegawai" src="../WEB-INF/images/group.png" onClick="openPencarianUser()">
            </td>
        </tr> 
        <tr>
            <td>Nama Bank</td>
            <td>
            	<select id="reqBankId" name="reqBankId">
                	<? while($bank->nextRow()){?>
                	<option value="<?=$bank->getField('BANK_ID')?>" <? if($bank->getField('BANK_ID') == $tempBankId) echo 'selected';?>><?=$bank->getField('NAMA')?></option>
                    <? }?>
                </select>
            </td>
        </tr>                
        <tr>
            <td>Nama Rekening</td>
            <td>
                <input name="reqNamaRekening" id="reqNamaRekening" class="easyui-validatebox" required="true" style="width:200px;"  type="text" value="<?=$tempNamaRekening?>" />
            </td>
        </tr>   
        <tr>
            <td>No Rekening</td>
            <td>
                <input name="reqNoRekening" id="reqNoRekening" class="easyui-validatebox" required="true" style="width:200px;"  type="text" value="<?=$tempNoRekening?>" />
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