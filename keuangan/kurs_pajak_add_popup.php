<?
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
//include_once("../WEB-INF/classes/base-keuangan/Valuta.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/SafrValuta.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/SafrValutaKursPajak.php");

$safr_valuta_kurs_pajak = new SafrValutaKursPajak();
$valuta = new SafrValuta();

$reqId = httpFilterGet("reqId");
$reqMode = httpFilterGet("reqMode");
$tempDepartemen = $userLogin->idDepartemen;

if($reqId == "")
{
	$reqMode = "insert";	
}
else
{
	$reqMode = "update";	
	//$safr_valuta_kurs_pajak->selectByParams(array('KURS_PAJAK_ID'=>$reqId), -1, -1);
	$safr_valuta_kurs_pajak->selectByParams(array(), -1, -1, " AND TGL_MULAI_RATE = ".dateToDBCheck(dateToPageCheck($reqId)));
	$safr_valuta_kurs_pajak->firstRow();
	
	$tempValutaId= $safr_valuta_kurs_pajak->getField('KODE_VALUTA');
	$tempTanggalMulai = dateToPageCheck($safr_valuta_kurs_pajak->getField('TGL_MULAI_RATE'));
	$tempTanggalSelesai = dateToPageCheck($safr_valuta_kurs_pajak->getField('TGL_AKHIR_RATE'));
	$tempNilai= $safr_valuta_kurs_pajak->getField('NILAI_RATE');
	$tempStatus= $safr_valuta_kurs_pajak->getField('KD_AKTIF');
	
}
$valuta->selectByParams(array("KD_AKTIF"=>"A"));
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
			$('#reqTanggalMulai').datebox('setValue', '<?="01-".date("m-Y")?>');	
			$('#reqTanggalSelesai').datebox('setValue', '<?=date("t",strtotime(date("Y-m-01"))).'-'.date("m-Y")?>');
		}
		
		$(function(){
			$('#ff').form({
				url:'../json-keuangansiuk/kurs_pajak_add.php',
				onSubmit:function(){
					return $(this).form('validate');
				},
				success:function(data){
					data = data.split("-");
					$.messager.alert('Info', data[data.length-1], 'info');
					window.parent.document.getElementById("reqKursPajak").value = $("#reqNilai").val();
					window.parent.divwin.close();							
				}
			});
			
		});
	</script>
    <link href="../WEB-INF/css/begron.css" rel="stylesheet" type="text/css">
    <link href="../WEB-INF/css/admin.css" rel="stylesheet" type="text/css">
    <!--<script language="javascript" type="text/javascript" src="../WEB-INF/lib/tiny_mce/tiny_mce.js"></script>
    <script language="javascript" type="text/javascript" src="../jslib/configTextEditorAdm.js"></script> -->

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
<body onLoad="setValue()">
<div id="begron"><img src="../WEB-INF/images/bg-kanan.jpg" width="100%" height="100%" alt="Smile"></div>
<div id="wadah">

    <div id="judul-halaman">
                <span><img src="../WEB-INF/images/panah-judul.png"> Tambah Data Referensi Kurs&nbsp;Valuta Pajak</span>
    </div>
    <form id="ff" method="post" novalidate>
    <table>
        <tr>           
             <td>Valuta</td>
			 <td colspan="3">
				<select id="reqValutaId" name="reqValutaId">
                <? 
				while($valuta->nextRow())
				{
				?>
                    <option value="<?=$valuta->getField('KODE_VALUTA')?>" <? if($valuta->getField('KODE_VALUTA') == "USD") echo 'selected';?>><?=$valuta->getField('KODE_VALUTA')?></option>
                <? 
				}
				?>
                </select>

  			&nbsp;&nbsp;&nbsp;&nbsp;             
  			</td>			
        </tr>
        <tr>
        <td>Tanggal Mulai</td>
            <td>
                 <input id="reqTanggalMulai" name="reqTanggalMulai" class="easyui-datebox" data-options="validType:'date'" value="<?=$tempTanggalMulai?>"></input>
       		</td>
        </tr>
        <tr>
        <td>Tanggal Selesai</td>
            <td>
                 <input id="reqTanggalSelesai" name="reqTanggalSelesai" class="easyui-datebox" data-options="validType:'date'" value="<?=$tempTanggalSelesai?>"></input>
       		</td>
        </tr>
        <tr>
            <td>Nilai</td>
            <td>
            	<input type="text" style="width:50px;" name="reqNilai" id="reqNilai" required OnFocus="FormatAngka('reqNilai')" OnKeyUp="FormatUang('reqNilai')" OnBlur="FormatUang('reqNilai')" value="<?=numberToIna($tempNilai)?>">
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