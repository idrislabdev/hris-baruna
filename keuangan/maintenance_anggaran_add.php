<?
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/KbbtNeracaAngg.php");

$kbbt_neraca_angg = new KbbtNeracaAngg();

$reqId = httpFilterGet("reqId");
$reqMode = httpFilterGet("reqMode");
$reqPusat = httpFilterGet("reqPusat");
$reqBesar = httpFilterGet("reqBesar");
$reqTahun = httpFilterGet("reqTahun");
$tempDepartemen = $userLogin->idDepartemen;


	$kbbt_neraca_angg->selectByParams(array('THN_BUKU'=>$reqTahun, 'A.KD_BUKU_BESAR'=>$reqBesar, 'A.KD_BUKU_PUSAT'=>$reqPusat), -1, -1);
	$kbbt_neraca_angg->firstRow();
	
	$tempTahunBuku = $kbbt_neraca_angg->getField("TAHUN_BUKU");
	//$tempKodeBukuPusat = $kbbt_neraca_angg->getField("KD_BUKU_PUSAT");
	$tempKodeBukuPusat = $kbbt_neraca_angg->getField("KD_BUKU_PUSAT"); //"000.00.00";
	$tempKodeSubBantu = "00000";// $kbbt_neraca_angg->getField("KD_SUB_BANTU");
	$tempKodeBukuBesar = $kbbt_neraca_angg->getField("KD_BUKU_BESAR");
	$tempKodeValuta = "IDR"; //$kbbt_neraca_angg->getField("KD_VALUTA");
	$tempJumlah = $kbbt_neraca_angg->getField("ANGG_TAHUNAN");

	$tempBulanJuli = $kbbt_neraca_angg->getField("P01_ANGG");
	$tempBulanAgustus = $kbbt_neraca_angg->getField("P02_ANGG");
	$tempBulanSeptember = $kbbt_neraca_angg->getField("P03_ANGG");
	$tempBulanOktober = $kbbt_neraca_angg->getField("P04_ANGG");
	$tempBulanNovember = $kbbt_neraca_angg->getField("P05_ANGG");
	$tempBulanDesember = $kbbt_neraca_angg->getField("P06_ANGG");
	$tempBulanJanuari = $kbbt_neraca_angg->getField("P07_ANGG");
	$tempBulanFebruari = $kbbt_neraca_angg->getField("P08_ANGG");
	$tempBulanMaret = $kbbt_neraca_angg->getField("P09_ANGG");
	$tempBulanApril = $kbbt_neraca_angg->getField("P10_ANGG");
	$tempBulanMei = $kbbt_neraca_angg->getField("P11_ANGG");
	$tempBulanJuni = $kbbt_neraca_angg->getField("P12_ANGG");

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
				url:'../json-keuangansiuk/maintenance_anggaran_add.php',
				onSubmit:function(){
					return $(this).form('validate');
				},
				success:function(data){
					$.messager.alert('Info', data, 'info');
					top.frames['mainFrame'].location.href = 'maintenance_anggaran.php?reqTahunBuku=<?=$reqTahun?>';
					top.closeWindow();	
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
			
			$("#reqJumlahBulanJuli, #reqJumlahBulanAgustus, #reqJumlahBulanSeptember, #reqJumlahBulanOktober, #reqJumlahBulanNovember, #reqJumlahBulanDesember, #reqJumlahBulanJanuari, #reqJumlahBulanFebruari, #reqJumlahBulanMaret, #reqJumlahBulanApril, #reqJumlahBulanMei, #reqJumlahBulanJuni").keyup(function(e) {
				setTimeout(setSumJumlah, 100);
			});
			
			function setSumJumlah()
			{
				if( $("#reqJumlahBulanJuli").val() == '' )	valJumlah1= 0;
				else										valJumlah1= Number(String($("#reqJumlahBulanJuli").val()).replaceAll('.',''));
				
				if( $("#reqJumlahBulanAgustus").val() == '' )	valJumlah2= 0;
				else										valJumlah2= Number(String($("#reqJumlahBulanAgustus").val()).replaceAll('.',''));
				
				if( $("#reqJumlahBulanSeptember").val() == '' )	valJumlah3= 0;
				else										valJumlah3= Number(String($("#reqJumlahBulanSeptember").val()).replaceAll('.',''));
				
				if( $("#reqJumlahBulanOktober").val() == '' )	valJumlah4= 0;
				else										valJumlah4= Number(String($("#reqJumlahBulanOktober").val()).replaceAll('.',''));

				if( $("#reqJumlahBulanNovember").val() == '' )	valJumlah5= 0;
				else										valJumlah5= Number(String($("#reqJumlahBulanNovember").val()).replaceAll('.',''));
			
				if( $("#reqJumlahBulanDesember").val() == '' )	valJumlah6= 0;
				else										valJumlah6= Number(String($("#reqJumlahBulanDesember").val()).replaceAll('.',''));
			
				if( $("#reqJumlahBulanJanuari").val() == '' )	valJumlah7= 0;
				else										valJumlah7= Number(String($("#reqJumlahBulanJanuari").val()).replaceAll('.',''));
			
				if( $("#reqJumlahBulanFebruari").val() == '' )	valJumlah8= 0;
				else										valJumlah8= Number(String($("#reqJumlahBulanFebruari").val()).replaceAll('.',''));
			
				if( $("#reqJumlahBulanMaret").val() == '' )	valJumlah9= 0;
				else										valJumlah9= Number(String($("#reqJumlahBulanMaret").val()).replaceAll('.',''));
			
				if( $("#reqJumlahBulanApril").val() == '' )	valJumlah10= 0;
				else										valJumlah10= Number(String($("#reqJumlahBulanApril").val()).replaceAll('.',''));
			
				if( $("#reqJumlahBulanMei").val() == '' )	valJumlah11= 0;
				else										valJumlah11= Number(String($("#reqJumlahBulanMei").val()).replaceAll('.',''));
			
				if( $("#reqJumlahBulanJuni").val() == '' )	valJumlah12= 0;
				else										valJumlah12= Number(String($("#reqJumlahBulanJuni").val()).replaceAll('.',''));
			


				valJumlah = valJumlah1 + valJumlah2 + valJumlah3 + valJumlah4 + valJumlah5 + valJumlah6 + valJumlah7 + valJumlah8 + valJumlah9 + valJumlah10 + valJumlah11 + valJumlah12;
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
                <span><img src="../WEB-INF/images/panah-judul.png"> Maintenance Anggaran</span>
    </div>
    <form id="ff" method="post" novalidate>
    <table>
        <tr>           
             <td>Tahun</td>
			 <td>
             	<input id="reqTahunBuku" name="reqTahunBuku" class="easyui-combotree" required data-options="url:'../json-keuangansiuk/tahun_combo_json.php?reqMode=anggaran'" style="width:80px;" value="<?=$reqTahun?>">
			</td>			
        </tr>
        <tr>
            <td>Kode&nbsp;Buku&nbsp;Besar</td>
            <td>
                <input id="reqKodeBukuBesar" name="reqKodeBukuBesar" class="easyui-combobox" required 
                data-options="
                valueField: 'id',
				textField: 'text',
                url:'../json-keuangansiuk/buku_besar_combo_json.php?filterKode=anggaran',
                onSelect: function(rec){
                var url = '../json-keuangansiuk/buku_besar_combo_json.php?reqId='+rec.id;
                $('#reqKodeBukuBesar').combobox('reload', url);
                }
                " style="width:300px;">
                &nbsp;&nbsp;
            </td>
        </tr>
        <tr>
            <td>Kode&nbsp;Pusat&nbsp;Biaya</td>
            <td>
                <input id="reqKodeBukuPusat" name="reqKodeBukuPusat" class="easyui-combobox" required 
                data-options="
                valueField: 'id',
				textField: 'text',
                url:'../json-keuangansiuk/buku_pusat_combo_json.php?filterKode=anggaran',
                onSelect: function(rec){
                var url = '../json-keuangansiuk/buku_pusat_combo_json.php?reqId='+rec.id;
                $('#reqKodeBukuPusat').combobox('reload', url);
                }
                " style="width:300px;">
                &nbsp;&nbsp;
            </td>
        </tr>
        <tr style="display:none">
            <td>Kode&nbsp;Sub&nbsp;Bantu</td>
            <td>
            <input type="text" class="easyui-validatebox" size="10" name="reqKodeSubBantu" id="reqKodeSubBantu" value="<?=$tempKodeSubBantu?>" maxlength="5"  />
            </td>
        </tr>
        <tr>
        	<td>Kode Valuta</td>
            <td>
                <input id="reqKodeValuta" name="reqKodeValuta" class="easyui-combobox" required readonly
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
        	<td>Jumlah Bulan Juli</td>
            <td>
            	<input name="reqJumlahBulanJuli" type="text" id="reqJumlahBulanJuli" class="easyui-validatebox" size="10" value="<?=numberToIna($tempBulanJuli)?>"  OnFocus="FormatAngka('reqJumlahBulanJuli')" OnKeyUp="FormatUang('reqJumlahBulanJuli')" OnBlur="FormatUang('reqJumlahBulanJuli')"/>
                &nbsp;&nbsp;
                Jumlah Bulan Agustus
            	<input name="reqJumlahBulanAgustus" type="text" id="reqJumlahBulanAgustus" class="easyui-validatebox" size="10" value="<?=numberToIna($tempBulanAgustus)?>"  OnFocus="FormatAngka('reqJumlahBulanAgustus')" OnKeyUp="FormatUang('reqJumlahBulanAgustus')" OnBlur="FormatUang('reqJumlahBulanAgustus')"/>
            </td>
        </tr>
		<tr>
        	<td>Jumlah Bulan September</td>
            <td>
            	<input name="reqJumlahBulanSeptember" type="text" id="reqJumlahBulanSeptember" class="easyui-validatebox" size="10" value="<?=numberToIna($tempBulanSeptember)?>"  OnFocus="FormatAngka('reqJumlahBulanSeptember')" OnKeyUp="FormatUang('reqJumlahBulanSeptember')" OnBlur="FormatUang('reqJumlahBulanSeptember')"/>
                &nbsp;&nbsp;
                Jumlah Bulan Oktober
            	<input name="reqJumlahBulanOktober" type="text" id="reqJumlahBulanOktober" class="easyui-validatebox" size="10" value="<?=numberToIna($tempBulanOktober)?>"  OnFocus="FormatAngka('reqJumlahBulanOktober')" OnKeyUp="FormatUang('reqJumlahBulanOktober')" OnBlur="FormatUang('reqJumlahBulanOktober')"/>
            </td>
        </tr>
		<tr>
        	<td>Jumlah Bulan November</td>
            <td>
            	<input name="reqJumlahBulanNovember" type="text" id="reqJumlahBulanNovember" class="easyui-validatebox" size="10" value="<?=numberToIna($tempBulanNovember)?>"  OnFocus="FormatAngka('reqJumlahBulanNovember')" OnKeyUp="FormatUang('reqJumlahBulanNovember')" OnBlur="FormatUang('reqJumlahBulanNovember')"/>
                &nbsp;&nbsp;
                Jumlah Bulan Desember
            	<input name="reqJumlahBulanDesember" type="text" id="reqJumlahBulanDesember" class="easyui-validatebox" size="10" value="<?=numberToIna($tempBulanDesember)?>"  OnFocus="FormatAngka('reqJumlahBulanDesember')" OnKeyUp="FormatUang('reqJumlahBulanDesember')" OnBlur="FormatUang('reqJumlahBulanDesember')"/>
            </td>
        </tr>
		<tr>
        	<td>Jumlah Bulan Januari</td>
            <td>
            	<input name="reqJumlahBulanJanuari" type="text" id="reqJumlahBulanJanuari" class="easyui-validatebox" size="10" value="<?=numberToIna($tempBulanJanuari)?>"  OnFocus="FormatAngka('reqJumlahBulanJanuari')" OnKeyUp="FormatUang('reqJumlahBulanJanuari')" OnBlur="FormatUang('reqJumlahBulanJanuari')"/>
                &nbsp;&nbsp;
                Jumlah Bulan Februari
            	<input name="reqJumlahBulanFebruari" type="text" id="reqJumlahBulanFebruari" class="easyui-validatebox" size="10" value="<?=numberToIna($tempBulanFebruari)?>"  OnFocus="FormatAngka('reqJumlahBulanFebruari')" OnKeyUp="FormatUang('reqJumlahBulanFebruari')" OnBlur="FormatUang('reqJumlahBulanFebruari')"/>
            </td>
        </tr>
		<tr>
        	<td>Jumlah Bulan Maret</td>
            <td>
            	<input name="reqJumlahBulanMaret" type="text" id="reqJumlahBulanMaret" class="easyui-validatebox" size="10" value="<?=numberToIna($tempBulanMaret)?>"  OnFocus="FormatAngka('reqJumlahBulanMaret')" OnKeyUp="FormatUang('reqJumlahBulanMaret')" OnBlur="FormatUang('reqJumlahBulanMaret')"/>
                &nbsp;&nbsp;
                Jumlah Bulan April
            	<input name="reqJumlahBulanApril" type="text" id="reqJumlahBulanApril" class="easyui-validatebox" size="10" value="<?=numberToIna($tempBulanApril)?>"  OnFocus="FormatAngka('reqJumlahBulanApril')" OnKeyUp="FormatUang('reqJumlahBulanApril')" OnBlur="FormatUang('reqJumlahBulanApril')"/>
            </td>
        </tr>
		<tr>
        	<td>Jumlah Bulan Mei</td>
            <td>
            	<input name="reqJumlahBulanMei" type="text" id="reqJumlahBulanMei" class="easyui-validatebox" size="10" value="<?=numberToIna($tempBulanMei)?>"  OnFocus="FormatAngka('reqJumlahBulanMei')" OnKeyUp="FormatUang('reqJumlahBulanMei')" OnBlur="FormatUang('reqJumlahBulanMei')"/>
                &nbsp;&nbsp;
                Jumlah Bulan Juni
            	<input name="reqJumlahBulanJuni" type="text" id="reqJumlahBulanJuni" class="easyui-validatebox" size="10" value="<?=numberToIna($tempBulanJuni)?>"  OnFocus="FormatAngka('reqJumlahBulanJuni')" OnKeyUp="FormatUang('reqJumlahBulanJuni')" OnBlur="FormatUang('reqJumlahBulanJuni')"/>
            </td>
        </tr>
		<tr>
        	<td>Total Anggaran</td>
            <td>
            	<input name="reqJumlah" type="text" id="reqJumlah" class="easyui-validatebox" size="10" value="<?=numberToIna($tempJumlah)?>" readonly/>
            </td>
        </tr>
    </table>
        <div>
            <input type="hidden" name="reqId" value="<?=$reqId?>">
            <input type="hidden" name="reqPusat" value="<?=$reqPusat?>">
            <input type="hidden" name="reqBesar" value="<?=$reqBesar?>">
            <input type="hidden" name="reqTahun" value="<?=$reqTahun?>">
            <input type="hidden" name="reqMode" value="<?=$reqMode?>">
            <input type="submit" value="Submit">
            <input type="reset" id="rst_form">
        </div>
    </form>
</div>
</body>
</html>