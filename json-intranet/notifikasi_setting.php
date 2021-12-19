<?
/* INCLUDE FILE */
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base/UserLoginBase.php");


/* create objects */
$reqEmail= httpFilterPost("reqEmail");

$headerSettingEmail = array();
function start_element($parser, $name, $attrs)
{
	global $headerSettingEmail;
	if($name == "settingEmail")
	{
		array_push($headerSettingEmail, $attrs);
	}
}
function end_element ($parser, $name){}

$playlist_string = file_get_contents("../WEB-INF/setting_email.xml");
$parser = xml_parser_create();
xml_set_element_handler($parser, "start_element", "end_element");
xml_parser_set_option($parser, XML_OPTION_CASE_FOLDING, 0);
xml_parse($parser, $playlist_string) or die("Error parsing XML document.");

$headerSettingEmail_final = array();
foreach($headerSettingEmail as $settingEmail){
	if($settingEmail['title'] == 'Email'){}
	else
	{
		array_push($headerSettingEmail_final, $settingEmail);
	}
}

array_push($headerSettingEmail_final, array(
				"title" => 'Email',
				"path" => $reqEmail
				)
			);

$write_string = "<headerSettingEmail>";
foreach($headerSettingEmail_final as $settingEmail){
	$write_string .= "<settingEmail title=\"$settingEmail[title]\" path=\"$settingEmail[path]\" />";
}
$write_string .= "</headerSettingEmail>";
//$fp = fopen("setting_email.xml", "w+");
$fp = fopen("../WEB-INF/setting_email.xml", "w+");
fwrite($fp, $write_string) or die("Error writing to file");
fclose($fp);

echo '1';
?>