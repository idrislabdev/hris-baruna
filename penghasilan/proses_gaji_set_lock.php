<?
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");

$reqJenisProses = httpFilterGet("reqJenisProses");
$reqPeriode = httpFilterGet("reqPeriode");

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	<title>Form Validation - jQuery EasyUI Demo</title>

    
    <link rel="stylesheet" type="text/css" href="../WEB-INF/lib/easyui/themes/default/easyui.css">
    <script type="text/javascript" src="../WEB-INF/js/jquery-1.6.1.min.js"></script>
    <script type="text/javascript" src="../WEB-INF/lib/easyui/jquery.easyui.min.js"></script>
	<script type="text/javascript">
		$(function(){
			$('#ff').form({
				url:'../json-gaji/proses_gaji_set_lock.php',
				onSubmit:function(){
					var win = $.messager.progress({
						title:'Please waiting',
						msg:'Kirim jurnal sedang diproses...'
					});						
					return $(this).form('validate');
				},
				success:function(data){
					$.messager.progress('close');
					$.messager.alert('Info', data, 'info');
					top.frames['mainFrame'].location.reload();
				    window.parent.divwin.close(); 
			
				}
			});

		});
	</script>
    <link href="../WEB-INF/css/begron.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" type="text/css" href="../WEB-INF/css/admin.css">

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
<body onLoad="setValue('<?=$tempFitur?>')">
<div id="begron"><img src="../WEB-INF/images/bg-kanan.jpg" width="100%" height="100%" alt="Smile"></div>
<div id="wadah">

    <div id="judul-halaman">
                <span><img src="../WEB-INF/images/panah-judul.png"> Set Nota Dinas</span>
    </div>
    <form id="ff" method="post" novalidate>
    <table>
        <tr>           
             <td>No. Nota JKK</td>
			 <td>
            	<input type="text" name="reqNoNota">
			</td>
            <td rowspan="2"><a href="#" style="text-decoration:blink; color:red"><strong> Perhatian : </strong></a><strong>Apabila mengisi No.Nota JKK dan JKM maka akan menggantikan jurnal sesuai dengan No. Nota JKK dan JKM sebelumnya. Pastikan diisi dengan benar!<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; (Untuk data baru, No. Nota JKK dan JKM dikosongi.)</strong></a></td>			
        </tr>   
        <tr>           
             <td>No. Nota JKM</td>
			 <td>
            	<input type="text" name="reqNoNotaJKM">
			</td>			
        </tr>           
        <tr>           
             <td>Nota Dinas</td>
			 <td colspan="2">
            	<input type="text" name="reqNotaDinas1" required>
			</td>			
        </tr>               
    </table>
        <div>
            <input type="hidden" name="reqJenisProses" value="<?=$reqJenisProses?>">
            <input type="hidden" name="reqPeriode" value="<?=$reqPeriode?>">
            <input type="submit" value="Submit">
            <input type="reset" id="rst_form">
        </div>
    </form>
</div>
</body>
</html>