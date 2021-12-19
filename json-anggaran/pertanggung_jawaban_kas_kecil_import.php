<?
/* INCLUDE FILE */
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base-anggaran/AnggaranKelengkapanDokumen.php");
include_once("../WEB-INF/classes/base-anggaran/AnggaranMutasi.php");
include_once("../WEB-INF/classes/base-anggaran/AnggaranMutasiD.php");
include_once("../WEB-INF/classes/utils/UserLogin.php");

include "../operasional/excel/excel_reader2.php";

$anggaran_mutasi_kode = new AnggaranMutasi();
$anggaran_mutasi = new AnggaranMutasi();
$anggaran_mutasi_d = new AnggaranMutasiD();
$anggaran_kelengkapan_dokumen = new AnggaranKelengkapanDokumen();

$reqId = httpFilterPost("reqId");
$reqMode = httpFilterPost("reqMode");
$reqKelengkapanDokumen = httpFilterPost("reqKelengkapanDokumen");
$reqNoBukti = httpFilterPost("reqNoBukti");
$reqNoRef1 = httpFilterPost("reqNoRef1");
$reqNoRef2 = httpFilterPost("reqNoRef2");
$reqNoRef3 = httpFilterPost("reqNoRef3");
$reqPegawaiId = httpFilterPost("reqPegawaiId");
$reqTanggalTransaksi = httpFilterPost("reqTanggalTransaksi");
$reqTahun = httpFilterPost("reqTahun");
$reqBulan = httpFilterPost("reqBulan");
$reqPersenPajak = httpFilterPost("reqPersenPajak");
$reqKodeValuta = httpFilterPost("reqKodeValuta");
$reqKursValuta = httpFilterPost("reqKursValuta");
$reqKetTambah = httpFilterPost("reqKetTambah");
$reqJumlahDiBayar = httpFilterPost("reqJumlahDiBayar");
$reqJumlahUangMuka = httpFilterPost("reqJumlahUangMuka");
$reqJenis = httpFilterPost("reqJenis");
$reqPuspel = httpFilterPost("reqPuspel");
$reqPuspelNama = httpFilterPost("reqPuspelNama");
$reqSupplier = httpFilterPost("reqSupplier");
$reqPuspelSubBantu = httpFilterPost("reqPuspelSubBantu");

$arraySubbantu = explode("-",$reqPuspelSubBantu);
$reqPuspelSubBantu = $arraySubbantu[0];
$reqSupplier = $arraySubbantu[1];

if($reqNoBukti == "")
	$reqNoBukti = $anggaran_mutasi_kode->getKode();

$data = new Spreadsheet_Excel_Reader($_FILES['reqLinkFile']['tmp_name']);
$baris = $data->rowcount($sheet_index=0);

$anggaran_mutasi->setField("NO_NOTA", $reqNoBukti);
$anggaran_mutasi->setField("PEGAWAI_ID", $userLogin->pegawaiId);
$anggaran_mutasi->setField("THN_BUKU", $reqTahun);
$anggaran_mutasi->setField("BLN_BUKU", $reqBulan);
$anggaran_mutasi->setField("TGL_TRANS", dateToDBCheck($data->val(2, 2)));
$anggaran_mutasi->setField("TGL_ENTRY", "SYSDATE");
$anggaran_mutasi->setField("KD_VALUTA", $reqKodeValuta);
$anggaran_mutasi->setField("TGL_VALUTA", dateToDBCheck($data->val(2, 2)));
$anggaran_mutasi->setField("KURS_VALUTA", $reqKursValuta);
$anggaran_mutasi->setField("JML_VAL_TRANS", dotToNo($reqJumlahDiBayar));
$anggaran_mutasi->setField("JML_RP_TRANS", dotToNo($reqJumlahDiBayar));
$anggaran_mutasi->setField("KET_TAMBAH", $reqKetTambah);
$anggaran_mutasi->setField("NO_POSTING", "");
$anggaran_mutasi->setField("TGL_POSTING", "NULL");
$anggaran_mutasi->setField("JML_CETAK", "0");
$anggaran_mutasi->setField("LAST_UPDATE_DATE", "SYSDATE");
$anggaran_mutasi->setField("LAST_UPDATED_BY", $userLogin->nama);
$anggaran_mutasi->setField("PROGRAM_NAME", "ANGGARAN_MUTASI_IMAIS");
$anggaran_mutasi->setField("NO_REF1", $reqNoRef1);
$anggaran_mutasi->setField("NO_REF2", $reqNoRef2);
$anggaran_mutasi->setField("NO_REF3", $reqNoRef3);
$anggaran_mutasi->setField("PAJAK", $reqPersenPajak);
$anggaran_mutasi->setField("UANG_MUKA", dotToNo($reqJumlahUangMuka));
$anggaran_mutasi->setField("JENIS_ANGGARAN_ID", $reqJenis);
$anggaran_mutasi->setField("PUSPEL", $reqPuspel);
$anggaran_mutasi->setField("PUSPEL_NAMA", $reqPuspelNama);
$anggaran_mutasi->setField("JML_VAL_REALISASI", dotToNo($reqJumlahDiBayar));
$anggaran_mutasi->setField("JML_VAL_LEBIH_KURANG", "");
$anggaran_mutasi->setField("PUSPEL_SUB_BANTU", $reqPuspelSubBantu);
$anggaran_mutasi->setField("SUPPLIER", $reqSupplier);

if($reqMode == "insert")
{	
	if($anggaran_mutasi->insert())
	{
		$id = $anggaran_mutasi->id;
		
		for($i=1;$i<=$baris;$i++)
		{
			if($data->val($i, 1) == "")
			{}
			else
			{
				$anggaran_mutasi_d = new AnggaranMutasiD();
				$anggaran_mutasi_d->setField("ANGGARAN_MUTASI_ID", $id);
				$anggaran_mutasi_d->setField("NO_NOTA", $reqNoBukti);
				$anggaran_mutasi_d->setField("NO_SEQ", $data->val($i, 1));
				$anggaran_mutasi_d->setField("KD_BUKU_BESAR", $data->val($i, 3));
				$anggaran_mutasi_d->setField("KD_BUKU_PUSAT", $data->val($i, 4));
				$anggaran_mutasi_d->setField("KD_SUB_BANTU", $data->val($i, 5));
				$anggaran_mutasi_d->setField("NAMA", $data->val($i, 6));
				$anggaran_mutasi_d->setField("KET_TAMBAH", $data->val($i, 7));
				$anggaran_mutasi_d->setField("UNIT", $data->val($i, 8));
				$anggaran_mutasi_d->setField("HARGA_SATUAN", dotToNo($data->val($i, 9)));
				$anggaran_mutasi_d->setField("JUMLAH", dotToNo($data->val($i, 10)));
				$anggaran_mutasi_d->setField("REALISASI", dotToNo($data->val($i, 10)));
				$anggaran_mutasi_d->setField("LEBIH_KURANG", 0);
				$anggaran_mutasi_d->setField("STATUS_JURNAL", "REALISASI");			
				$anggaran_mutasi_d->insertPertanggungJawaban();
				//echo $anggaran_mutasi_d->query;
				unset($anggaran_mutasi_d);
			}
		}

		if($reqKelengkapanDokumen==""){}
		else
		{
			$anggaran_kelengkapan_dokumen->setField("ANGGARAN_MUTASI_ID", $id);
			$anggaran_kelengkapan_dokumen->delete();
			
			$arrKelengkapanAnggaran = explode(",", $reqKelengkapanDokumen);
			for($i=0;$i<count($arrKelengkapanAnggaran);$i++)
			{
				$anggaran_kelengkapan_dokumen = new AnggaranKelengkapanDokumen();
				
				$anggaran_kelengkapan_dokumen->setField("ANGGARAN_MUTASI_ID", $id);
				$anggaran_kelengkapan_dokumen->setField("KELENGKAPAN_DOKUMEN_ID", $arrKelengkapanAnggaran[$i]);
				$anggaran_kelengkapan_dokumen->insert();
				unset($anggaran_kelengkapan_dokumen);	
			}
		}
				
		echo $id."-Data berhasil disimpan.";	
	}
	//echo $anggaran_mutasi->query;
}
?>