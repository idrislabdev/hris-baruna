<?
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base-simpeg/Departemen.php");
include_once("../WEB-INF/classes/base-simpeg/DepartemenKelas.php");

$departemen = new Departemen();
$reqMode = httpFilterGet("reqMode");
$reqId = httpFilterGet("reqId");
$reqCabangId = httpFilterGet("reqCabangId");

if($reqMode == "update")
{
	$departemen->selectByParams(array("DEPARTEMEN_ID" => $reqId));
	$departemen->firstRow();
	$tempNama = $departemen->getField("NAMA");
	$tempKeterangan = $departemen->getField("KETERANGAN");
	$tempPuspel = $departemen->getField("PUSPEL");
	$tempStatus= $departemen->getField("STATUS_AKTIF");
	$tempTmtAktif= dateToPage($departemen->getField("TMT_AKTIF"));
	$tempTmtNonAktif= dateToPage($departemen->getField("TMT_NON_AKTIF"));	
	$tempKodeSubBantu = $departemen->getField("KODE_SUB_BANTU");   
    $tempKodeBBPangkal = $departemen->getField("KODE_BB_PANGKAL");    
    $tempKodeBBSPP = $departemen->getField("KODE_BB_SPP");    
    $tempKodeBBKegiatan = $departemen->getField("KODE_BB_KEGIATAN");    
    $tempKodeBPPangkal = $departemen->getField("KODE_BP_PANGKAL");    
    $tempKodeBPSPP = $departemen->getField("KODE_BP_SPP");   
    $tempKodeBPKegiatan = $departemen->getField("KODE_BP_KEGIATAN");
    $tempKategoriSekolah = $departemen->getField("KATEGORI_SEKOLAH");

    
}
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
				url:'../json-intranet/departemen_add.php',
				onSubmit:function(){
					return $(this).form('validate');
				},
				success:function(data){
                    //alert(data);
                    //return false;
					$.messager.alert('Info', data, 'info');
					top.frames['mainFrame'].location.reload();
					<? if($reqMode == "update") { ?> window.parent.divwin.close(); <? } ?>					
				}
			});
		});
		$.fn.datebox.defaults.formatter = function(date){
			var y = date.getFullYear();
			var m = date.getMonth()+1;
			var d = date.getDate();
			return d+'-'+m+'-'+y;
		}	


        function createRowDepartemenKelas()
        {
            $(function () {
                  $.get("departemen_kelas_template", function (data) {
                    $("#tbDepartemenKelas").append(data);
                });
            }); 
        }
	
	</script>
    <link href="../WEB-INF/css/begron.css" rel="stylesheet" type="text/css">  
    <link rel="stylesheet" type="text/css" title="blue" href="../WEB-INF/css/admin.css">
    <link href="../WEB-INF/css/begron.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" type="text/css" href="../WEB-INF/css/admin.css">
    <link href="../WEB-INF/lib/media/themes/main_datatables.css" rel="stylesheet" type="text/css" /> 
</head>
<body onLoad="setValue();">
<div id="begron"><img src="../WEB-INF/images/bg-kanan.jpg" width="100%" height="100%" alt="Smile"></div>
<div id="wadah">

    <div id="judul-halaman">
                <span><img src="../WEB-INF/images/panah-judul.png">Tambah Data Departemen</span>
    </div>
    <form id="ff" method="post" novalidate>
    <table>
        <tr>
            <td>Nama Departemen</td>
            <td>
                <input name="reqNama" class="easyui-validatebox" required title="Nama departemen harus diisi" size="40" type="text" value="<?=$tempNama?>" />
            </td>
        </tr>
        <tr>
            <td>Keterangan</td>

            <td>
                <textarea name="reqKeterangan" title="Keterangan harus diisi" style="width:250px; height:10	0px;"><?=$tempKeterangan?></textarea>
            </td>
        </tr>
        <tr>
            <td>Puspel</td>
            <td>
                <input name="reqPuspel" class="easyui-validatebox" required title="Nama puspel harus diisi" size="20" type="text" value="<?=$tempPuspel?>" />
            </td>
        </tr>  
        <tr>
            <td>Kode Sub Bantu</td>
            <td>
                <input name="reqKodeSubBantu" class="easyui-validatebox" title="Kode Sub bantu harus diisi" size="20" type="text" value="<?=$tempKodeSubBantu?>" />
            </td>
        </tr>  
        <tr>
            <td>Status</td>
            <td>
                <input type="checkbox" <? if($tempStatus == '1') echo 'checked';?> name="reqStatus" value="1" />
            </td>
        </tr>       
        <tr>
            <td>TMT Aktif</td>
            <td>
				<?
                	if($tempTmtAktif == "--")
					{
				?>
                	<input id="dd" name="reqTmtAktif" class="easyui-datebox" value=""></input>
				<?
					}
					else
					{
				?>	
                	<input id="dd" name="reqTmtAktif" class="easyui-datebox" value="<?=$tempTmtAktif?>"></input>                
            	<?
					}
				?>
            </td>
        </tr>
        <tr>
            <td>TMT Non Aktif</td>
            <td>
				<?
                	if($tempTmtNonAktif == "--")
					{
				?>
                	<input id="dd" name="reqTmtNonAktif" class="easyui-datebox" value=""></input>
				<?
					}
					else
					{
				?>	
                	<input id="dd" name="reqTmtNonAktif" class="easyui-datebox" value="<?=$tempTmtNonAktif?>"></input>                
            	<?
					}
				?>             
            </td>
        </tr>  
        <tr>
            <td>Kode BB Pangkal</td>
            <td>
                <input name="reqKodeBBPangkal" id="reqKodeBBPangkal" class="easyui-validatebox" required title="Nama puspel harus diisi" size="20" type="text" value="<?=$tempKodeBBPangkal?>" />
            </td>
        </tr>  
        <tr>
            <td>Kode BB SPP</td>
            <td>
                <input name="reqKodeBBSPP" id="reqKodeBBSPP" class="easyui-validatebox" required title="Nama puspel harus diisi" size="20" type="text" value="<?=$tempKodeBBSPP?>" />
            </td>
        </tr>  
        <tr>
            <td>Kode BB Kegiatan</td>
            <td>
                <input name="reqKodeBBKegiatan" id="reqKodeBBKegiatan" class="easyui-validatebox" required title="Nama puspel harus diisi" size="20" type="text" value="<?=$tempKodeBBKegiatan?>" />
            </td>
        </tr>   
        <tr>
            <td>Kode BP Pangkal</td>
            <td>
                <input name="reqKodeBPPangkal" id="reqKodeBPPangkal" class="easyui-validatebox" required title="Nama puspel harus diisi" size="20" type="text" value="<?=$tempKodeBPPangkal?>" />
            </td>
        </tr>  
        <tr>
            <td>Kode BP SPP</td>
            <td>
                <input name="reqKodeBPSPP" id="reqKodeBPSPP" class="easyui-validatebox" required title="Nama puspel harus diisi" size="20" type="text" value="<?=$tempKodeBPSPP?>" />
            </td>
        </tr>  
        <tr>
            <td>Kode BP Kegiatan</td>
            <td>
                <input name="reqKodeBPKegiatan" id="reqKodeBPKegiatan" class="easyui-validatebox" required title="Nama puspel harus diisi" size="20" type="text" value="<?=$tempKodeBPKegiatan?>" />
            </td>
        </tr>  
        <tr>
            <td>Kategori Sekolah</td>
            <td>
                <input type="text" name="reqKategoriSekolah" id="reqKategoriSekolah" class="easyui-combobox" style="width:170%" data-options="valueField:'id',textField:'text',url:'../json-simpeg/kategori_sekolah_combo_json.php'" value="<?=$tempKategoriSekolah?>" />

            </td>
        </tr> 
        <?
        if($reqMode == "insert")
        {}
        else
        {
        ?>
                 <table id="gradient-style" style="width:96%">
                    <thead>
                        <tr>
                            <th scope="col">Nama<a style="cursor:pointer" id="btnAdd" title="Tambah" onClick="createRowDepartemenKelas()">Tambah</a></th>
                            <th scope="col">Keterangan</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="tbDepartemenKelas">
                        <?
                            $departemen_kelas = new DepartemenKelas();
                            $departemen_kelas->selectByParams(array("DEPARTEMEN_ID" => $reqId));
                            while($departemen_kelas->nextRow())
                            {
                        ?>
                            <tr>
                                <td>
                                    <input type="hidden" name="reqDepartemenKelasId[]" value="<?=$departemen_kelas->getField("DEPARTEMEN_KELAS_ID")?>">
                                    <input type="text" name="reqNamaKelas[]" value="<?=$departemen_kelas->getField("NAMA")?>"></td>
                                <td>
                                    <input type="text" name="reqKeteranganKelas[]" value="<?=$departemen_kelas->getField("KETERANGAN")?>">
                                    </td>
                                <td>
                                    <a class="hapus" style="text-align:center; cursor:pointer" onclick="$(this).parent().parent().remove();">DELETE</a>
                                </td>
                            </tr>
                        <?
                        }
                        ?>
                    </tbody>  
                </table>    
        <?
        }
        ?>      
    </table>
        <div>
            <input type="hidden" name="reqId" value="<?=$reqId?>">
            <input type="hidden" name="reqCabangId" value="<?=$reqCabangId?>">
            <input type="hidden" name="reqMode" value="<?=$reqMode?>">
            <input type="submit" value="Submit">
            <input type="reset" id="rst_form">
        </div>
    </form>
</div>
</body>
</html>