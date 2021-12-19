<?
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
$reqId = httpFilterGet("reqId");
$reqMode = httpFilterGet("reqMode");

$reqMode = "insert";
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
		}
		
		$(function(){
			$('#ff').form({
				url:'../json-keuangansiuk/hapus_jurnal_add.php',
				onSubmit:function(){


					if($(this).form('validate'))
					{
						var win = $.messager.progress({
							title:'Aplikasi Keuangan',
							msg:'proses data...'
						});
					}			


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
                <span><img src="../WEB-INF/images/panah-judul.png"> Hapus Jurnal Sudah Posting</span>
    </div>
     <form id="ff" method="post" novalidate enctype="multipart/form-data">
    <table>
    	<tr>
            <td valign="top">Nomor Jurnal</td>
            <td valign="top">
            	<input type="text" style="width:150px;" name="reqNomor" id="reqNomor"  value="<?=$reqNomor?>" >
            	<br>
            	<span style="font-weight: bold; font-size:11px">Tekan enter untuk informasi jurnal.</span>
            </td>
        </tr>
        <tr class="simpan" style="display:none;">
            <td>Deskripsi</td>
            <td>
            	<input type="text" style="width:550px;" readonly name="reqDeskripsi" id="reqDeskripsi" class="easyui-validatebox" required value="<?=($reqDeskripsi)?>">
            </td>
        </tr>    
        <tr class="simpan" style="display:none;">
            <td>Nilai</td>
            <td>
            	<input type="text" style="width:150px;" readonly name="reqNilai" id="reqNilai" class="easyui-validatebox" required value="<?=($reqNilai)?>">
            </td>
        </tr>            
    </table>
        <div class="simpan" style="display:none;">
            <input type="hidden" name="reqId" value="<?=$reqId?>">
            <input type="hidden" name="reqMode" value="<?=$reqMode?>">
            <input type="submit" id="reqSubmit" value="Hapus Data" style="display:none">
            <input type="button" value="Hapus Data" onclick="konfirmasi()">
        </div>
    </form>
</div>
</body>
</html>

<script type="text/javascript">

	$(document).ready(function() {
	  $(window).keydown(function(event){
	    if(event.keyCode == 13) {
	      event.preventDefault();
	      return false;
	    }
	  });
	});

	$( document ).ready(function() {


		$("#reqNomor").keyup(function(e){ 
		    var code = e.keyCode; // recommended to use e.key, it's normalized across devices and languages

		    if(code=="13") 
		    {
		    	reqNomor = $("#reqNomor").val();
		    	$.get( "../json-keuangansiuk/hapus_jurnal_get.php/?reqId="+reqNomor, function( data ) {
				 
				  data = JSON.parse(data);
				  $("#reqNomor").val(data.NO_NOTA);
				  $("#reqDeskripsi").val(data.KET_TAMBAH);
				  $("#reqNilai").val(data.JML_VAL_TRANS);

				  $(".simpan").show();

				});
		    }


		});
	});


	function konfirmasi()
	{
		reqNomor = $("#reqNomor").val();
		if(confirm("Apakah anda yakin ingin menghapus jurnal nomor " + reqNomor + "?"))
		{
			$("#reqSubmit").click();
		}

	}
</script>