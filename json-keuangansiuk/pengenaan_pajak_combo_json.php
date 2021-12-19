<?
/* INCLUDE FILE */
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");

$arr_parent[0]['id'] = "Y";
$arr_parent[0]['text'] = "YA";
$arr_parent[1]['id'] = "N";
$arr_parent[1]['text'] = "TIDAK";

echo json_encode($arr_parent);
?>