<?
/* INCLUDE FILE */
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base/Faq.php");
include_once("../WEB-INF/classes/utils/UserLogin.php");

$faq = new Faq();

$reqId = httpFilterPost("reqId");
$reqMode = httpFilterPost("reqMode");
$reqPertanyaan 	= httpFilterPost("reqPertanyaan");
$reqJawaban 	= httpFilterPost("reqJawaban");
$reqNoUrut 	= httpFilterPost("reqNoUrut");

if($reqMode == "insert")
{
	$faq->setField("PERTANYAAN", $reqPertanyaan);
	$faq->setField("JAWABAN", $reqJawaban);
	$faq->setField("NO_URUT", $reqNoUrut);
	
	if($faq->insert())
		echo "Data berhasil disimpan.";
}
else
{
	$faq->setField("FAQ_ID", $reqId);
	$faq->setField("PERTANYAAN", $reqPertanyaan);
	$faq->setField("JAWABAN", $reqJawaban);
	$faq->setField("NO_URUT", $reqNoUrut);
	
	if($faq->update())
		echo "Data berhasil disimpan.";
	
}
?>