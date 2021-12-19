<?
/* *******************************************************************************************************
MODUL NAME 			: SIMWEB
FILE NAME 			: Entity.php
AUTHOR				: MRF
VERSION				: 1.0
MODIFICATION DOC	:
DESCRIPTION			: Class that responsible to handle query executions
***************************************************************************************************** */

/***
* Class Entity merupakan virtual class yang digunakan untuk mengimplmentasikan
* entity. Setiap tabel pada database akan diterjemahkan menjadi entity dan
* akan diimplementasikan oleh class yang merupakan turunan dari class Entity ini.
* 
**/	

/* TWEAK ***********
should not used if you dont want the getField return value to be altered
this tweak alters '&quote' and '&backslash' strings become "'" and "\" respectively
*/
include_once("../WEB-INF/functions/default.func.php");	

include_once("../WEB-INF-SIUK/setup/config.php");	
include_once("../WEB-INF-SIUK/classes/db/DBManager.php");

class EntitySIUK{
	/* Properties */
	/** 
	* Objek database connection
	* @var dbEntity
	*/
    var $dbEntity;		
	
	/** 
	* Array untuk menyimpan hasil query 'SELECT' 
	* @var array
	**/
    var $rowResult=array();
	
	/** 
	* Jumlah baris yang berhasil didapat melalui query SELECT 
	* @var int 
	**/
    var $rowCount;
	
	/**
	* Row sekarang yang sedang aktif
	* @var array
	*/
   	 var $currentRow;
	 
	 /**
	* Index dari row yang sedang aktif. Dimulai dari 0
	* @var int
	**/
	var $currentRowIndex; 
	
	/** 
	* Pesan error. 
	* @var String
	**/
    var $errorMsg;

    /**
	* Class constructor		
	*/
	function EntitySIUK(){
		global $dbDefault;
		$this->dbEntity = $dbDefault;
	}
	
	function PrepareSP($statement){
	
		return $this->dbEntity->conn->PrepareSP($statement);
	}

	function InParameter(&$stmt,&$var,$name,$maxLen=4000,$type=false)
	{
		return $this->dbEntity->conn->Parameter($stmt,$var,$name,false,$maxLen,$type);
	}
	
	/*
	*/
	function OutParameter(&$stmt,&$var,$name,$maxLen=4000,$type=false)
	{
		return $this->dbEntity->conn->Parameter($stmt,$var,$name,true,$maxLen,$type);
	
	}
		
	/**
	* Mengambil nilai dari field.
	* @param string fieldName Nama field.
	* @return variant Nilai dari field tersebut. 
	*/
	function getField($fieldName, $_TWEAK_ALTER_RETURN = true){
		if($_TWEAK_ALTER_RETURN == true)
			return formatTextToPage($this->currentRow[$fieldName]);
		else
			return $this->currentRow[$fieldName];
	}
	
	/**
	* Memberi nilai pada field.
	* @param string fieldName Nama field yang akan di-set.
	* @param variant fieldValue Nilai yang akan di simpan ke field.
	* @return void
	*/
	function setField($fieldName,$fieldValue){
		$this->currentRow[$fieldName]=$fieldValue;
	}
	
	/***
	* Eksekusi query yang menghasilkan pengembalian record (SELECT). 
	* @author M Reza Faisal
	* @param string sql Query string.
	* @param array inputArray Array input parameters.		
	*/
    function select($sql,$inputArray=false){
		#Initialize
		$_rowResult = array();
		$this->rowCount = 0;
	
		#execute query
		$this->dbEntity->conn->SetFetchMode(ADODB_FETCH_ASSOC);
		$rs = @$this->dbEntity->conn->Execute($sql,$inputArray);
		if(!$rs){
			$this->errorMsg = "PESAN ERROR : ".$this->dbEntity->getErrorMsg()." (".$this->dbEntity->getErrorNo().")";
		} 
		else {
			$i=0;
			while($row=$rs->FetchRow()){
				$_rowResult[$i]=$row;
				$i = $i+1;
			}
			
			$this->rowResult = $_rowResult;
			$this->rowCount = $i;
			
			//$this->currentRowIndex = -1;
			//$this->currentRow = array();
		}
		
		return $rs;
    }
	
	/**
	* Eksekusi query SELECT dengan batasan record yang diambil. 
	* @author M Reza Faisal
	* @param string sql Query string
	* @param int numrow Jumlah maksimum record yang diambil. Jika diambil semua ==> -1
	* @param int offset Nomor awal record yang diambil. Mulai dari 0 untuk record pertama, -1 ==> diambil semua
	* @param string inputArray Parameter input.
	**/		
    function selectLimit($sql,$numrow=-1,$offset=-1,$inputArray=false){
		#Initialize
		$_rowResult = array();
		$this->rowCount = 0;
	
		#execute query
		$this->dbEntity->conn->SetFetchMode(ADODB_FETCH_ASSOC);
		$rs = @$this->dbEntity->conn->SelectLimit($sql,$numrow,$offset,$inputArray);
		if(!$rs){
			$this->errorMsg = "PESAN ERROR : ".$this->dbEntity->getErrorMsg()." (".$this->dbEntity->getErrorNo().")";
		}
		else {
			$i=0;
			while($row=$rs->FetchRow()){
				$_rowResult[$i]=$row;
				$i = $i+1;
			}
			$this->rowResult = $_rowResult;
			$this->rowCount = $i;
			
			$this->currentRowIndex = -1;
			$this->currentRow = array();
		}
		
		return $rs;
    }
	
	/**
	* Memberi nilai current row dengan row yang berasal dari query result, sesuai index cursor sekarang		
	*/
	function setRowValue(){
		$this->currentRow = $this->rowResult[$this->currentRowIndex];
	}
	
	/**
	* Mengarahkan kursor ke row pertama (record ke-0)
	* @return boolean True jika row pertama ada, false jika tidak ada.
	*/
   	function firstRow(){
      	if($this->rowCount>0){
			$this->currentRowIndex=0;
			$this->setRowValue();
			return true;
      	} else {
        	return false;
    	}
	}
	
	/**
	* Mengarahkan kursor ke row berikutnya
	* @return boolean True jika row berikutnya ada, false jika tidak ada.
	*/
    function nextRow(){
		if($this->currentRowIndex < $this->rowCount-1){
			$this->currentRowIndex++;
			$this->setRowValue();
			return true;
		} else {
			return false;
    	}
	}
	
	/**
	* Mengarahkan kursor ke row terakhir (recordCount-1)
	* @return boolean True jika row terakhir ada, false jika tidak ada.
	*/
    function lastRow(){
		if($this->rowCount>0){
			$this->currentRowIndex=$this->rowCount-1;
			$this->setRowValue();
			return true;
		}else {
			return false;
    	}
	}
	
	/**
	* Mengarahkan kursor ke row sebelumnya
	* @return boolean True jika row sebelumnya ada, false jika tidak ada.
	*/
    function prevRow(){
		if($this->currentRowIndex > 0){
			$this->currentRowIndex--;
			$this->setRowValue();
			return true;
		} else {
			return false;
    	}
	}
	
	/***
	* Eksekusi query yang tidak menghasilkan pengembalian (CREATE,ALTER,INSERT,UPDATE, dlsb).
	* @author Priyo Edi P
	* @param string sql Query string.
	* @param array inputArray Array input parameters.
	**/
    function execQuery($sql,$inputArray=false){
		$rs = $this->dbEntity->conn->Execute($sql,$inputArray);
		if(!$rs){
			$this->errorMsg = "PESAN ERROR : ".$this->dbEntity->getErrorMsg()." (".$this->dbEntity->getErrorNo().")";
		}
		return $rs;
    }

    function uploadBlob($table,$column,$blob,$id){
		$rs = $this->dbEntity->conn->UpdateBlobFile($table,$column,$blob,$id); 
		if(!$rs){
			$this->errorMsg = "PESAN ERROR : ".$this->dbEntity->getErrorMsg()." (".$this->dbEntity->getErrorNo().")";
		}
		return $rs;
    }
	
	/**
	* Mencari ID selanjutnya dari sebuah tabel, untuk tipe id integer.
	* @param string idName Nama id
	* @param string tableName Nama tabel
	* @param string filter Filter yang diterapkan (WHERE....)
	* @return int ID selanjutnya, Jika belum ada maka nilainya 1
	*/
	function getNextId($idName,$tableName,$filter=""){
		$str = "SELECT MAX($idName) as MAXVALUE FROM $tableName ";
		if($filter != "")
			$str = $str . " WHERE $filter";				
			$this->select($str);
			
			if($this->rowCount>0){
				$temp = $this->rowResult[0]["MAXVALUE"] + 1; //next key*/
			}else{ //belum ada recordnya
        		$temp = 1;
      		}
		return $temp;
	}

	function getNextKode(){
		$str = " SELECT MAX(SUBSTR(KODE, 5, 6)) + 1 MAXVALUE FROM REKANAN ";
		$this->select($str);
			if($this->rowCount>0){
				$temp = $this->rowResult[0]["MAXVALUE"] + 1; //next key*/
			}else{ //belum ada recordnya
        		$temp = 1;
      		}
		return $temp;
	}	
	/**
	*	Cari id selanjutnya berdasarkan waktu, tipe id varchar minimal 17 karakter
	*	Format : XXXXXXXXXXNNNNNNN
	*					 12345678901234567		
	* XXXXXXXXXX = diperoleh dari time()
	* NNNNNNN = nomor urut (mulai dari 1)
	*	@author Priyo EP
	* @param string idName Nama id
	* @param string tableName Nama tabel
	* @param int idLen Panjang ID
	* @param string filter Filter yang diterapkan (WHERE....)
	* @return string ID selanjutnya
	*/
	function getNextTimeId($idName,$tableName,$idLen=15,$filter=""){
		/*Inisialisasi*/
		$strTime = time();//panjang 10 karakter			
		$countLen = 5; //panjang counter
		
		/*Cari id yang mirip*/	
		$str = "SELECT MAX($idName) AS $idName FROM $tableName WHERE $idName LIKE '$strTime%' ";
			
		if($filter != "")
		$str = $str . " AND $filter";				
		$this->select($str);
		/*Jika ketemu, tambah 1, jika tidak generat baru*/
		if($this->tempRowCount>0){ 
			$counter = substr($this->queryResult[0][$idName],$idLen-$countLen,$countLen);
			$counter = $counter + 1;
			$newCountLen = strlen($counter);
				
			if($newCountLen < $countLen)
				$prefix = str_repeat("0",$countLen-$newCountLen);
			else
				$prefix = "";
					
			$nextKey = $strTime.$prefix.$counter;
		}else{ //belum ada recordnya			
       		$nextKey = $strTime.str_repeat("0",$countLen-1)."1";
      	}			
		return $nextKey;
	}
	
	/**
	* Mengirimkan pesan error/kesalahan
	* @return String
	*/
	function getErrorMsg() {
		return $this->errorMsg;
	}
	
}
?>