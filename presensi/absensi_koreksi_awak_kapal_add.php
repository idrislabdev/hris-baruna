<?
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base-absensi/AbsensiKoreksi.php");
include_once("../WEB-INF/classes/base-absensi/IjinKoreksi.php");
include_once("../WEB-INF/classes/base-simpeg/Pegawai.php");

$absensi_koreksi = new AbsensiKoreksi();
$ijin_koreksi = new IjinKoreksi();

$reqId = httpFilterGet("reqId");

$reqBulan = httpFilterGet("reqBulan");
$reqTahun = httpFilterGet("reqTahun");
$reqKelompok = httpFilterGet("reqKelompok");

$reqPeriode = $reqBulan.$reqTahun;
$tempDepartemen = $userLogin->idDepartemen;
 
// calc dates and weekdays
if ($reqBulan == null || $reqBulan == '')		
	$currMonth= date("m");				
else
	$currMonth = intval($reqBulan);	
				
$currYear = $reqTahun;
$startDate = strtotime($currYear . "-" . $currMonth . "-01 00:00:01");
$startDay= date("N", $startDate);
$monthName = date("M",$startDate );

$daysInMonth = cal_days_in_month(CAL_GREGORIAN, date("m", $startDate), date( "Y", $startDate));
$endDate = strtotime($currYear . "-" . $currMonth . "-" .  $daysInMonth ." 00:00:01");

$endDay = date("N", $endDate);
// php date sunday is zero
if ($startDay> 6)
	$startDay = 7 -$startDay;

$currElem = 0;
$dayCounter = 0;
$firstDayHasCome = false;
$arrCal = array();
for($i = 0; $i <= 5; $i ++) {
	for($j= 0; $j <= 6; $j++) {
		// decide what to show in the cell
		if($currElem < $startDay && !$firstDayHasCome)			
			$arrCal[$i][$j] = "";
		else if ($currElem == $startDay && !$firstDayHasCome) {
			$firstDayHasCome= true;
			$arrCal[$i][$j] = ++$dayCounter;
		}
		else if ($firstDayHasCome) {
			if ($dayCounter < $daysInMonth)
				$arrCal[$i][$j] = ++ $dayCounter; 
			else
				$arrCal[$i][$j] = "";	
		}							

		$currElem ++;				
	}
}
		
$reqHariLibur = $absensi_koreksi->getHariLibur($reqBulan,$reqTahun);
$absensi_koreksi->selectByParams(array('A.PEGAWAI_ID'=>$reqId), -1, -1, "", $reqPeriode);
$absensi_koreksi->firstRow();			

$ijin_koreksi->selectByParams(array());
$k=0;
while($ijin_koreksi->nextRow())
{
	$arrIjin[$k]["ID"] = $ijin_koreksi->getField("KODE"); 
	$arrIjin[$k]["NAMA"] = $ijin_koreksi->getField("NAMA");
	$k++;	
}

$pegawai = new Pegawai();
$pegawai->selectByParams(array("A.PEGAWAI_ID" => $reqId));
$pegawai->firstRow();
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

	<script type="text/javascript">
	
		$(function(){
			$('#ff').form({
				url:'../json-absensi/absensi_koreksi_add.php',
				onSubmit:function(){
					return $(this).form('validate');
				},
				success:function(data){
					$.messager.alert('Info', data, 'info');
					top.frames['mainFrame'].location = 'absensi_koreksi_awak_kapal.php?reqTahun=<?=$reqTahun?>&reqBulan=<?=$reqBulan?>';
					//window.parent.divwin.close();			
				}				
			});

		});
	</script>
    
    <link href="../WEB-INF/css/begron.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" type="text/css" title="blue" href="../WEB-INF/css/admin.css">
    <script language="javascript" type="text/javascript" src="../WEB-INF/lib/tiny_mce/tiny_mce.js"></script>
    <script language="javascript" type="text/javascript" src="../jslib/configTextEditorAdm.js"></script> 
	<script language="javascript">
 		function updateKoreksiHari(id, hari, value)
		{
			var string = document.getElementById("reqKoreksiHari").value;
			var result = string.match(hari);
			// result == 'BEST';
			
			if (result){
				return;
			}			
			
			if(document.getElementById("reqKoreksiHari").value == "")
				comma = "";
			else
				comma = ",";
			
			if(document.getElementById("reqIjinId"+id).value == value)
			{}
			else
				document.getElementById("reqKoreksiHari").value = document.getElementById("reqKoreksiHari").value + comma + hari;
				
		}
    </script>
<style type="text/css">
div.wrapper{
	display:block;
	width:100%;
	margin:0;
	text-align:left;
	background-color:#f3e6c3;
}

.col1{
	height:100px;
	background-color:#231f20;
	color:#FFFFFF;
	}
.col2{
	height:1950px;
	background-image:url(../images/live137244_goldensparks.jpg);
	background-repeat:no-repeat;
	padding-top:30px;
	}
.col4{
	height:auto;
	background-color:#bdbdbd;
	color:#000000;
	padding-top:20px;
	padding-bottom:10px;
	}
.col5{
	height:30px;
	background-color:#060606;
	color:#FFFFFF;
	padding-top:20px;
	}
.col6{	
	height:70px;
	background-color:#231f20;
	padding-top:10px;
	color:#FFFFFF;
	}

.heading{
	font:"Times New Roman", Times, serif;
	font-weight:bold;
	font-size:20px;
	margin:10px 0 10px 0;
	}
.heading1{
	font:"Times New Roman", Times, serif;
	font-weight:bold;
	font-size:18px;
	}
.heading2{
	font:"Times New Roman", Times, serif;
	font-weight:bold;
	font-size:30px;
	text-align:center;
	color:#a21212;
	margin-bottom:10px;
	}
.closingDate{
	margin-top:40px;
	text-align:center;
	font-weight:bold;
	color:#FF0000;
	}
	
.clear{
	clear:both;
	}
.container_col2{
	width:980px;
	min-height:300px;
	height:auto;
	margin:0 auto;
	padding:40px;
	background-color:#FFFFFF;
	}
.container_comp{
	width:980px;
	height:500px;
	margin:0 auto;
	padding:40px;
	background-color:#f7f7f7;
	border-radius:20px;
	border:1px solid #999999;
	margin-bottom:25px;
	}
.container_calendar{
	/*width:840px;
	height:541px;*/
	width:805px;
	height:465px;
	margin:0 auto;
	background-color:#f7f7f7;
	border-radius:20px;
	border:2px solid #999999;
	margin-bottom:25px;
	}
	

.navg_month{
	height:24px;
	text-align:center;
	margin-bottom:15px;
	font-size:16px;
	word-spacing:10px;
	}
.month{
	color:#a21212;
	text-decoration:none;
	}
.month:hover{
	color:#000066;
	text-decoration:none;
	}
.day{
	/*width:109px;*/
	width:104px;
	height:25px;
	color:#330000;
	float:left;
	padding:5px;
	text-align:center;
	font:bold 14px arial;
	border-bottom:1px solid #999999;
	border-right:1px solid #999999;
	background-color:#cccccc;
	}
.date{
	/*width:119px;
	height:100px;*/
	width:114px;
	height:70px;
	float:left;
	border-bottom:1px solid #999999;
	border-right:1px solid #999999;
	background-color:#ffffff;
	}
.date:hover{
	background-color:#ededed;
	cursor:pointer;
	}
.date .top{
	/*width:118px;*/
	width:114px;
	height:48px;
	/*border:1px solid red;*/
	}
.date .bottom{
	width:114px;
	height:48px;
	/*border:1px solid red;*/
	}
.date .bottom .part{
	width:37px;
	height:46px;
	float:left;
	/*border:1px solid red;*/
	}
.seprator{
	color:#333333;
	text-shadow:#000000;
	}
</style>
     
</head>
<body>
<div id="begron"><img src="../WEB-INF/images/bg-kanan.jpg" width="100%" height="100%" alt="Smile"></div>
<div id="wadah">

    <div id="judul-halaman">
                <span><img src="../WEB-INF/images/panah-judul.png"> Tambah Koreksi Absen</span>
        <div style="float:right; margin-right:20px; margin-top:-20px;">
            <div style="margin-top:28px; width:400px; margin-left:5px; float:left; position:relative; text-align:left;">
                <div style="border:2px solid #FFF; float:left; margin-right:4px; height:77px; width:60px; -webkit-box-shadow: 0 8px 6px -6px black; -moz-box-shadow: 0 8px 6px -6px black; box-shadow: 0 8px 6px -6px black;">
                    <img src="../simpeg/image_script.php?reqPegawaiId=<?=$reqId?>&reqMode=pegawai" width="60" height="77">
                </div>
                
                <div style="float:left; position:relative; width:300px;"> 
                    <div style="color:#000; font-size:18px; text-shadow:1px 1px 1px #000;"><?=$pegawai->getField("NAMA")?> (<?=$pegawai->getField("NRP")?>)</div>     
                    <div style="color:#000; font-size:16px; text-shadow:1px 1px 1px #000; line-height:20px;">Hari Kerja : <?=$reqKelompok?></div>
                    <div style="color:#000; font-size:16px; text-shadow:1px 1px 1px #000; line-height:20px;">Periode : <?=$monthName. "&nbsp;" . $currYear?></div>
                </div>
        	</div>
 	    </div>	
    </div>
    
    <!--<div class="container_comp">-->
    <div>
     <form id="ff" method="post" novalidate>
        <div class="heading2">&nbsp;</div>
        <div class="container_calendar">
            <div>
                <div class="day" style="border-top-left-radius:18px;">Minggu</div>
                <div class="day">Senin</div>
                <div class="day">Selasa</div>
                <div class="day">Rabu</div>
                <div class="day">Kamis</div>
                <div class="day">Jum'at</div>
                <div class="day" style="border-top-right-radius:18px;">Sabtu</div>
                <div class="clear"></div>
            </div>

            <?php
                $currElem = 0;
                $dayCounter = 0;
                $firstDayHasCome = false;
                $lowerLeftCorner= "style=\"border-bottom-left-radius:18px;\"";
                $lowerRightCorner= "style=\"border-bottom-right-radius:18px;\"";

                for($i = 0; $i <= 5; $i ++) {
                    echo("<div>\r\n");
                    for($j= 0; $j <= 6; $j++) {
                        
                        $divId = $currYear . "-";
                        $divId .= $currMonth . "-";
                        if(intval($arrCal[$i][$j]) < 10)
                            $divId .= "0";
                        $divId .= $arrCal[$i][$j];

                        $leftCorner = "";
                        $rightCorner = "";
                        if ($i == 5 && $j ==0)
                            $leftCorner = $lowerLeftCorner;
                        if ($i == 5 && $j == 6)
                            $leftCorner = $lowerRightCorner;

                        // decide what to show in the cell
                        if($currElem < $startDay && !$firstDayHasCome)	{		
                            echo("<div class=\"date\"". $leftCorner .">\r\n");
                            echo("</div>\r\n");

                        }
                        else if ($currElem == $startDay && !$firstDayHasCome) {
                            $firstDayHasCome= true;
							if((date('l', strtotime($divId)) == "Saturday" || date('l', strtotime($divId)) == "Sunday" || searchWordDelimeter($reqHariLibur, (int)date("d", strtotime($divId))) == true) && $reqKelompok == '5H')
								$libur = true;
							else
								$libur = false;								
							?>
							<div id="<?=$divId?>" class="date" <?=$leftCorner?> <? if($libur == true) { ?> style="background-color:#F00" <? } elseif($absensi_koreksi->getField("HARI_".$arrCal[$i][$j]) == 'A') { ?> style="background-color:#FFC" <? } ?>>
							<div class="top">
							<div class="date_topright"><?=$arrCal[$i][$j]?><br>
                            <?
							if($libur == false)
							{
							?>
                              <select name="reqIjinId[]" id="reqIjinId<?=$arrCal[$i][$j]?>" style="width:105px;" onChange="updateKoreksiHari('<?=$arrCal[$i][$j]?>', '<?=generateZero($arrCal[$i][$j], 2)?>', '<?=$absensi_koreksi->getField("HARI_".$arrCal[$i][$j])?>');">
                              <?
							  for($k=0;$k<count($arrIjin);$k++)
							  {	
                              ?>
                              <option value="<?=$arrIjin[$k]["ID"]?>" <? if($arrIjin[$k]["ID"] == $absensi_koreksi->getField("HARI_".$arrCal[$i][$j])) echo "selected"; ?>><?=$arrIjin[$k]["NAMA"]?></option>
                              <?
                              }
                              ?>
                              </select>
                            <?
							}
							else
							{
							?>
                            	<input type="hidden" name="reqIjinId[]">
                            <?
							}
							?>
                            </div>
							</div>
							<div class="bottom">
							<div class="part"></div>
							<div class="part"></div>
							<div class="part"></div>
							</div>
							</div>							
                            <?
                            $dayCounter ++;

                        }
                        else if ($firstDayHasCome) {
                            if ($dayCounter < $daysInMonth) {
								if((date('l', strtotime($divId)) == "Saturday" || date('l', strtotime($divId)) == "Sunday" || searchWordDelimeter($reqHariLibur, (int)date("d", strtotime($divId))) == true) && $reqKelompok == '5H')
									$libur = true;
								else
									$libur = false;	
								?>
								<div id="<?=$divId?>" class="date" <?=$leftCorner?> <? if($libur == true) { ?> style="background-color:#F00" <? } elseif($absensi_koreksi->getField("HARI_".$arrCal[$i][$j]) == 'A') { ?> style="background-color:#FFC" <? } ?>>
								<div class="top">
								<div class="date_topright"><?=$arrCal[$i][$j]?><br>
                                  <?
								  if($libur == false)
								  {
								  ?>
 	                              <select name="reqIjinId[]" id="reqIjinId<?=$arrCal[$i][$j]?>" style="width:105px;" onChange="updateKoreksiHari('<?=$arrCal[$i][$j]?>', '<?=generateZero($arrCal[$i][$j], 2)?>', '<?=$absensi_koreksi->getField("HARI_".$arrCal[$i][$j])?>');">
                                   <?
                                  for($k=0;$k<count($arrIjin);$k++)
                                  {	
                                  ?>
                                  <option value="<?=$arrIjin[$k]["ID"]?>" <? if($arrIjin[$k]["ID"] == $absensi_koreksi->getField("HARI_".$arrCal[$i][$j])) echo "selected"; ?>><?=$arrIjin[$k]["NAMA"]?></option>
                                  <?
                                  }
                                  ?>
                                  </select>                                
									<?
                                    }
                                    else
                                    {
                                    ?>
                                        <input type="hidden" name="reqIjinId[]">
                                    <?
                                    }
                                    ?>
                                </div>
								</div>
								<div class="bottom">
								<div class="part"></div>
								<div class="part"></div>
								<div class="part"></div>
								</div>
								</div>							
								<?
                                $dayCounter ++;
                            }	
                            else {
                                echo("<div class=\"date\"". $leftCorner . ">\r\n");
                                echo("</div>\r\n");

                            }
                        }								
        
                    $currElem ++;				
                    }
                    echo("</div>\r\n");
                }
                
            ?>
            <br>&nbsp;<br>
            <input type="hidden" name="reqId" value="<?=$reqId?>">
            <input type="hidden" name="reqKoreksiHari" id="reqKoreksiHari" value="<?=$reqKoreksiHari?>">
            <input type="hidden" name="reqPeriode" value="<?=$reqPeriode?>">
            <input type="hidden" name="reqKategori" value="KAPAL">
            <input type="submit" value="Submit">         
        </div>
 	</form>
    </div>
    
</div>
</body>
</html>