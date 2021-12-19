<?
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");

$reqMode = "insert";	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	<title>Form Validation - jQuery EasyUI Demo</title>

    
    <link href="../WEB-INF/lib/easyui/themes/default/easyui.css" rel="stylesheet" type="text/css">
    <script type="text/javascript" src="js/jquery-1.6.1.min.js"></script>
    <script type="text/javascript" src="../WEB-INF/lib/easyui/jquery.easyui.min.js"></script>
    <script type="text/javascript" src="../WEB-INF/lib/easyui/kalender.js"></script>
	<script type="text/javascript">
		$(function(){
			$('#ff').form({
				url:'../json-keuangansiuk/rubah_posting_add.php',
				onSubmit:function(){
					var win = $.messager.progress({
						title:'Aplikasi Keuangan',
						msg:'proses simpan...'
					});				
					return $(this).form('validate');
				},
				success:function(data){ 
					$.messager.progress('close');
					$.messager.alert('Info', data, 'info');
					top.frames['mainFrame'].location.reload();				
				}
			});
			
			$('form input').on('keypress', function(e) {
				return e.which !== 13;
			});
			

		});
		
		function proses()
		{
			var isCtrl = false;
			$('#reqNota').keyup(function (e) {
				if(e.which == 13)
				{
					$.get( "../json-keuangansiuk/get_nota_json/?reqId="+$("#reqNota").val(), function( data ) {
					 	
						if(data.NO_NOTA == "")
						{
							$.messager.alert('Info', "Nota tidak ditemukan atau belum diposting.", 'info');
							$("#btnSubmit").hide();
						}
						else
						{
							$("#reqTanggalNota").val(data.TGL_POSTING);
							$("#reqKeterangan").val(data.KET_TAMBAH);
							$("#reqStatusClosing").val(data.STATUS_CLOSING);
							if(data.STATUS_CLOSING == 'O')
							{
								$("#btnSubmit").show();
							}
							else
							{
								$.messager.alert('Info', "Nota sudah closing period, tidak dapat dirubah.", 'info');
								$("#btnSubmit").hide();
								return;
							}
							
						}
						
					 
					}, "json" );
				}
			});
		}
		
	</script>
    <script type="text/javascript">
        function stopRKey(evt) {
          var evt = (evt) ? evt : ((event) ? event : null);
          var node = (evt.target) ? evt.target : ((evt.srcElement) ? evt.srcElement : null);
          if ((evt.keyCode == 13) && ((node.type=="text") || (node.type=="radio") || (node.type=="checkbox")) )  {return false;}
        }

        document.onkeypress = stopRKey;
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
                <span><img src="../WEB-INF/images/panah-judul.png"> Maintenance Rubah Posting</span>
    </div>
    <form id="ff" method="post" novalidate>
    <table>
        <tr>           
             <td>No. Nota</td>
			 <td>
				<input name="reqNota" id="reqNota" class="easyui-validatebox"  style="width:170px;" type="text" value="<?=$tempKode?>" onKeyDown="proses();" />
                <br>
                Ketik nota kemudian tekan enter.
			</td>			
        </tr>
        <tr>
            <td>Tanggal Posting</td>
            <td>
                <input name="reqTanggalNota" id="reqTanggalNota" readonly style="width:170px" type="text" required value="<?=$tempNama?>" />
            </td>
        </tr>
        <tr>
            <td>Status Closing</td>
            <td>
                <input name="reqStatusClosing" id="reqStatusClosing" readonly style="width:50px" type="text" required value="<?=$tempNama?>" />
            </td>
        </tr>
        
        <tr>
            <td>Keterangan</td>
            <td>  
                <input name="reqKeterangan" id="reqKeterangan" required style="width:370px" type="text" required value="<?=$tempNama?>" />
            </td>
        </tr>
        <tr>
            <td>Tanggal Posting Baru</td>
            <td>
                <input id="reqTanggal" name="reqTanggal" required class="easyui-datebox" data-options="validType:'date'" value="<?=$tempTanggalSiup?>" />
            </td>
        </tr>
    </table>
        <div>
            <input type="hidden" name="reqId" value="<?=$reqId?>">
            <input type="hidden" name="reqMode" value="<?=$reqMode?>">
            <input type="submit" value="Submit" id="btnSubmit">
            <input type="reset" id="rst_form">
        </div>
    </form>
</div>
</body>
</html>