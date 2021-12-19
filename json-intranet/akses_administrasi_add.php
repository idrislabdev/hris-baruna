<?
/* INCLUDE FILE */
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/classes/base/AksesAdmIntranet.php");
include_once("../WEB-INF/classes/base/AksesAdmIntranetMenu.php");
include_once("../WEB-INF/classes/utils/UserLogin.php");

$akses_adm_intranet = new AksesAdmIntranet();
$akses_adm_intranet_menu = new AksesAdmIntranetMenu();

$reqMode = httpFilterPost("reqMode");
$reqMenuId = $_POST["reqMenuId"];
$reqCheck = $_POST["reqCheck"];
$reqNama = $_POST["reqNama"];
$reqAksesIntranet = $_POST["reqAksesIntranet"];
$reqTable = $_POST["reqTable"];

if($reqMode == "insert")
{	
	  $akses_adm_intranet->setField("NAMA", $reqNama);
	  $akses_adm_intranet->setField("TABLE", $reqTable);
	  $akses_adm_intranet->insert();

	  for($i=0;$i<count($reqMenuId);$i++)
	  {
		  $akses_adm_intranet_menu = new AksesAdmIntranetMenu();
	 	  $akses_adm_intranet_menu->setField("AKSES_ADM_INTRANET_ID", $akses_adm_intranet->id);
	 	  $akses_adm_intranet_menu->setField("MENU_ID", $reqMenuId[$i]);
	 	  $akses_adm_intranet_menu->setField("AKSES", $reqCheck[$i]);
	 	  $akses_adm_intranet_menu->setField("TABLE", $reqTable);
		  $akses_adm_intranet_menu->insert();
		  unset($akses_adm_intranet_menu);	  
	  }
		  echo "Data berhasil disimpan.";
}
else
{
	  $akses_adm_intranet->setField("NAMA", $reqNama);
	  $akses_adm_intranet->setField("AKSES_ADM_INTRANET_ID", $reqAksesIntranet);	  
	  $akses_adm_intranet->setField("TABLE", $reqTable);
	  $akses_adm_intranet->update();

	  $akses_adm_intranet_menu->setField("AKSES_ADM_INTRANET_ID", $reqAksesIntranet);
	  $akses_adm_intranet_menu->setField("TABLE", $reqTable);
	  $akses_adm_intranet_menu->delete();
	
	  for($i=0;$i<count($reqMenuId);$i++)
	  {
		  $akses_adm_intranet_menu = new AksesAdmIntranetMenu();
	 	  $akses_adm_intranet_menu->setField("AKSES_ADM_INTRANET_ID", $reqAksesIntranet);
	 	  $akses_adm_intranet_menu->setField("MENU_ID", $reqMenuId[$i]);
	 	  $akses_adm_intranet_menu->setField("AKSES", $reqCheck[$i]);
	 	  $akses_adm_intranet_menu->setField("TABLE", $reqTable);
		  $akses_adm_intranet_menu->insert();
		  unset($akses_adm_intranet_menu);	  
	  }
		  echo "Data berhasil disimpan.";
}
?>