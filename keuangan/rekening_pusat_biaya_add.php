<?
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/KbbrBukuPusat.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/KbbrGroupRek.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/SafrValuta.php");

$rekening_pusat_biaya = new KbbrBukuPusat();
$kbbr_group_rek = new KbbrGroupRek();
$safr_valuta = new SafrValuta();

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
	$rekening_pusat_biaya->selectByParams(array('KD_BUKU_BESAR'=>$reqId), -1, -1);
	$rekening_pusat_biaya->firstRow();
	
	$tempTipeRekening = $rekening_pusat_biaya->getField("ID_GROUP");
	$tempKodeBukuBesar = $rekening_pusat_biaya->getField("KD_BUKU_BESAR");
	$tempNamaBukuBesar = $rekening_pusat_biaya->getField("NM_BUKU_BESAR");
	$tempPolaEntry = $rekening_pusat_biaya->getField("POLA_ENTRY");
	$tempGroupDtlKode = $rekening_pusat_biaya->getField("GRUP_DTL_KODE");
	$tempKodeValuta = $rekening_pusat_biaya->getField("KODE_VALUTA");
	$reqKategoriSekolah = $rekening_pusat_biaya->getField("GRUP_LEVEL3");
	$reqBosBopda = $rekening_pusat_biaya->getField("GRUP_LEVEL4");

	
}

$kbbr_group_rek->selectByParams();
$safr_valuta->selectByParams();

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	<title>Form Validation - jQuery EasyUI Demo</title>

    
    <link href="../WEB-INF/lib/easyui/themes/default/easyui.css" rel="stylesheet" type="text/css">
    <script type="text/javascript" src="js/jquery-1.6.1.min.js"></script>
    <script type="text/javascript" src="../WEB-INF/lib/easyui/jquery.easyui.min.js"></script>
	<script type="text/javascript">
		function setValue(){
			$('#cc').combotree('setValue', '<?=$tempDepartemen?>');
		}
		$.fn.datebox.defaults.formatter = function(date){
			var y = date.getFullYear();
			var m = date.getMonth()+1;
			var d = date.getDate();
			return d+'-'+m+'-'+y;
		}		
		$(function(){
			$('#ff').form({
				url:'../json-keuangansiuk/rekening_pusat_biaya_add.php',
				onSubmit:function(){
					return $(this).form('validate');
				},
				success:function(data){
					$.messager.alert('Info', data, 'info');
					<?
					if($reqMode == "insert")
					{
					?>
					$('#rst_form').click();
					<?
					}
					?>
					top.frames['mainFrame'].location.reload();
					<? if($reqMode == "update") { ?> //window.parent.divwin.close(); <? } ?>					
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
<body>
<div id="begron"><img src="../WEB-INF/images/bg-kanan.jpg" width="100%" height="100%" alt="Smile"></div>
<div id="wadah">

    <div id="judul-halaman">
                <span><img src="../WEB-INF/images/panah-judul.png"> Tambah Data Rekening Buku Pusat</span>
    </div>
    <form id="ff" method="post" novalidate>
    <table>
        <tr>           
             <td>Kode</td>
			 <td>
				<input name="reqKodeBukuBesar" class="easyui-validatebox" required style="width:100px" type="text" value="<?=$tempKodeBukuBesar?>" />
			</td>			
        </tr>
        <tr>           
             <td>Nama</td>
			 <td>
				<input name="reqNamaBukuBesar" class="easyui-validatebox" style="width:150px" type="text" value="<?=$tempNamaBukuBesar?>" />
			</td>			
        </tr>
        <tr>           
             <td>Group</td>
			 <td>
             	<select name="reqGroupDtlKode">
                	<option value="D" <? if($tempGroupDtlKode == "D") echo "selected";?>>D</option>
                    <option value="H" <? if($tempGroupDtlKode == "H") echo "selected";?>>H</option>
                </select>
			</td>			
        </tr>
        <tr>           
             <td>Grup Sekolah</td>
			 <td>
             	<select name="reqKategoriSekolah">
                        <option value=""></option>
                        <option value="TK Barunawati Surabaya" <? if($reqKategoriSekolah == "TK Barunawati Surabaya") echo "selected";?>>TK Barunawati Surabaya</option>
                        <option value="SD Barunawati Surabaya" <? if($reqKategoriSekolah == "SD Barunawati Surabaya") echo "selected";?>>SD Barunawati Surabaya</option>
                        <option value="SMP Barunawati Surabaya" <? if($reqKategoriSekolah == "SMP Barunawati Surabaya") echo "selected";?>>SMP Barunawati Surabaya</option>
                        <option value="SMA Barunawati Surabaya" <? if($reqKategoriSekolah == "SMA Barunawati Surabaya") echo "selected";?>>SMA Barunawati Surabaya</option>
                        <option value="SMK Barunawati Surabaya" <? if($reqKategoriSekolah == "SMK Barunawati Surabaya") echo "selected";?>>SMK Barunawati Surabaya</option>
                        <option value="STIAMAK Barunawati Surabaya" <? if($reqKategoriSekolah == "STIAMAK Barunawati Surabaya") echo "selected";?>>STIAMAK Barunawati Surabaya</option>
                        <option value="TK Barunawati Semarang" <? if($reqKategoriSekolah == "TK Barunawati Semarang") echo "selected";?>>TK Barunawati Semarang</option>
                        <option value="SD Barunawati Semarang" <? if($reqKategoriSekolah == "SD Barunawati Semarang") echo "selected";?>>SD Barunawati Semarang</option>
                        <option value="SMP Barunawati Semarang" <? if($reqKategoriSekolah == "SMP Barunawati Semarang") echo "selected";?>>SMP Barunawati Semarang</option>
                        <option value="TK Barunawati Badas" <? if($reqKategoriSekolah == "TK Barunawati Badas") echo "selected";?>>TK Barunawati Badas</option>
                        <option value="TK Barunawati Benoa" <? if($reqKategoriSekolah == "TK Barunawati Benoa") echo "selected";?>>TK Barunawati Benoa</option>
                        <option value="TK Barunawati Cilacap" <? if($reqKategoriSekolah == "TK Barunawati Cilacap") echo "selected";?>>TK Barunawati Cilacap</option>
                        <option value="TK Barunawati Kota Baru" <? if($reqKategoriSekolah == "TK Barunawati Kota Baru") echo "selected";?>>TK Barunawati Kota Baru</option>
                        <option value="TK Barunawati Kupang" <? if($reqKategoriSekolah == "TK Barunawati Kupang") echo "selected";?>>TK Barunawati Kupang</option>
                        <option value="TK Barunawati Lembar" <? if($reqKategoriSekolah == "TK Barunawati Lembar") echo "selected";?>>TK Barunawati Lembar</option>
                        <option value="TK Barunawati Probolinggo 1" <? if($reqKategoriSekolah == "TK Barunawati Probolinggo 1") echo "selected";?>>TK Barunawati Probolinggo 1</option>
                        <option value="TK Barunawati Probolinggo 2" <? if($reqKategoriSekolah == "TK Barunawati Probolinggo 2") echo "selected";?>>TK Barunawati Probolinggo 2</option>
                        <option value="TK Barunawati Pulang Pisau" <? if($reqKategoriSekolah == "TK Barunawati Pulang Pisau") echo "selected";?>>TK Barunawati Pulang Pisau</option>
                </select>
			</td>			
        </tr>
        <tr>           
             <td>BOS / BOPDA</td>
			 <td>
             	<select name="reqBosBopda">
                    <option value=""></option>
                	<option value="BOS" <? if($reqBosBopda == "BOS") echo "selected";?>>BOS</option>
                    <option value="BOPDA" <? if($reqBosBopda == "H") echo "selected";?>>BOPDA</option>
                </select>
			</td>			
        </tr>
        <tr>           
             <td>Valuta</td>
			 <td>
             	<select name="reqKodeValuta">
                	<option></option>
                	<?
					while($safr_valuta->nextRow())
					{
                    ?>
                	<option value="<?=$safr_valuta->getField("KODE_VALUTA")?>" <? if($tempKodeValuta == $safr_valuta->getField("KODE_VALUTA")) echo "selected";?>><?=$safr_valuta->getField("KODE_VALUTA")?></option>
                    <?
					}
                    ?>
                </select>
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