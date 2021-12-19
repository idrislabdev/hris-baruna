<?
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base-absensi/AbsensiIjin.php");
include_once("../WEB-INF/classes/base-absensi/IjinKoreksi.php");

$absensi_ijin = new AbsensiIjin();
$ijin = new IjinKoreksi();

$reqId = httpFilterGet("reqId");
$tempDepartemen = $userLogin->idDepartemen;

if($reqId == "")
{
	$reqMode = "insert";	
}
else
{
	$reqMode = "update";	
	$absensi_ijin->selectByParamsMonitoring(array('ABSENSI_IJIN_ID'=>$reqId), -1, -1);
	$absensi_ijin->firstRow();

	$tempPegawaiId= $absensi_ijin->getField('PEGAWAI_ID');
	$tempNRP= $absensi_ijin->getField('NRP');
	$tempNama= $absensi_ijin->getField('NAMA_PEGAWAI');
	$tempDepartemenId= $absensi_ijin->getField('DEPARTEMEN_ID');
	$tempDepartemen= $absensi_ijin->getField('DEPARTEMEN');
	$tempIjinId= $absensi_ijin->getField('IJIN_ID');
	$tempTanggalAwal= $absensi_ijin->getField('TANGGAL_AWAL');
	$tempTanggalAkhir= $absensi_ijin->getField('TANGGAL_AKHIR');
	$tempKeterangan= $absensi_ijin->getField('KETERANGAN');
	
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	<title>Form Validation - jQuery EasyUI Demo</title>

    
    <link rel="stylesheet" type="text/css" href="../WEB-INF/lib/easyui/themes/default/easyui.css">
    <script type="text/javascript" src="../WEB-INF/js/jquery-1.6.1.min.js"></script>
    <script type="text/javascript" src="../WEB-INF/lib/easyui/jquery.easyui.min.js"></script>
	<script type="text/javascript" src="../WEB-INF/lib/colorpicker/js/jquery/jquery.js"></script>
	
    <!--warna-->
	<script src="../WEB-INF/lib/colorpicker/jquery.colourPicker.js" type="text/javascript"></script>
	<link href="../WEB-INF/lib/colorpicker/jquery.colourPicker.css" rel="stylesheet" type="text/css">
    <!--warna-->   
	<script type="text/javascript">
	/*
		function setNull(){
			$('#labelGeneralCuti').hide();
			$('#reqStatusKeteranganCuti').val('');
			$('#reqKeteranganCuti').val('');
			
			$('#labelGeneralSakit').hide();
			$('#reqStatusKeteranganSakit').attr('checked', false);
			$('#reqStatusKeteranganSakit').val('');
			$('#reqKeteranganSakit').val('');
			
		}
		
		function setAdd(){
			$('#labelGeneralSakit').hide();
			$('#reqStatusKeteranganSakit').attr('checked', false);
			$('#reqStatusKeteranganSakit').val('');
			$('#reqKeteranganSakit').val('');
			
		}
		
		function setValue(ijin_id, keterangan){
			$('#cc').combotree('setValue', '<?=$tempDepartemen?>');
			
			<? 
			if($tempIjinId == '')
			{
			?>
				setAdd();
			<? 
			}
			else
			{
			?>
				setNull();
			<? 
			}
			?>
				
			if(ijin_id == 3)
			{
				$('#labelGeneralSakit').show();
				if('<?=$tempKeterangan?>' == '')
					$('#reqKeteranganSakit').val('Tanpa Surat Keterangan');
				else{
					if('<?=$tempKeterangan?>' == 'Ada Surat Keterangan'){
						$('#reqStatusKeteranganSakit').attr('checked', true);
					}else{
						$('#reqStatusKeteranganSakit').attr('checked', false);
					}
					$('#reqKeteranganSakit').val(keterangan);
				}
			}
			else if(ijin_id == 1)
			{
				$('#labelGeneralCuti').show();
				$('#reqStatusKeteranganCuti').val('1');
				$('#reqKeteranganSakit').val('');
				$('#reqKeteranganCuti').val(keterangan);
			}
		}
			*/
			
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
		$(function(){
			$('#ff').form({
				url:'../json-absensi/absensi_ijin_cuti_add.php',
				onSubmit:function(){
					return $(this).form('validate');
				},
				success:function(data){
					$.messager.alert('Info', data, 'info');
					$('#rst_form').click();
					$('#cc').combotree('setValue', '<?=$tempDepartemen?>');
					top.frames['mainFrame'].location.reload();
					<? if($reqMode == "update") { ?> window.parent.divwin.close(); <? } ?>					
				}				
			});
/*
			$("#reqNRP").keypress(function(e) {
				var code = e.which;
				if(code==13){	
					$.getJSON("../json-absensi/get_pegawai.php?reqKode="+$("#reqNRP").val(),
					function(data){
						$("#reqNama").val(data.nama);
						$("#reqPegawaiId").val(data.pegawai_id);
						$("#reqDepartemen").val(data.departemen);
						$("#reqDepartemenId").val(data.departemen_id);
					});
				}
			});
			
			// kondisi pilih status sakit
			$('#reqStatusKeteranganSakit').bind('click', function(ev) {
				var n = $("#reqStatusKeteranganSakit:checked").length;
				if(n == 1)
					$('#reqKeteranganSakit').val('Ada Surat Keterangan');
				else
					$('#reqKeteranganSakit').val('Tanpa Surat Keterangan');
			});	
			
			
			$('#reqIjinId').bind('change', function(ev) {		
				var ijin_id = $('#reqIjinId').val();
				
				setNull();
				
				if(ijin_id == 3)
				{
					$('#labelGeneralSakit').show();
					
					// kondisi apabila status surat Ada Surat Keterangan
					if('<?=$tempKeterangan?>' == 'Ada Surat Keterangan'){
						$('#reqStatusKeteranganSakit').attr('checked', true);
						$('#reqKeteranganSakit').val('<?=$tempKeterangan?>');
					}
					// kondisi apabila status surat Tanpa Surat Keterangan
					else if('<?=$tempKeterangan?>' == 'Tanpa Surat Keterangan'){
						$('#reqStatusKeteranganSakit').attr('checked', false);
						$('#reqKeteranganSakit').val('<?=$tempKeterangan?>');
					}
					// kondisi apabila status awal
					else{
						$('#reqStatusKeteranganSakit').attr('checked', false);
						$('#reqKeteranganSakit').val('Tanpa Surat Keterangan');
					}
				}
				else if(ijin_id == 1)
				{
					$('#labelGeneralCuti').show();
					$('#reqStatusKeteranganCuti').val('1');
				}
			});	
		*/
		});
		</script>
        
         <link rel="stylesheet" href="../WEB-INF/lib/DHTMLWindow/windowfiles/dhtmlwindow.css" type="text/css" />
    <script type="text/javascript" src="../WEB-INF/lib/DHTMLWindow/windowfiles/dhtmlwindow.js"></script>
	<script>
	
	function OptionSet(id, nrp,nama, jabatan, lama_cuti){
			document.getElementById('reqNRP').value = nrp;
			document.getElementById('reqNama').value = nama;
			//document.getElementById('reqJabatan').value = jabatan;
			document.getElementById('reqPegawaiId').value = id;		
			//document.getElementById('reqCutiDiambil').value = lama_cuti;			
		}
		
		function OpenDHTML(opAddress, opCaption, opWidth, opHeight)
		{
			var left = (screen.width/2)-(opWidth/2);
			//var left=50;
			
			divwin=dhtmlwindow.open('divbox', 'iframe', opAddress, opCaption, 'width='+opWidth+'px,height='+opHeight+'px,left='+left+',top=20,resize=1,scrolling=1,midle=1'); return false;
		}
		
		function openPencarianUser()
		{
			OpenDHTML('../simpeg/pegawai_pencarian.php', 'Pencarian User', 900, 700);	
		}
		
	</script>
    <link href="../WEB-INF/css/begron.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" type="text/css" title="blue" href="../WEB-INF/css/admin.css">
    <!--script language="javascript" type="text/javascript" src="../WEB-INF/lib/tiny_mce/tiny_mce.js"></script>
    <script language="javascript" type="text/javascript" src="../jslib/configTextEditorAdm.js"></script--> 

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
<body onLoad="setValue('<?=$tempIjinId?>','<?=$tempKeterangan?>');">
<div id="begron"><img src="../WEB-INF/images/bg-kanan.jpg" width="100%" height="100%" alt="Smile"></div>
<div id="wadah">

    <div id="judul-halaman">
                <span><img src="../WEB-INF/images/panah-judul.png"> Tambah Data Ijin</span>
    </div>
    <form id="ff" method="post" novalidate>
    <table>
    
        <tr>           
             <td>Nama</td>
			 <td><input type="hidden" name="reqPegawaiId" id="reqPegawaiId" value="<?=$tempPegawaiId?>"/>
				<input name="reqNRP" id="reqNRP" class="easyui-validatebox" required style="width:80px" type="hidden" value="<?=$tempNRP?>" />
				<input name="reqNama" id="reqNama" class="easyui-validatebox" readonly style="width:200px" type="text" value="<?=$tempNama?>" />
                &nbsp;&nbsp;
                <img src="../WEB-INF/images/group.png" onClick="openPencarianUser()">
			</td>			
        </tr>
        <tr>           
             <td>Jenis Ijin</td>
			 <td>
                  <select name="reqIjinId" id="reqIjinId">
                  <? $ijin->selectByParams(array(),-1,-1, " AND (KODE LIKE 'I%' OR KODE = 'P' OR KODE LIKE 'S%' OR KODE like 'C%') "," ORDER BY KODE DESC");
                    while($ijin->nextRow()){
                  ?>
                    <option value="<?=$ijin->getField("IJIN_KOREKSI_ID")?>" <? if($ijin->getField("IJIN_KOREKSI_ID") == $tempIjinId) echo "selected"; ?>><?=$ijin->getField("NAMA")?> (<?=$ijin->getField("KODE")?>)</option>
                  <?
                    }
                  ?>
                  </select>
             
             <!--label id="labelGeneralSakit">
                <input type="checkbox" id="reqStatusKeteranganSakit" name="reqStatusKeteranganSakit" value="3" 
				<? 
				  if($tempKeterangan == 'Tanpa Surat Keterangan' || $tempKeterangan == 'Ada Surat Keterangan'){
					  if($tempKeterangan == 'Ada Surat Keterangan')
					  	echo 'checked'; 
			      }?>
                >
                <input type="text" id="reqKeteranganSakit" name="reqKeteranganSakit" readonly style='font-size:12px; font-weight:bold; width:300px; border:none; background:inherit' size="20" value="<?=$tempKeteranganSakit?>">
             </label-->
             <!--label id="labelGeneralCuti">
             	<input type="hidden" id="reqStatusKeteranganCuti" name="reqStatusKeteranganCuti">
                <select id="reqKeteranganCuti" name="reqKeteranganCuti">
                	<option value="Cuti Tahunan" <? if($tempKeterangan == 'Cuti Tahunan') echo 'selected';?>>Cuti Tahunan</option>
                    <option value="Cuti alasan penting" <? if($tempKeterangan == 'Cuti alasan penting') echo 'selected';?>>Cuti alasan penting</option>
                    <option value="Cuti Sakit" <? if($tempKeterangan == 'Cuti Sakit') echo 'selected';?>>Cuti Sakit</option>
                    <option value="Cuti Besar" <? if($tempKeterangan == 'Cuti Besar') echo 'selected';?>>Cuti Besar</option>
                </select>
             </label-->
			</td>
        </tr>                
        <tr>
            <td>Tanggal Awal</td>
            <td>
				<input id="dd" name="reqTanggalAwal" class="easyui-datebox" required value="<?=$tempTanggalAwal?>"></input>                
            </td>
        </tr>
        <tr>
            <td>Tanggal Akhir</td>
            <td>
				<input id="dd" name="reqTanggalAkhir" class="easyui-datebox" required value="<?=$tempTanggalAkhir?>"></input>                
            </td>
        </tr>
        <tr>
            <td>Keterangan</td>
            <td>
            <textarea name="reqKeterangan" cols="40" rows="3"><?=$tempKeterangan?></textarea>
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