<?
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/classes/base-operasional/KapalKru.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");

$kapal_kru = new KapalKru();
$reqId = httpFilterGet("reqId");

$kapal_kru->selectByParamsKapalPekerjaanPremi($reqId);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	<title>Form Validation - jQuery EasyUI Demo</title>
    <link href="../WEB-INF/css/begron.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" type="text/css" href="../WEB-INF/css/admin.css">
    <link rel="stylesheet" type="text/css" href="../WEB-INF/css/bluetabs.css" />
    <link rel="stylesheet" type="text/css" href="../WEB-INF/lib/easyui/themes/default/easyui.css">
	<link href="../WEB-INF/lib/media/themes/main_datatables.css" rel="stylesheet" type="text/css" /> 
    
    <script type="text/javascript" src="../WEB-INF/js/jquery-1.6.1.min.js"></script>
    <script type="text/javascript" src="../WEB-INF/lib/easyui/jquery.easyui.min.js"></script>
    <script type="text/javascript">
		$.fn.datebox.defaults.formatter = function(date){
			var y = date.getFullYear();
			var m = date.getMonth()+1;
			var d = date.getDate();
			return d+'-'+m+'-'+y;
		}
		
		$(function(){
			$('#ff').form({
				url:'../json-operasional/pegawai_kapal_histori_add.php',
				onSubmit:function(){
					return $(this).form('validate');
				},
				success:function(data){
					window.parent.frames['mainFramePop'].pesan_histori();
					window.parent.divwin.close();
					
				}				
			});
			
		});
		
	</script>
    
    <style>
	    .CodeMirror-scroll { height: 100%; overflow-x: auto;}
	</style>
    
    <style type="text/css" media="screen">
	  .scroll{
		width:965px;
		overflow:auto;
		margin:0; padding:5px; border:0;
		scrollbar-face-color: #6095C1;
		scrollbar-highlight-color: #C2D7E7;
		scrollbar-3dlight-color: #85AECF;
		scrollbar-darkshadow-color: #427AA8;
		scrollbar-shadow-color: #315B7D;
		scrollbar-arrow-color: #FFFFFF;
		scrollbar-track-color: #4DECF8S;
		text-align:justify;
		background-color: #E1F2FB;
	}
	* html .scroll{
		overflow-y: scroll; 
		overflow-x: hidden;
	}
    </style>
    
</head>
<body>
<div id="begron"><img src="../WEB-INF/images/bg-kanan.jpg" width="100%" height="100%" alt="Smile"></div>
<div id="wadah">
    <div id="judul-halaman">
                <span><img src="../WEB-INF/images/panah-judul.png"> Data Premi Khusus</span>
    </div>
    <!--<div id="bluemenu" class="bluetabs" style="background:url(../WEB-INF/css/media/bluetab.gif); width:100%; margin-top:0px;'"> 
        <ul>
            <li>
            <a href="#" onClick="$('#btnSubmit').click();">Simpan</a>
            </li>
        </ul>
    </div>-->
    <form id="ff" method="post" novalidate>
    <div class="content" style="height:100%; overflow:hidden; overflow:-x:hidden; overflow-y:auto; ">
        <table id="gradient-style" style="width:97%; height:100%">
        <thead>
        <tr>
            <th scope="col" style="text-align:center">No</th>
            <th scope="col" style="text-align:center">Nama</th>
            <th scope="col" style="text-align:center">NRP</th>
            <th scope="col" style="text-align:center">NPWP</th>
            <th scope="col" style="text-align:center">Jabatan</th>
            <th scope="col" style="text-align:center">% Premi</th>
            <th scope="col" style="text-align:center">Jumlah</th>
            <th scope="col" style="text-align:center">% Potongan</th>
            <th scope="col" style="text-align:center">Jumlah Potongan</th>
            <th scope="col" style="text-align:center">Dibayarkan</th>
        </tr>
        </thead>
        <tbody>
            <?
			$i=1;
            while($kapal_kru->nextRow())
			{
			?>
 			<tr>
                <td><?=$i?></td>
                <td><?=$kapal_kru->getField("NAMA")?></td>
                <td><?=$kapal_kru->getField("NRP")?></td>
                <td><?=$kapal_kru->getField("NPWP")?></td>
                <td><?=$kapal_kru->getField("JABATAN")?></td>
                <td><?=$kapal_kru->getField("PROSENTASE")?></td>
                <td><?=currencyToPage($kapal_kru->getField("JUMLAH"))?></td>
                <td><?=$kapal_kru->getField("PROSENTASE_POTONGAN")?></td>
                <td><?=currencyToPage($kapal_kru->getField("JUMLAH_POTONGAN"))?></td>
                <td><?=currencyToPage($kapal_kru->getField("DIBAYARKAN"))?></td>
            </tr>
            <?
				$i++;
			}
			?>
        </tbody>
        </table>
        <div style="display:none">
            <input type="hidden" name="reqMode" value="insert">
            <input type="hidden" name="reqId" value="<?=$reqId?>">
            <input type="submit" name="reqSubmit" id="btnSubmit" value="Submit">
            <input type="reset" id="rst_form">
        </div>
    </div>
    </form>
    
</div>
</body>
</html>