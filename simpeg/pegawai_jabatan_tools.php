<?
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base-simpeg/PegawaiJabatan.php");
include_once("../WEB-INF/classes/base/DeleteRowUser.php");


$pegawai_jabatan = new PegawaiJabatan();

$reqId = httpFilterGet("reqId");
$reqDeleteId = httpFilterGet("reqDeleteId");
$reqMode = httpFilterGet("reqMode");


$pegawai_jabatan->selectByParamsTools(array(), -1, -1);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	<title>Form Validation - jQuery EasyUI Demo</title>
    <link href="../WEB-INF/css/begron.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" type="text/css" href="../WEB-INF/css/admin.css">
    <link href="../WEB-INF/lib/media/themes/main_datatables.css" rel="stylesheet" type="text/css" /> 
    <link rel="stylesheet" type="text/css" href="../WEB-INF/lib/easyui/themes/default/easyui.css">
    <script type="text/javascript" src="../WEB-INF/js/jquery-1.6.1.min.js"></script>
    <script type="text/javascript" src="../WEB-INF/lib/easyui/jquery.easyui.min.js"></script>
    <script type="text/javascript">
	function updateData(id, departemenid, tanggalid)
	{
		//alert($('#'+tanggalid).datebox('getValue'));
		//alert($('#'+departemenid).combobox('getValue'));	
		$.getJSON('../json-simpeg/pegawai_jabatan_tools.php?reqId='+id+'&reqTanggal='+$('#'+tanggalid).datebox('getValue')+'&reqDepartemen='+$('#'+departemenid).combobox('getValue'), function (data) 
		{
			$.each(data, function (i, SingleElement) {
			});
		});		
		alert('Data berhasil diubah');
			
	}
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
    
</head>
<body>
<div id="begron"><img src="../WEB-INF/images/bg-kanan.jpg" width="100%" height="100%" alt="Smile"></div>
<div id="wadah">

    <div id="judul-halaman">
                <span><img src="../WEB-INF/images/panah-judul.png">Tools Perbaikan Data</span>
    </div>
    <table id="gradient-style" style="width:96%">
    <thead>
    <tr>
    <th scope="col">NRP</th>
    <th scope="col">Nama</th>
    <th scope="col">TMT Jabatan</th>
    <th scope="col">Departemen Sebelum</th>
    <th scope="col">Departemen Sesudah</th>
    <th scope="col">Aksi</th>
    </tr>
    </thead>
    <tbody>

    <?
	$i = 0;
    while($pegawai_jabatan->nextRow())
	{
	?>
    	<tr onClick="parent.frames['mainFrameDetilPop'].location.href = 'pegawai_add_jabatan.php?reqId=<?=$reqId?>&reqRowId=<?=$pegawai_jabatan->getField("PEGAWAI_JABATAN_ID")?>'">
            <td><?=$pegawai_jabatan->getField("NRP")?></td>
            <td><?=$pegawai_jabatan->getField("NAMA")?></td>
            <td><input id="dd<?=$i?>" name="reqTMT<?=$i?>" class="easyui-datebox" required value="<?=dateToPage($pegawai_jabatan->getField("TMT_JABATAN"))?>"></input></td>
            <td><?=$pegawai_jabatan->getField("NAMA_DEPARTEMEN")?></td>
            <td> <input id="ccDepartemen<?=$i?>" class="easyui-combotree" value="" required="true" name="reqDepartemen<?=$i?>" data-options="panelHeight:'88',url:'../json-simpeg/departemen_combo_json.php'" style="width:300px;"></td>
            <script type="text/javascript">
			$(function(){
				$('#ccDepartemen<?=$i?>').combotree('setValue', '<?=$pegawai_jabatan->getField("DEPARTEMEN_ID")?>');
			});
            </script>
            <td><a href="#" onClick="updateData('<?=$pegawai_jabatan->getField("PEGAWAI_JABATAN_ID")?>', 'ccDepartemen<?=$i?>', 'dd<?=$i?>')">Update</a></td>
        </tr>    
    <?
		$i++;
	}
	?>    
    </table>

</div>
</body>
</html>