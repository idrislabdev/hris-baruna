<?
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/classes/base-operasional/KapalKru.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");

$kapal_kru = new KapalKru();
$reqId = httpFilterGet("reqId");
$reqPeriode = httpFilterGet("reqPeriode");

$kapal_kru->selectByParamsKapalPremi($reqId, $reqPeriode);
$i=0;
while($kapal_kru->nextRow())
{
	$arrKapalKru[$i]["PREMI_JSON"] 			= $kapal_kru->getField("PREMI_JSON");
	$arrKapalKru[$i]["AWAK_KAPAL"] 			= $kapal_kru->getField("AWAK_KAPAL");
	$arrKapalKru[$i]["NRP"] 				= $kapal_kru->getField("NRP");
	$arrKapalKru[$i]["NPWP"] 				= $kapal_kru->getField("NPWP");
	$arrKapalKru[$i]["KELAS"] 				= $kapal_kru->getField("KELAS");
	$arrKapalKru[$i]["JABATAN"] 			= $kapal_kru->getField("JABATAN");
	$arrKapalKru[$i]["REALISASI_PRODUKSI"] 	= $kapal_kru->getField("REALISASI_PRODUKSI");
	$arrKapalKru[$i]["INTERVAL_PRODUKSI"] 	= $kapal_kru->getField("INTERVAL_PRODUKSI");
	$arrKapalKru[$i]["TARIF_NORMAL"] 		= $kapal_kru->getField("TARIF_NORMAL");
	$arrKapalKru[$i]["FAKTOR_KONVERSI"] 	= $kapal_kru->getField("FAKTOR_KONVERSI");
	$arrKapalKru[$i]["PRODUKSI_MAKSIMAL"] 	= $kapal_kru->getField("PRODUKSI_MAKSIMAL");
	$arrKapalKru[$i]["PRODUKSI_NORMAL"] 	= $kapal_kru->getField("PRODUKSI_NORMAL");
	$arrKapalKru[$i]["TARIF_MAKSIMAL"] 		= $kapal_kru->getField("TARIF_MAKSIMAL");
	$arrKapalKru[$i]["MASUK_KERJA"] 			= $kapal_kru->getField("MASUK_KERJA");
	$arrKapalKru[$i]["MASA_KERJA"] 			= $kapal_kru->getField("MASA_KERJA");
	$arrKapalKru[$i]["PPH"] 				= $kapal_kru->getField("PPH");
	$i++;	
}

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
                <span><img src="../WEB-INF/images/panah-judul.png"> Data Premi</span>
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
    <div class="scroll">
        <table id="gradient-style" style="width:150%; height:100%">
        <thead>
        <tr>
            <th rowspan="3" scope="col" style="text-align:center">No</th>
            <th rowspan="3" scope="col" style="text-align:center">Nama</th>
            <th rowspan="3" scope="col" style="text-align:center">NIPP</th>
            <th rowspan="3" scope="col" style="text-align:center">NPWP</th>
            <th rowspan="3" scope="col" style="text-align:center">KJ</th>
            <th rowspan="3" scope="col" style="text-align:center">Jabatan</th>
            <th rowspan="3" scope="col" style="text-align:center; width:30px;">Realisasi Produk<br>(jam)</th>
            
            <th colspan="3" scope="col" style="text-align:center">Besaran Insentif</th>
            
            <th rowspan="3" scope="col" style="text-align:center" width="30px;">Faktor <br>Konversi</th>
            
            <th rowspan="2" scope="col" style="text-align:center">Jumlah</th>
            <th colspan="3" scope="col" style="text-align:center">Insentif Kelebihan Produksi</th>
            <th colspan="3" style="text-align:center">Total</th>
            <th colspan="2" scope="col" style="text-align:center">Pph Pasal 21</th>
            <th rowspan="2" scope="col" style="text-align:center">Insentif yang diterima</th>
        </tr>
        <tr>
            <th colspan="2" scope="col" style="text-align:center">Produksi Jam</th>
            <th scope="col" style="text-align:center">Tarif / Jam</th>
            
            <th scope="col" style="text-align:center">Produksi Jam</th>
            <th scope="col" style="text-align:center">Tarif / Jam</th>
            <th scope="col" style="text-align:center">Jumlah</th>
            
            <th scope="col" style="text-align:center">HK</th>
            <th scope="col" style="text-align:center">MK</th>
            <th scope="col" style="text-align:center">Insentif</th>
            
            <th scope="col" style="text-align:center">(%)</th>
            <th scope="col" style="text-align:center">(Rupiah)</th>
        </tr>
        <tr>
            <th scope="col" style="text-align:center"><?=$arrKapalKru[0]["PRODUKSI_NORMAL"]?></th>
            <th scope="col" style="text-align:center"><?=$arrKapalKru[0]["PRODUKSI_MAKSIMAL"]?></th>
            
            <th scope="col" style="text-align:center">( Rp. )</th>
            <th scope="col" style="text-align:center">( Rp. )</th>
            <th scope="col" style="text-align:center"><?=$arrKapalKru[0]["PRODUKSI_MAKSIMAL"]?></th>
            <th scope="col" style="text-align:center">( Rp. )</th>
            <th scope="col" style="text-align:center">( Rp. )</th>
            <th scope="col" style="text-align:center">( hari )</th>
            <th scope="col" style="text-align:center">( hari )</th>
            <th scope="col" style="text-align:center">( Rp. )</th>
            <th scope="col" style="text-align:center">( Rp. )</th>
            <th scope="col" style="text-align:center">( Rp. )</th>
            <th scope="col" style="text-align:center">( Rp. )</th>
        </tr>
        </thead>
        <tbody>
        	<? 
			for($i=0;$i<count($arrKapalKru);$i++)
			{
				$json_premi = json_decode($arrKapalKru[$i]["PREMI_JSON"]);
			?>
            <tr>
                <td><?=$i+1?></td>
                <td><?=$arrKapalKru[$i]["AWAK_KAPAL"]?></td>
                <td><?=$arrKapalKru[$i]["NRP"]?></td>
                <td><?=$arrKapalKru[$i]["NPWP"]?></td>
                <td align="center"><?=$arrKapalKru[$i]["KELAS"]?></td>
                <td><?=$arrKapalKru[$i]["JABATAN"]?></td>
                <td align="center"><?=$arrKapalKru[$i]["REALISASI_PRODUKSI"]?></td>
                <td colspan="2" align="center"><?=$arrKapalKru[$i]["INTERVAL_PRODUKSI"]?></td>
                <td align="center"><?=currencyToPage($arrKapalKru[$i]["TARIF_NORMAL"], "")?></td>
                <td align="center"><?=$arrKapalKru[$i]["FAKTOR_KONVERSI"]?></td>
                <td align="center"><?=currencyToPage($json_premi->{"PREMI"}{0}, "")?></td>
                <?
                if($arrKapalKru[$i]["REALISASI_PRODUKSI"] < $arrKapalKru[$i]["PRODUKSI_MAKSIMAL"])
					$jam = 0;
				else
					$jam = ($arrKapalKru[$i]["REALISASI_PRODUKSI"] - $arrKapalKru[$i]["PRODUKSI_MAKSIMAL"]);
				?>
                <td align="center"><?=$jam?></td>
                <td align="center"><?=currencyToPage($arrKapalKru[$i]["TARIF_MAKSIMAL"], "")?></td>
                <td align="center"><?=currencyToPage($json_premi->{"PREMI"}{1}, "")?></td>
                <td align="center"><?=$arrKapalKru[$i]["MASA_KERJA"]?></td>
                <td align="center"><?=$arrKapalKru[$i]["MASUK_KERJA"]?></td>
                <td align="center"><?=currencyToPage($json_premi->{"PREMI"}{2}, "")?></td>
                <td align="center"><?=$arrKapalKru[$i]["PPH"]?></td>
                <td align="center"><?=currencyToPage($json_premi->{"PREMI"}{3}, "")?></td>
                <td align="center"><?=currencyToPage($json_premi->{"PREMI"}{4}, "")?></td>
            </tr>
            <? 
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
    </div>
    </form>
    
</div>
</body>
</html>