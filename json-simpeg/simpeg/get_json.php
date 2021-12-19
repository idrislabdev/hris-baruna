<?php
defined('BASEPATH') OR exit('No direct script access allowed');

include_once("functions/string.func.php");
include_once("functions/default.func.php");
include_once("functions/date.func.php");

class get_json extends CI_Controller {

	function __construct() {
		parent::__construct();
		
		//kauth
		if (!$this->kauth->getInstance()->hasIdentity())
		{
			// trow to unauthenticated page!
			redirect('app');
		}       
		
		/* GLOBAL VARIABLE */

		$this->UID = $this->kauth->getInstance()->getIdentity()->UID;
		$this->pegawaiId = $this->kauth->getInstance()->getIdentity()->pegawaiId;
		$this->jabatan = $this->kauth->getInstance()->getIdentity()->jabatan;
		$this->cabang = $this->kauth->getInstance()->getIdentity()->cabang;
		$this->cabangP3Id = $this->kauth->getInstance()->getIdentity()->cabangP3Id;
		$this->perusahaanId = $this->kauth->getInstance()->getIdentity()->perusahaanId;
		$this->perusahaanCabangId = $this->kauth->getInstance()->getIdentity()->perusahaanCabangId;
		$this->userPublish = $this->kauth->getInstance()->getIdentity()->userPublish;						
		$this->idUser = $this->kauth->getInstance()->getIdentity()->idUser;
		$this->nama = $this->kauth->getInstance()->getIdentity()->nama;
		$this->loginTime = $this->kauth->getInstance()->getIdentity()->loginTime;
		$this->userNRP = $this->kauth->getInstance()->getIdentity()->userNRP;
		$this->loginTimeStr = $this->kauth->getInstance()->getIdentity()->loginTimeStr;
		$this->level = $this->kauth->getInstance()->getIdentity()->level;
		$this->idLevel = $this->kauth->getInstance()->getIdentity()->idLevel;
		$this->idDepartemen = $this->kauth->getInstance()->getIdentity()->idDepartemen;
		$this->idCabang = $this->kauth->getInstance()->getIdentity()->idCabang;		
		$this->departemen = $this->kauth->getInstance()->getIdentity()->departemen;
		$this->userAksesIntranet = $this->kauth->getInstance()->getIdentity()->userAksesIntranet;
		$this->userAksesOperasional = $this->kauth->getInstance()->getIdentity()->userAksesOperasional;
		$this->userAksesArsip = $this->kauth->getInstance()->getIdentity()->userAksesArsip;
		$this->userAksesInventaris = $this->kauth->getInstance()->getIdentity()->userAksesInventaris;
		$this->userAksesSPPD = $this->kauth->getInstance()->getIdentity()->userAksesSPPD;
		$this->userAksesKepegawaian = $this->kauth->getInstance()->getIdentity()->userAksesKepegawaian;
		$this->userAksesPenghasilan = $this->kauth->getInstance()->getIdentity()->userAksesPenghasilan;
		$this->userAksesPresensi = $this->kauth->getInstance()->getIdentity()->userAksesPresensi;
		$this->userAksesPenilaian = $this->kauth->getInstance()->getIdentity()->userAksesPenilaian;
		$this->userAksesBackup = $this->kauth->getInstance()->getIdentity()->userAksesBackup;
		$this->userAksesHukum = $this->kauth->getInstance()->getIdentity()->userAksesHukum;
		$this->userAksesAnggaran = $this->kauth->getInstance()->getIdentity()->userAksesAnggaran;
		$this->userAksesWebsite = $this->kauth->getInstance()->getIdentity()->userAksesWebsite;	
		$this->userAksesSurvey = $this->kauth->getInstance()->getIdentity()->userAksesSurvey;	
		$this->userAksesFileManager = $this->kauth->getInstance()->getIdentity()->userAksesFileManager;	
		$this->userAksesSMSGateway = $this->kauth->getInstance()->getIdentity()->userAksesSMSGateway;
		$this->userAksesKeuangan = $this->kauth->getInstance()->getIdentity()->userAksesKeuangan;
		$this->userAksesDokumenHukum = $this->kauth->getInstance()->getIdentity()->userAksesDokumenHukum;
		$this->userAksesKomersial = $this->kauth->getInstance()->getIdentity()->userAksesKomersial;	
		$this->userAksesGalangan = $this->kauth->getInstance()->getIdentity()->userAksesGalangan;	
	}	
	
	
	function get_cabang_p3()
	{

		/* INCLUDE FILE */
		//include_once("../WEB-INF/classes/utils/UserLogin.php");
		include_once("../WEB-INF/classes/base-simpeg/CabangP3.php");
		include_once("../WEB-INF/functions/string.func.php");
		include_once("../WEB-INF/functions/default.func.php");
		include_once("../WEB-INF/functions/date.func.php");
		include_once("../WEB-INF/classes/utils/Validate.php");

		/* LOGIN CHECK */
		/*if ($userLogin->checkUserLogin()) 
		{ 
			$userLogin->retrieveUserInfo();
		}*/
		$reqCabang= httpFilterGet("reqCabang");

		$cabang_p3 = new CabangP3();
		$cabang_p3->selectByParams(array(), - 1, -1, " AND KODE =" .$reqCabang );
		$cabang_p3->firstRow();
		//echo $cabang_p3->query;
		$cabang_p3_id = $cabang_p3->getField('CABANG_P3_ID');

		$arrFinal = array("cabang_p3_id" => $cabang_p3_id);
		echo json_encode($arrFinal);
	}

	function get_direktorat_p3()
	{
		/* INCLUDE FILE */
		//include_once("../WEB-INF/classes/utils/UserLogin.php");
		include_once("../WEB-INF/classes/base-simpeg/DirektoratP3.php");
		include_once("../WEB-INF/functions/string.func.php");
		include_once("../WEB-INF/functions/default.func.php");
		include_once("../WEB-INF/functions/date.func.php");
		include_once("../WEB-INF/classes/utils/Validate.php");

		/* LOGIN CHECK */
		/*if ($userLogin->checkUserLogin()) 
		{ 
			$userLogin->retrieveUserInfo();
		}*/
		$reqCabangId= httpFilterGet("reqCabangId");
		$reqDirektorat= httpFilterGet("reqDirektorat");
		$reqSubDirektorat= httpFilterGet("reqSubDirektorat");
		$reqSeksi= httpFilterGet("reqSeksi");
		$tempDirektoratId= $reqDirektorat.$reqSubDirektorat.$reqSeksi;

		$direktorat_p3 = new DirektoratP3();
		$direktorat_p3->selectByParams(array(), - 1, -1, " AND CABANG_P3_ID =" .$reqCabangId." AND DIREKTORAT_P3_ID =" .$tempDirektoratId );
		$direktorat_p3->firstRow();
		//echo $direktorat_p3->query;
		$direktorat_p3_id = $direktorat_p3->getField('DIREKTORAT_P3_ID');
		$direktorat_p3_nama = $direktorat_p3->getField('NAMA');

		$arrFinal = array("direktorat_p3_id" => $direktorat_p3_id, "direktorat_p3_nama" => $direktorat_p3_nama);
		echo json_encode($arrFinal);
	}

	function get_jabatan_perbantuan()
	{
		/* INCLUDE FILE */
		//include_once("../WEB-INF/classes/utils/UserLogin.php");
		include_once("../WEB-INF/classes/base-simpeg/Jabatan.php");
		include_once("../WEB-INF/functions/string.func.php");
		include_once("../WEB-INF/functions/default.func.php");
		include_once("../WEB-INF/functions/date.func.php");
		include_once("../WEB-INF/classes/utils/Validate.php");

		/* LOGIN CHECK */
		/*if ($userLogin->checkUserLogin()) 
		{ 
			$userLogin->retrieveUserInfo();
		}*/
		$reqNomorUrut= httpFilterGet("reqNomorUrut");
		$reqKelas= httpFilterGet("reqKelas");

		$jabatan = new Jabatan();
		$jabatan->selectByParams(array(), - 1, -1, " AND KELOMPOK = 'P' AND NO_URUT =" .$reqNomorUrut. " AND KELAS =" .$reqKelas );
		$jabatan->firstRow();
		//echo $jabatan->query;
		$jabatan_id = $jabatan->getField('JABATAN_ID');
		$jabatan = $jabatan->getField('NAMA');

		$arrFinal = array("jabatan" => $jabatan, "jabatan_id" => $jabatan_id);
		echo json_encode($arrFinal);
	}

	function get_nomor_urut_kelas()
	{
		/* INCLUDE FILE */
		//include_once("../WEB-INF/classes/utils/UserLogin.php");
		include_once("../WEB-INF/classes/base-simpeg/Jabatan.php");
		include_once("../WEB-INF/functions/string.func.php");
		include_once("../WEB-INF/functions/default.func.php");
		include_once("../WEB-INF/functions/date.func.php");
		include_once("../WEB-INF/classes/utils/Validate.php");

		/* LOGIN CHECK */
		/*if ($userLogin->checkUserLogin()) 
		{ 
			$userLogin->retrieveUserInfo();
		}*/
		$reqId= httpFilterGet("reqId");

		$jabatan = new Jabatan();
		$jabatan->selectByParams(array(), - 1, -1, " AND JABATAN_ID =" .$reqId );
		$jabatan->firstRow();
		//echo $jabatan->query;
		$nomor_urut = $jabatan->getField('NO_URUT');
		$kelas = $jabatan->getField('KELAS');

		$arrFinal = array("nomor_urut" => $nomor_urut, "kelas" => $kelas);
		echo json_encode($arrFinal);

	}

	function get_periodik_penghasilan_gaji()
	{
		/* INCLUDE FILE */
		//include_once("../WEB-INF/classes/utils/UserLogin.php");
		include_once("../WEB-INF/classes/base-simpeg/PegawaiJabatan.php");
		include_once("../WEB-INF/functions/string.func.php");
		include_once("../WEB-INF/functions/default.func.php");
		include_once("../WEB-INF/functions/date.func.php");
		include_once("../WEB-INF/classes/utils/Validate.php");

		/* LOGIN CHECK */
		/*if ($userLogin->checkUserLogin()) 
		{ 
			$userLogin->retrieveUserInfo();
		}*/
		$reqPeriode= httpFilterGet("reqPeriode");
		$reqPegawaiId= httpFilterGet("reqPegawaiId");
		$reqKelas= httpFilterGet("reqKelas");
		$reqJumlahPenghasilan = httpFilterGet("reqJumlahPenghasilan");

		$reqJumlahPenghasilan = str_replace(".", "", $reqJumlahPenghasilan);

		if($reqPeriode == "")
			$reqPeriode=0;

		if($reqJumlahPenghasilan == "")
			$reqJumlahPenghasilan=0;
			
		$pegawai_jabatan = new PegawaiJabatan();
		$pegawai_jabatan->selectByParamsJsonGaji(array('A.PEGAWAI_ID'=>$reqPegawaiId),-1,-1,$reqPeriode, $reqJumlahPenghasilan, $reqKelas);
		$pegawai_jabatan->firstRow();

		$json_gaji = $pegawai_jabatan->getField('JSON_GAJI');
		$pegawai_jabatan_json_gaji= $pegawai_jabatan->getField('JSON_GAJI');

		echo $json_gaji;
	}

	function get_periodik_penghasilan_gaji_mpp()
	{
		/* INCLUDE FILE */
		//include_once("../WEB-INF/classes/utils/UserLogin.php");
		include_once("../WEB-INF/classes/base-simpeg/PegawaiJabatan.php");
		include_once("../WEB-INF/functions/string.func.php");
		include_once("../WEB-INF/functions/default.func.php");
		include_once("../WEB-INF/functions/date.func.php");
		include_once("../WEB-INF/classes/utils/Validate.php");

		/* LOGIN CHECK */
		/*if ($userLogin->checkUserLogin()) 
		{ 
			$userLogin->retrieveUserInfo();
		}*/
		$reqPeriode= httpFilterGet("reqPeriode");
		$reqPegawaiId= httpFilterGet("reqPegawaiId");
		$reqJumlahPenghasilan = httpFilterGet("reqJumlahPenghasilan");

		$reqJumlahPenghasilan = str_replace(".", "", $reqJumlahPenghasilan);

		if($reqPeriode == "")
			$reqPeriode=0;

		if($reqJumlahPenghasilan == "")
			$reqJumlahPenghasilan=0;
			
		$pegawai_jabatan = new PegawaiJabatan();
		$pegawai_jabatan->selectByParamsJsonGajiMPP(array('A.PEGAWAI_ID'=>$reqPegawaiId),-1,-1,$reqPeriode, $reqJumlahPenghasilan);
		$pegawai_jabatan->firstRow();

		$json_gaji = $pegawai_jabatan->getField('JSON_GAJI');
		$pegawai_jabatan_json_gaji= $pegawai_jabatan->getField('JSON_GAJI');

		echo $json_gaji;
	}

	function get_periodik_penghasilan_p3()
	{
		/* INCLUDE FILE */

		include_once("../WEB-INF/classes/base-simpeg/PegawaiJabatan.php");
		include_once("../WEB-INF/functions/string.func.php");
		include_once("../WEB-INF/functions/default.func.php");
		include_once("../WEB-INF/functions/date.func.php");
		include_once("../WEB-INF/classes/utils/Validate.php");

		/* LOGIN CHECK */
		/*if ($userLogin->checkUserLogin()) 
		{ 
			$userLogin->retrieveUserInfo();
		}*/
		$reqPeriode= httpFilterGet("reqPeriode");
		$reqKelas= httpFilterGet("reqKelas");
		$reqKelasPms= httpFilterGet("reqKelasPms");

		if($reqPeriode == "")
			$reqPeriode=0;

		if($reqKelas == "")
			$reqKelas=0;
			
		$pegawai_jabatan = new PegawaiJabatan();
		$pegawai_jabatan->selectByParamsJsonGajiP3($reqPeriode, $reqKelas);
		$pegawai_jabatan->firstRow();
		$jumlah = $pegawai_jabatan->getField("JUMLAH");

		$pegawai_jabatan->selectByParamsJsonGajiTPPP3($reqKelas);
		$pegawai_jabatan->firstRow();
		$tpp = $pegawai_jabatan->getField("JUMLAH");

		$pegawai_jabatan->selectByParamsGajiPMS($reqPeriode, $reqKelasPms);
		$pegawai_jabatan->firstRow();
		$tpppms = $pegawai_jabatan->getField("TPP_PMS");
		$meritpms = $pegawai_jabatan->getField("MERIT_PMS");

		$arrFinal = array("JUMLAH" => $jumlah, "TPP" => $tpp, "JUMLAH_PMS" => $meritpms, "TPP_PMS" => $tpppms);

		echo json_encode($arrFinal);
	}

	function get_periodik_penghasilan_tpp_p3()
	{
		/* INCLUDE FILE */

		include_once("../WEB-INF/classes/base-simpeg/PegawaiJabatan.php");
		include_once("../WEB-INF/functions/string.func.php");
		include_once("../WEB-INF/functions/default.func.php");
		include_once("../WEB-INF/functions/date.func.php");
		include_once("../WEB-INF/classes/utils/Validate.php");

		/* LOGIN CHECK */
		/*if ($userLogin->checkUserLogin()) 
		{ 
			$userLogin->retrieveUserInfo();
		}*/
		$reqPeriode= httpFilterGet("reqPeriode");
		$reqKelas= httpFilterGet("reqKelas");

		if($reqPeriode == "")
			$reqPeriode=0;

		if($reqKelas == "")
			$reqKelas=0;
			
		$pegawai_jabatan = new PegawaiJabatan();
		$pegawai_jabatan->selectByParamsJsonGajiP3($reqPeriode, $reqKelas);
		$pegawai_jabatan->firstRow();
		$jumlah = $pegawai_jabatan->getField("JUMLAH");

		$pegawai_jabatan->selectByParamsJsonGajiTPPP3($reqKelas);
		$pegawai_jabatan->firstRow();
		$tpp = $pegawai_jabatan->getField("JUMLAH");
		$arrFinal = array("JUMLAH" => $jumlah, "TPP" => $tpp);


		echo json_encode($arrFinal);
	}

}
?>
