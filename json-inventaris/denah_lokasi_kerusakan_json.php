<?
/* INCLUDE FILE */
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base-inventaris/Lokasi.php");


/* create objects */

$lokasi_parent = new Lokasi();
$_THUMB_PREFIX = "z__thumb_";
$_IMAGE_PREFIX = "z__image_";

$i = 0;

$lokasi_parent->selectByParams(array("LOKASI_PARENT_ID" => 0), -1,-1, " AND EXISTS(SELECT 1 FROM INVENTARIS_RUANGAN X INNER JOIN INVENTARIS_PERBAIKAN Y ON X.INVENTARIS_RUANGAN_ID = Y.INVENTARIS_RUANGAN_ID WHERE SUBSTR(X.LOKASI_ID, 1, 3) = A.LOKASI_ID) AND NOT FILE_GAMBAR IS NULL ");
while($lokasi_parent->nextRow())
{
	$arr_categories[$i]['id'] = "categories".$i;
	$arr_categories[$i]['title'] = $lokasi_parent->getField("NAMA");
	$arr_categories[$i]['color'] = "#38a3d5";
	$arr_categories[$i]['show']  = "false";
	
	$arr_level[$i]['id'] = "level".$i;
	$arr_level[$i]['name'] = $lokasi_parent->getField("NAMA");
	$arr_level[$i]['title'] = $lokasi_parent->getField("NAMA");
	$arr_level[$i]['map']  = "../masterdata/uploads/lokasi/".$lokasi_parent->getField("FILE_GAMBAR");	
	if($i == 0)
		$arr_level[$i]['show']  = "true";	
	$arr_level[$i]['minimap']  = "../masterdata/uploads/lokasi/".$_THUMB_PREFIX.$lokasi_parent->getField("FILE_GAMBAR");
	
	list($width, $height, $type, $attr) = getimagesize("../masterdata/uploads/lokasi/".$lokasi_parent->getField("FILE_GAMBAR"));	
	
	$j=0;
	$lokasi = new Lokasi();	
	$lokasi->selectByParamsLokasiPerbaikan(array(), -1, -1, " AND LOKASI_PARENT_ID = '".$lokasi_parent->getField("LOKASI_ID")."' ");
	while($lokasi->nextRow())
	{
		
		$desc = "<table>";
		$desc .= "<tr><td>Penanggung Jawab :</td><td>".$lokasi->getField("KETERANGAN")."</td></tr>";
		$desc .= "<tr><td colspan='2'>".$lokasi->getField("KERUSAKAN")."</td></tr>";	
		$desc .= "</table>";
			
		$arr_location[$j]['id'] = "location".$i."-".$j;
		$arr_location[$j]['label'] = $lokasi->getField("NAMA");
		$arr_location[$j]['kondisi'] = $lokasi->getField("LOKASI_INDUK");	
		$arr_location[$j]['description'] = $desc;
		$arr_location[$j]['category'] = "categories".$i;
		if($lokasi->getField("TOTAL_ARSIP") > 0)
			$icon = "im-pin-green";
		else
			$icon = "im-pin";
		
		$arr_location[$j]['icon'] = $icon;		
		$arr_location[$j]['x']  = round($lokasi->getField("X") / $width, 2);
		$arr_location[$j]['y']  = round($lokasi->getField("Y") / $height, 2);	
		$arr_location[$j]['zoom'] = "3";		
		$j++;
	}
	$arr_level[$i]['locations'] = $arr_location;
	unset($arr_location);
	unset($lokasi);
	$i++;
}

$arr_utama[0]['mapwidth'] = $width;
$arr_utama[0]['mapheight'] = $height;
$arr_utama[0]['categories'] = $arr_categories;
$arr_utama[0]['levels'] = $arr_level;

echo substr(substr(json_encode($arr_utama), 1), 0, -1);
?>