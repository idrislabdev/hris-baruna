<?php
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/KbbrThnBukuD.php");

$reqId = httpFilterGet("reqId");

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<meta http-equiv="Content-type" content="text/html; charset=UTF-8">
<title>neraca komparatif</title>
<link rel="shortcut icon" type="image/ico" href="http://www.datatables.net/media/images/favicon.ico">
<link rel="alternate" type="application/rss+xml" title="RSS 2.0" href="http://www.datatables.net/rss.xml">
<link href="../WEB-INF/css/admin.css" rel="stylesheet" type="text/css">


<!--RIGHT CLICK EVENT-->		
<style>

	.vmenu{
	border:1px solid #aaa;
	position:absolute;
	background:#fff;
	display:none;font-size:0.75em;}
	.first_li{}
	.first_li span{width:100px;display:block;padding:5px 10px;cursor:pointer}
	.inner_li{display:none;margin-left:120px;position:absolute;border:1px solid #aaa;border-left:1px solid #ccc;margin-top:-28px;background:#fff;}
	.sep_li{border-top: 1px ridge #aaa;margin:5px 0}
	.fill_title{font-size:11px;font-weight:bold;/height:15px;/overflow:hidden;word-wrap:break-word;}

</style>
<link href="../WEB-INF/lib/media/themes/main_datatables.css" rel="stylesheet" type="text/css" /> 
<link href="../WEB-INF/css/begron.css" rel="stylesheet" type="text/css">  
<link rel="stylesheet" type="text/css" href="css/bluetabs.css" />
<link href="../WEB-INF/lib/easyui/themes/default/easyui.css" rel="stylesheet" type="text/css">
<!--script src="../WEB-INF/lib/media/js/jquery-1.4.4.min.js" type="text/javascript"></script-->
<script type="text/javascript" src="js/jquery-1.6.1.min.js"></script>
<script type="text/javascript" src="../WEB-INF/lib/easyui/jquery.easyui.min.js"></script>
<script type="text/javascript" charset="utf-8">
    $(document).ready( function () {
				$('#btnKirim').on('click', function () {

					var win = $.messager.progress({
						title:'Please waiting',
						msg:'Proses kirim email...'
					});	
					
							$.getJSON('../json-keuangansiuk/penjualan_non_tunai_email.php?reqId=<?=$reqId?>&reqValuta=' + $( "#reqBahasa" ).val() + '&reqSendMail=' + $("input[name=reqEmail]:checked").val() + '&reqKet=' + $('textarea#reqKet').val(),
							  function(data){
							
							$.messager.progress('close');
							alert(data.PESAN);
							top.frames['mainFrame'].location.reload();
							window.parent.divwin.close();
							});
							
				});
			  
			   $('#btnBatal').on('click', function () {
				 	window.parent.divwin.close();		
			  });
			  
			  
	});
</script>
</head>
<body style="overflow:hidden">
<div id="begron"><img src="../WEB-INF/images/bg-kanan.jpg" width="100%" height="100%" alt="Smile"></div>
<div id="wadah">
	<form method="post">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
            <td class="">
            <div id="judul-halaman">
                <span><img src="../WEB-INF/images/panah-judul.png"> Kirim Email Nota Tagihan</span>
            </div>            
            </td>
        </tr>
    </table>

	<table>
        <tr>           
             <td>Bahasa </td>
			 <td>
             	<select id="reqBahasa">
                    	<option value="IND">Indonesia</option>
                        <option value="ENG">Inggris</option>
                </select>
             </td>			
        </tr>
        <tr>           
             <td>Keterangan </td>
			 <td>
             	<textarea name="reqKet" id="reqKet" cols="50" rows="5"></textarea>
             </td>			
        </tr>
        
        <tr>
        	<td colspan="3"><input type="hidden" id="reqId" name="reqId" value="<?=$reqId?>" /><input type="button" id="btnKirim" value="Kirim"><input type="button" id="btnBatal" value="Batal"></td>
        </tr>      
    </table>    	   
    </form>
</div>
</body>
</html>

