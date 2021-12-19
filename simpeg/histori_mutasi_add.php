<?
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base-simpeg/Pegawai.php");

$pegawai = new Pegawai();

$reqId = httpFilterGet("reqId");
$reqMode = httpFilterGet("reqMode");

$pegawai->selectByParamsHistoriMutasi(array("PEGAWAI_ID" => $reqId));
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	<title>Form Validation - jQuery EasyUI Demo</title>
    <link href="../WEB-INF/css/begron.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" type="text/css" href="../WEB-INF/css/admin.css">
    <link href="../WEB-INF/lib/media/themes/main_datatables.css" rel="stylesheet" type="text/css" /> 
</head>
<body>
<div id="begron"><img src="../WEB-INF/images/bg-kanan.jpg" width="100%" height="100%" alt="Smile"></div>
<div id="wadah">

    <div id="judul-halaman">
                <span><img src="../WEB-INF/images/panah-judul.png">Data Histori Mutasi</span>
    </div>
    <table id="gradient-style" style="width:96%">
    <thead>
    <tr>
    <th scope="col">No. SK</th>
    <th scope="col">TMT SK</th>
    <th scope="col">Tanggal SK</th>
    <th scope="col">Departemen Lama</th>
    <th scope="col">Departemen Baru</th>
    </tr>
    </thead>
    <tbody>

    <?
    while($pegawai->nextRow())
	{
	?>
    	<tr>
            <td><?=$pegawai->getField("NO_SK")?></td>
            <td><?=dateToPageCheck($pegawai->getField("TMT_SK"))?></td>
            <td><?=dateToPageCheck($pegawai->getField("TANGGAL_SK"))?></td>
            <td><?=$pegawai->getField("DEPARTEMEN_LAMA")?></td>
            <td><?=$pegawai->getField("DEPARTEMEN_BARU")?></td>
        </tr>    
    <?
	}
	?>    
    </table>

</div>
</body>
</html>