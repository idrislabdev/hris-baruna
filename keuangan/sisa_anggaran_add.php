<?
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base-anggaran/Anggaran.php");

$anggaran = new Anggaran();

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
	$anggaran->selectByParams(array('A.ANGGARAN_ID'=>$reqId), -1, -1);
	$anggaran->firstRow();

	$tempTahunBuku = $anggaran->getField("TAHUN_BUKU");
	$tempKodeBukuPusat = $anggaran->getField("KD_BUKU_PUSAT");
	$tempKodeSubBantu = $anggaran->getField("KD_SUB_BANTU");
	$tempKodeBukuBesar = $anggaran->getField("KD_BUKU_BESAR");
	$tempKodeValuta = $anggaran->getField("KD_VALUTA");
	$tempJumlah = $anggaran->getField("JUMLAH");
	$tempJumlahTriwulan1 = $anggaran->getField("JUMLAH_TRIWULAN1");
	$tempJumlahTriwulan3 = $anggaran->getField("JUMLAH_TRIWULAN3");
	$tempJumlahTriwulan2 = $anggaran->getField("JUMLAH_TRIWULAN2");
	$tempJumlahTriwulan4 = $anggaran->getField("JUMLAH_TRIWULAN4");
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	<title>Form Validation - jQuery EasyUI Demo</title>

    
    <link href="../WEB-INF/lib/easyui/themes/default/easyui.css" rel="stylesheet" type="text/css">
    <script type="text/javascript" src="js/jquery-1.6.1.min.js"></script>
    <script type="text/javascript" src="../WEB-INF/lib/easyui/jquery.easyui.min.js"></script>
    <script type="text/javascript" src="../keuangan/js/globalfunction.js"></script>
	<script type="text/javascript">
		function setValue(){
			$('#reqTahunBuku').combobox('setValue', '<?=date("Y")?>');
			$('#reqKodeBukuBesar').combobox('setValue', '<?=$tempKodeBukuBesar?>');
			$('#reqKodeValuta').combobox('setValue', '<?=$tempKodeValuta?>');
			$('#reqKodeBukuPusat').combobox('setValue', '<?=$tempKodeBukuPusat?>');
		}
		$.fn.datebox.defaults.formatter = function(date){
			var y = date.getFullYear();
			var m = date.getMonth()+1;
			var d = date.getDate();
			return d+'-'+m+'-'+y;
		}
		
		$(function(){
			$('#ff').form({
				url:'../json-anggaran/anggaran_add.php',
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
			
			var valJumlah=valJumlah1=valJumlah2=valJumlah3=valJumlah4="0";
			$("#reqJumlah").keyup(function(e) {
				if( $("#reqJumlah").val() == '' ){}
				else
				{
					valJumlah=Number(String($("#reqJumlah").val()).replaceAll('.',''));
					valJumlah /= 4;
				}
				
				$("#reqJumlahTriwulan1").val(FormatCurrency(valJumlah));
				$("#reqJumlahTriwulan2").val(FormatCurrency(valJumlah));
				$("#reqJumlahTriwulan3").val(FormatCurrency(valJumlah));
				$("#reqJumlahTriwulan4").val(FormatCurrency(valJumlah));
			});
			
			$("#reqJumlahTriwulan1, #reqJumlahTriwulan2, #reqJumlahTriwulan3, #reqJumlahTriwulan4").keyup(function(e) {
				setTimeout(setSumJumlah, 100);
			});
			
			function setSumJumlah()
			{
				if( $("#reqJumlahTriwulan1").val() == '' )	valJumlah1= 0;
				else										valJumlah1= Number(String($("#reqJumlahTriwulan1").val()).replaceAll('.',''));
				
				if( $("#reqJumlahTriwulan2").val() == '' )	valJumlah2= 0;
				else										valJumlah2= Number(String($("#reqJumlahTriwulan2").val()).replaceAll('.',''));
				
				if( $("#reqJumlahTriwulan3").val() == '' )	valJumlah3= 0;
				else										valJumlah3= Number(String($("#reqJumlahTriwulan3").val()).replaceAll('.',''));
				
				if( $("#reqJumlahTriwulan4").val() == '' )	valJumlah4= 0;
				else										valJumlah4= Number(String($("#reqJumlahTriwulan4").val()).replaceAll('.',''));
				
				valJumlah = valJumlah1 + valJumlah2 + valJumlah3 + valJumlah4;
				$("#reqJumlah").val(FormatCurrency(valJumlah));
			}
		});
	</script>
    
    <script type="text/javascript">
	$(document).ready(function() {
		String.prototype.replaceAll = function(
		strTarget, // The substring you want to replace
		strSubString // The string you want to replace in.
		){
		var strText = this;
		var intIndexOfMatch = strText.indexOf( strTarget );
		 
		// Keep looping while an instance of the target string
		// still exists in the string.
		while (intIndexOfMatch != -1){
		// Relace out the current instance.
		strText = strText.replace( strTarget, strSubString )
		 
		// Get the index of any next matching substring.
		intIndexOfMatch = strText.indexOf( strTarget );
		}
		 
		// Return the updated string with ALL the target strings
		// replaced out with the new substring.
		return( strText );
		}
	})
	</script>
    
    <link href="../WEB-INF/css/begron.css" rel="stylesheet" type="text/css">
    <link href="../WEB-INF/css/admin.css" rel="stylesheet" type="text/css">

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
<body onLoad="setValue();">
<div id="begron"><img src="../WEB-INF/images/bg-kanan.jpg" width="100%" height="100%" alt="Smile"></div>
<div id="wadah">
    <div id="judul-halaman">
                <span><img src="../WEB-INF/images/panah-judul.png"> Set Anggaran</span>
    </div>
    <form id="ff" method="post" novalidate>
    <table>
        <tr>           
             <td>Tahun</td>
			 <td>
             	<input id="reqTahunBuku" name="reqTahunBuku" class="easyui-combobox" required="true" data-options="url:'../json-keuangansiuk/tahun_combo_json.php'" style="width:80px;">
			</td>			
        </tr>
        <tr>
            <td>Kode&nbsp;Buku&nbsp;Pusat</td>
            <td>
                <input id="reqKodeBukuPusat" name="reqKodeBukuPusat" class="easyui-combobox" required="true" 
                data-options="
                valueField: 'id',
				textField: 'text',
                url:'../json-keuangansiuk/buku_pusat_combo_json.php',
                onSelect: function(rec){
                var url = '../json-keuangansiuk/buku_pusat_combo_json.php?reqId='+rec.id;
                $('#reqKodeBukuPusat').combobox('reload', url);
                }
                " style="width:300px;">
                &nbsp;&nbsp;
            </td>
        </tr>
        <tr>
            <td>Kode&nbsp;Buku&nbsp;Besar</td>
            <td>
                <input id="reqKodeBukuBesar" name="reqKodeBukuBesar" class="easyui-combobox" required="true" 
                data-options="
                valueField: 'id',
				textField: 'text',
                url:'../json-keuangansiuk/buku_besar_combo_json.php',
                onSelect: function(rec){
                var url = '../json-keuangansiuk/buku_besar_combo_json.php?reqId='+rec.id;
                $('#reqKodeBukuBesar').combobox('reload', url);
                }
                " style="width:300px;">
                &nbsp;&nbsp;
            </td>
        </tr>
        <tr>
            <td>Kode&nbsp;Sub&nbsp;Bantu</td>
            <td>
            <input type="text" class="easyui-validatebox" size="10" name="reqKodeSubBantu" id="reqKodeSubBantu" value="<?=$tempKodeSubBantu?>"  />
            </td>
        </tr>
        <tr>
        	<td>Kode Valuta</td>
            <td>
                <input id="reqKodeValuta" name="reqKodeValuta" class="easyui-combobox" required="true" 
                data-options="
                valueField: 'id',
				textField: 'text',
                url:'../json-keuangansiuk/valuta_combo_json.php',
                onSelect: function(rec){
                var url = '../json-keuangansiuk/valuta_combo_json.php?reqId='+rec.id;
                $('#reqKodeValuta').combobox('reload', url);
                }
                " style="width:50px;">
            </td>     
        </tr>
        <tr>
        	<td>Jumlah</td>
            <td>
            	<input name="reqJumlah" type="text" id="reqJumlah" class="easyui-validatebox" size="10" value="<?=numberToIna($tempJumlah)?>"  OnFocus="FormatAngka('reqJumlah')" OnKeyUp="FormatUang('reqJumlah')" OnBlur="FormatUang('reqJumlah')"/>
            </td>
        </tr>
        <tr>
        	<td>Jumlah Triwulan 1</td>
            <td>
            	<input name="reqJumlahTriwulan1" type="text" id="reqJumlahTriwulan1" class="easyui-validatebox" size="10" value="<?=numberToIna($tempJumlahTriwulan1)?>"  OnFocus="FormatAngka('reqJumlahTriwulan1')" OnKeyUp="FormatUang('reqJumlahTriwulan1')" OnBlur="FormatUang('reqJumlahTriwulan1')"/>
                &nbsp;&nbsp;
                Jumlah Triwulan 3
                <input name="reqJumlahTriwulan3" type="text" id="reqJumlahTriwulan3" class="easyui-validatebox" size="10" value="<?=numberToIna($tempJumlahTriwulan3)?>"  OnFocus="FormatAngka('reqJumlahTriwulan3')" OnKeyUp="FormatUang('reqJumlahTriwulan3')" OnBlur="FormatUang('reqJumlahTriwulan3')"/>
            </td>
        </tr>
        <tr>
        	<td>Jumlah Triwulan 2</td>
            <td>
            	<input name="reqJumlahTriwulan2" type="text" id="reqJumlahTriwulan2" class="easyui-validatebox" size="10" value="<?=numberToIna($tempJumlahTriwulan2)?>"  OnFocus="FormatAngka('reqJumlahTriwulan2')" OnKeyUp="FormatUang('reqJumlahTriwulan2')" OnBlur="FormatUang('reqJumlahTriwulan2')"/>
                &nbsp;&nbsp;
                Jumlah Triwulan 4
                <input name="reqJumlahTriwulan4" type="text" id="reqJumlahTriwulan4" class="easyui-validatebox" size="10" value="<?=numberToIna($tempJumlahTriwulan4)?>"  OnFocus="FormatAngka('reqJumlahTriwulan4')" OnKeyUp="FormatUang('reqJumlahTriwulan4')" OnBlur="FormatUang('reqJumlahTriwulan4')"/>
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