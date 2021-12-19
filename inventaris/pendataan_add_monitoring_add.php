<?
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base-inventaris/Inventaris.php");
include_once("../WEB-INF/classes/base-inventaris/Lokasi.php");

$lokasi = new Lokasi();
$inventaris= new Inventaris();

$reqMode = httpFilterGet("reqMode");
$reqId = httpFilterGet("reqId");
$reqInventarisId = httpFilterGet("reqInventarisId");

$reqLokasi = $lokasi->getLokasi($reqId);

$inventaris->selectByParams(array(),-1,-1, " AND A.INVENTARIS_ID = '".$reqInventarisId."'");
$inventaris->firstRow();
$tempJenisInventarisId = $inventaris->getField("JENIS_INVENTARIS_ID");
$tempSpesifikasi = trim($inventaris->getField("SPESIFIKASI"));
unset($inventaris);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Untitled Document</title>

<link href="../WEB-INF/css/begron.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" type="text/css" href="../WEB-INF/css/admin.css">	

<link rel="stylesheet" type="text/css" href="../WEB-INF/lib/easyui/themes/default/easyui.css">
<script type="text/javascript" src="../WEB-INF/js/jquery-1.6.1.min.js"></script>
<script type="text/javascript" src="../WEB-INF/lib/easyui/jquery.easyui.min.js"></script>
<script type="text/javascript" src="../WEB-INF/lib/easyui/kalender-easyui.js"></script>
<script type="text/javascript" src="../WEB-INF/lib/easyui/globalfunction.js"></script>

<script language="Javascript">
<? include_once "../jslib/formHandler.php"; ?>
</script>

<script type="text/javascript">	
	function setValue(){
		$('#reqInventaris').combobox('setValue', '<?=$reqInventarisId?>');
		$('#reqJenisInventaris').combotree('setValue', '<?=$tempJenisInventarisId?>');
		$('#reqLokasi').combotree('setValue', '<?=$reqId?>');
	}
	
	$(function(){
		$('#ff').form({
			url:'../json-inventaris/pendataan_add_monitoring_add.php',
			onSubmit:function(){
				return $(this).form('validate');
			},
			success:function(data){
                // alert(data);return false;
				data = data.split("-");
				$.messager.alert('Info', data[1], 'info');
				$('#rst_form').click();
				top.frames['mainFrame'].location.reload();
				window.parent.frames['mainFramePop'].location.href = 'pendataan_add_monitoring.php?reqId=<?=$reqId?>';				
				window.parent.frames['mainFrameDetilPop'].location.href = 'pendataan_add_data.php?reqId=<?=$reqId?>&reqInventarisId='+data[0]+'&reqInventarisNama='+data[1];
			}
		});
		
		$('#reqJenisInventaris').combotree({
			filter: function(q, row) { return row['text'].toLowerCase().indexOf(q.toLowerCase()) != -1; },
			width:'400',
			panelWidth:'400',
			valueField: 'id', 
			textField: 'text',
			url: '../json-inventaris/jenis_inventaris_combo_json.php',
			onChange:function(){
				var value= $('#reqJenisInventaris').combobox('getValue');
				if(value == '')
				{
					$('#reqInventaris').combobox('setValue', '');
					setInventaris('');
				}
			},
			onSelect:function(rec){
				setInventaris(rec.id);
			}
		});
	});
	
	function setInventaris(val)
	{
		var url = '../json-inventaris/inventaris_combo_json.php?reqId='+val;
		$('#reqInventaris').combobox('reload', url);
	}
</script>
<style>
.combo span{
	width:300px !important;	
}
</style>
</head>
<body>
<div id="begron"><img src="../WEB-INF/images/bg-kanan.jpg" width="100%" height="100%" alt="Smile"></div>
<div id="wadah">

    <div id="judul-halaman">
                <span><img src="../WEB-INF/images/panah-judul.png">Tambah Data Asset</span>
    </div>
    	<form id="ff" method="post" novalidate enctype="multipart/form-data">
    	<div id="popup-tabel2">
    	<table>
        	<tr>
                <td>Lokasi</td>
                <td>:</td>
                <td>
                <?=$reqLokasi?>
                </td>
            </tr> 
            <tr>
                <td>No Invoice / Faktur</td>
                <td>:</td>
                <td>
                <input type="text" id="reqNoInvoice" name="reqNoInvoice" class="easyui-validatebox" style="width:200px;" value="" />
                </td>           
            </tr>
            <tr>
                <td>Jenis Asset</td>
                <td>:</td>
                <td>
                <input type="text" id="reqJenisInventaris" name="reqJenisInventaris" class="easyui-combotree" required style="width:350px;" />
                </td>           
            </tr>
            <tr>
                <td>Asset</td>
                <td>:</td>
                <td>            
                <input type="hidden" name="reqInventarisNama" id="reqInventarisNama" value="">
                <input id="reqInventaris" name="reqInventaris" class="easyui-combobox" required style="width:450px !important;" 
                data-options="
                filter: function(q, row) { return row['text'].toLowerCase().indexOf(q.toLowerCase()) != -1; },
                valueField: 'id', textField: 'text',
                width:'400',
                panelWidth:'400',
                url:'../json-inventaris/inventaris_combo_json.php',
                        onSelect:function(rec){       
                            $('#reqInventarisNama').val($('#reqInventaris').combobox('getText'));
                            $('#reqSpesifikasi').val(rec.spesifikasi);
                            $('#reqJenisInventaris').combotree('setValue', rec.jenis_inventaris_id);
                        },
                        onChange:function(rec){               
                            $('#reqInventarisNama').val($('#reqInventaris').combobox('getText'));
                           <?
                           if($tempSpesifikasi == "")
						   {
						   ?> 
                            $('#reqSpesifikasi').val('');                        
                           <?
                           }
						   ?>
                        }
                " style="width:200px;" />
                </td>           
            </tr>    
            <tr>
                <td>Spesifikasi</td>
                <td>:</td>
                <td>
                	<textarea name="reqSpesifikasi" id="reqSpesifikasi"  style="width:328px;"><?=$tempSpesifikasi?></textarea>
                </td>           
            </tr>  
            <tr>
                <td>Tanggal Perolehan</td>
                <td>:</td>
                <td>
                    <input id="reqPerolehan" name="reqPerolehan" class="easyui-datebox" required data-options="validType:'date'"/>
                </td>           
            </tr>
            <tr>
                <td>Perolehan Harga</td>
                <td>:</td>
                <td>
                    <input name="reqPerolehanHarga" type="text" id="reqPerolehanHarga" class="easyui-validatebox" style="width:113px;" OnFocus="FormatAngka('reqPerolehanHarga')" OnKeyUp="FormatUang('reqPerolehanHarga')" OnBlur="FormatUang('reqPerolehanHarga')"/>
                </td>
            </tr>        
            <tr>
                <td>Jumlah</td>
                <td>:</td>
                <td>
                    <input name="reqJumlah" id="reqJumlah" class="easyui-validatebox" style="width:40px;" required type="text" value="<?=$tempJumlah?>" />
                </td>
            </tr>         
            <?php /*?><tr>
                <td>Umur Ekonomis / Sisa Umur</td>
                <td>:</td>
                <td>
                    <input name="reqUmurEkonomis" id="reqUmurEkonomis" class="easyui-validatebox" style="width:40px;" required type="text" value="<?=$tempJumlah?>" />
                </td>
            </tr><?php */?>               
        	<tr>
            	<td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>
                    <input type="hidden" name="reqId" value="<?=$reqId?>">
                    <input type="hidden" name="reqMode" value="<?=$reqMode?>">
                	<input type="submit" value="Simpan" /> 
                    <input type="reset" value="Reset" />
                </td>
            </tr>
        </table>
        </div>
        </form>
        </div>
		<script>
        
        $("#reqJumlah").keypress(function(e) {
            //alert(e.which);e.which!=46 && 
            if( e.which!=8 && e.which!=0 && (e.which<48 || e.which>57))
            {
            return false;
            }
        });
        </script>
    </div>
</body>
</html>