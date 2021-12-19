<?
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/KbbrBukuBesar.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/KbbrGroupRek.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/SafrValuta.php");

$rekening_buku_besar = new KbbrBukuBesar();
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
	$rekening_buku_besar->selectByParams(array('KD_BUKU_BESAR'=>$reqId), -1, -1);
	$rekening_buku_besar->firstRow();
	
	$tempTipeRekening = $rekening_buku_besar->getField("ID_GROUP");
	$tempKodeBukuBesar = $rekening_buku_besar->getField("KD_BUKU_BESAR");
	$tempNamaBukuBesar = $rekening_buku_besar->getField("NM_BUKU_BESAR");
	$tempPolaEntry = $rekening_buku_besar->getField("POLA_ENTRY_ID");
	$tempGroupDtlKode = $rekening_buku_besar->getField("GRUP_DTL_KODE");
	$tempKodeValuta = $rekening_buku_besar->getField("KODE_VALUTA");
	$tempGrupLevel5 = $rekening_buku_besar->getField("GRUP_LEVEL5");
	$tempGrupLevel3 = $rekening_buku_besar->getField("GRUP_LEVEL3");
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
				url:'../json-keuangansiuk/rekening_buku_besar_add.php',
				onSubmit:function(){
					return $(this).form('validate');
				},
				success:function(data){
					//alert(data);
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
					<? if($reqMode == "update") { ?> window.parent.divwin.close(); <? } ?>					
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
                <span><img src="../WEB-INF/images/panah-judul.png"> Tambah Data Rekening Buku&nbsp;Besar</span>
    </div>
    <form id="ff" method="post" novalidate>
    <table>
        <tr>           
             <td>Tipe</td>
			 <td>
             	<select name="reqTipeRekening">
                	<?
					while($kbbr_group_rek->nextRow())
					{
                    ?>
                	<option value="<?=$kbbr_group_rek->getField("ID_GROUP")?>" <? if($tempTipeRekening == $kbbr_group_rek->getField("ID_GROUP")) echo "selected";?>><?=$kbbr_group_rek->getField("NAMA_GROUP")?></option>
                    <?
					}
                    ?>
                </select>
			</td>			
        </tr>
        <tr>           
             <td>Kode</td>
			 <td>
				<input name="reqKodeBukuBesar" class="easyui-validatebox" required style="width:100px" type="text" value="<?=$tempKodeBukuBesar?>" />
			</td>			
        </tr>
        <tr>           
             <td>Nama</td>
			 <td>
				<input name="reqNamaBukuBesar" class="easyui-validatebox" style="width:450px" type="text" value="<?=$tempNamaBukuBesar?>" />
			</td>			
        </tr>
        <tr>           
             <td>Pola Entry</td>
			 <td>
             	<select name="reqPolaEntry">
                	<option value="0" <? if($tempPolaEntry == "0") echo "selected";?>>Buku&nbsp;Besar</option>
                    <option value="1" <? if($tempPolaEntry == "1") echo "selected";?>>Buku&nbsp;Besar & Kartu</option>
                    <option value="3" <? if($tempPolaEntry == "3") echo "selected";?>>Buku&nbsp;Besar, Kartu & Buku&nbsp;Pusat</option>
                </select>
			</td>			
        </tr>
        <tr>           
             <td>Group</td>
			 <td>
             	<select name="reqGroupDtlKode">
                	<option value="D" <? if($tempGroupDtlKode == "D") echo "selected";?>>DETIL</option>
                    <option value="H" <? if($tempGroupDtlKode == "H") echo "selected";?>>HEADER</option>
                </select>
			</td>			
        </tr>
        <tr>           
             <td>Jenis</td>
			 <td>
             	<select name="reqGrupLevel5">
                	<option value="" <? if($tempGrupLevel5 == "") echo "selected";?>></option>
                	<option value="DANA" <? if($tempGrupLevel5 == "DANA") echo "selected";?>>DANA</option>
                    <option value="INV" <? if($tempGrupLevel5 == "INV") echo "selected";?>>INV</option>
                    <option value="OPS" <? if($tempGrupLevel5 == "OPS") echo "selected";?>>OPS</option>
                </select>
			</td>			
        </tr>
        <tr>           
             <td>Arus Kas</td>
			 <td>
             	<select name="reqGrupLevel3">
                	<option value="LANCAR" <? if($tempGrupLevel3 == "LANCAR") echo "selected";?>>LANCAR</option>
                    <option value="TIDAK_LANCAR" <? if($tempGrupLevel3 == "TIDAK_LANCAR") echo "selected";?>>TIDAK LANCAR</option>
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