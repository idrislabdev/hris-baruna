<? 
/* *******************************************************************************************************
MODUL NAME 			: PEL
FILE NAME 			: 
AUTHOR				: 
VERSION				: 1.0
MODIFICATION DOC	:
DESCRIPTION			: 
***************************************************************************************************** */

  /***
  * Entity-base class untuk mengimplementasikan tabel USER_GROUP.
  * 
  ***/
  include_once("../WEB-INF/classes/db/Entity.php");

  class UserGroup extends Entity{ 

	var $query;
    /**
    * Class constructor.
    **/
    function UserGroup()
	{
      $this->Entity(); 
    }
	
	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("USER_GROUP_ID", $this->getNextId("USER_GROUP_ID","USER_GROUP"));

		$str = "
					INSERT INTO USER_GROUP (
					   USER_GROUP_ID, NAMA, AKSES_APP_OPERASIONAL_ID, AKSES_APP_ARSIP_ID, AKSES_APP_INVENTARIS_ID, AKSES_APP_SPPD_ID, AKSES_APP_KEPEGAWAIAN_ID, AKSES_APP_PENGHASILAN_ID
					   ,AKSES_APP_PRESENSI_ID, AKSES_APP_PENILAIAN_ID, AKSES_APP_BACKUP_ID, AKSES_APP_HUKUM_ID, AKSES_ADM_WEBSITE_ID, AKSES_ADM_INTRANET_ID, AKSES_APP_SURVEY_ID,
					   PUBLISH_KANTOR_PUSAT, AKSES_APP_FILE_MANAGER_ID, AKSES_APP_KOMERSIAL_ID, AKSES_SMS_GATEWAY, AKSES_KEUANGAN, AKSES_KONTRAK_HUKUM, AKSES_APP_NOTIFIKASI_ID,
					   AKSES_APP_GALANGAN_ID, AKSES_APP_ANGGARAN_ID, AKSES_APP_KEUANGAN_ID)
 			  	VALUES (
				  ".$this->getField("USER_GROUP_ID").",
				  '".$this->getField("NAMA")."',
				  ".$this->getField("AKSES_APP_OPERASIONAL_ID").",
				  '".$this->getField("AKSES_APP_ARSIP_ID")."',
				  ".$this->getField("AKSES_APP_INVENTARIS_ID").",
				  ".$this->getField("AKSES_APP_SPPD_ID").",
				  ".$this->getField("AKSES_APP_KEPEGAWAIAN_ID").",
				  ".$this->getField("AKSES_APP_PENGHASILAN_ID").",
				  ".$this->getField("AKSES_APP_PRESENSI_ID").",
				  ".$this->getField("AKSES_APP_PENILAIAN_ID").",
				  ".$this->getField("AKSES_APP_BACKUP_ID").",
				  ".$this->getField("AKSES_APP_HUKUM_ID").",
				  ".$this->getField("AKSES_ADM_WEBSITE_ID").",
				  ".$this->getField("AKSES_ADM_INTRANET_ID").",
				  ".$this->getField("AKSES_APP_SURVEY_ID").",
				  '".$this->getField("PUBLISH_KANTOR_PUSAT")."',
				  ".$this->getField("AKSES_APP_FILE_MANAGER_ID").",
				  ".$this->getField("AKSES_APP_KOMERSIAL_ID").",
				  '".$this->getField("AKSES_SMS_GATEWAY")."',
				  ".($this->getField("AKSES_KEUANGAN") == "" ? 0 : $this->getField("AKSES_KEUANGAN")) . ",
				  ".$this->getField("AKSES_KONTRAK_HUKUM").",
				  ".$this->getField("AKSES_APP_NOTIFIKASI_ID").",
				  ".$this->getField("AKSES_APP_GALANGAN_ID").",
				  ".$this->getField("AKSES_APP_ANGGARAN_ID").",
				  ".$this->getField("AKSES_APP_KEUANGAN_ID")."				  			  
				)"; 
		$this->query = $str;

		return $this->execQuery($str);
    }

    function update()
	{
		$str = "
				UPDATE USER_GROUP
				SET    
					   NAMA          = '".$this->getField("NAMA")."',
					   AKSES_APP_OPERASIONAL_ID= ".$this->getField("AKSES_APP_OPERASIONAL_ID").",
					   AKSES_APP_ARSIP_ID= '".$this->getField("AKSES_APP_ARSIP_ID")."',
					   AKSES_APP_INVENTARIS_ID= ".$this->getField("AKSES_APP_INVENTARIS_ID").",
					   AKSES_APP_SPPD_ID= ".$this->getField("AKSES_APP_SPPD_ID").",
					   AKSES_APP_KEPEGAWAIAN_ID= ".$this->getField("AKSES_APP_KEPEGAWAIAN_ID").",
					   AKSES_APP_PENGHASILAN_ID= ".$this->getField("AKSES_APP_PENGHASILAN_ID").",
					   AKSES_APP_PRESENSI_ID= ".$this->getField("AKSES_APP_PRESENSI_ID").",
					   AKSES_APP_PENILAIAN_ID= ".$this->getField("AKSES_APP_PENILAIAN_ID").",
					   AKSES_APP_BACKUP_ID= ".$this->getField("AKSES_APP_BACKUP_ID").",
					   AKSES_APP_HUKUM_ID= ".$this->getField("AKSES_APP_HUKUM_ID").",
					   AKSES_ADM_WEBSITE_ID= ".$this->getField("AKSES_ADM_WEBSITE_ID").",
					   AKSES_ADM_INTRANET_ID= ".$this->getField("AKSES_ADM_INTRANET_ID").",
					   AKSES_APP_SURVEY_ID= ".$this->getField("AKSES_APP_SURVEY_ID").",
					   PUBLISH_KANTOR_PUSAT = ".$this->getField("PUBLISH_KANTOR_PUSAT").",
					   AKSES_APP_FILE_MANAGER_ID = ".$this->getField("AKSES_APP_FILE_MANAGER_ID").",
					   AKSES_APP_KOMERSIAL_ID = ".$this->getField("AKSES_APP_KOMERSIAL_ID").",
					   AKSES_SMS_GATEWAY = '".$this->getField("AKSES_SMS_GATEWAY")."',
					   AKSES_KEUANGAN = '".$this->getField("AKSES_KEUANGAN")."',
					   AKSES_KONTRAK_HUKUM = '".$this->getField("AKSES_KONTRAK_HUKUM")."',
					   AKSES_APP_NOTIFIKASI_ID = ".$this->getField("AKSES_APP_NOTIFIKASI_ID").",
					   AKSES_APP_GALANGAN_ID = ".$this->getField("AKSES_APP_GALANGAN_ID").",
					   AKSES_APP_ANGGARAN_ID = ".$this->getField("AKSES_APP_ANGGARAN_ID").",
					   AKSES_APP_KEUANGAN_ID = ".$this->getField("AKSES_APP_KEUANGAN_ID")."
				WHERE  USER_GROUP_ID     = ".$this->getField("USER_GROUP_ID")."

			 "; 
		$this->query = $str;
		//echo $this->query;
		return $this->execQuery($str);
    }

	function delete()
	{
        $str = "DELETE FROM USER_GROUP
                WHERE 
                  USER_GROUP_ID = ".$this->getField("USER_GROUP_ID").""; 
				  
		$this->query = $str;
        return $this->execQuery($str);
    }

    /** 
    * Cari record berdasarkan array parameter dan limit tampilan 
    * @param array paramsArray Array of parameter. Contoh array("id"=>"xxx","IJIN_USAHA_ID"=>"yyy") 
    * @param int limit Jumlah maksimal record yang akan diambil 
    * @param int from Awal record yang diambil 
    * @return boolean True jika sukses, false jika tidak 
    **/ 
    function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $statement="", $order=" ORDER BY A.NAMA ASC")
	{
		$str = "
					SELECT 
                    USER_GROUP_ID, A.NAMA, KETERANGAN, B.NAMA AKSES_APP_DATABASE, C.NAMA AKSES_APP_OPERASIONAL, 
                    D.NAMA AKSES_APP_KEPEGAWAIAN, E.NAMA AKSES_APP_PENGHASILAN,
                    F.NAMA AKSES_APP_PRESENSI, G.NAMA AKSES_APP_PENILAIAN, M.NAMA AKSES_APP_ARSIP, N.NAMA AKSES_APP_INVENTARIS, O.NAMA AKSES_APP_SPPD, 
                    H.NAMA AKSES_APP_BACKUP, P.NAMA AKSES_APP_HUKUM, I.NAMA AKSES_ADM_WEBSITE, J.NAMA AKSES_ADM_INTRANET, K.NAMA AKSES_APP_SURVEY, L.NAMA AKSES_APP_KOMERSIAL,
                    R.NAMA AKSES_APP_GALANGAN,
                    A.AKSES_APP_DATABASE_ID, A.AKSES_APP_OPERASIONAL_ID, A.AKSES_APP_KEPEGAWAIAN_ID, A.AKSES_APP_PENGHASILAN_ID, 
                    A.AKSES_APP_PRESENSI_ID, A.AKSES_APP_PENILAIAN_ID, A.AKSES_APP_BACKUP_ID, A.AKSES_APP_HUKUM_ID, A.AKSES_ADM_WEBSITE_ID, A.AKSES_ADM_INTRANET_ID,
                    A.AKSES_APP_SURVEY_ID, A.AKSES_APP_KOMERSIAL_ID,R.AKSES_APP_GALANGAN_ID, CASE WHEN PUBLISH_KANTOR_PUSAT = 1 THEN 'Ya' ELSE 'Tidak' END PUBLISH_KANTOR_PUSAT,
                    PUBLISH_KANTOR_PUSAT PUBLISH_KANTOR_PUSAT_ID,  CASE WHEN AKSES_APP_FILE_MANAGER_ID = 1 THEN 'Ya' ELSE 'Tidak' END AKSES_APP_FILE_MANAGER,
                    CASE WHEN AKSES_SMS_GATEWAY = 1 THEN 'Ya' ELSE 'Tidak' END AKSES_SMS_GATEWAY,
                    AKSES_SMS_GATEWAY AKSES_SMS_GATEWAY_ID,
                    AKSES_APP_FILE_MANAGER_ID, A.AKSES_APP_ARSIP_ID, A.AKSES_APP_INVENTARIS_ID, A.AKSES_APP_SPPD_ID,
                    AKSES_KEUANGAN AKSES_KEUANGAN_ID,
                    CASE WHEN AKSES_KONTRAK_HUKUM = 1 THEN 'Ya' ELSE 'Tidak' END AKSES_KONTRAK_HUKUM,
                    AKSES_KONTRAK_HUKUM AKSES_KONTRAK_HUKUM_ID,
                    Q.NAMA AKSES_APP_NOTIFIKASI,
                    A.AKSES_APP_NOTIFIKASI_ID AKSES_APP_NOTIFIKASI_ID, A.AKSES_APP_KEUANGAN_ID, S.NAMA AKSES_KEUANGAN,
                    T.NAMA AS AKSES_APP_ANGGARAN, T.AKSES_APP_ANGGARAN_ID 
                    FROM USER_GROUP A 
                    LEFT JOIN AKSES_APP_DATABASE B ON A.AKSES_APP_DATABASE_ID = B.AKSES_APP_DATABASE_ID 
                    LEFT JOIN AKSES_APP_OPERASIONAL C ON A.AKSES_APP_OPERASIONAL_ID = C.AKSES_APP_OPERASIONAL_ID 
                    LEFT JOIN AKSES_APP_KEPEGAWAIAN D ON A.AKSES_APP_KEPEGAWAIAN_ID = D.AKSES_APP_KEPEGAWAIAN_ID 
                    LEFT JOIN AKSES_APP_PENGHASILAN E ON A.AKSES_APP_PENGHASILAN_ID = E.AKSES_APP_PENGHASILAN_ID 
                    LEFT JOIN AKSES_APP_PRESENSI F ON A.AKSES_APP_PRESENSI_ID = F.AKSES_APP_PRESENSI_ID 
                    LEFT JOIN AKSES_APP_PENILAIAN G ON A.AKSES_APP_PENILAIAN_ID = G.AKSES_APP_PENILAIAN_ID 
                    LEFT JOIN AKSES_APP_BACKUP H ON A.AKSES_APP_BACKUP_ID = H.AKSES_APP_BACKUP_ID 
                    LEFT JOIN AKSES_ADM_WEBSITE I ON A.AKSES_ADM_WEBSITE_ID = I.AKSES_ADM_WEBSITE_ID 
                    LEFT JOIN AKSES_ADM_INTRANET J ON A.AKSES_ADM_INTRANET_ID = J.AKSES_ADM_INTRANET_ID 
                    LEFT JOIN AKSES_APP_SURVEY K ON A.AKSES_APP_SURVEY_ID = K.AKSES_APP_SURVEY_ID 
                    LEFT JOIN AKSES_APP_KOMERSIAL L ON A.AKSES_APP_KOMERSIAL_ID = L.AKSES_APP_KOMERSIAL_ID
                    LEFT JOIN AKSES_APP_ARSIP M ON A.AKSES_APP_ARSIP_ID = M.AKSES_APP_ARSIP_ID
                    LEFT JOIN AKSES_APP_INVENTARIS N ON A.AKSES_APP_INVENTARIS_ID = N.AKSES_APP_INVENTARIS_ID
                    LEFT JOIN AKSES_APP_SPPD O ON A.AKSES_APP_SPPD_ID = O.AKSES_APP_SPPD_ID
                    LEFT JOIN AKSES_APP_HUKUM P ON A.AKSES_APP_HUKUM_ID = P.AKSES_APP_HUKUM_ID 
                    LEFT JOIN AKSES_APP_NOTIFIKASI Q ON A.AKSES_APP_NOTIFIKASI_ID = Q.AKSES_APP_NOTIFIKASI_ID
                    LEFT JOIN AKSES_APP_GALANGAN R ON A.AKSES_APP_NOTIFIKASI_ID = R.AKSES_APP_GALANGAN_ID  
                    LEFT JOIN AKSES_APP_KEUANGAN S ON A.AKSES_APP_KEUANGAN_ID = S.AKSES_APP_KEUANGAN_ID  
                    LEFT JOIN AKSES_APP_ANGGARAN T ON A.AKSES_APP_ANGGARAN_ID = T.AKSES_APP_ANGGARAN_ID 
                    WHERE USER_GROUP_ID IS NOT NULL
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
		$str = "	SELECT 
					USER_GROUP_ID, NAMA, KETERANGAN, AKSES_INTRANET_ID, AKSES_APP_DATABASE_ID, AKSES_APP_OPERASIONAL_ID, AKSES_APP_KEPEGAWAIAN_ID, AKSES_APP_PENGHASILAN_ID,
					AKSES_APP_PRESENSI_ID, AKSES_APP_PENILAIAN_ID, AKSES_APP_BACKUP_ID, AKSES_ADM_WEBSITE_ID, AKSES_ADM_INTRANET_ID, AKSES_APP_SURVEY_ID
					FROM USER_GROUP A WHERE USER_GROUP_ID IS NOT NULL
			    "; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key LIKE '%$val%' ";
		}
		
		$this->query = $str;
		$str .= $statement." ORDER BY NAMA ASC";
		return $this->selectLimit($str,$limit,$from); 
    }	
    /** 
    * Hitung jumlah record berdasarkan parameter (array). 
    * @param array paramsArray Array of parameter. Contoh array("id"=>"xxx","IJIN_USAHA_ID"=>"yyy") 
    * @return long Jumlah record yang sesuai kriteria 
    **/ 
    function getCountByParams($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(USER_GROUP_ID) AS ROWCOUNT FROM USER_GROUP
		        WHERE USER_GROUP_ID IS NOT NULL ".$statement; 
		
		while(list($key,$val)=each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$this->select($str); 
		if($this->firstRow()) 
			return $this->getField("ROWCOUNT"); 
		else 
			return 0; 
    }

    function getCountByParamsLike($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(USER_GROUP_ID) AS ROWCOUNT FROM USER_GROUP
		        WHERE USER_GROUP_ID IS NOT NULL ".$statement; 
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