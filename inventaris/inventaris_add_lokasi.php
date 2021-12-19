<?
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base-inventaris/Inventaris.php");
include_once("../WEB-INF/classes/base-inventaris/Lokasi.php");

$lokasi = new Lokasi();
$inventaris= new Inventaris();

$reqMode = httpFilterGet("reqMode");
$reqId = httpFilterGet("reqId");
$reqInventarisId = httpFilterGet("reqInventarisId");

$reqLokasi = $lokasi->getLokasi($reqId);

$inventaris->selectByParams(array(),-1,-1, " AND A.INVENTARIS_ID = '".$reqInventarisId."'");
$inventaris->firstRow();
$tempJenisInventarisId = $inventaris->getField("JENIS_INVENTARIS_ID");
$tempSpesifikasi = trim($inventaris->getField("SPESIFIKASI"));
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Untitled Document</title>

<link href="../WEB-INF/css/begron.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" type="text/css" href="../WEB-INF/css/admin.css">	

<link rel="stylesheet" type="text/css" href="../WEB-INF/lib/easyui/themes/default/easyui.css">
<script type="text/javascript" src="../WEB-INF/js/jquery-1.6.1.min.js"></script>
<script type="text/javascript" src="../WEB-INF/lib/easyui/jquery.easyui.min.js"></script>
<script type="text/javascript" src="../WEB-INF/lib/easyui/kalender-easyui.js"></script>
<script type="text/javascript" src="../WEB-INF/lib/easyui/globalfunction.js"></script>

<script language="Javascript">
<? include_once "../jslib/formHandler.php"; ?>
</script>

<script type="text/javascript">	
	
	$(function(){
		$('#ff').form({
			url:'../json-inventaris/inventaris_add_lokasi.php',
			onSubmit:function(){
				return $(this).form('validate');
			},
			success:function(data){
				$.messager.alert('Info', data, 'info');
				$('#rst_form').click();
				top.frames['mainFrame'].location.reload();
				window.parent.frames['mainFramePop'].location.href = 'pendataan_add_monitoring.php?reqId=<?=$reqId?>';				
				window.parent.frames['mainFrameDetilPop'].location.href = 'pendataan_add_data.php?reqId=<?=$reqId?>';
			}
		});
		
	});
	
</script>
<style>
.combo span{
	width:300px !important;	
}
</style>
</head>
<body>
<div id="begron"><img src="../WEB-INF/images/bg-kanan.jpg" width="100%" height="100%" alt="Smile"></div>
<div id="wadah">

    <div id="judul-halaman">
                <span><img src="../WEB-INF/images/panah-judul.png">Pindah Asset</span>
    </div>
    	<form id="ff" method="post" novalidate enctype="multipart/form-data">
    	<div id="popup-tabel2">
    	<table>
        	<tr>
                <td>Lokasi</td>
                <td>:</td>
                <td>
                <?=$reqLokasi?>
                </td>
            </tr> 
            <tr>
                <td>Asset</td>
                <td>:</td>
                <td>
                <?=$inventaris->getField("NAMA")?>
                </td>           
            </tr>
            <tr>
                <td>Lokasi Baru</td>
                <td>:</td>
                <td>
                <input id="cc" class="easyui-combotree" name="reqLokasiBaru" required data-options="url:'../json-inventaris/lokasi_combo_json.php'" style="width:350px;">
                </td>           
            </tr>
        	<tr>
            	<td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>
                    <input type="hidden" name="reqLokasiLama" value="<?=$reqId?>">
                    <input type="hidden" name="reqInventarisId" value="<?=$reqInventarisId?>">
                    <input type="hidden" name="reqMode" value="<?=$reqMode?>">
                	<input type="submit" value="Simpan" /> 
                    <input type="reset" value="Reset" />
                </td>
            </tr>
        </table>
        </div>
        </form>
        </div>
		<script>
        
        $("#reqJumlah").keypress(function(e) {
            //alert(e.which);e.which!=46 && 
            if( e.which!=8 && e.which!=0 && (e.which<48 || e.which>57))
            {
            return false;
            }
        });
        </script>
    </div>
</body>
</html>