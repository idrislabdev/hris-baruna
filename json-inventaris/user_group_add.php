<?
/* INCLUDE FILE */
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base-inventaris/UserGroupsBase.php");

$user_groups_base = new UserGroupsBase();

$reqId = httpFilterPost("reqId");
$reqMode = httpFilterPost("reqMode");
$reqNama= httpFilterPost("reqNama");

$reqMenu = $_POST["reqMenu"];
$reqField = array("MASTER_DATA", "USER_MANAJEMEN", "PENDATAAN", "PENGENDALIAN", "PEMBELIAN", "PERMOHONAN_PERBAIKAN", "PERMOHONAN_PEMUSNAHAN", "PERSETUJUAN_PERBAIKAN", "PERSETUJUAN_PEMUSNAHAN");

if($reqMode == "insert")
{
	$user_groups_base->setField('NAMA', $reqNama);
	
	if($user_groups_base->insert())
	{
		$id = $user_groups_base->id;
		for($i=0;$i<count($reqField);$i++)
		{
			$user_group_menu = new UserGroupsBase();
			
			$user_group_menu->setField("USER_GROUP_ID", $id);
			$user_group_menu->setField("FIELD_NAME", $reqField[$i]);
			$user_group_menu->setField("FIELD_VALUE", $reqMenu[$i]);
			$user_group_menu->updateByField();
			
			unset($user_group_menu);	
		}	
		
		echo "Data berhasil disimpan.";
	}
}
else
{
	$user_groups_base->setField('USER_GROUP_ID', $reqId); 
	$user_groups_base->setField('NAMA', $reqNama);
	
	if($user_groups_base->update())
	{
		$id = $reqId;
		for($i=0;$i<count($reqField);$i++)
		{
			$user_group_menu = new UserGroupsBase();
			
			$user_group_menu->setField("USER_GROUP_ID", $id);
			$user_group_menu->setField("FIELD_NAME", $reqField[$i]);
			$user_group_menu->setField("FIELD_VALUE", $reqMenu[$i]);
			$user_group_menu->updateByField();
			
			unset($user_group_menu);	
		}	
		
		echo "Data berhasil disimpan.";
	}
}
?>