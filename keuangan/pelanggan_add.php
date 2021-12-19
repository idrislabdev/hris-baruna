<?
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/KbbrNoNota.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/SafmPelanggan.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/SafmBank.php");

$pelanggan = new SafmPelanggan();

$bank = new SafmBank();

$reqId = httpFilterGet("reqId");
$reqMode = httpFilterGet("reqMode");
$tempDepartemen = $userLogin->idDepartemen;

$bank->selectByParamsBank();
while($bank->nextRow())
{
	$arrBank[] = $bank->getField("BANK");
	$arrKodeBank[] = $bank->getField("KODE");	
}

if($reqKodeBank == "")
	$reqKodeBank = $arrKodeBank[0];
	
	
if($reqId == "")
{
	$reqMode = "insert";	
}
else
{
	
	$reqMode = "update";	
	$pelanggan->selectByParams(array("MPLG_KODE"=>$reqId), -1, -1);
	$pelanggan->firstRow();
	
	$tempKode = $pelanggan->getField("MPLG_KODE");
	$tempNama = $pelanggan->getField("MPLG_NAMA");
	$tempAlamat = $pelanggan->getField("MPLG_ALAMAT");
	$tempKota = $pelanggan->getField("MPLG_KOTA");
	$tempNoTelepon = $pelanggan->getField("MPLG_TELEPON");
	$tempEmail = $pelanggan->getField("MPLG_EMAIL_ADDRESS");
	$tempContPerson = $pelanggan->getField("MPLG_CONT_PERSON");
	$tempJenisUsaha = $pelanggan->getField("MPLG_JENIS_USAHA");
	$tempBadanUsaha = $pelanggan->getField("MPLG_BADAN_USAHA");
	$tempNpwp = $pelanggan->getField("MPLG_NPWP");
	$tempSiup = $pelanggan->getField("MPLG_SIUP");
	$tempTanggalSiup = dateToPageCheck($pelanggan->getField("MPLG_TGL_SIUP"));
	$tempNoWd = $pelanggan->getField("MPLG_NO_WD");
	$tempBankRp = $pelanggan->getField("MBANK_KODE_RUPIAH");
	$tempBankUs = $pelanggan->getField("MBANK_KODE_VALAS");
}
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
				url:'../json-keuangansiuk/pelanggan_add.php',
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
                <span><img src="../WEB-INF/images/panah-judul.png"> Tambah Data Maintenance Master Pelanggan</span>
    </div>
    <form id="ff" method="post" novalidate>
    <table>
        <tr>           
             <td>Kode Pelanggan</td>
			 <td>
				<input name="reqKode" class="easyui-validatebox"  style="width:170px;" type="text" value="<?=$tempKode?>" />
			</td>			
        </tr>
        <tr>
            <td>Nama Pelanggan</td>
            <td>
                <input name="reqNama" style="width:170px" type="text" required value="<?=$tempNama?>" />
            </td>
        </tr>
        <tr>
            <td>Alamat</td>
            <td>
                <input name="reqAlamat" style="width:170px" type="text" value="<?=$tempAlamat?>" />
            </td>
        </tr>
        <tr>
            <td>Kota</td>
            <td>
                <input name="reqKota" style="width:170px" type="text" value="<?=$tempKota?>" />
            </td>
        </tr>
        <tr>
            <td>No Telepon</td>
            <td>
                <input name="reqNoTelepon" style="width:170px" type="text" value="<?=$tempNoTelepon?>" />
            </td>
        </tr>
        <tr>
            <td>Email Address</td>
            <td>
                <input name="reqEmail" style="width:170px" maxlength="20" type="text" value="<?=$tempEmail?>" />
            </td>
        </tr>
        <tr>
            <td>Cont Person</td>
            <td>
                <input name="reqContPerson" style="width:170px" type="text" value="<?=$tempContPerson?>" />
            </td>
        </tr>
        <tr>
            <td>Jenis Usaha</td>
            <td>
		        <select name="reqJenisUsaha">
                	<option value="" <? if($tempJenisUsaha == "") echo "selected";?>></option>
                    <option value="PMLDOCK" <? if($tempJenisUsaha == "PMLDOCK") echo "selected";?>>PMLDOCK</option>
                    <option value="PMLKAPAL" <? if($tempJenisUsaha == "PMLKAPAL") echo "selected";?>>PMLKAPAL</option>
                    <option value="AGENPLYR" <? if($tempJenisUsaha == "AGENPLYR") echo "selected";?>>AGENPLYR</option>
                    <option value="PERORG" <? if($tempJenisUsaha == "PERORG") echo "selected";?>>PERORG</option>
                    <option value="AGENPBMEMK" <? if($tempJenisUsaha == "AGENPBMEMK") echo "selected";?>>AGENPBMEMK</option>
                    <option value="LAINLAIN" <? if($tempJenisUsaha == "LAINLAIN") echo "selected";?>>LAINLAIN</option>
                    <option value="EMKL" <? if($tempJenisUsaha == "EMKL") echo "selected";?>>EMKL</option>
                </select>
            </td>            
        </tr>
        <tr>
        	<td>Badan&nbsp;Usaha</td>
            <td>    
                <select name="reqBadanUsaha">
                	<option value="ABRI" <? if($tempBadanUsaha == "ABRI") echo "selected";?>>ABRI</option>
                    <option value="BUMN" <? if($tempBadanUsaha == "BUMN") echo "selected";?>>BUMN</option>
                    <option value="INSTANSI PEMERINTAH" <? if($tempBadanUsaha == "INSTANSI PEMERINTAH") echo "selected";?>>INSTANSI PEMERINTAH</option>
                    <option value="SWASTA" <? if($tempBadanUsaha == "SWASTA") echo "selected";?>>SWASTA</option>
                    <option value="PERORANGAN" <? if($tempBadanUsaha == "PERORANGAN") echo "selected";?>>PERORANGAN</option>
                </select>
            </td>
        </tr>
        <tr>
            <td>N.P.W.P</td>
            <td>
                <input name="reqNpwp" style="width:170px" type="text" value="<?=$tempNpwp?>" />
            </td>
        </tr>
        <tr>
            <td>SIUP</td>
            <td>
                <input name="reqSiup" style="width:170px" type="text" value="<?=$tempSiup?>" />
                &nbsp;&nbsp;&nbsp;
                <input id="reqTanggalSiup" name="reqTanggalSiup" class="easyui-datebox" data-options="validType:'date'" value="<?=$tempTanggalSiup?>" />
            </td>
        </tr>
        <tr>
            <td>No. W.D</td>
            <td>   
                <input name="reqNoWd" style="width:170px" type="text" value="<?=$tempNoWd?>" />
            </td>
        </tr>
        <tr>
            <td>Bank (Rupiah)</td>
            <td>
            	  <select name="reqBankRp" id="reqBankRp">
        		  <?
                  for($i=0;$i<count($arrKodeBank);$i++)
				  {
				  ?>
                  	 <option value="<?=$arrKodeBank[$i]?>"><?=$arrBank[$i]?></option>
                  <?	  
				  }
				  ?>
        		  </select>
        		  &nbsp;&nbsp;
        
            </td>
        </tr>
        <tr>
            <td>Bank (Dollar US)</td>
             <td>
            	  <select name="reqBankUs" id="reqBankUs">
        		  <?
                  for($i=0;$i<count($arrKodeBank);$i++)
				  {
				  ?>
                  	 <option value="<?=$arrKodeBank[$i]?>"><?=$arrBank[$i]?></option>
                  <?	  
				  }
				  ?>
        		  </select>
        		  &nbsp;&nbsp;
        
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