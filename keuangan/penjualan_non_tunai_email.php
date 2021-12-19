<?
/* INCLUDE FILE */
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/KbbtJurBb.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/NotifikasiNotaTagihan.php");

$kbbt_jur_bb = new KbbtJurBb();

$reqId = httpFilterGet("reqId");

$reqEmail = httpFilterGet("reqEmail");
$reqValuta = httpFilterGet("reqValuta");
$reqSendMail = httpFilterGet("reqSendMail");
$reqKet = httpFilterGet("reqKet");

if ($reqId <> "") {
	$kbbt_jur_bb = new KbbtJurBb();
			
			$kbbt_jur_bb->selectByParamsSimple(array("NO_NOTA" => $reqId));
			$kbbt_jur_bb->firstRow();
			
			if (strpos($reqId, "JPJ") !== false && $kbbt_jur_bb->getField("NO_POSTING") <> "" && $kbbt_jur_bb->getField("TGL_POSTING") <> "") {
			
				$notifikasi = new NotifikasiNotaTagihan();
				$notifikasi->selectDataPelanggan(array("MPLG_KODE" => $kbbt_jur_bb->getField("KD_KUSTO")));
				$kbbt_jur_bb->firstRow();
				$mplg_email = $kbbt_jur_bb->getField("MPLG_EMAIL_ADDRESS");
				$mplg_email = "chandra.ganacan@gmail.com";
				unset($notifikasi);
				if ($mplg_email <> "") {
					$notifikasi = new NotifikasiNotaTagihan();
					$pesan = $notifikasi->sendMail($mplg_email, $reqId, $reqValuta, $reqKet );
					unset($notifikasi);
					
					$notifikasi = new NotifikasiNotaTagihan();
					$notifikasi->setField("NO_NOTA", $reqId);
					$notifikasi->setField("EMAIL_TUJUAN", $mplg_email);
					$notifikasi->setField("CREATED_BY", $userLogin->idUser);
					$notifikasi->insert();
					unset($notifikasi);
					$pesan = "Proses kirim email berhasil.";
				} else {
					$pesan = "Proses kirim email gagal, email pelanggan belum ditentukan.";
				}
			} else {
					$pesan = "Proses kirim email gagal karena nota belum posting!";
			}
			
}


if($error == 1)
	$pesan = "Proses gagal.";

$arrFinal = array("PESAN" => $pesan);

echo json_encode($arrFinal);
?>