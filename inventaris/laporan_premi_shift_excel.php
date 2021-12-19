<?
include_once("functions/string.func.php");
include_once("functions/date.func.php");
$reqStatusPegawai = $this->input->post("reqStatusPegawai");
$reqDepartemen = $this->input->post("reqDepartemen");
$reqStatusPegawaiNama = $this->input->post("reqStatusPegawaiNama");
$reqDepartemenNama = $this->input->post("reqDepartemenNama");
$reqPeriode = $this->input->post("reqPeriode");
$reqExcel = $this->input->post("reqExcel");

if($reqExcel == "1")
{
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=laporan_premi_shift.xls");
}

$this->load->model("GajiPegawai");
$gaji_pegawai = new GajiPegawai();


$statement_privacy .= " AND PERIODE = '".$reqPeriode."'";


/* FILTER DEPARTEMEN */
$arrDepartemen = explode("-", $reqDepartemen);
$reqCabangId = $arrDepartemen[0];
$reqDepartemenId = $arrDepartemen[1];
$reqSubDepartemenId = $arrDepartemen[2];

if(trim($reqDepartemen) !== '')
    $statement_privacy .= " AND A.CABANG_ID LIKE '".$reqDepartemen."%'";
if (trim($reqDepartemenId) !== '')
    $statement_privacy .= " AND A.DEPARTEMEN_ID LIKE '".$reqDepartemen."%'";
if (trim($reqSubDepartemenId) !== "")
    $statement_privacy .= " AND A.SUB_DEPARTEMEN_ID LIKE '".$reqSubDepartemenId."%' ";

if($reqStatusPegawai == "")
{}
else
{
    $statement_privacy .= " AND A.STATUS_PEGAWAI_ID IN (".$reqStatusPegawai.") ";
}

$gaji_pegawai->selectByParamsPremiShift(array(), -1, -1, $statement_privacy);
//echo $gaji_pegawai->query;exit;
if($reqStatusPegawaiNama == "")
    $reqStatusPegawaiNama = "Semua";
if($reqDepartemenNama == "")
    $reqDepartemenNama = "Semua";
?>
<!doctype html>
<html>
	<head>
		<meta charset="utf-8">
		<base href="<?=base_url()?>" />
        <script>
		document.onkeydown = function(e) {
			if(e.keyCode == 123) {
			 return false;
			}
			if(e.ctrlKey && e.shiftKey && e.keyCode == 'I'.charCodeAt(0)){
			 return false;
			}
			if(e.ctrlKey && e.shiftKey && e.keyCode == 'J'.charCodeAt(0)){
			 return false;
			}
			if(e.ctrlKey && e.keyCode == 'U'.charCodeAt(0)){
			 return false;
			}
		
			if(e.ctrlKey && e.shiftKey && e.keyCode == 'C'.charCodeAt(0)){
			 return false;
			}      
		 }		
		</script>
	    <link rel="stylesheet" type="text/css" href="css/gaya-laporan.css">
	</head>
    
	<body oncontextmenu="return false;">
    
    <!-- <table class="area-kop-slip">
    	<tr>
    	<?
		if($reqExcel == "1")
		{}
		else
		{
		?>
        	<td rowspan="3" width="100px"><img src="images/PJB-PNG.png" class="logo-slip"></td>
        <?
		}
		?>
        	<td colspan="10"><strong>PT PJB</strong></td>
        </tr>
    	<tr>
    	  <td colspan="10">Jl. Ketintang Baru No. 11. Surabaya (60231) Jawa Timur, Indonesia</td>
  	  </tr>
    	<tr>
    	  <td colspan="10">Telp. (62-31) 8283180 Fax. (62-31) 8283183</td>
  	  </tr>
	</table>
    
    
    <div class="area-keterangan-slip">
    	<div align="center"><b>LAPORAN PREMI SHIFT<br>
         Periode <?=getNamePeriode($reqPeriode)?></b></div>
    </div>
    <div  class="area-data-slip">
         <div class="atas" align="left">Status : <?=$reqStatusPegawaiNama?></div>
        <div class="bawah" align="left">Cabang : <?=$reqDepartemenNama?> </div>
    </div>     -->
    
    <table class="area-data-slip" border="1">
    	<tr>
            <td rowspan="2">No. </td>
            <td rowspan="2">NID</td>
            <td rowspan="2">Nama</td>
            <td rowspan="2">Jabatan</td>
            <td colspan="3">Jumlah Shift Hari    Kerja</td>
            <td rowspan="2">Premi Shift Hari Kerja</td>
            <td colspan="3">Jumlah Shift Hari    Libur</td>
            <td rowspan="2">Premi Shift Hari Libur</td>
            <td rowspan="2">Jumlah Hari Shift</td>
            <td rowspan="2">Total Premi Shift</td>
        </tr>
        <tr>
            <td>Pagi</td>
            <td>Sore</td>
            <td>Malam</td>
            <td>Pagi</td>
            <td>Sore</td>
            <td>Malam</td>
         </tr>
      <?
	  $no= 1;
	  $PREMI_NORMAL = 0;
	  $PREMI_LIBUR = 0;
	  $TOTAL_PREMI = 0;
	  while($gaji_pegawai->nextRow())
	  {
      ?>
      	<tr>
        	<td><?=$no?></td>
        	<td><?=$gaji_pegawai->getField("PEGAWAI_ID")?></td>
        	<td><?=($gaji_pegawai->getField("NAMA"))?></td>
        	<td><?=($gaji_pegawai->getField("JABATAN"))?></td>
        	<td><?=numberToIna($gaji_pegawai->getField("PAGI_NORMAL"))?></td>
        	<td><?=numberToIna($gaji_pegawai->getField("SORE_NORMAL"))?></td>
        	<td><?=numberToIna($gaji_pegawai->getField("MALAM_NORMAL"))?></td>
        	<td><?=numberToIna($gaji_pegawai->getField("PREMI_NORMAL"))?></td>
        	<td><?=numberToIna($gaji_pegawai->getField("PAGI_LIBUR"))?></td>
        	<td><?=numberToIna($gaji_pegawai->getField("SORE_LIBUR"))?></td>
            <td><?=numberToIna($gaji_pegawai->getField("MALAM_LIBUR"))?></td>
            <td><?=numberToIna($gaji_pegawai->getField("PREMI_LIBUR"))?></td>
            <td><?=numberToIna($gaji_pegawai->getField("JUMLAH_HARI"))?></td>
            <td><?=numberToIna($gaji_pegawai->getField("TOTAL_PREMI"))?></td>
        </tr>
      <?
	  $PREMI_NORMAL += $gaji_pegawai->getField("PREMI_NORMAL");
	  $PREMI_LIBUR  += $gaji_pegawai->getField("PREMI_LIBUR");
	  $TOTAL_PREMI  += $gaji_pegawai->getField("TOTAL_PREMI");
	  $no++;
	  }
	  ?>
      <tr>
      	  <th colspan="4"></th>
          <th></th>
          <th></th>
          <th></th>
          <th align="left"><?=numberToIna($PREMI_NORMAL)?></th>
          <th></th>
          <th></th>
          <th></th>
          <th align="left"><?=numberToIna($PREMI_LIBUR)?></th>
          <th></th>
          <th align="left"><?=numberToIna($TOTAL_PREMI)?></th>
      </tr>       
	</table>
    
    </body>
</html>