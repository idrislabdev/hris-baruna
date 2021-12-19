<?
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base-anggaran/AnggaranMutasi.php");

$anggaran_mutasi = new AnggaranMutasi();

$reqId = httpFilterGet("reqId");
$reqRowId = httpFilterGet("reqRowId");
$reqPeriode= httpFilterGet("reqPeriode");
$reqMode = httpFilterGet("reqMode");

if($reqId == "")
{
	$reqMode = "insert";
}
else
{
	$reqMode = "update";
	$anggaran_mutasi->selectByParams(array("ANGGARAN_MUTASI_ID"=>$reqId), -1, -1);
	$anggaran_mutasi->firstRow();
	
	$tempIdAnggaran = $anggaran_mutasi->getField("ANGGARAN_ID");
	$tempBukuPusat = $anggaran_mutasi->getField("KD_BUKU_PUSAT");
	$tempBukuBesar = $anggaran_mutasi->getField("KD_BUKU_BESAR");
	$tempTanggal = dateToPageCheck($anggaran_mutasi->getField("TANGGAL"));
	$tempJumlah = $anggaran_mutasi->getField("JUMLAH");
	$tempProsentasePph = $anggaran_mutasi->getField("");
	$tempPph = $anggaran_mutasi->getField("PPH");
	$tempStatusVerifikasi = $anggaran_mutasi->getField("STATUS_VERIFIKASI");    
	$tempVerifikasi = $anggaran_mutasi->getField("VERIFIKASI");    
}

$tempProsentasePph= 10;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	<title>Form Validation - jQuery EasyUI Demo</title>

    
    <link href="../WEB-INF/lib/easyui/themes/default/easyui.css" rel="stylesheet" type="text/css">
    <script type="text/javascript" src="js/jquery-1.6.1.min.js"></script>
    <script type="text/javascript" src="../WEB-INF/lib/easyui/jquery.easyui.min.js"></script>
    <script type="text/javascript" src="js/globalfunction.js"></script>
	<script type="text/javascript">
		$.fn.datebox.defaults.formatter = function(date) {
			var y = date.getFullYear();
			var m = date.getMonth() + 1;
			var d = date.getDate();
			return (d < 10 ? '0' + d : d) + '-' + (m < 10 ? '0' + m : m) + '-' + y;
		};
		
		$.extend($.fn.validatebox.defaults.rules, {
			date:{
				validator:function(value, param) {
					if(value.length == '10')
					{
						var reg = /^(\d{1,2})(-|\/)(\d{1,2})\2(\d{1,4})$/;
						return reg.test(value);
					}
					else
					{
						return false;
					}
				},
				message:"Format Tanggal: dd-mm-yyyy"
			}  
		});
	
		$.fn.datebox.defaults.parser = function(s) {
			if (s) {
				var a = s.split('-');
				var d = new Number(a[0]);
				var m = new Number(a[1]);
				var y = new Number(a[2]);
				var dd = new Date(y, m-1, d);
				return dd;
			} 
			else 
			{
				return new Date();
			}
		};
		
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
<body>
<div id="begron"><img src="../WEB-INF/images/bg-kanan.jpg" width="100%" height="100%" alt="Smile"></div>
<div id="wadah">

    <div id="judul-halaman">
                <span><img src="../WEB-INF/images/panah-judul.png"> Data Penggunaan Anggaran</span>
    </div>
    <form id="ff" method="post" novalidate>
    <table>
        <tr>           
             <td>Buku Pusat</td>
			 <td>
				<input type="hidden" id="reqIdAnggaran" name="reqIdAnggaran" size="30" value="<?=$tempIdAnggaran?>" />
                <input id="reqBukuPusat" name="reqBukuPusat" class="easyui-validatebox" required size="50" type="text" value="<?=$tempBukuPusat?>" readonly/>&nbsp;&nbsp;
			</td>
        </tr>
        <tr>
            <td>Buku&nbsp;Besar</td>
            <td>
            	<input id="reqBukuBesar" name="reqBukuBesar" size="50" type="text" value="<?=$tempBukuBesar?>" readonly/>
            </td>
        <tr>        
             <td>Tanggal</td>
			 <td>
             	<input id="reqTanggal" name="reqTanggal" type="text" value="<?=$tempTanggal?>" readonly />
			</td>
        </tr>
        <tr>           
             <td>Jumlah</td>
			 <td>
				<input name="reqJumlah" type="text" id="reqJumlah" readonly class="easyui-validatebox" size="20" value="<?=numberToIna($tempJumlah)?>" />
                &nbsp;&nbsp;&nbsp;&nbsp;
                Prosentase
                <input type="text" name="reqProsentasePph" id="reqProsentasePph" size="5" value="<?=$tempProsentasePph?>" readonly />
                PPH
                &nbsp;&nbsp;&nbsp;&nbsp;
                <input name="reqPph" type="text" id="reqPph" readonly class="easyui-validatebox" size="20" value="<?=$tempPph?>" />
			</td>
        </tr>
        <tr>           
             <td>Status Verifikasi</td>
			 <td>
             	<input type="text" name="reqStatusVerifikasi" id="reqStatusVerifikasi" value="<?=$tempVerifikasi?>" readonly/>
			</td>            
		</tr>
    </table>
    </form>
</div>
</body>
</html>