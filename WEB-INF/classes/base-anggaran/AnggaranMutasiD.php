<? 
/* *******************************************************************************************************
MODUL NAME 			: MTSN LAWANG
FILE NAME 			: 
AUTHOR				: 
VERSION				: 1.0
MODIFICATION DOC	:
DESCRIPTION			: 
***************************************************************************************************** */

  /***
  * Entity-base class untuk mengimplementasikan tabel kategori.
  * 
  ***/
  include_once("../WEB-INF/classes/db/Entity.php");

  class AnggaranMutasiD extends Entity{ 

	var $query;
    /**
    * Class constructor.
    **/
    function AnggaranMutasiD()
	{
      $this->Entity(); 
    }
	
	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		//$this->setField("ANGGARAN_ID", $this->getNextId("ANGGARAN_ID","PEL_ANGGARAN.ANGGARAN_MUTASI_D")); 
		$str = "
				INSERT INTO PEL_ANGGARAN.ANGGARAN_MUTASI_D (
				   ANGGARAN_MUTASI_ID, NO_SEQ, NO_NOTA, 
				   KD_BUKU_BESAR, KD_SUB_BANTU, KD_BUKU_PUSAT, 
				   NAMA, UNIT, HARGA_SATUAN, 
				   JUMLAH, KET_TAMBAH, STATUS_JURNAL, PAJAK) 
				VALUES(
					  ".$this->getField("ANGGARAN_MUTASI_ID").",
					  '".$this->getField("NO_SEQ")."',
					  '".$this->getField("NO_NOTA")."',
					  '".$this->getField("KD_BUKU_BESAR")."',
					  '".$this->getField("KD_SUB_BANTU")."',
					  '".$this->getField("KD_BUKU_PUSAT")."',
					  '".$this->getField("NAMA")."',
					  '".$this->getField("UNIT")."',
					  '".$this->getField("HARGA_SATUAN")."',
					  '".$this->getField("JUMLAH")."',
					  '".$this->getField("KET_TAMBAH")."',
					  '".$this->getField("STATUS_JURNAL")."',
					  '".$this->getField("PAJAK")."'
				)"; 
		$this->id = $this->getField("ANGGARAN_ID");
		$this->query = $str;
		return $this->execQuery($str);
    }
	
	function insertPertanggungJawaban()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		//$this->setField("ANGGARAN_ID", $this->getNextId("ANGGARAN_ID","PEL_ANGGARAN.ANGGARAN_MUTASI_D")); 
		$str = "
				INSERT INTO PEL_ANGGARAN.ANGGARAN_MUTASI_D (
				   ANGGARAN_MUTASI_ID, NO_SEQ, NO_NOTA, 
				   KD_BUKU_BESAR, KD_SUB_BANTU, KD_BUKU_PUSAT, 
				   NAMA, UNIT, HARGA_SATUAN, 
				   JUMLAH, KET_TAMBAH, REALISASI, LEBIH_KURANG, STATUS_JURNAL) 
				VALUES(
					  ".$this->getField("ANGGARAN_MUTASI_ID").",
					  '".$this->getField("NO_SEQ")."',
					  '".$this->getField("NO_NOTA")."',
					  '".$this->getField("KD_BUKU_BESAR")."',
					  '".$this->getField("KD_SUB_BANTU")."',
					  '".$this->getField("KD_BUKU_PUSAT")."',
					  '".$this->getField("NAMA")."',
					  '".$this->getField("UNIT")."',
					  '".$this->getField("HARGA_SATUAN")."',
					  '".$this->getField("JUMLAH")."',
					  '".$this->getField("KET_TAMBAH")."',
					  '".$this->getField("REALISASI")."',
					  '".$this->getField("LEBIH_KURANG")."',
					  '".$this->getField("STATUS_JURNAL")."'
				)"; 
		$this->id = $this->getField("ANGGARAN_ID");
		$this->query = $str;
		return $this->execQuery($str);
    }
	
    function update()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$str = "
			   UPDATE  PEL_ANGGARAN.ANGGARAN_MUTASI_D
			   SET 
			   		 NO_SEQ = '".$this->getField("NO_SEQ")."',
					 NO_NOTA = '".$this->getField("NO_NOTA")."',
					 KD_BUKU_BESAR = '".$this->getField("KD_BUKU_BESAR")."',
					 KD_SUB_BANTU = '".$this->getField("KD_SUB_BANTU")."',
					 KD_BUKU_PUSAT = '".$this->getField("KD_BUKU_PUSAT")."',
					 NAMA = '".$this->getField("NAMA")."',
					 UNIT = '".$this->getField("UNIT")."',
					 HARGA_SATUAN = '".$this->getField("HARGA_SATUAN")."',
					 JUMLAH = '".$this->getField("JUMLAH")."',
					 KET_TAMBAH = '".$this->getField("KET_TAMBAH")."'
			 WHERE ANGGARAN_MUTASI_ID = ".$this->getField("ANGGARAN_MUTASI_ID")."
 
				"; 
				$this->query = $str;
		return $this->execQuery($str);
    }

    function updateRealisasi()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$str = "
			   UPDATE  PEL_ANGGARAN.ANGGARAN_MUTASI_D
			   SET 
			   		 REALISASI = '".$this->getField("REALISASI")."',
					 LEBIH_KURANG = '".$this->getField("LEBIH_KURANG")."'
			 WHERE ANGGARAN_MUTASI_ID = ".$this->getField("ANGGARAN_MUTASI_ID")." AND
			 	   KD_BUKU_BESAR = '".$this->getField("KD_BUKU_BESAR")."' AND
				   KD_BUKU_PUSAT = '".$this->getField("KD_BUKU_PUSAT")."'
				"; 
				$this->query = $str;
		return $this->execQuery($str);
    }

    function updateVerifikasiPertanggungjawaban()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$str = "
			   UPDATE  PEL_ANGGARAN.ANGGARAN_MUTASI_D
			   SET 
			   		 REALISASI = '".$this->getField("REALISASI")."',
					 LEBIH_KURANG = '".$this->getField("LEBIH_KURANG")."',
 			 	     NAMA = '".$this->getField("NAMA")."',
 			 	     KD_BUKU_BESAR = '".$this->getField("KD_BUKU_BESAR")."',
 			 	     KD_SUB_BANTU = '".$this->getField("KD_SUB_BANTU")."',
				     KD_BUKU_PUSAT = '".$this->getField("KD_BUKU_PUSAT")."'
			 WHERE ANGGARAN_MUTASI_ID = ".$this->getField("ANGGARAN_MUTASI_ID")." AND
			 	   NO_SEQ = ".$this->getField("NO_SEQ")."   AND STATUS_JURNAL = 'REALISASI'
				"; 
				$this->query = $str;
		return $this->execQuery($str);
    }
	
    function updateVerifikasiRencana()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$str = "
			   UPDATE  PEL_ANGGARAN.ANGGARAN_MUTASI_D
			   SET 
 			 	     NAMA = '".$this->getField("NAMA")."',
 			 	     KD_BUKU_BESAR = '".$this->getField("KD_BUKU_BESAR")."',
 			 	     KD_SUB_BANTU = '".$this->getField("KD_SUB_BANTU")."',
				     KD_BUKU_PUSAT = '".$this->getField("KD_BUKU_PUSAT")."',
				     PAJAK = '".$this->getField("PAJAK")."'
			 WHERE ANGGARAN_MUTASI_ID = ".$this->getField("ANGGARAN_MUTASI_ID")." AND
			 	   NO_SEQ = ".$this->getField("NO_SEQ")."   AND STATUS_JURNAL = 'RENCANA'
				"; 
				$this->query = $str;
		return $this->execQuery($str);
    }
			
	function delete()
	{
        $str = "DELETE FROM PEL_ANGGARAN.ANGGARAN_MUTASI_D
                WHERE 
                  ANGGARAN_MUTASI_ID = ".$this->getField("ANGGARAN_MUTASI_ID")."  AND STATUS_JURNAL = 'RENCANA' "; 
				  
		$this->query = $str;
        return $this->execQuery($str);
    }

	function deleteRealisasi()
	{
        $str = "DELETE FROM PEL_ANGGARAN.ANGGARAN_MUTASI_D
                WHERE 
                  ANGGARAN_MUTASI_ID = ".$this->getField("ANGGARAN_MUTASI_ID")."  AND STATUS_JURNAL = 'REALISASI' "; 
		$this->query = $str;
        return $this->execQuery($str);
    }
    /** 
    * Cari record berdasarkan array parameter dan limit tampilan 
    * @param array paramsArray Array of parameter. Contoh array("id"=>"xxx","nama"=>"yyy") 
    * @param int limit Jumlah maksimal record yang akan diambil 
    * @param int from Awal record yang diambil 
    * @return boolean True jika sukses, false jika tidak 
    **/ 
    function selectByParams($paramsArray=array(),$limit=-1,$from=-1,$statement="", $order="")
	{
		$str = "
				SELECT 
                A.ANGGARAN_MUTASI_ID, A.NO_SEQ, A.NO_NOTA, 
                   A.KD_BUKU_BESAR, A.KD_SUB_BANTU, A.KD_BUKU_PUSAT, 
                   NAMA, UNIT, HARGA_SATUAN, NM_SUB_BANTU,
                   A.JUMLAH, KET_TAMBAH, NVL(B.JUMLAH, 0) OVERBUDGET, C.NM_BUKU_BESAR, 
				   D.NM_BUKU_BESAR NM_BUKU_PUSAT, NVL(REALISASI, 0) REALISASI, NVL(LEBIH_KURANG, A.JUMLAH) LEBIH_KURANG,
                   NVL(UNIT, 1) * HARGA_SATUAN TOTAL, A.PAJAK,
                   A.KD_SUB_BANTU || ' ' || F.MPLG_NAMA NM_SUB_BANTU 
                FROM PEL_ANGGARAN.ANGGARAN_MUTASI_D A 
                LEFT JOIN PEL_ANGGARAN.ANGGARAN_OVERBUDGET B ON A.ANGGARAN_MUTASI_ID = B.ANGGARAN_MUTASI_ID AND A.KD_BUKU_BESAR = B.KD_BUKU_BESAR AND A.KD_BUKU_PUSAT = B.KD_BUKU_PUSAT AND A.NO_SEQ = B.NO_SEQ
                LEFT JOIN KBBR_BUKU_BESAR@KEUANGAN C ON A.KD_BUKU_BESAR = C.KD_BUKU_BESAR
                LEFT JOIN KBBR_BUKU_PUSAT@KEUANGAN D ON A.KD_BUKU_PUSAT = D.KD_BUKU_BESAR                
                LEFT JOIN KBBR_KARTU_TAMBAH@KEUANGAN E ON A.KD_SUB_BANTU = E.KD_SUB_BANTU
                LEFT JOIN PELANGGAN@KEUANGAN F ON F.MPLG_KODE = A.KD_SUB_BANTU 
                WHERE 1 = 1 AND STATUS_JURNAL = 'RENCANA'
			"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		$str .= $statement." ".$order;
		$this->query = $str;
		return $this->selectLimit($str,$limit,$from); 
    }
	
	 function selectByParamsOverbudget($paramsArray=array(),$limit=-1,$from=-1,$statement="", $order="")
	{
		$str = "
				SELECT 
                A.ANGGARAN_MUTASI_ID, A.NO_SEQ, A.NO_NOTA, 
                   A.KD_BUKU_BESAR, A.KD_SUB_BANTU, A.KD_BUKU_PUSAT, 
                   NAMA, UNIT, HARGA_SATUAN, NM_SUB_BANTU,
                   A.JUMLAH, KET_TAMBAH, NVL(B.JUMLAH, 0) OVERBUDGET, C.NM_BUKU_BESAR, 
				   D.NM_BUKU_BESAR NM_BUKU_PUSAT, NVL(REALISASI, 0) REALISASI, NVL(LEBIH_KURANG, A.JUMLAH) LEBIH_KURANG,
                   NVL(UNIT, 1) * HARGA_SATUAN TOTAL, A.PAJAK
                FROM PEL_ANGGARAN.ANGGARAN_MUTASI_D A 
                LEFT JOIN PEL_ANGGARAN.ANGGARAN_OVERBUDGET B ON A.ANGGARAN_MUTASI_ID = B.ANGGARAN_MUTASI_ID AND A.KD_BUKU_BESAR = B.KD_BUKU_BESAR AND A.KD_BUKU_PUSAT = B.KD_BUKU_PUSAT AND A.NO_SEQ = B.NO_SEQ
                LEFT JOIN KBBR_BUKU_BESAR@KEUANGAN C ON A.KD_BUKU_BESAR = C.KD_BUKU_BESAR
                LEFT JOIN KBBR_BUKU_PUSAT@KEUANGAN D ON A.KD_BUKU_PUSAT = D.KD_BUKU_BESAR                
                LEFT JOIN KBBR_KARTU_TAMBAH@KEUANGAN E ON A.KD_SUB_BANTU = E.KD_SUB_BANTU
                WHERE 1 = 1 AND STATUS_JURNAL = 'RENCANA'
			"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		$str .= $statement." ".$order;
		$this->query = $str;		
		return $this->selectLimit($str,$limit,$from); 
    }

    function selectByParamsRealisasi($paramsArray=array(),$limit=-1,$from=-1,$statement="", $order="")
	{
		$str = "
				SELECT DISTINCT  
                A.ANGGARAN_MUTASI_ID, A.NO_SEQ, A.NO_NOTA, 
                   A.KD_BUKU_BESAR, A.KD_SUB_BANTU, NM_SUB_BANTU, A.KD_BUKU_PUSAT, 
                   NAMA, UNIT, HARGA_SATUAN, 
                   A.JUMLAH, KET_TAMBAH, NVL(B.JUMLAH, 0) OVERBUDGET, C.NM_BUKU_BESAR, D.NM_BUKU_BESAR NM_BUKU_PUSAT, NVL(REALISASI, 0) REALISASI, NVL(LEBIH_KURANG, A.JUMLAH) LEBIH_KURANG, PAJAK
                FROM PEL_ANGGARAN.ANGGARAN_MUTASI_D A 
                LEFT JOIN PEL_ANGGARAN.ANGGARAN_OVERBUDGET B ON A.ANGGARAN_MUTASI_ID = B.ANGGARAN_MUTASI_ID AND A.KD_BUKU_BESAR = B.KD_BUKU_BESAR AND A.KD_BUKU_PUSAT = B.KD_BUKU_PUSAT
                LEFT JOIN KBBR_BUKU_BESAR@KEUANGAN C ON A.KD_BUKU_BESAR = C.KD_BUKU_BESAR
                LEFT JOIN KBBR_BUKU_PUSAT@KEUANGAN D ON A.KD_BUKU_PUSAT = D.KD_BUKU_BESAR              
                LEFT JOIN KBBR_KARTU_TAMBAH@KEUANGAN E ON A.KD_SUB_BANTU = E.KD_SUB_BANTU
                WHERE 1 = 1 AND STATUS_JURNAL = 'REALISASI'
			"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ".$order;
		$this->query = $str;
		//echo $str; exit;
		
		return $this->selectLimit($str,$limit,$from); 
    }


    function selectByParamsJurnalUangMuka($paramsArray=array(),$limit=-1,$from=-1,$statement="", $order="")
	{
		$str = "
				SELECT ANGGARAN_MUTASI_ID,
				   KD_BUKU_BESAR, KD_SUB_BANTU, 
				   KD_BUKU_PUSAT,
				   SALDO_VAL_DEBET, SALDO_VAL_KREDIT, 
				   SALDO_RP_DEBET, SALDO_RP_KREDIT  FROM
				(    				
                SELECT  
				   ANGGARAN_MUTASI_ID,
				   KD_BUKU_BESAR_UM KD_BUKU_BESAR, PUSPEL_SUB_BANTU KD_SUB_BANTU, 
				   '000.00.00' KD_BUKU_PUSAT,
				   JML_VAL_TRANS SALDO_VAL_DEBET, 0 SALDO_VAL_KREDIT, 
				   JML_VAL_TRANS SALDO_RP_DEBET, 0 SALDO_RP_KREDIT
				FROM PEL_ANGGARAN.ANGGARAN_MUTASI WHERE 1 = 1                
                UNION ALL
                SELECT  
                   ANGGARAN_MUTASI_ID,
                   '101.01.00' KD_BUKU_BESAR, '00000' KD_SUB_BANTU, 
                   '000.00.00' KD_BUKU_PUSAT,
                   0 SALDO_VAL_DEBET, JML_VAL_TRANS SALDO_VAL_KREDIT, 
                   0 SALDO_RP_DEBET, JML_VAL_TRANS SALDO_RP_KREDIT
                FROM PEL_ANGGARAN.ANGGARAN_MUTASI WHERE 1 = 1
                ) A WHERE 1 = 1 
			"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
	
		$str .= $statement." ".$order;
		$this->query = $str;
		
		
		return $this->selectLimit($str,$limit,$from); 
    }
	
	function selectByParamsPencarian($paramsArray=array(),$limit=-1,$from=-1,$statement="", $order="")
	{
		$str = "
				SELECT KD_SUB_BANTU, NM_SUB_BANTU FROM KBBR_KARTU_TAMBAH@KEUANGAN WHERE 1 = 1
			"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
	
		$str .= $statement." ".$order;
		$this->query = $str;
		
		
		return $this->selectLimit($str,$limit,$from); 
    }

	function selectByParamsPemakaianAnggaran($paramsArray=array(),$limit=-1,$from=-1,$statement="", $order="")
	{
		/* rem by chandra 24 februari 2015 karena PPN belum dijumlahkan
		$str = "
				SELECT A.KD_BUKU_BESAR, A.KD_BUKU_PUSAT, A.KD_SUB_BANTU, B.NM_BUKU_BESAR, SUM(JUMLAH) JUMLAH  
				FROM PEL_ANGGARAN.ANGGARAN_MUTASI_D A
				LEFT JOIN KBBR_BUKU_BESAR@KEUANGAN B ON A.KD_BUKU_BESAR = B.KD_BUKU_BESAR
				WHERE 1 = 1 AND STATUS_JURNAL = 'RENCANA'
			"; 
		*/
		
		$str = "SELECT A.KD_BUKU_BESAR, A.KD_BUKU_PUSAT, A.KD_SUB_BANTU, B.NM_BUKU_BESAR, 
				SUM(
				    DECODE(A.PAJAK, 
				        'Y', (A.JUMLAH * NVL(C.PAJAK / 100,0))
				        ,0
				    ) + A.JUMLAH
				    ) JUMLAH
				/*NVL (SUM(A.JUMLAH+DECODE(A.PAJAK, 'Y', A.JUMLAH*(NVL(C.PAJAK/100,0)),0)),0)  JUMLAH  */
                FROM PEL_ANGGARAN.ANGGARAN_MUTASI_D A
                LEFT JOIN KBBR_BUKU_BESAR@KEUANGAN B ON A.KD_BUKU_BESAR = B.KD_BUKU_BESAR
                LEFT JOIN PEL_ANGGARAN.ANGGARAN_MUTASI C ON A.ANGGARAN_MUTASI_ID = C.ANGGARAN_MUTASI_ID
				WHERE 1 = 1 AND STATUS_JURNAL = 'RENCANA' ";
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
	
		$str .= $statement." GROUP BY A.KD_BUKU_BESAR, B.NM_BUKU_BESAR, A.KD_BUKU_PUSAT, A.KD_SUB_BANTU ".$order;
		$this->query = $str;
		
		//echo $str; exit;
		return $this->selectLimit($str,$limit,$from); 
    }
	
    function selectByParamsJurnalPermintaanAnggaran($paramsArray=array(),$limit=-1,$from=-1,$statement="", $order=" ORDER BY NO_SEQ ASC ")
	{
		$str = "
				
                SELECT ANGGARAN_MUTASI_ID,
				   KD_BUKU_BESAR, KD_SUB_BANTU, 
                   KD_BUKU_PUSAT,
                   SALDO_VAL_DEBET, SALDO_VAL_KREDIT, 
                   SALDO_RP_DEBET, SALDO_RP_KREDIT, KET_TAMBAH  FROM
                (    
                SELECT  
                   ANGGARAN_MUTASI_ID,
                   KD_BUKU_BESAR, KD_SUB_BANTU, 
                   KD_BUKU_PUSAT,
                   JUMLAH SALDO_VAL_DEBET, 0 SALDO_VAL_KREDIT, 
                   JUMLAH SALDO_RP_DEBET, 0 SALDO_RP_KREDIT, NO_SEQ, NAMA KET_TAMBAH
                FROM PEL_ANGGARAN.ANGGARAN_MUTASI_D WHERE STATUS_JURNAL = 'REALISASI'
                UNION ALL
                SELECT  
                   ANGGARAN_MUTASI_ID,
                   '101.01.00' KD_BUKU_BESAR, '00000' KD_SUB_BANTU, 
                   '000.00.00' KD_BUKU_PUSAT,
                   0 SALDO_VAL_DEBET, JML_VAL_REALISASI SALDO_VAL_KREDIT, 
                   0 SALDO_RP_DEBET, JML_VAL_REALISASI SALDO_RP_KREDIT, 9999 NO_SEQ, '' KET_TAMBAH
                FROM PEL_ANGGARAN.ANGGARAN_MUTASI
                ) A WHERE 1 = 1 
			"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ".$order;
		$this->query = $str;
		
		
		return $this->selectLimit($str,$limit,$from); 
    }


    function selectByParamsJurnalPertanggungjawabanUangMukaKurang($paramsArray=array(),$limit=-1,$from=-1,$statement="", $order="")
	{
		$str = "
                SELECT ANGGARAN_MUTASI_ID,
                   KD_BUKU_BESAR, KD_SUB_BANTU, 
                   KD_BUKU_PUSAT,
                   SALDO_VAL_DEBET, SALDO_VAL_KREDIT, 
                   SALDO_RP_DEBET, SALDO_RP_KREDIT  FROM
                (                    
                SELECT  
                   A.ANGGARAN_MUTASI_ID,
                   A.KD_BUKU_BESAR, '00000' KD_SUB_BANTU, 
                   KD_BUKU_PUSAT,
                   JUMLAH SALDO_VAL_DEBET, 0 SALDO_VAL_KREDIT, 
                   JUMLAH SALDO_RP_DEBET, 0 SALDO_RP_KREDIT
                FROM PEL_ANGGARAN.ANGGARAN_MUTASI_D A 
                     INNER JOIN PEL_ANGGARAN.ANGGARAN_MUTASI B ON A.ANGGARAN_MUTASI_ID = B.ANGGARAN_MUTASI_ID
                     INNER JOIN (SELECT A.ANGGARAN_MUTASI_ID, MAX(KD_BUKU_BESAR) KD_BUKU_BESAR FROM PEL_ANGGARAN.ANGGARAN_MUTASI_D A WHERE STATUS_JURNAL = 'REALISASI' GROUP BY A.ANGGARAN_MUTASI_ID) C ON C.ANGGARAN_MUTASI_ID = A.ANGGARAN_MUTASI_ID 
                WHERE STATUS_JURNAL = 'RENCANA'                                     
                UNION ALL
                SELECT  
                   A.ANGGARAN_MUTASI_ID,
                   KD_BUKU_BESAR_UM KD_BUKU_BESAR, PUSPEL_SUB_BANTU KD_SUB_BANTU, 
                   '000.00.00' KD_BUKU_PUSAT,
                   0 SALDO_VAL_DEBET, A.JML_VAL_TRANS SALDO_VAL_KREDIT, 
                   0 SALDO_RP_DEBET, A.JML_VAL_TRANS SALDO_RP_KREDIT
                FROM PEL_ANGGARAN.ANGGARAN_MUTASI A
                ) A WHERE 1 = 1
			"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ".$order;
		$this->query = $str;
		
		
		return $this->selectLimit($str,$limit,$from); 
    }	

    function selectByParamsJurnalPertanggungjawabanUangMuka($paramsArray=array(),$limit=-1,$from=-1,$statement="", $order="")
	{
		$str = "
				SELECT ANGGARAN_MUTASI_ID,
                   KD_BUKU_BESAR, KD_SUB_BANTU, 
                   KD_BUKU_PUSAT,
                   SALDO_VAL_DEBET, SALDO_VAL_KREDIT, 
                   SALDO_RP_DEBET, SALDO_RP_KREDIT  FROM
                (    
                SELECT  
                   ANGGARAN_MUTASI_ID,
                   KD_BUKU_BESAR, KD_SUB_BANTU, 
                   KD_BUKU_PUSAT,
                   JUMLAH SALDO_VAL_DEBET, 0 SALDO_VAL_KREDIT, 
                   JUMLAH SALDO_RP_DEBET, 0 SALDO_RP_KREDIT
                FROM PEL_ANGGARAN.ANGGARAN_MUTASI_D WHERE STATUS_JURNAL = 'REALISASI'
                UNION ALL
                SELECT  
                   A.ANGGARAN_MUTASI_ID,
                   KD_BUKU_BESAR_UM KD_BUKU_BESAR, PUSPEL_SUB_BANTU KD_SUB_BANTU, 
                   '000.00.00' KD_BUKU_PUSAT,
                   0 SALDO_VAL_DEBET, JML_VAL_REALISASI SALDO_VAL_KREDIT, 
                   0 SALDO_RP_DEBET, JML_VAL_REALISASI SALDO_RP_KREDIT
                FROM PEL_ANGGARAN.ANGGARAN_MUTASI A
                ) A WHERE 1 = 1
			"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ".$order;
		$this->query = $str;
		
		
		return $this->selectLimit($str,$limit,$from); 
    }	

    function selectByParamsJurnalPertanggungjawabanKurangJKK($paramsArray=array(),$limit=-1,$from=-1,$statement="", $order="")
	{
		$str = "
                SELECT ANGGARAN_MUTASI_ID,
                   KD_BUKU_BESAR, KD_SUB_BANTU, 
                   KD_BUKU_PUSAT,
                   SALDO_VAL_DEBET, SALDO_VAL_KREDIT, 
                   SALDO_RP_DEBET, SALDO_RP_KREDIT  FROM
                (    
                SELECT  
                   A.ANGGARAN_MUTASI_ID,
                   KD_BUKU_BESAR, KD_SUB_BANTU, 
                   KD_BUKU_PUSAT,
                   JUMLAH - COALESCE((SELECT JUMLAH FROM PEL_ANGGARAN.ANGGARAN_MUTASI_D X WHERE X.ANGGARAN_MUTASI_ID = A.ANGGARAN_MUTASI_ID AND X.NO_SEQ = A.NO_SEQ AND STATUS_JURNAL = 'RENCANA'), 0) SALDO_VAL_DEBET, 0 SALDO_VAL_KREDIT, 
                   JUMLAH - COALESCE((SELECT JUMLAH FROM PEL_ANGGARAN.ANGGARAN_MUTASI_D X WHERE X.ANGGARAN_MUTASI_ID = A.ANGGARAN_MUTASI_ID AND X.NO_SEQ = A.NO_SEQ AND STATUS_JURNAL = 'RENCANA'), 0)  SALDO_RP_DEBET, 0 SALDO_RP_KREDIT
                FROM PEL_ANGGARAN.ANGGARAN_MUTASI_D A INNER JOIN PEL_ANGGARAN.ANGGARAN_MUTASI B ON A.ANGGARAN_MUTASI_ID = B.ANGGARAN_MUTASI_ID  
                WHERE STATUS_JURNAL = 'REALISASI' 
                UNION ALL
                SELECT  
                   A.ANGGARAN_MUTASI_ID,
                   '101.01.00' KD_BUKU_BESAR, '00000' KD_SUB_BANTU, 
                   '000.00.00' KD_BUKU_PUSAT,
                   0 SALDO_VAL_DEBET, ABS(JML_VAL_LEBIH_KURANG) SALDO_VAL_KREDIT, 
                   0 SALDO_RP_DEBET, ABS(JML_VAL_LEBIH_KURANG) SALDO_RP_KREDIT
                FROM PEL_ANGGARAN.ANGGARAN_MUTASI A
                ) A WHERE 1 = 1
			"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ".$order;

		$this->query = $str;
		
		
		return $this->selectLimit($str,$limit,$from); 
    }	

    function selectByParamsJurnalPertanggungjawabanPengembalianJKM($paramsArray=array(),$limit=-1,$from=-1,$statement="", $order="")
	{
		$str = "
				SELECT ANGGARAN_MUTASI_ID,
                   KD_BUKU_BESAR, KD_SUB_BANTU, 
                   KD_BUKU_PUSAT,
                   SALDO_VAL_DEBET, SALDO_VAL_KREDIT, 
                   SALDO_RP_DEBET, SALDO_RP_KREDIT  FROM
                (    
                SELECT  
                   A.ANGGARAN_MUTASI_ID,
                   '101.01.00' KD_BUKU_BESAR, '00000' KD_SUB_BANTU, 
                   '000.00.00' KD_BUKU_PUSAT,
                   ABS(JML_VAL_LEBIH_KURANG) SALDO_VAL_DEBET, 0 SALDO_VAL_KREDIT, 
                   ABS(JML_VAL_LEBIH_KURANG) SALDO_RP_DEBET, 0 SALDO_RP_KREDIT
                FROM PEL_ANGGARAN.ANGGARAN_MUTASI A
                UNION ALL
                SELECT  
                   A.ANGGARAN_MUTASI_ID,
                   KD_BUKU_BESAR_UM KD_BUKU_BESAR, PUSPEL_SUB_BANTU KD_SUB_BANTU, 
                   '000.00.00' KD_BUKU_PUSAT,
                   0 SALDO_VAL_DEBET, ABS(JML_VAL_LEBIH_KURANG) SALDO_VAL_KREDIT, 
                   0 SALDO_RP_DEBET, ABS(JML_VAL_LEBIH_KURANG) SALDO_RP_KREDIT
                FROM PEL_ANGGARAN.ANGGARAN_MUTASI A              
                ) A WHERE 1 = 1 
			"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ".$order;
		$this->query = $str;
		
		
		return $this->selectLimit($str,$limit,$from); 
    }	
		 
	function selectByParamsLike($paramsArray=array(),$limit=-1,$from=-1, $statement="")
	{
		$str = "    
				SELECT 
				ANGGARAN_MUTASI_ID, NO_SEQ, NO_NOTA, 
				   KD_BUKU_BESAR, KD_SUB_BANTU, KD_BUKU_PUSAT, 
				   NAMA, UNIT, HARGA_SATUAN, 
				   JUMLAH, KET_TAMBAH
				FROM PEL_ANGGARAN.ANGGARAN_MUTASI_D
                WHERE 1 = 1
			"; 
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key LIKE '%$val%' ";
		}
		
		$str .= $statement." ORDER BY ANGGARAN_ID DESC";
		$this->query = $str;		
		return $this->selectLimit($str,$limit,$from); 
    }	
    /** 
    * Hitung jumlah record berdasarkan parameter (array). 
    * @param array paramsArray Array of parameter. Contoh array("id"=>"xxx","nama"=>"yyy") 
    * @return long Jumlah record yang sesuai kriteria 
    **/ 
    function getCountByParams($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(A.ANGGARAN_MUTASI_ID) AS ROWCOUNT FROM PEL_ANGGARAN.ANGGARAN_MUTASI_D A WHERE 1 = 1 ".$statement; 
		while(list($key,$val)=each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$this->select($str); 
		$this->query = $str;
		if($this->firstRow()) 
			return $this->getField("ROWCOUNT"); 
		else 
			return 0; 
    }
	
	 function getCountByParamsPencarian($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(1) AS ROWCOUNT FROM KBBR_KARTU_TAMBAH@KEUANGAN WHERE 1 = 1 ".$statement; 
		while(list($key,$val)=each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$this->select($str); 
		$this->query = $str;
		if($this->firstRow()) 
			return $this->getField("ROWCOUNT"); 
		else 
			return 0; 
    }

    function getSumByParams($paramsArray=array(), $statement="")
	{
		/* rem by chandra 24 FEB 2015 karena PPN belum dijumlahkan pada total
		$str = "SELECT NVL (SUM (A.JUMLAH), 0) AS JUMLAH
				  FROM PEL_ANGGARAN.ANGGARAN_MUTASI_D A INNER JOIN PEL_ANGGARAN.ANGGARAN_MUTASI B
					   ON A.ANGGARAN_MUTASI_ID = B.ANGGARAN_MUTASI_ID AND THN_BUKU = TO_CHAR(SYSDATE, 'YYYY')
				 WHERE 1 = 1 ".$statement; 
		*/		 
		$str = "SELECT NVL (SUM (A.JUMLAH + DECODE(A.PAJAK, 'Y', A.JUMLAH*(B.PAJAK/100),0)), 0) AS JUMLAH
				  FROM PEL_ANGGARAN.ANGGARAN_MUTASI_D A INNER JOIN PEL_ANGGARAN.ANGGARAN_MUTASI B
					   ON A.ANGGARAN_MUTASI_ID = B.ANGGARAN_MUTASI_ID AND THN_BUKU = TO_CHAR(SYSDATE, 'YYYY')
				 WHERE 1 = 1 ".$statement; 
		while(list($key,$val)=each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		//echo $str; exit;
		$this->select($str); 
		$this->query = $str;
		if($this->firstRow()) 
			return $this->getField("JUMLAH"); 
		else 
			return 0; 
    }
	
    function getCountByParamsLike($paramsArray=array())
	{
		$str = "SELECT COUNT(ANGGARAN_MUTASI_ID) AS ROWCOUNT FROM PEL_ANGGARAN.ANGGARAN_MUTASI_D WHERE 1 = 1 "; 
		while(list($key,$val)=each($paramsArray))
		{
			$str .= " AND $key LIKE '%$val%' ";
		}
		
		$this->select($str); 
		if($this->firstRow()) 
			return $this->getField("ROWCOUNT"); 
		else 
			return 0; 
    }	
  } 
?>