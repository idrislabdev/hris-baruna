<?php
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base-simpeg/Pegawai.php");
include_once("../WEB-INF/classes/base-simpeg/PegawaiJenisPegawai.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/SafmPelanggan.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/KbbrKartuTambah.php");

include "../keuangan/excel/excel_reader2.php";

$data = new Spreadsheet_Excel_Reader($_FILES['reqLinkFile']['tmp_name']);

$baris = $data->rowcount($sheet_index=0);
// var_dump($baris);exit();

// import data excel mulai baris ke-2 (karena baris pertama adalah nama kolom)
$sukses = 0;
for ($i=2; $i<=$baris; $i++)
{	
	$reqNIS						= $data->val($i, 1);
	$reqNama					= $data->val($i, 2);
	$reqJenisKelamin			= $data->val($i, 3);
	$reqTempat					= $data->val($i, 4);
	$reqTanggal 				= $data->val($i, 5);
	$reqAlamat 					= $data->val($i, 6);
	$reqTanggalKelas			= $data->val($i, 7);
	$reqDepartemenId			= $data->val($i, 8);
	$reqDepartemenKelasId		= $data->val($i, 9);
	$reqKelas					= $data->val($i, 9);
	$reqSPP						= $data->val($i, 11);


	if(!empty($reqNIS))
	{
		if($reqTanggalKelas == "")
		{
			echo "Tanggal masuk wajib diisi.";
			exit;
		}
	}
	
	$pegawai 	= new Pegawai();

	$cek_nis = $pegawai->getCountByParams(array("NIS" => $reqNIS));
	
	if ($cek_nis > 0) 
	{
		//echo "Data siswa (".$reqNIS.") sudah ada.";

		$reqId = $pegawai->getPegawaiId(array("NIS" => $reqNIS));


		$pegawai->setField("PEGAWAI_ID", $reqId);
		$pegawai->setField("DEPARTEMEN_ID", $reqDepartemenId);
		$pegawai->updateKadetDepartemen();



		$pegawai_jenis_pegawai 	= new PegawaiJenisPegawai();


		$cek_jenis = $pegawai_jenis_pegawai->getIdByParams(array("PEGAWAI_ID" => $reqId), " AND  TMT_JENIS_PEGAWAI = ".dateToDBCheckImport($reqTanggalKelas));

		if($cek_jenis == 0)
		{
			$pegawai_jenis_pegawai->setField("PEGAWAI_ID", $reqId);
			$pegawai_jenis_pegawai->setField("JENIS_PEGAWAI_ID", "8");
			$pegawai_jenis_pegawai->setField("TMT_JENIS_PEGAWAI", dateToDBCheckImport($reqTanggalKelas));
			$pegawai_jenis_pegawai->setField("DEPARTEMEN_KELAS_ID", $reqDepartemenKelasId);
			$pegawai_jenis_pegawai->setField("JUMLAH_SPP", $reqSPP);
			$pegawai_jenis_pegawai->setField("KELAS_SEKOLAH", $reqKelas);
			$pegawai_jenis_pegawai->setField("JURUSAN", $reqDepartemenId);
			//$pegawai_jenis_pegawai->deleteKadet();
			if($pegawai_jenis_pegawai->importKadet())
				$sukses++;
		}
		else
		{
			$pegawai_jenis_pegawai->setField("PEGAWAI_JENIS_PEGAWAI_ID", $cek_jenis);
			$pegawai_jenis_pegawai->setField("PEGAWAI_ID", $reqId);
			$pegawai_jenis_pegawai->setField("JENIS_PEGAWAI_ID", "8");
			$pegawai_jenis_pegawai->setField("TMT_JENIS_PEGAWAI", dateToDBCheckImport($reqTanggalKelas));
			$pegawai_jenis_pegawai->setField("DEPARTEMEN_KELAS_ID", $reqDepartemenKelasId);
			$pegawai_jenis_pegawai->setField("JUMLAH_SPP", $reqSPP);
			$pegawai_jenis_pegawai->setField("KELAS_SEKOLAH", $reqKelas);
			$pegawai_jenis_pegawai->setField("JURUSAN", $reqDepartemenId);
			//$pegawai_jenis_pegawai->deleteKadet();
			if($pegawai_jenis_pegawai->updateKadet())
				$sukses++;

		}

	}
	else 
	{
		$pegawai->setField("NIS", $reqNIS);
		$pegawai->setField("NAMA", str_replace("'", "''", $reqNama));
		$pegawai->setField("JENIS_KELAMIN", $reqJenisKelamin);
		$pegawai->setField("TEMPAT_LAHIR", $reqTempat);
		$pegawai->setField("TANGGAL_LAHIR", dateToDBCheckImport($reqTanggal));
		$pegawai->setField("STATUS_PEGAWAI_ID", "1");
		$pegawai->setField("ALAMAT", $reqAlamat);
		$pegawai->setField("DEPARTEMEN_ID", $reqDepartemenId);
		if ($pegawai->importKadet())
		{	
			$reqId = $pegawai->id;
			$sukses++;

			$pegawai_jenis_pegawai 	= new PegawaiJenisPegawai();
			$pegawai_jenis_pegawai->setField("PEGAWAI_ID", $reqId);
			$pegawai_jenis_pegawai->setField("JENIS_PEGAWAI_ID", "8");
			$pegawai_jenis_pegawai->setField("TMT_JENIS_PEGAWAI", dateToDBCheckImport($reqTanggalKelas));
			$pegawai_jenis_pegawai->setField("DEPARTEMEN_KELAS_ID", $reqDepartemenKelasId);
			$pegawai_jenis_pegawai->setField("JUMLAH_SPP", $reqSPP);
			$pegawai_jenis_pegawai->setField("KELAS_SEKOLAH", $reqKelas);
			$pegawai_jenis_pegawai->setField("JURUSAN", $reqDepartemenId);

			if ($pegawai_jenis_pegawai->importKadet())
			{
				// echo "XXX";exit();
				$pelanggan = new SafmPelanggan();

				$adaData = $pelanggan->getCountByParams(array("MPLG_KODE" => $reqNIS));

				if($adaData == 0)
				{
					$pelanggan->setField("KD_CABANG", "96");	
					$pelanggan->setField("JENIS_TABLE", "M");
					$pelanggan->setField("ID_TABLE", "SAFMPLG");
					$pelanggan->setField("PROGRAM_NAME", "KBB_M_SAFM_PELANGGAN_NEW_IMAIS");
					$pelanggan->setField("MPLG_JENIS_USAHA", "SISWA");
					$pelanggan->setField("MPLG_BADAN_USAHA", "SISWA");
		    		$pelanggan->setField("MPLG_KODE", $reqNIS);
					$pelanggan->setField("MPLG_NAMA", str_replace("'", "''", $reqNama));

					if ($pelanggan->importKadet()) 
					{ 
						
					}
				}

			}
		}
	}

}
				echo $sukses." data berhasil di import.";


?>