<?
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base-simpeg/PegawaiJabatanP3.php");
include_once("../WEB-INF/classes/base-simpeg/Jabatan.php");
include_once("../WEB-INF/classes/base-simpeg/CABANGP3.php");
include_once("../WEB-INF/classes/base-simpeg/DirektoratP3.php");
include_once("../WEB-INF/classes/base-simpeg/PejabatPenetap.php");

$pegawai_jabatan_p3 = new PegawaiJabatanP3();
$jabatan = new Jabatan();
$cabang = new CABANGP3();
$pejabat_penetap = new PejabatPenetap();
$departemen_cabang = new DirektoratP3();

$reqId = httpFilterRequest("reqId");
$reqMode = httpFilterRequest("reqMode");
$reqSubmit = httpFilterPost("reqSubmit");
$reqRowId= httpFilterRequest("reqRowId");

$pegawai_jabatan_p3->selectByParams(array('PEGAWAI_JABATAN_P3_ID'=>$reqRowId));
$pegawai_jabatan_p3->firstRow();

$tempTanggal = dateToPageCheck($pegawai_jabatan_p3->getField('TANGGAL_SK'));
$tempTMT = dateToPageCheck($pegawai_jabatan_p3->getField('TMT_JABATAN'));
$tempNoSK = $pegawai_jabatan_p3->getField('NO_SK');
$tempCABANGP3 = $pegawai_jabatan_p3->getField('CABANG_P3_ID');
$tempCabang= $pegawai_jabatan_p3->getField('CABANG_P3_KODE');
$tempDirektoratP3 = $pegawai_jabatan_p3->getField('DIREKTORAT_P3_ID');
$tempDirektoratP3Nama = $pegawai_jabatan_p3->getField('DEPARTEMEN_NAMA');
$tempJabatanId = $pegawai_jabatan_p3->getField('JABATAN_ID');
$tempJabatan = $pegawai_jabatan_p3->getField('JABATAN_NAMA');
$tempNomorUrut = $pegawai_jabatan_p3->getField('NO_URUT');
$tempKelas = $pegawai_jabatan_p3->getField('KELAS');
$tempNama = $pegawai_jabatan_p3->getField('NAMA');
$tempKeterangan = $pegawai_jabatan_p3->getField('KETERANGAN');
$tempPejabat = $pegawai_jabatan_p3->getField('PEJABAT_PENETAP_ID');
$tempRowId = $pegawai_jabatan_p3->getField('PEGAWAI_JABATAN_P3_ID');

//echo '---'.substr($tempDirektoratP3,2,2);
$tempDirektorat= substr($tempDirektoratP3,0,2);
$tempSubDirektorat= substr($tempDirektoratP3,2,2);
$tempSeksi= substr($tempDirektoratP3,4,2);

$jabatan->selectByParams();
$cabang->selectByParams();
$pejabat_penetap->selectByParams();

//check apakah sudah pernah entri, kalau sudah harus melalui proses apabila belum enable
$jumlah_entri = $pegawai_jabatan_p3->getCountByParams(array("PEGAWAI_ID" => $reqId));
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	<title>Form Validation - jQuery EasyUI Demo</title>
    <link href="../WEB-INF/css/begron.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" type="text/css" href="../WEB-INF/css/admin.css">    
    <link rel="stylesheet" type="text/css" href="../WEB-INF/css/bluetabs.css" />
    <link rel="stylesheet" type="text/css" href="../WEB-INF/lib/easyui/themes/default/easyui.css">
    <script type="text/javascript" src="../WEB-INF/js/jquery-1.6.1.min.js"></script>
    <script type="text/javascript" src="../WEB-INF/lib/easyui/jquery.easyui.min.js"></script>
    <script type="text/javascript">
		var tempTMT='';
		
		function setValue(){

			<?
			if($jumlah_entri > 0)
			{
			?>
			$("#ff :input").attr("disabled", true);
			$('#bluemenu').hide();
			<?
			}
			?>
						
			$('#ccJabatan').combobox('setValue', '<?=$tempJabatanId?>');
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
		
		$.extend($.fn.validatebox.defaults.rules, {
			existTMT:{
				validator: function(value, param){
					if(value.length == '10')
					{
						var reg = /^(\d{1,2})(-|\/)(\d{1,2})\2(\d{1,4})$/;
						if(reg.test(value) == true)
						{
							if($(param[0]).val() == "")
							{
								$.getJSON("../json-simpeg/pegawai_add_jabatan_perbantuan_tmt_json.php?reqId=<?=$reqId?>&reqTMT="+value,
								function(data){
									tempTMT= data.PEGAWAI_JABATAN_P3_ID;
								});
							}
							else
							{
								$.getJSON("../json-simpeg/pegawai_add_jabatan_perbantuan_tmt_json.php?reqId=<?=$reqId?>&reqTMTTemp="+$(param[0]).val()+"&reqTMT="+value,
								function(data){
									tempTMT= data.PEGAWAI_JABATAN_P3_ID;
								});
							}
							 
							 if(tempTMT == '')
								return true;
							 else
								return false;
						}
						else
						{
							return false;
						}
					}
					else
					{
						return false;
					}
				},
				message: 'TMT Tanggal, sudah ada atau Format Tanggal belum sesuai: {dd-mm-yyyy}'
			}
		});
		
		$(function(){
			$('#ff').form({
				url:'../json-simpeg/pegawai_add_jabatan_perbantuan.php',
				onSubmit:function(){
					return $(this).form('validate');
				},
				success:function(data){
					data = data.split("-");
					$.messager.alert('Info', data[1], 'info');
					$('#rst_form').click();
					
					parent.frames['mainFramePop'].location.href = 'pegawai_add_jabatan_perbantuan_monitoring.php?reqId=' + data[0];
					document.location.href = 'pegawai_add_jabatan_perbantuan.php?reqId=' + data[0] + '&reqRowId=' + data[2];
				}				
			});
			
			
			/*$("#ccDirektoratP3").click(function(e) {
				var t = $('#ccDirektoratP3').combotree('tree');	// get the tree object
				var n = t.tree('getSelected');		// get selected node
				alert(n.text);
			});*/
			
			/*$("#reqNomorUrut, #reqKelas").keypress(function(e) {
				if( $("#reqNomorUrut").val() != '' && $("#reqKelas").val() != '' ){
					var code = e.which;
					if(code==13){
						//alert('enter');
						$.getJSON("../json-simpeg/get_jabatan_perbantuan.php?reqNomorUrut="+$("#reqNomorUrut").val()+"&reqKelas="+$("#reqKelas").val(),
						function(data){
							$("#reqJabatanId").val(data.jabatan_id);
							$("#reqJabatan").val(data.jabatan);
							//$('#ccJabatan').combotree('setValue', '3262');
						});
					}else $("#reqJabatan").val('');
				}else $("#reqJabatan").val('');
			});
			
			$("#reqNomorUrut, #reqKelas").keyup(function(e) {
				if( $("#reqNomorUrut").val() != '' || $("#reqKelas").val() != '' ){
					$('#ccJabatan').combobox({
						url:'../json-simpeg/jabatan_p3_combo_json.php?reqNomorUrut='+$("#reqNomorUrut").val()+'&reqKelas='+$("#reqKelas").val(),
						valueField:'id',
						textField:'text',
						onSelect: function(rec){
							$.getJSON("../json-simpeg/get_nomor_urut_kelas.php?reqId="+rec.id,
							function(data){
								$("#reqNomorUrut").val(data.nomor_urut);
								$("#reqKelas").val(data.kelas);
							});
						},
						panelHeight:'88'
					});
				}
			});
			
			*/
			
			$("#reqCabang, #reqDirektorat, #reqSubDirektorat, #reqSeksi, #reqNomorUrut, #reqKelas").keypress(function(e) {
				if( e.which!=8 && e.which!=0 && (e.which<48 || e.which>57))
				{
				return false;
				}
			});
			
			$("#reqKelas").keypress(function(e) {
				if( $("#reqKelas").val() != '' ){
					var code = e.which;
					if(code==13){
						$('#ccJabatan').combobox({
							url:'../json-simpeg/jabatan_p3_combo_json.php?reqKelas='+$("#reqKelas").val(),
							valueField:'id',
							textField:'text',
							panelHeight:'88'
						});
					}
				}
			});
			
			$("#reqCabang").keyup(function(e) {
				if( $("#reqCabang").val() != '' ){
					$.getJSON("../json-simpeg/get_cabang_p3.php?reqCabang="+$("#reqCabang").val(),
					function(data){
						$("#reqCabangId").val(data.cabang_p3_id);
					});
				}
			});
			
			$("#reqCabang, #reqDirektorat, #reqSubDirektorat, #reqSeksi").keyup(function(e) {
				if( $("#reqCabangId").val() != '' || $("#reqDirektorat").val() != '' || $("#reqSubDirektorat").val() != '' || $("#reqSeksi").val() != '' ){
					$.getJSON('../json-simpeg/get_direktorat_p3.php?reqCabangId='+$("#reqCabangId").val()+'&reqDirektorat='+$("#reqDirektorat").val()+'&reqSubDirektorat='+$("#reqSubDirektorat").val()+'&reqSeksi='+$("#reqSeksi").val(),
					function(data){
						$("#reqDirektoratP3").val(data.direktorat_p3_id);
						$("#reqDirektoratP3Nama").val(data.direktorat_p3_nama);
					});
				}
			});
			
		});
	</script>
    
    <?php /*?><script>
			function reload(){
					$('#ccDirektoratP3').combotree('reload');
			}
			function setValue(){
					$('#ccDirektoratP3').combotree('setValue', 2);
			}
			function getValue(){
					var val = $('#ccDirektoratP3').combotree('getValue');
					alert(val);
			}
			function disable(){
					$('#ccDirektoratP3').combotree('disable');
			}
			function enable(){
					$('#ccDirektoratP3').combotree('enable');
			}
	</script><?php */?>


    <style>
	    .CodeMirror-scroll { height: 100%; overflow-x: auto;}
	</style>
    
</head>
<body onLoad="setValue();">
<!--<body>-->
<div id="begron"><img src="../WEB-INF/images/bg-kanan.jpg" width="100%" height="100%" alt="Smile"></div>
<div id="wadah" class="CodeMirror-scroll">
	<div id="bluemenu" class="bluetabs" style="background:url(../WEB-INF/css/media/bluetab.gif); position:fixed; width:100%; margin-top:0px; zIndex: -1'"> 
        <ul>
            <li>
            <a href="#" onClick="$('#btnSubmit').click();">Simpan</a>
            </li>        
        <?
        if($reqRowId == "") {}
		else
		{
		?>
            <li>
            <a href="pegawai_add_jabatan_perbantuan.php?reqId=<?=$reqId?>">Batal</a>
            </li>        
        <?
		}
		?>
        </ul>
    </div>
    <form id="ff" method="post" novalidate style="margin-top:20px;">
    <table>
        <tr>
            <td>Tanggal SK</td>
            <td>
                <input id="dd" name="reqTanggal" class="easyui-datebox" data-options="validType:'date'" value="<?=$tempTanggal?>"></input>
                &nbsp;&nbsp;&nbsp;
                Terhitung Mulai Tanggal (TMT)
                <input type="hidden" name="reqTMTTemp" id="reqTMTTemp" value="<?=$tempTMT?>">
                <input id="dd" name="reqTMT" class="easyui-datebox" validType="existTMT['#reqTMTTemp']" required value="<?=$tempTMT?>"></input>
            </td>
        </tr>
        <tr>
            <td>Nomor SK</td>
            <td>
                <input name="reqNoSK" id="reqNoSK" class="easyui-validatebox" required size="60" type="text" value="<?=$tempNoSK?>" />
            </td>
        </tr>
        <tr>
            <td>Cabang</td>
            <input id="reqCabangId" name="reqCabangId" type="hidden" value="<?=$tempCABANGP3?>">
            <td><input id="reqCabang" class="easyui-validatebox" style="width:50px;" value="<?=$tempCabang?>"></td>
        </tr>
        <tr>
            <td>Direktorat
            <!--<div style="margin:10px 0;">
                    <a href="#" class="easyui-linkbutton" onclick="reload()">Reload</a>
                    <a href="#" class="easyui-linkbutton" onclick="setValue()">SetValue</a>
                    <a href="#" class="easyui-linkbutton" onclick="getValue()">GetValue</a>
                    <a href="#" class="easyui-linkbutton" onclick="disable()">Disable</a>
                    <a href="#" class="easyui-linkbutton" onclick="enable()">Enable</a>
            </div>-->
            </td>
            <td>
            <input id="reqDirektorat" name="reqDirektorat" class="easyui-validatebox" value="<?=$tempDirektorat?>" style="width:50px;">&nbsp;&nbsp;&nbsp;
            <!--<input id="ccDirektoratP3" class="easyui-combotree"  required="true" name="reqDirektoratP3" data-options="url:'../json-simpeg/direktorat_p3_combo_json.php'" style="width:300px;">-->
            Sub Direktorat
            &nbsp;&nbsp;&nbsp;&nbsp;<input id="reqSubDirektorat" name="reqSubDirektorat" value="<?=$tempSubDirektorat?>" class="easyui-validatebox" style="width:50px;">&nbsp;&nbsp;&nbsp;
            Seksi
            &nbsp;&nbsp;&nbsp;&nbsp;<input id="reqSeksi" name="reqSeksi" value="<?=$tempSeksi?>" class="easyui-validatebox" style="width:50px;">
            </td>
        </tr>
        <tr>
            <td>Nama Direktorat</td>
            <input id="reqDirektoratP3" class="easyui-validatebox"  type="hidden" name="reqDirektoratP3" value="<?=$tempDirektoratP3?>">
            <td><input id="reqDirektoratP3Nama" class="easyui-validatebox"  required="true" name="reqDirektoratP3Nama" value="<?=$tempDirektoratP3Nama?>" style="width:225px;"></td>
        </tr>
        <tr>
            <td>Kelas<!--Nomor Urut--></td>
            <td>
                <!--<input id="reqNomorUrut" size="5" class="easyui-validatebox" required="required" value="<?=$tempNomorUrut?>"></input>
                &nbsp;&nbsp;&nbsp;
                Kelas-->
                <input id="reqKelas" size="5" class="easyui-validatebox" required value="<?=$tempKelas?>"></input>
                <span style="font-size:12px;"><strong><em>&nbsp;*Isi Kelas, tekan enter untuk pengisian Jabatan.</em></strong></span>
            </td>
        </tr>
        <tr>
            <td>Nama Jabatan</td>
            <td>
            	<input id="ccJabatan" class="easyui-combobox"  required="true" name="reqJabatanId" 
                	data-options="
                    url:'../json-simpeg/jabatan_p3_combo_json.php',
					valueField:'id',
					textField:'text',
                    onSelect: function(rec){
                        $.getJSON('../json-simpeg/get_nomor_urut_kelas.php?reqId='+rec.id,
                        function(data){
                            $('#reqKelas').val(data.kelas);
                        });
                    },
					panelHeight:'120'"
                style="width:300px;">
                
            	<?php /*?><input id="reqJabatanId" type="hidden" name="reqJabatanId" value="<?=$tempJabatanId?>"></input>
            	<input id="reqJabatan" type="text" name="reqJabatan" size="65" class="easyui-validatebox" readonly required="required" value="<?=$tempJabatan?>"></input><?php */?>
                
            	<?php /*?><input id="ccJabatan" class="easyui-combotree"  required="true" name="reqJabatanId" data-options="url:'../json-simpeg/jabatan_combo_json.php?reqStatus=perbantuan'" style="width:300px;"><?php */?>
            	<?php /*?><select id="reqJabatanId" name="reqJabatanId">
                <? while($jabatan->nextRow()){?>
                	<option value="<?=$jabatan->getField('JABATAN_ID')?>" <? if($tempJabatanId == $jabatan->getField('JABATAN_ID')) echo 'selected';?>><?=$jabatan->getField('NAMA')?></option>
                <? }?>
                </select><?php */?>
            </td>
        </tr>
        <?php /*?><tr>
            <td>Nomor SK</td>
            <td>
                <input name="reqNoSK" id="reqNoSK" class="easyui-validatebox" required="required" size="60" type="text" value="<?=$tempNoSK?>" />
            </td>
        </tr><?php */?>
        <?php /*?><tr>
            <td>Nomor urut</td>
            <td>
                <input name="reqNoUrut" id="reqNoUrut" class="easyui-validatebox" required="required" size="20" type="text" value="<?=$tempNoUrut?>" />
                &nbsp;&nbsp;&nbsp;
                Kelas Jabatan
                <input name="reqKelas" id="reqKelas" class="easyui-validatebox" required="required" size="20" type="text" value="<?=$tempKelas?>" />
            </td>
        </tr>
        <tr>
            <td>Nama Jabatan</td>
            <td>
                <input name="reqNama" id="reqNama" class="easyui-validatebox" required="required" size="40" type="text" value="<?=$tempNama?>" />
            </td>
        </tr><?php */?>
        <tr>
            <td>Uraian Tugas</td>
            <td>
            	<textarea id="reqKeterangan" name="reqKeterangan" cols="60" class="easyui-validatebox"><?=$tempKeterangan?></textarea>
            </td>
        </tr>
        <tr>
            <td>Pejabat Penetap</td>
            <td>
            	<select id="reqPejabat" name="reqPejabat">
                <? while($pejabat_penetap->nextRow()){?>
                	<option value="<?=$pejabat_penetap->getField('PEJABAT_PENETAP_ID')?>" <? if($tempPejabat == $pejabat_penetap->getField('PEJABAT_PENETAP_ID')) echo 'selected';?>><?=$pejabat_penetap->getField('NAMA')?></option>
                <? }?>
                </select>
            </td>
        </tr>
    </table>
    	<div style="display:none">
        	<? if($tempRowId == ''){ $reqMode='insert'; }else{ $reqMode='update'; }?>
            <input type="hidden" name="reqMode" value="<?=$reqMode?>">
            <input type="hidden" name="reqId" value="<?=$reqId?>">
            <input type="hidden" name="reqRowId" value="<?=$reqRowId?>">
            <input type="submit" name="reqSubmit" id="btnSubmit" value="Submit">
            <input type="reset" id="rst_form">
        </div>
    </form>
</div>
</body>
</html>