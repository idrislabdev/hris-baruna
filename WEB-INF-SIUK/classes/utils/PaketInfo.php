<?
/* *******************************************************************************************************
MODUL NAME 			: SIMWEB
FILE NAME 			: TamuLogin.php
AUTHOR				: MRF
VERSION				: 1.0
MODIFICATION DOC	:
DESCRIPTION			: Class that responsible to handle process authentication for users on Admin group
***************************************************************************************************** */

/***********************************************************************
class.userlogin.php	
Mengelola informasi tentang user login. Untuk menggunakan kelas ini tidak
perlu di-instansiasi dulu, sudah otomatis.
Priyo Edi Purnomo dimodifikasi M Reza Faisal
************************************************************************/

include_once("../WEB-INF/classes/utils/GlobalParam.php");
include_once("../WEB-INF/classes/base/Paket.php");

  class PaketInfo{
	var $id;
	var $nama;
	var $metode_lelang_id;
	var $metode_lelang_nama;
	var $metode_kualifikasi;
	var $metode_kualifikasi_id;
	var $metode_evaluasi;
	var $metode_evaluasi_id;
	var $jenis;
	var $jenis_id;
	var $kualifikasi;
	var $kualifikasi_id;
	var $nilai;
	var $nilai_owner_estimate;
	var $tanggal;
	var $passing_grade;	
	var $lokasi;
	
	var $syarat_teknis_tenaga_ahli;
	var $syarat_teknis_peralatan;
	var $syarat_teknis_sertifikat;
	var $syarat_rekening_koran;
	var $syarat_rekening_koran_bulan;
	var $syarat_keuangan_spt;
	var $syarat_keuangan_ppn;
	var $syarat_keuangan_pph;
	
	var $syarat_admin_klasifikasi;
	
	var $syarat_keuangan_bulan_ppn;
	var $syarat_keuangan_bulan_pph;
	
	var $syarat_ijin_siujk;
	var $syarat_ijin_siui;
	var $syarat_ijin_lain;
	var $syarat_adm_kualifikasi_info;
    /******************** CONSTRUCTOR **************************************/
    function PaketInfo(){
	
		 $this->emptyProps();
    }

    /******************** METHODS ************************************/
    /** Empty the properties **/
    function emptyProps(){
		$this->id = "";
		$this->nama = "";
		$this->metode_lelang_id = "";
		$this->metode_lelang_nama = "";
		$this->metode_kualifikasi = "";
		$this->metode_kualifikasi_id = "";
		$this->metode_evaluasi = "";
		$this->metode_evaluasi_id = "";
		$this->jenis = "";
		$this->jenis_id = "";
		$this->kualifikasi = "";
		$this->kualifikasi_id = "";
		$this->nilai = "";			
		$this->nilai_owner_estimate = "";					
		$this->tanggal = "";	
		$this->passing_grade = "";				
		$this->lokasi = "";
		
		$this->syarat_teknis_tenaga_ahli = "";
		$this->syarat_teknis_peralatan = "";
		$this->syarat_teknis_sertifikat = "";
		$this->syarat_rekening_koran = "";
		$this->syarat_rekening_koran_bulan = "";
		$this->syarat_keuangan_spt = "";
		$this->syarat_keuangan_info_spt = "";
		$this->syarat_keuangan_ppn = "";
		$this->syarat_keuangan_pph = "";
		$this->syarat_keuangan_pkp = "";
		$this->syarat_admin_klasifikasi = "";
		
		$this->syarat_keuangan_bulan_ppn= "";
		$this->syarat_keuangan_bulan_pph= "";
		
		$this->syarat_ijin_siujk= "";
		$this->syarat_ijin_siui= "";
		$this->syarat_ijin_lain= "";
		$this->syarat_adm_kualifikasi_info= "";
    }
		
    
    /** Verify user login. True when login is valid**/
    function getPaket($paket_id){			
		$usr = new Paket();
		$usr->selectById($paket_id);
		if ($usr->firstRow()) {
			
			                                             
			$this->id = $usr->getField("PAKET_ID");
			$this->nama = $usr->getField("NAMA");
			$this->metode_lelang_id = $usr->getField("PAKET_METODE_LELANG_ID");
			$this->metode_lelang_nama = $usr->getField("PAKET_METODE_LELANG");
			$this->metode_kualifikasi = $usr->getField("PAKET_METODE_KUALIFIKASI");
			$this->metode_kualifikasi_id = $usr->getField("PAKET_METODE_KUALIFIKASI_ID");
			$this->metode_evaluasi = $usr->getField("PAKET_METODE_EVALUASI");
			$this->metode_evaluasi_id = $usr->getField("PAKET_METODE_EVALUASI_ID");
			$this->jenis = $usr->getField("PAKET_JENIS");
			$this->jenis_id = $usr->getField("PAKET_JENIS_ID");
			$this->kualifikasi = $usr->getField("REKANAN_KUALIFIKASI");
			$this->kualifikasi_id = $usr->getField("REKANAN_KUALIFIKASI_ID");
			$this->nilai = $usr->getField("NILAI");	
			$this->nilai_owner_estimate = $usr->getField("NILAI_OWNER_ESTIMATE");	
			$this->tanggal = $usr->getField("TANGGAL");	
			$this->passing_grade = $usr->getField("PASS_GRADE");	
			$this->lokasi = $usr->getField("LOKASI");
			
			$this->syarat_teknis_tenaga_ahli = $usr->getField("SYARAT_TEKNIS_TENAGA_AHLI");
			$this->syarat_teknis_peralatan = $usr->getField("SYARAT_TEKNIS_PERALATAN");
			$this->syarat_teknis_sertifikat = $usr->getField("SYARAT_TEKNIS_SERTIFIKAT");
			$this->syarat_rekening_koran = $usr->getField("SYARAT_REKENING_KORAN");
			$this->syarat_rekening_koran_bulan = $usr->getField("SYARAT_REKENING_KORAN_BULAN");
			$this->syarat_keuangan_spt = $usr->getField("SYARAT_KEUANGAN_SPT");
			$this->syarat_keuangan_ppn = $usr->getField("SYARAT_KEUANGAN_PPN");
			$this->syarat_keuangan_pph = $usr->getField("SYARAT_KEUANGAN_PPH");
			$this->syarat_keuangan_pkp = $usr->getField("SYARAT_KEUANGAN_PKP");
						
			$this->syarat_admin_klasifikasi = $usr->getField("SYARAT_ADM_KUALIFIKASI");
			
			$this->syarat_keuangan_bulan_pph= $usr->getField("SYARAT_KEUANGAN_PPH_BULAN");
			$this->syarat_keuangan_bulan_ppn= $usr->getField("SYARAT_KEUANGAN_PPN_BULAN");
			
			$this->syarat_keuangan_info_spt= $usr->getField("SYARAT_TEKNIS_SERTIFIKAT_INFO");
			
			$this->syarat_ijin_siujk= $usr->getField("SYARAT_IJIN_SIUJK");
			$this->syarat_ijin_siui= $usr->getField("SYARAT_IJIN_SIUI");
			$this->syarat_ijin_lain= $usr->getField("SYARAT_IJIN_LAIN");
			$this->syarat_adm_kualifikasi_info= $usr->getField("SYARAT_ADM_KUALIFIKASI_INFO");
		}
		
		$this->query = $usr->query;
		
		unset($usr);
    }
		   
}
	
  /***** INSTANTIATE THE GLOBAL OBJECT */
  $paketInfo = new PaketInfo();

?>