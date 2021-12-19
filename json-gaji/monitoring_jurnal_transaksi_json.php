<?php
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF-SIUK/classes/base/KbbtJurBb.php");

$kbbt_jur_bb = new KbbtJurBb();

$kbbt_jur_bb->selectByParams(array());        		

while($kbbt_jur_bb->nextRow())
{
	echo "MASUK".$kbbt_jur_bb->getField("KD_CABANG");
}

?>
