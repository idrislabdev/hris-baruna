<?
/* INCLUDE FILE */
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base-anggaran/AnggaranMutasi.php");
include_once("../WEB-INF/classes/base-simpeg/PegawaiJabatan.php");
include_once("../WEB-INF/classes/utils/UserLogin.php");

$anggaran_mutasi = new AnggaranMutasi();
$pegawai_jabatan = new PegawaiJabatan();

$reqId = httpFilterPost("reqId");

$pegawai_jabatan->selectByParamsPegawaiJabatanOperasional(array("A.PEGAWAI_ID" => $userLogin->pegawaiId));
$pegawai_jabatan->firstRow();

$anggaran_mutasi->setField("APPROVED_BY", $userLogin->nama);
$anggaran_mutasi->setField("APPROVED_JABATAN", $pegawai_jabatan->getField("JABATAN_NAMA"));
$anggaran_mutasi->setField("ANGGARAN_MUTASI_ID", $reqId);
$anggaran_mutasi->updateApproved();

echo $reqId."-Anggaran telah mengetahui manager yang bersangkutan.";

?>