<?
/* INCLUDE FILE */
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base/ForumKategori.php");
include_once("../WEB-INF/classes/utils/UserLogin.php");

$forum_kategori = new ForumKategori();

$reqId = httpFilterPost("reqId");
$reqMode = httpFilterPost("reqMode");
$reqNama = httpFilterPost("reqNama");
$reqKeterangan = httpFilterPost("reqKeterangan");

if($reqMode == "insert")
{
	$forum_kategori->setField("FORUM_KATEGORI_ID", $reqId);
	$forum_kategori->setField("NAMA", $reqNama);
	$forum_kategori->setField("KETERANGAN", $reqKeterangan);
	if($forum_kategori->insert())
		echo "Data berhasil disimpan.";
}
else
{
	$forum_kategori->setField("FORUM_KATEGORI_ID", $reqId);
	$forum_kategori->setField("NAMA", $reqNama);
	$forum_kategori->setField("KETERANGAN", $reqKeterangan);
	if($forum_kategori->update())
		echo "Data berhasil disimpan.";
	
}
?>