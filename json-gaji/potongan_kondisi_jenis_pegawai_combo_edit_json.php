<?
/* INCLUDE FILE */
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base-gaji/Kondisi.php");
include_once("../WEB-INF/classes/base-gaji/PotonganKondisiJenisPegawai.php");

/* create objects */

$kondisi = new Kondisi();
$potongan_kondisi_jenis_pegawai = new PotonganKondisiJenisPegawai();


$reqId = httpFilterGet("reqId");
$reqKelasId = httpFilterGet("reqKelasId");
$reqKelompokId = httpFilterGet("reqKelompokId");
$reqJenisPegawaiId = httpFilterGet("reqJenisPegawaiId");
/* LOGIN CHECK */
if ($userLogin->checkUserLogin()) 
{ 
	$userLogin->retrieveUserInfo();
}

$potongan_kondisi_jenis_pegawai->selectByParams(array("JENIS_PEGAWAI_ID" => $reqJenisPegawaiId, "POTONGAN_KONDISI_ID" => $reqId, "KELAS" => $reqKelasId, "KELOMPOK" => $reqKelompokId));
$potongan_kondisi_jenis_pegawai->firstRow();
$text = $potongan_kondisi_jenis_pegawai->getField("JUMLAH");

function checkVariabel($text, $search)
{
	$arrText = explode(",",$text);
	for($i=0;$i<count($arrText);$i++)
	{
		if($arrText[$i] == $search)
			return true;	
	}
	return false;
}

$j=0;
$kondisi->selectByParams(array("KONDISI_PARENT_ID" => 0));
while($kondisi->nextRow())
{
	$arr_parent[$j]['id'] = $kondisi->getField("KONDISI_ID");
	$arr_parent[$j]['text'] = $kondisi->getField("NAMA");
	if(checkVariabel($text, $kondisi->getField("KONDISI_ID")))
		$arr_parent[$j]['checked'] = true;
	$k = 0;
	$child = new Kondisi();
	$child->selectByParams(array("KONDISI_PARENT_ID" => $kondisi->getField("KONDISI_ID")));
	while($child->nextRow())
	{
		$arr_child[$k]['id'] = $child->getField("KONDISI_ID");
		$arr_child[$k]['text'] = $child->getField("NAMA");
		if(checkVariabel($text, $child->getField("KONDISI_ID")))
			$arr_child[$k]['checked'] = true;
		
		$l = 0;
		$sub = new Kondisi();
		$sub->selectByParams(array("KONDISI_PARENT_ID" => $child->getField("KONDISI_ID")));
		while($sub->nextRow())
		{
			$arr_sub[$l]['id'] = $sub->getField("KONDISI_ID");
			$arr_sub[$l]['text'] = $sub->getField("NAMA");	
			$l++;
		}
		
		$arr_child[$k]['children'] = $arr_sub;
		unset($sub);
		unset($arr_sub);
		$k++;
	}
	$arr_parent[$j]['children'] = $arr_child;
	
	unset($child);
	unset($arr_child);
	
	$j++;
}

echo json_encode($arr_parent);
?>